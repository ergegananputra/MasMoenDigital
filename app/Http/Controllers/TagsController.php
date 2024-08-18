<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use League\CommonMark\Normalizer\SlugNormalizer;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();

        return view('tags.index', compact('tags'));
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

        Tag::create([
            'name' => $name,
            'slug' => $slug,
        ]);

        session()->flash('create', 'Tag berhasil ditambahkan');

        return redirect()->route('management.tags.index');
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
        $tag = Tag::findOrFail($id);
        $tags = Tag::all();

        return view('tags.index', compact('tag', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $name = $request->name;
        $slug = (new SlugNormalizer())->normalize($name);

        Tag::findOrFail($id)->update([
            'name' => $name,
            'slug' => $slug,
        ]);

        session()->flash('update', 'Tag berhasil diperbarui');

        return redirect()->route('management.tags.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Tag::findOrFail($id)->delete();

        session()->flash('delete', 'Tag berhasil dihapus');

        return redirect()->route('management.tags.index');
    }
}
