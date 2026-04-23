<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Drug;
use App\Models\Category;
use App\Models\Treatment;
use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Prescription;
use App\Models\Consultation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Check if user is patient and show patient-specific dashboard
        if ($user && $user->role && $user->role->name === 'patient') {
            return $this->patientDashboard($user);
        }

        // Admin, doctors, receptionists, cashiers go to main dashboard
        $totalPatients = Patient::count();
        $totalDoctors = User::whereHas('role', fn($q) => $q->where('name', 'doctor'))->count();
        $totalDrugs = Drug::count();
        $totalCategories = Category::count();
        $lowStockDrugs = Drug::whereColumn('quantity', '<=', 'low_stock_threshold')->count();
        
        $totalRevenue = Bill::where('payment_status', 'completed')->sum('total_amount');
        $totalPrescriptions = Consultation::count();
        $totalPaymentsCompleted = Bill::where('payment_status', 'completed')->count();
        $pendingPayments = Bill::where('payment_status', 'pending')->sum('total_amount');

        $todayAppointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();

        $todayStats = [
            'total' => $todayAppointments->count(),
            'completed' => $todayAppointments->where('status', 'completed')->count(),
            'pending' => $todayAppointments->where('status', 'pending')->count(),
            'cancelled' => $todayAppointments->where('status', 'cancelled')->count(),
        ];

        $recentAppointments = Appointment::with(['patient', 'doctor'])->latest()->take(5)->get();
        $recentPatients = Patient::latest()->take(5)->get();
        $lowStockAlerts = Drug::whereColumn('quantity', '<=', 'low_stock_threshold')->take(5)->get();
        $recentPrescriptions = Prescription::with(['patient', 'doctor'])->latest()->take(5)->get();

        $demographics = [
            'labels' => ['Male', 'Female'],
            'data' => [
                max(Patient::where('gender', 'male')->count(), 1),
                max(Patient::where('gender', 'female')->count(), 1)
            ]
        ];

        $revenueTrend = Bill::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->where('payment_status', 'completed')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $revenueLabels = $revenueTrend->pluck('date')->map(fn($d) => date('M d', strtotime($d)))->toArray();
        $revenueData = $revenueTrend->pluck('total')->toArray();

        $doctorWorkload = User::whereHas('role', fn($q) => $q->where('name', 'doctor'))
            ->withCount([
                'appointmentsAsDoctor as completed_appointments_count' => fn($q) => $q->where('status', 'completed'),
                'appointmentsAsDoctor as scheduled_appointments_count' => fn($q) => $q->whereIn('status', ['pending', 'confirmed'])
            ])
            ->get();

        $doctorsOnDuty = Appointment::with('doctor')
            ->whereDate('appointment_date', today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->distinct('doctor_id')
            ->count('doctor_id');

        $consultationFees = Bill::where('payment_status', 'completed')
            ->where('bill_type', 'consultation')
            ->sum('total_amount');

        $pharmacySales = Bill::where('payment_status', 'completed')
            ->where('bill_type', 'pharmacy')
            ->sum('total_amount');

        $weeklyRevenue = Bill::where('payment_status', 'completed')
            ->where('created_at', '>=', now()->startOfWeek())
            ->sum('total_amount');

        $monthlyRevenue = Bill::where('payment_status', 'completed')
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('total_amount');

        $recentPayments = Bill::with('user')
            ->where('payment_status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPatients',
            'totalDoctors',
            'totalDrugs',
            'totalCategories',
            'lowStockDrugs',
            'totalRevenue',
            'totalPrescriptions',
            'totalPaymentsCompleted',
            'pendingPayments',
            'todayAppointments',
            'todayStats',
            'recentAppointments',
            'recentPatients',
            'lowStockAlerts',
            'recentPrescriptions',
            'demographics',
            'revenueLabels',
            'revenueData',
            'doctorWorkload',
            'doctorsOnDuty',
            'consultationFees',
            'pharmacySales',
            'weeklyRevenue',
            'monthlyRevenue',
            'recentPayments'
        ));
    }

    public function patientDashboard($user)
    {
        // Get patient's upcoming appointments
        $upcomingAppointments = Appointment::with(['doctor'])
            ->where('patient_id', $user->id)
            ->where('appointment_date', '>=', today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        // Get patient's recent consultations
        $recentConsultations = Consultation::with(['doctor'])
            ->where('patient_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get patient's recent bills
        $recentBills = Bill::with(['cashier'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Calculate patient statistics
        $stats = [
            'upcoming_appointments' => $upcomingAppointments->count(),
            'total_appointments' => Appointment::where('patient_id', $user->id)->count(),
            'pending_payments' => Bill::where('user_id', $user->id)->where('payment_status', 'pending')->count(),
            'completed_consultations' => Consultation::where('patient_id', $user->id)->count(),
        ];

        return view('patient.dashboard', compact('upcomingAppointments', 'recentConsultations', 'recentBills', 'stats'));
    }

    public function overview()
    {
        return $this->dashboard();
    }
}
