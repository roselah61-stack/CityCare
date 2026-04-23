<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctor = Auth::user();
        
        // Get today's appointments
        $todayAppointments = Appointment::with(['patient'])
            ->where('doctor_id', $doctor->id)
            ->where('appointment_date', today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_time')
            ->get();

        // Get upcoming appointments
        $upcomingAppointments = Appointment::with(['patient'])
            ->where('doctor_id', $doctor->id)
            ->where('appointment_date', '>', today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(10)
            ->get();

        // Get recent consultations
        $recentConsultations = Consultation::with(['patient'])
            ->where('doctor_id', $doctor->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get statistics
        $stats = [
            'total_patients' => Appointment::where('doctor_id', $doctor->id)->distinct('patient_id')->count(),
            'today_appointments' => $todayAppointments->count(),
            'pending_appointments' => Appointment::where('doctor_id', $doctor->id)->where('status', 'pending')->count(),
            'completed_consultations' => Consultation::where('doctor_id', $doctor->id)->count(),
        ];

        return view('doctor.dashboard', compact('todayAppointments', 'upcomingAppointments', 'recentConsultations', 'stats'));
    }

    public function appointments(Request $request)
    {
        $doctor = Auth::user();
        $query = Appointment::with(['patient', 'consultation'])
            ->where('doctor_id', $doctor->id);

        // Filter by date
        if ($request->filled('date_filter')) {
            if ($request->date_filter === 'today') {
                $query->where('appointment_date', today());
            } elseif ($request->date_filter === 'week') {
                $query->whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->date_filter === 'month') {
                $query->whereMonth('appointment_date', now()->month)
                      ->whereYear('appointment_date', now()->year);
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by patient name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
                           ->orderBy('appointment_time', 'desc')
                           ->paginate(15);

        return view('doctor.appointments', compact('appointments'));
    }

    public function showAppointment($id)
    {
        $appointment = Appointment::with(['patient', 'consultation.prescription.items'])
            ->where('doctor_id', Auth::id())
            ->findOrFail($id);

        // Get patient's medical history
        $patientHistory = Consultation::with(['prescription'])
            ->where('doctor_id', Auth::id())
            ->where('patient_id', $appointment->patient_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('doctor.appointment_show', compact('appointment', 'patientHistory'));
    }

    public function createConsultation($appointmentId)
    {
        $appointment = Appointment::with(['patient'])
            ->where('doctor_id', Auth::id())
            ->findOrFail($appointmentId);

        return view('doctor.create_consultation', compact('appointment'));
    }

    public function storeConsultation(Request $request, $appointmentId)
    {
        $appointment = Appointment::where('doctor_id', Auth::id())->findOrFail($appointmentId);
        
        $request->validate([
            'chief_complaint' => 'required|string',
            'history_of_present_illness' => 'nullable|string',
            'past_medical_history' => 'nullable|string',
            'family_history' => 'nullable|string',
            'social_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'medications' => 'nullable|string',
            'physical_examination' => 'nullable|string',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
            'follow_up_plan' => 'nullable|string',
            'notes' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
            'temperature' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'heart_rate' => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer',
            'oxygen_saturation' => 'nullable|integer',
        ]);

        $consultation = Consultation::create([
            'appointment_id' => $appointmentId,
            'doctor_id' => Auth::id(),
            'patient_id' => $appointment->patient_id,
            'chief_complaint' => $request->chief_complaint,
            'history_of_present_illness' => $request->history_of_present_illness,
            'past_medical_history' => $request->past_medical_history,
            'family_history' => $request->family_history,
            'social_history' => $request->social_history,
            'allergies' => $request->allergies,
            'medications' => $request->medications,
            'physical_examination' => $request->physical_examination,
            'vital_signs' => json_encode([
                'blood_pressure' => $request->blood_pressure,
                'temperature' => $request->temperature,
                'weight' => $request->weight,
                'height' => $request->height,
                'heart_rate' => $request->heart_rate,
                'respiratory_rate' => $request->respiratory_rate,
                'oxygen_saturation' => $request->oxygen_saturation,
            ]),
            'diagnosis' => $request->diagnosis,
            'differential_diagnosis' => $request->differential_diagnosis ?? null,
            'investigations_ordered' => $request->investigations_ordered ?? null,
            'treatment_plan' => $request->treatment_plan,
            'medications_prescribed' => $request->medications_prescribed ?? null,
            'follow_up_plan' => $request->follow_up_plan,
            'notes' => $request->notes,
        ]);

        // Calculate BMI if height and weight are provided
        if ($request->height && $request->weight) {
            $heightInMeters = $request->height / 100;
            $bmi = round($request->weight / ($heightInMeters * $heightInMeters), 2);
            $consultation->update(['bmi' => $bmi]);
        }

        // Update appointment status
        $appointment->update(['status' => 'completed']);

        return redirect()->route('doctor.appointments')
            ->with('success', 'Consultation completed successfully.');
    }

    public function patients(Request $request)
    {
        $doctor = Auth::user();
        $query = User::whereHas('role', function ($q) {
            $q->where('name', 'patient');
        })->whereHas('appointments', function ($q) use ($doctor) {
            $q->where('doctor_id', $doctor->id);
        });

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $patients = $query->paginate(15);

        return view('doctor.patients', compact('patients'));
    }

    public function showPatient($id)
    {
        $patient = User::whereHas('role', function ($q) {
            $q->where('name', 'patient');
        })->findOrFail($id);

        // Get patient's appointments with this doctor
        $appointments = Appointment::with(['consultation'])
            ->where('doctor_id', Auth::id())
            ->where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        // Get patient's medical history
        $consultations = Consultation::with(['prescription'])
            ->where('doctor_id', Auth::id())
            ->where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('doctor.patient_show', compact('patient', 'appointments', 'consultations'));
    }

    public function schedule()
    {
        $doctor = Auth::user();
        
        // Get appointments for the next 7 days
        $weekAppointments = Appointment::with(['patient'])
            ->where('doctor_id', $doctor->id)
            ->whereBetween('appointment_date', [now()->startOfDay(), now()->addDays(7)->endOfDay()])
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get()
            ->groupBy('appointment_date');

        return view('doctor.schedule', compact('weekAppointments'));
    }
}
