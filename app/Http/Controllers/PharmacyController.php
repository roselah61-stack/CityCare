<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Drug;
use App\Models\DrugInventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PharmacyController extends Controller
{
    public function prescriptions()
    {
        $prescriptions = Prescription::with(['doctor', 'patient', 'items.drug'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('pharmacy.prescriptions', compact('prescriptions'));
    }

    public function showPrescription($id)
    {
        $prescription = Prescription::with(['doctor', 'patient', 'items.drug'])->findOrFail($id);
        return view('pharmacy.prescription_show', compact('prescription'));
    }

    public function dispense(Request $request, $id)
    {
        $prescription = Prescription::with('items.drug')->findOrFail($id);

        DB::transaction(function () use ($prescription) {
            foreach ($prescription->items as $item) {
                $drug = $item->drug;
                
                if ($drug->quantity < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$drug->name}");
                }

                $drug->decrement('quantity', $item->quantity);

                DrugInventoryLog::create([
                    'drug_id' => $drug->id,
                    'quantity' => $item->quantity,
                    'type' => 'stock_out',
                    'description' => "Dispensed for prescription #{$prescription->id}",
                    'user_id' => Auth::id()
                ]);
            }

            $prescription->update(['status' => 'dispensed']);
        });

        return redirect()->route('pharmacy.prescriptions')->with('success', 'Medications dispensed successfully.');
    }

    public function inventory()
    {
        $drugs = Drug::with(['category', 'inventoryLogs'])->latest()->get();
        $totalStockValue = $drugs->sum(fn($d) => $d->price * $d->quantity);
        $lowStockCount = $drugs->where('quantity', '<=', 10)->count();
        $expiredCount = $drugs->where('expiry_date', '<', now())->count();
        
        return view('pharmacy.inventory', compact('drugs', 'totalStockValue', 'lowStockCount', 'expiredCount'));
    }
}
