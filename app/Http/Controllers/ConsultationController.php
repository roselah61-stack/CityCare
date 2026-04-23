<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Different data based on user role
        switch($user->role->name) {
            case 'doctor':
                // Doctors see their own consultations
                $consultations = Consultation::with(['doctor', 'patient', 'appointment'])
                    ->where('doctor_id', $user->id)
                    ->latest()
                    ->get();
                break;
                
            case 'pharmacist':
                // Pharmacists see all consultations (for prescription dispensing)
                $consultations = Consultation::with(['doctor', 'patient', 'appointment', 'prescription'])
                    ->latest()
                    ->get();
                break;
                
            case 'patient':
                // Patients see their own consultations
                $consultations = Consultation::with(['doctor', 'patient', 'appointment'])
                    ->where('patient_id', $user->id)
                    ->latest()
                    ->get();
                break;
                
            case 'admin':
                // Admins see all consultations
                $consultations = Consultation::with(['doctor', 'patient', 'appointment'])
                    ->latest()
                    ->get();
                break;
                
            default:
                $consultations = collect();
                break;
        }

        return view('consultations.index', compact('consultations'));
    }

    public function create($appointment_id)
    {
        $appointment = Appointment::with('patient')->findOrFail($appointment_id);
        $drugs = Drug::where('quantity', '>', 0)->get();
        return view('consultations.create', compact('appointment', 'drugs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'chief_complaint' => 'required|string|max:500',
            'history_of_present_illness' => 'nullable|string|max:1000',
            'past_medical_history' => 'nullable|string|max:1000',
            'family_history' => 'nullable|string|max:1000',
            'social_history' => 'nullable|string|max:500',
            'allergies' => 'nullable|string|max:500',
            'medications' => 'nullable|string|max:500',
            'physical_examination' => 'nullable|string|max:1000',
            'vital_signs' => 'nullable|string|max:500',
            'diagnosis' => 'required|string|max:500',
            'differential_diagnosis' => 'nullable|string|max:500',
            'investigations_ordered' => 'nullable|string|max:500',
            'investigation_results' => 'nullable|string|max:1000',
            'treatment_plan' => 'required|string|max:1000',
            'medications_prescribed' => 'nullable|string|max:1000',
            'follow_up_plan' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'blood_pressure' => 'nullable|string|max:20',
            'temperature' => 'nullable|string|max:10',
            'weight' => 'nullable|numeric|min:0|max:500',
            'height' => 'nullable|numeric|min:0|max:300',
            'heart_rate' => 'nullable|integer|min:30|max:200',
            'respiratory_rate' => 'nullable|integer|min:10|max:40',
            'oxygen_saturation' => 'nullable|integer|min:70|max:100',
            'drugs' => 'nullable|array',
            'drugs.*.id' => 'required|exists:drugs,id',
            'drugs.*.dosage' => 'required|string|max:100',
            'drugs.*.duration' => 'required|string|max:50',
            'drugs.*.quantity' => 'required|integer|min:1|max:100',
        ]);

        DB::transaction(function () use ($request) {
            $appointment = Appointment::findOrFail($request->appointment_id);
            
            // Calculate BMI if height and weight are provided
            $bmi = null;
            if ($request->filled('height') && $request->filled('weight')) {
                $heightInMeters = $request->height / 100;
                $bmi = round($request->weight / ($heightInMeters * $heightInMeters), 2);
            }

            $consultation = Consultation::create([
                'appointment_id' => $appointment->id,
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
                'vital_signs' => $request->vital_signs,
                'diagnosis' => $request->diagnosis,
                'differential_diagnosis' => $request->differential_diagnosis,
                'investigations_ordered' => $request->investigations_ordered,
                'investigation_results' => $request->investigation_results,
                'treatment_plan' => $request->treatment_plan,
                'medications_prescribed' => $request->medications_prescribed,
                'follow_up_plan' => $request->follow_up_plan,
                'notes' => $request->notes,
                'blood_pressure' => $request->blood_pressure,
                'temperature' => $request->temperature,
                'weight' => $request->weight,
                'height' => $request->height,
                'heart_rate' => $request->heart_rate,
                'respiratory_rate' => $request->respiratory_rate,
                'oxygen_saturation' => $request->oxygen_saturation,
                'bmi' => $bmi,
            ]);

            $appointment->update(['status' => 'completed']);

            if (!empty($request->drugs)) {
                $prescription = Prescription::create([
                    'consultation_id' => $consultation->id,
                    'doctor_id' => Auth::id(),
                    'patient_id' => $appointment->patient_id,
                    'status' => 'pending'
                ]);

                foreach ($request->drugs as $drugData) {
                    PrescriptionItem::create([
                        'prescription_id' => $prescription->id,
                        'drug_id' => $drugData['id'],
                        'dosage' => $drugData['dosage'],
                        'duration' => $drugData['duration'],
                        'quantity' => $drugData['quantity'],
                        'instructions' => $drugData['instructions'] ?? null
                    ]);
                }
            }
        });

        return redirect()->route('consultations.index')->with('success', 'Consultation recorded and prescription issued.');
    }

    public function show($id)
    {
        $consultation = Consultation::with(['doctor', 'patient', 'appointment', 'prescription.items.drug'])->findOrFail($id);
        return view('consultations.show', compact('consultation'));
    }
}
