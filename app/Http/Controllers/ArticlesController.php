<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Normalizer\SlugNormalizer;
use Illuminate\Support\Str;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('articles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('articles.form', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'title' => 'required',
            'category' => 'required|exists:categories,id',
            'whatsapp_name' => 'required|string',
            'whatsapp_number' => 'required|numeric',
            'content' => 'required',
            'price' => 'required|numeric',
            'unit' => 'required|string',
            'address' => 'nullable|string',
            'google_maps' => 'nullable|string',
            'google_maps_embeded' => 'nullable|string',
        ]);

        // get all photos from the request
        $photos = $request->file('photos');

        // get all tags from the request
        $tags = $request->tags;

        // saving the thumbnail
        $thumbnail = $request->file('thumbnail');
        $title = $request->title;
        $thumbnailExtension = $thumbnail->extension();
        $thumbnailName = $this->slugify($title . "-" . $thumbnail->getClientOriginalName());
        $thumbnailFilename = $thumbnailName. "." . $thumbnailExtension;
        $thumbnailPath = $thumbnail->storeAs('public/uploads', $thumbnailFilename);

        $embed_gmaps_link = $request->google_maps_embeded;
        if ($embed_gmaps_link) {
            if (Str::startsWith($embed_gmaps_link, 'https://www.google.com/maps/embed')) {
                $embed_gmaps_link = $request->embed_gmaps_link;
            } else if (Str::startsWith($embed_gmaps_link, '<iframe')) {
                $url = explode('"', $embed_gmaps_link)[1];
                $embed_gmaps_link = $url;
            }
        } else {
            $embed_gmaps_link = "";
        }

        // saving the article
        $article = Article::create([
            "slug" => $this->slugify($title),
            "title" => $title,
            "content" => $request->content,
            "whatsapp_name" => $request->whatsapp_name,
            "whatsapp_number" => $request->whatsapp_number,
            "price" => $request->price,
            "unit" => $request->unit,
            "address" => $request->address,
            "google_maps" => $request->google_maps,
            "google_maps_embed" => $embed_gmaps_link,

            "is_active" => true,
            "is_featured" => false,
            "featured_end_date" => now(),

            "category_id" => $request->category,
            "user_id" => Auth::user()->id,

            "thumbnail_path" => Storage::url($thumbnailPath),
        ]);

        // saving the tags
        foreach ($tags as $tagId) {
            // find or create the tag
            $tag = Tag::find($tagId);
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $tagId,
                    'slug' => $this->slugify($tagId),
                ]);
            }

            // attach the tag to the article
            $article->tags()->attach($tag->id);

            // save the tag
            $tag->save();
        }

        // saving the photos
        if($photos != null) {
            foreach ($photos as $photo) {
                $originalName = $photo->getClientOriginalName();
                $extension = $photo->extension();
                $photoName = $this->slugify($title . "-". $originalName);
                $photoFilename = $photoName. "." . $extension;
                $photoPath = $photo->storeAs('public/uploads', $photoFilename);
                $article->images()->create([
                    'path' => Storage::url($photoPath),
                    'name' => $originalName,
                    'slug' => $this->slugify($photoName),
                    'article_id' => $article->id,
                ]);
            }
        }

        return redirect()->route('management.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $article = Article::where('slug', $slug)->first();
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $isEdit = true;
        $article = Article::where('slug', $slug)->first();
        $tags = Tag::all();
        $categories = Category::all();
        return view('articles.form', compact('isEdit', 'article', 'tags', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $article = Article::where('slug', $slug)->first();

        $validator = $request->validate([
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'title' => 'required',
            'category' => 'required|exists:categories,id',
            'whatsapp_name' => 'required|string',
            'whatsapp_number' => 'required|numeric',
            'content' => 'required',
            'price' => 'required|numeric',
            'unit' => 'required|string',
            'address' => 'nullable|string',
            'google_maps' => 'nullable|string',
            'google_maps_embeded' => 'nullable|string',
        ]);

        // get all photos from the request
        $photos = $request->file('photos');

        // get all tags from the request
        $tags = $request->tags;

        // saving the thumbnail
        $thumbnail = $request->file('thumbnail');
        $title = $request->title;
        $thumbnailExtension = $thumbnail->extension();
        $thumbnailName = $this->slugify($title . "-" . $thumbnail->getClientOriginalName());
        $thumbnailFilename = $thumbnailName. "." . $thumbnailExtension;
        $thumbnailPath = $thumbnail->storeAs('public/uploads', $thumbnailFilename);

        $embed_gmaps_link = $request->google_maps_embeded;
        if ($embed_gmaps_link) {
            if (Str::startsWith($embed_gmaps_link, 'https://www.google.com/maps/embed')) {
                $embed_gmaps_link = $request->embed_gmaps_link;
            } else if (Str::startsWith($embed_gmaps_link, '<iframe')) {
                $url = explode('"', $embed_gmaps_link)[1];
                $embed_gmaps_link = $url;
            }
        } else {
            $embed_gmaps_link = "";
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        //
    }

    public function destroyPhoto(Article $article, string $photoID)
    {
        Log::info($photoID);
        $photo = $article->images()->where('id', $photoID)->first();
        $photo->delete();

        return redirect()->back();
    }

    private function slugify(string $text): string
    {
        $slug = (new SlugNormalizer())->normalize($text);
        return $slug;
    }
}
