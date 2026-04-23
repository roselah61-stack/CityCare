<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Bill;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientPortalController extends Controller
{
    private function ensurePatientRole()
    {
        $user = Auth::user();
        
        if (!$user->role || $user->role->name !== 'patient') {
            abort(403, 'Access denied. This area is for patients only.');
        }
        
        return $user;
    }

    public function dashboard()
    {
        $patient = $this->ensurePatientRole();
        
        // Get upcoming appointments
        $upcomingAppointments = Appointment::with(['doctor'])
            ->where('patient_id', $patient->id)
            ->where('appointment_date', '>=', today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        // Get recent consultations
        $recentConsultations = Consultation::with(['doctor'])
            ->where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get recent bills
        $recentBills = Bill::with(['cashier'])
            ->where('user_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Calculate statistics
        $stats = [
            'upcoming_appointments' => $upcomingAppointments->count(),
            'total_appointments' => Appointment::where('patient_id', $patient->id)->count(),
            'pending_payments' => Bill::where('user_id', $patient->id)->where('payment_status', 'pending')->count(),
            'completed_consultations' => Consultation::where('patient_id', $patient->id)->count(),
        ];

        return view('patient.dashboard', compact('upcomingAppointments', 'recentConsultations', 'recentBills', 'stats'));
    }

    public function profile()
    {
        try {
            $user = Auth::user();
            
            // Use the user object directly since patients are users with patient role
            $patient = $user;
            
            return view('patient.profile', compact('patient'));
        } catch (\Exception $e) {
            \Log::error('Profile error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load profile. Please try again.');
        }
    }

    public function updateProfile(Request $request)
    {
        $patient = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date|before:today',
            'emergency_contact' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        $patient->update($request->all());

        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $patient = Auth::user();

        if (!Hash::check($request->current_password, $patient->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $patient->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function appointments(Request $request)
    {
        $patient = Auth::user();
        $query = Appointment::with(['doctor', 'consultation'])
            ->where('patient_id', $patient->id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('appointment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('appointment_date', '<=', $request->date_to);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
                           ->orderBy('appointment_time', 'desc')
                           ->paginate(10);

        return view('patient.appointments', compact('appointments'));
    }

    public function showAppointment($id)
    {
        $appointment = Appointment::with(['doctor', 'consultation.prescription'])
            ->where('patient_id', Auth::id())
            ->findOrFail($id);

        return view('patient.appointment_show', compact('appointment'));
    }

    public function bookAppointment()
    {
        $doctors = User::whereHas('role', function ($q) {
            $q->where('name', 'doctor');
        })->get();

        return view('patient.book_appointment', compact('doctors'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'required|string',
        ]);

        // Check for existing appointments at the same time
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingAppointment) {
            return back()->with('error', 'This time slot is already booked. Please choose a different time.')->withInput();
        }

        Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('patient.appointments')
            ->with('success', 'Appointment booked successfully.');
    }

    public function medicalHistory()
    {
        try {
            $patient = Auth::user();
            
            $consultations = Consultation::with(['doctor', 'prescription.items'])
                ->where('patient_id', $patient->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('patient.medical_history', compact('consultations'));
        } catch (\Exception $e) {
            \Log::error('Medical history error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load medical history. Please try again.');
        }
    }

    public function showConsultation($id)
    {
        $consultation = Consultation::with(['doctor', 'prescription.items'])
            ->where('patient_id', Auth::id())
            ->findOrFail($id);

        return view('patient.consultation_show', compact('consultation'));
    }

    public function payments()
    {
        $patient = Auth::user();
        
        $bills = Bill::with(['cashier'])
            ->where('user_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Calculate totals
        $totals = [
            'total_amount' => Bill::where('user_id', $patient->id)->sum('total_amount'),
            'paid_amount' => Bill::where('user_id', $patient->id)->where('payment_status', 'completed')->sum('total_amount'),
            'pending_amount' => Bill::where('user_id', $patient->id)->where('payment_status', 'pending')->sum('total_amount'),
        ];

        return view('patient.payments', compact('bills', 'totals'));
    }

    public function showPayment($id)
    {
        $bill = Bill::with(['cashier'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('patient.payment_show', compact('bill'));
    }

    public function visitHistory()
    {
        $patient = Auth::user();
        
        $appointments = Appointment::with(['doctor', 'consultation'])
            ->where('patient_id', $patient->id)
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('patient.visit_history', compact('appointments'));
    }
}
