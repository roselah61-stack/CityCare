<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Category;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    public function index(Request $request)
{
    $query = Drug::query();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where('name', 'like', "%{$search}%")
              ->orWhere('price', 'like', "%{$search}%");
    }

    $drugs = $query->get();

    return view('drugs.index', compact('drugs'));
}

    public function create()
    {
        $categories = Category::all();
        return view('drugs.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required'
        ]);

        Drug::create([
    'name' => $request->name,
    'category_id' => $request->category_id,
    'price' => $request->price,
    'quantity' => $request->quantity,
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
        $drug->update($request->all());

        return redirect()->route('drug.list')->with('success', 'Drug updated successfully');
    }

    public function destroy($id)
    {
        Drug::destroy($id);

        return redirect()->route('drug.list')->with('success', 'Drug deleted successfully');
    }
}