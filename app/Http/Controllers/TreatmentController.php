<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Models\Patient;
use App\Models\Drug;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index()
    {
        $treatments = Treatment::with(['patient', 'drug'])->get();
        return view('treatments.index', compact('treatments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $drugs = Drug::all();
        

        return view('treatments.create', compact('patients', 'drugs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'drug_id' => 'required|exists:drugs,id',
            'details' => 'required|string',
            'treatment_date' => 'required|date'
        ]);

        Treatment::create([
            'patient_id' => $request->patient_id,
            'drug_id' => $request->drug_id,
            'details' => $request->details,
            'treatment_date' => $request->treatment_date,
        ]);

        return redirect()->route('treatment.list')->with('success', 'Treatment added successfully');
    }

    public function show($id)
{
    $treatment = Treatment::with(['patient', 'drug'])->findOrFail($id);

    return view('treatments.show', compact('treatment'));
}

    public function edit($id)
{
    $treatment = Treatment::findOrFail($id);
    $patients = Patient::all();
    $drugs = Drug::all();

    return view('treatments.edit', compact('treatment', 'patients', 'drugs'));
}

    public function update(Request $request, $id)
    {
        $treatment = Treatment::findOrFail($id);
        
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'drug_id' => 'required|exists:drugs,id',
            'details' => 'required|string',
            'treatment_date' => 'required|date'
        ]);

        $treatment->update([
            'patient_id' => $request->patient_id,
            'drug_id' => $request->drug_id,
            'details' => $request->details,
            'treatment_date' => $request->treatment_date,
        ]);

        return redirect()->route('treatment.list')->with('success', 'Treatment updated successfully');
    }

    public function destroy($id)
    {
        Treatment::destroy($id);

        return redirect()->route('treatment.list')->with('success', 'Treatment deleted successfully');
    }
}