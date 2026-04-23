<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
public function create()
{
    return view('categories.create');
}
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name,NULL,id,deleted_at,NULL',
        'description' => 'required|string'
    ]);

    Category::create([
        'name' => $request->name,
        'description' => $request->description
    ]);

    return redirect()->route('categories.index')
        ->with('success', 'Category created successfully');
}
    public function index()
{
    $categories = Category::all();
    return view('categories.index', compact('categories'));
}


public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('categories.edit', compact('category'));
}

public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);
    
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name,' . $id . ',id,deleted_at,NULL',
        'description' => 'required|string'
    ]);

    $category->update([
        'name' => $request->name,
        'description' => $request->description
    ]);

    return redirect()->route('categories.index')->with('success', 'Category updated successfully');
}

public function destroy($id)
{
    Category::destroy($id);
    return back();
}

public function show($id)
{
    $category = Category::findOrFail($id);
    return view('categories.show', compact('category'));
}
}