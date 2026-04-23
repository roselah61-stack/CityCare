<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_appointments' => Appointment::count(),
            'total_revenue' => Bill::where('payment_status', 'completed')->sum('total_amount'),
            'total_patients' => User::whereHas('role', fn($q) => $q->where('name', 'patient'))->count(),
            'pending_prescriptions' => Prescription::where('status', 'pending')->count(),
        ];

        $recent_revenue = Bill::where('payment_status', 'completed')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        return view('reports.index', compact('stats', 'recent_revenue'));
    }

    public function export($type)
    {
        if ($type === 'revenue') {
            try {
                $data = Bill::with('user')->where('payment_status', 'completed')->get();
                $filename = "revenue_report_" . date('Ymd') . ".csv";
                
                $csvContent = '';
                $csvContent .= "Bill ID,Patient,Amount,Date,Payment Method\n";
                
                foreach ($data as $bill) {
                    $csvContent .= implode(',', [
                        $bill->id,
                        '"' . $bill->user->name . '"',
                        $bill->total_amount,
                        is_string($bill->created_at) ? $bill->created_at : $bill->created_at->format('Y-m-d'),
                        '"' . ($bill->payment_method ?? 'N/A') . '"'
                    ]) . "\n";
                }
                
                return response($csvContent)
                    ->header('Content-Type', 'text/csv')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->header('Cache-Control', 'no-cache, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', '0');
                    
            } catch (\Exception $e) {
                \Log::error('Export error: ' . $e->getMessage());
                return back()->with('error', 'Export failed: ' . $e->getMessage());
            }
        }

        if ($type === 'appointments') {
            try {
                $data = Appointment::with(['patient', 'doctor'])->get();
                $filename = "appointments_report_" . date('Ymd') . ".csv";
                
                $csvContent = '';
                $csvContent .= "Appointment ID,Patient,Doctor,Date,Time,Status,Reason\n";
                
                foreach ($data as $appointment) {
                    $csvContent .= implode(',', [
                        $appointment->id,
                        '"' . ($appointment->patient ? $appointment->patient->name : 'N/A') . '"',
                        '"' . ($appointment->doctor ? $appointment->doctor->name : 'N/A') . '"',
                        is_string($appointment->appointment_date) ? $appointment->appointment_date : $appointment->appointment_date->format('Y-m-d'),
                        is_string($appointment->appointment_time) ? $appointment->appointment_time : $appointment->appointment_time->format('H:i'),
                        '"' . $appointment->status . '"',
                        '"' . ($appointment->reason ?? 'N/A') . '"'
                    ]) . "\n";
                }
                
                return response($csvContent)
                    ->header('Content-Type', 'text/csv')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->header('Cache-Control', 'no-cache, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', '0');
                    
            } catch (\Exception $e) {
                \Log::error('Export error: ' . $e->getMessage());
                return back()->with('error', 'Export failed: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'Export type not supported yet.');
    }
}
