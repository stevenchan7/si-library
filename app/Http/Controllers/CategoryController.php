<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('category.index', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'unique:categories'],
        ]);

        $validatedData['title'] = strtolower($request->title);

        //masukkan data ke database
        Category::create($validatedData);

        return redirect('/categories')->with('success', 'New category added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [];

        //jika user mengganti category
        if($request->title != $category->title){
            $rules['title'] = ['required', 'unique:books'];
        }

        $validatedData = $request->validate($rules);

        //masukkan data ke database
        Category::where('id', $category->id)->update($validatedData);

        return redirect('/categories')->with('success', 'Category has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Category::destroy($category->id);
        return redirect('/categories')->with('success', 'Category has been deleted');
    }
}
