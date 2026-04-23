<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Category;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    public function index(Request $request)
    {
        $query = Drug::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('price', 'like', "%{$search}%")
                  ->orWhereHas('category', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->where('quantity', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('quantity', 0);
            } elseif ($request->stock_status === 'low_stock') {
                $query->whereColumn('quantity', '<=', 'low_stock_threshold')
                      ->where('quantity', '>', 0);
            }
        }

        // Filter by price range
        if ($request->filled('price_from')) {
            $query->where('price', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $query->where('price', '<=', $request->price_to);
        }

        // Filter by expiry date
        if ($request->filled('expiry_status')) {
            if ($request->expiry_status === 'expired') {
                $query->where('expiry_date', '<', now());
            } elseif ($request->expiry_status === 'expiring_soon') {
                $query->where('expiry_date', '<=', now()->addDays(30))
                      ->where('expiry_date', '>', now());
            } elseif ($request->expiry_status === 'valid') {
                $query->where('expiry_date', '>', now()->addDays(30));
            }
        }

        // Filter by quantity range
        if ($request->filled('quantity_from')) {
            $query->where('quantity', '>=', $request->quantity_from);
        }
        if ($request->filled('quantity_to')) {
            $query->where('quantity', '<=', $request->quantity_to);
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $allowedSorts = ['name', 'price', 'quantity', 'expiry_date', 'created_at'];
        
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }

        // Pagination
        $drugs = $query->paginate(20)->withQueryString();

        // Get categories for filter dropdown
        $categories = Category::all();

        if ($request->ajax()) {
            return response()->json([
                'drugs' => $drugs,
                'html' => view('drugs.partials.drug_table', compact('drugs'))->render()
            ]);
        }

        return view('drugs.index', compact('drugs', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('drugs.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:drugs,name,NULL,id,deleted_at,NULL',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'description' => 'nullable|string'
        ]);

        Drug::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => $request->quantity ?? 0,
            'description' => $request->description,
        ]);

        return redirect()->route('drug.list')->with('success', 'Drug created successfully');
    }

public function show($id)
{
    $drug = Drug::with('category')->findOrFail($id);
    return view('drugs.show', compact('drug'));
}

    public function edit($id)
{
    $drug = Drug::findOrFail($id);
    $categories = Category::all();

    return view('drugs.edit', compact('drug', 'categories'));
}

    public function update(Request $request, $id)
    {
        $drug = Drug::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:drugs,name,' . $id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'description' => 'nullable|string'
        ]);

        $drug->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => $request->quantity ?? 0,
            'description' => $request->description,
        ]);

        return redirect()->route('drug.list')->with('success', 'Drug updated successfully');
    }

    public function destroy($id)
    {
        Drug::destroy($id);

        return redirect()->route('drug.list')->with('success', 'Drug deleted successfully');
    }
}