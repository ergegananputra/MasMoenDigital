<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use League\CommonMark\Normalizer\SlugNormalizer;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
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
        $validator = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $name = $request->name;
        $slug = (new SlugNormalizer())->normalize($name);

        Category::create([
            'name' => $name,
            'slug' => $slug,
        ]);

        session()->flash('create', 'Kategori berhasil ditambahkan');

        return redirect()->route('management.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::all();
        return view('categories.index', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->slug = (new SlugNormalizer())->normalize($request->name);
        $category->save();

        session()->flash('update', 'Kategori berhasil diperbarui');

        return redirect()->route('management.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();

        session()->flash('delete', 'Kategori berhasil dihapus');

        return redirect()->route('management.categories.index');
    }
}
