<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Drug;
use App\Models\Category;
use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard()
{
    $search = request('search');
    
    $patients = Patient::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->latest()
        ->take(5)
        ->get();

    $totalPatients = Patient::count();
    $totalDrugs = Drug::count();
    $totalCategories = Category::count();
    $totalTreatments = Treatment::count();

    $months = [];
    $patientCounts = [];

    for ($i = 4; $i >= 0; $i--) {

        $date = Carbon::now()->subMonths($i);

        $months[] = $date->format('M');

        $patientCounts[] = Patient::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();
    }

    $drugCategories = Category::pluck('name')->toArray();

    $drugCounts = Category::withCount('drugs')
        ->get()
        ->pluck('drugs_count')
        ->toArray();

    return view('dashboard', compact(
        'patients',
        'totalPatients',
        'totalDrugs',
        'totalCategories',
        'totalTreatments',
        'months',
        'patientCounts',
        'drugCategories',
        'drugCounts'
    ));
}

    public function overview()
    {
        $patients = Patient::count();
        $drugs = Drug::count();
        $treatments = Treatment::count();
        $categories = Category::count();

        return view('overview.index', compact(
            'patients',
            'drugs',
            'treatments',
            'categories'
        ));
    }
}