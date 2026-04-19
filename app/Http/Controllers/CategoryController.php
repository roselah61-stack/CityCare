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
        'name' => 'required',
        'description' => 'required'
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
    $category->update($request->all());

    return redirect()->route('categories.index');
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