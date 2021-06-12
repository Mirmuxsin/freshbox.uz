<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index() {
        $categories = Categories::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create() {
        $categories = Categories::all();
        $category = new Categories();
        return view('admin.categories.create', compact('categories'))->with(compact('category'));
    }

    public function edit($id) {
        $category = Categories::find($id);
        $categories = Categories::all();
        return view('admin.categories.edit', compact('category'))->with(compact('categories'));
    }

    public function update(Request $request, $id) {

        // Find the product
        $category = Categories::find($id);

        // Validate The form
        $request->validate([
            'id' => 'required',
           'name' => 'required',
           'subcategory' => 'required',
        ]);

        // Updating the product
        $category->update([
            'id' => $request->id,
            'name' => $request->name,
            'subcategory' => $request->subcategory,
        ]);

        // Store a message in session
        $request->session()->flash('msg', 'Category has been updated');

        // Redirect
        return redirect('admin/categories');

    }

    
    public function store(Request $request) {

        // Validate the form
        $request->validate([
           'name' => 'required',
        ]);

        // Save the data into database
        Categories::create([
            'id' => null,
            'name' => $request->name,
            'subcategory' => $request->subcategory
        ]);

        // Sessions Message
        $request->session()->flash('msg','Your category has been added');

        // Redirect

        return redirect('admin/categories');

    }

    
    public function destroy($id) {
        // Delete the product
        Categories::destroy($id);

        // Store a message
        session()->flash('msg','Category has been deleted');

        // Redirect back
        return redirect('admin/categories');


    }

    public function show($id) {
        $categories = Categories::all();
        $category = Categories::find($id);

        return view('admin.categories.details', compact('categories'))->with(compact('category'));
        
    }

}
