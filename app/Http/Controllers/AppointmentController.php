<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->name;
        
        $query = Appointment::with(['doctor', 'patient']);

        // Apply role-based filtering
        if ($role === 'patient') {
            $query->where('patient_id', $user->id);
        } elseif ($role === 'doctor') {
            $query->where('doctor_id', $user->id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('appointment_date', 'like', "%{$search}%")
                  ->orWhere('appointment_time', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhereHas('doctor', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('patient', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by doctor
        if ($request->filled('doctor_id') && $role !== 'doctor') {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        // Filter by specific date
        if ($request->filled('appointment_date')) {
            $query->whereDate('appointment_date', $request->appointment_date);
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'appointment_date');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSorts = ['appointment_date', 'appointment_time', 'status', 'created_at'];
        
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('appointment_date', 'desc')->orderBy('appointment_time', 'desc');
        }

        // Pagination
        $appointments = $query->paginate(12)->withQueryString();

        // Get doctors for filter dropdown (only for admin/receptionist)
        $doctors = [];
        if (in_array($role, ['admin', 'receptionist'])) {
            $doctors = User::whereHas('role', function ($q) {
                $q->where('name', 'doctor');
            })->get();
        }

        if ($request->ajax()) {
            return response()->json([
                'appointments' => $appointments,
                'html' => view('appointments.partials.appointment_table', compact('appointments'))->render()
            ]);
        }

        return view('appointments.index', compact('appointments', 'doctors'));
    }

    public function create()
    {
        $doctors = User::whereHas('role', function ($q) {
            $q->where('name', 'doctor');
        })->get();

        $patients = User::whereHas('role', function ($q) {
            $q->where('name', 'patient');
        })->get();

        return view('appointments.create', compact('doctors', 'patients'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->name;

        // Role-based validation
        if ($role === 'receptionist') {
            $request->validate([
                'patient_id' => 'required|exists:users,id',
                'doctor_id' => 'required|exists:users,id',
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required',
                'reason' => 'nullable|string'
            ]);
        } elseif ($role === 'patient') {
            // Patients can only book for themselves
            $request->validate([
                'doctor_id' => 'required|exists:users,id',
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required',
                'reason' => 'nullable|string'
            ]);
            $request->merge(['patient_id' => $user->id]);
        }

        // Enhanced overlap detection (considering appointment duration)
        $appointmentTime = $request->appointment_time;
        $appointmentDate = $request->appointment_date;
        $doctorId = $request->doctor_id;

        // Check for overlapping appointments (30-minute slots assumed)
        $startTime = date('H:i:s', strtotime($appointmentTime));
        $endTime = date('H:i:s', strtotime($appointmentTime . ' +30 minutes'));

        $overlappingAppointment = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $appointmentDate)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    // New appointment starts during existing appointment
                    $q->where('appointment_time', '<=', $startTime)
                      ->whereRaw("ADDTIME(appointment_time, '00:30:00') > ?", [$startTime]);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // New appointment ends during existing appointment
                    $q->where('appointment_time', '<', $endTime)
                      ->whereRaw("ADDTIME(appointment_time, '00:30:00') >= ?", [$endTime]);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // New appointment completely overlaps existing appointment
                    $q->where('appointment_time', '>=', $startTime)
                      ->where('appointment_time', '<', $endTime);
                });
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($overlappingAppointment) {
            $conflictTime = $overlappingAppointment->appointment_time;
            return back()->with('error', "Time slot conflict! Doctor already has an appointment at {$conflictTime}. Please choose a different time.")->withInput();
        }

        // Create appointment
        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        // Role-based redirect
        if ($role === 'patient') {
            return redirect()->route('patient.appointments')->with('success', 'Appointment scheduled successfully.');
        }

        return redirect()->route('appointments.index')->with('success', 'Appointment scheduled successfully.');
    }

    public function show($id)
    {
        $appointment = Appointment::with(['doctor', 'patient', 'consultation'])->findOrFail($id);
        $user = Auth::user();
        $role = $user->role->name;

        // Role-based access control
        if ($role === 'patient' && $appointment->patient_id !== $user->id) {
            abort(403, 'Unauthorized access to this appointment.');
        }
        if ($role === 'doctor' && $appointment->doctor_id !== $user->id) {
            abort(403, 'Unauthorized access to this appointment.');
        }

        return view('appointments.show', compact('appointment'));
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        $role = $user->role->name;

        // Only receptionists and admins can edit appointments
        if (!in_array($role, ['receptionist', 'admin'])) {
            abort(403, 'Unauthorized to edit appointments.');
        }

        $doctors = User::whereHas('role', function ($q) {
            $q->where('name', 'doctor');
        })->get();

        $patients = User::whereHas('role', function ($q) {
            $q->where('name', 'patient');
        })->get();

        return view('appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        $role = $user->role->name;

        // Only receptionists and admins can update appointments
        if (!in_array($role, ['receptionist', 'admin'])) {
            abort(403, 'Unauthorized to update appointments.');
        }

        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'nullable|string'
        ]);

        // Check for overlapping appointments (if doctor or time changed)
        if ($appointment->doctor_id != $request->doctor_id || 
            $appointment->appointment_date != $request->appointment_date || 
            $appointment->appointment_time != $request->appointment_time) {
            
            $startTime = date('H:i:s', strtotime($request->appointment_time));
            $endTime = date('H:i:s', strtotime($request->appointment_time . ' +30 minutes'));

            $overlappingAppointment = Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('id', '!=', $appointment->id)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where(function ($q) use ($startTime, $endTime) {
                        $q->where('appointment_time', '<=', $startTime)
                          ->whereRaw("ADDTIME(appointment_time, '00:30:00') > ?", [$startTime]);
                    })->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('appointment_time', '<', $endTime)
                          ->whereRaw("ADDTIME(appointment_time, '00:30:00') >= ?", [$endTime]);
                    });
                })
                ->whereIn('status', ['pending', 'confirmed'])
                ->first();

            if ($overlappingAppointment) {
                $conflictTime = $overlappingAppointment->appointment_time;
                return back()->with('error', "Time slot conflict! Doctor already has an appointment at {$conflictTime}. Please choose a different time.")->withInput();
            }
        }

        $appointment->update($request->all());

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        $role = $user->role->name;

        // Only receptionists and admins can cancel appointments
        if (!in_array($role, ['receptionist', 'admin'])) {
            abort(403, 'Unauthorized to cancel appointments.');
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('appointments.index')->with('success', 'Appointment cancelled successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        $role = $user->role->name;

        // Role-based status update permissions
        if ($role === 'doctor' && $appointment->doctor_id !== $user->id) {
            abort(403, 'Unauthorized to update this appointment status.');
        }

        $request->validate(['status' => 'required|in:pending,confirmed,completed,cancelled']);
        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Appointment status updated.');
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required',
            'date' => 'required|date'
        ]);

        $bookedTimes = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointment_time')
            ->toArray();

        // Standard hospital slots: 9:00 AM to 5:00 PM, every 30 mins
        $slots = [];
        $start = strtotime('09:00');
        $end = strtotime('17:00');

        while ($start <= $end) {
            $time = date('H:i', $start);
            $slots[] = [
                'time' => $time,
                'available' => !in_array($time . ':00', $bookedTimes)
            ];
            $start = strtotime('+30 minutes', $start);
        }

        return response()->json($slots);
    }
}
