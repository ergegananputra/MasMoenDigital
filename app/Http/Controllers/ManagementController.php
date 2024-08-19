<?php

namespace App\Http\Controllers;


use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $category = $request->category;
        $keyword = $request->search;

        $query = Article::query();

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        if (!is_null($category)) {
            $query->orWhere('category_id', $category);
        }

        if (!is_null($keyword)) {
            $query->orWhere('title', 'like', '%' . $keyword . '%');
            $query->orWhere('content', 'like', '%' . $keyword . '%');
        }

        $articles = $query->orderBy('updated_at', 'desc')->paginate(12);
    
        $categories = Category::all();

        return view('management.index', compact('articles', 'categories'));
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
