<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
{
    $query = Patient::query();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where('name', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
    }

    $patients = $query->get();

    return view('patients.index', compact('patients'));
}

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);

        Patient::create([
    'name' => $request->name,
    'phone' => $request->phone,
    'email' => $request->email,
    'gender' => $request->gender,
    'address' => $request->address,
    'status' => $request->status
]);

        return redirect()->route('patient.list')->with('success', 'Patient added successfully');
    }

    public function show($id)
{
    $patient = Patient::findOrFail($id);
    return view('patients.show', compact('patient'));
}
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        return redirect()->route('patient.list')->with('success', 'Patient updated successfully');
    }

    public function destroy($id)
    {
        Patient::destroy($id);

        return redirect()->route('patient.list')->with('success', 'Patient deleted successfully');
    }
}