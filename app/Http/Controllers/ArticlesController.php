<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleViews;
use App\Models\Category;
use App\Models\Tag;
use HTMLPurifier;
use HTMLPurifier_Config;
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
    public function index(Request $request)
    {
        $category = $request->category;
        $keyword = $request->search;

        $query = Article::query();

        if (!is_null($category)) {
            $query->orWhere('category_id', $category);
        }

        if (!is_null($keyword)) {
            $query->orWhere('title', 'like', '%' . $keyword . '%');
            $query->orWhere('content', 'like', '%' . $keyword . '%');
        }

        $articles = $query->orderBy('updated_at', 'desc')->paginate(12);

        $categories = Category::all();
        return view('articles.index', compact('articles', 'categories'));
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

    private function validate(Request $request) {
        $rules = [
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'title' => 'required',
            'category' => 'required|exists:categories,id',
            'whatsapp_name' => 'nullable|string', // nullable
            'whatsapp_number' => 'nullable|numeric', // nullable
            'content' => 'required',
            'price' => 'nullable|numeric', // nullable
            'unit' => 'nullable|string', // nullable
            'address' => 'nullable|string',
            'google_maps' => 'nullable|string',
            'google_maps_embeded' => 'nullable|string',
        ];

        $photos = $request->file('photos');
        if ($photos != null) {
            $rules['photos.*'] = 'image|mimes:jpeg,png,jpg,gif,svg';
        }

        $tags = $request->tags;
        if ($tags != null) {
            $rules['tags.*'] = 'string';
        }

        $result = $request->validate($rules);

        // sanitize the content
        $result['content'] = $this->purify($result['content']);
        if ($tags != null) {
            $result['tags'] = array_map(function($tag) {
                return $this->purify($tag);
            }, $tags);
        }


        return $result;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = (object) $this->validate($request);

        // get all photos from the request
        $photos = $request->file('photos');

        // get all tags from the request
        $tags = $validator->tags;

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

        $clean_content = $validator->content;

        // saving the article
        $article = Article::create([
            "slug" => $this->slugify($title),
            "title" => $title,
            "content" => $clean_content,
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

        return redirect()->route('articles.show', $article);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $slug)
    {
        $article = Article::where('slug', $slug)->first();

        try {
            ArticleViews::create([
                'article_id' => $article->id,
                'user_id' => Auth::id(),
                'ip_address' => $request->getClientIp(),
            ]);
        } catch (\Exception $e) {
            Log::error(__METHOD__ . ' - ' . $e->getMessage());
        }

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

        $validator = (object) $this->validate($request);

        // get all photos from the request
        $photos = $request->file('photos');

        // get all tags from the request
        $tags = $validator->tags;

        // saving the thumbnail

        // check if there is a new thumbnail
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $title = $request->title;
            $thumbnailExtension = $thumbnail->extension();
            $thumbnailName = $this->slugify($title . "-" . $thumbnail->getClientOriginalName());
            $thumbnailFilename = $thumbnailName. "." . $thumbnailExtension;
            $thumbnailPath = $thumbnail->storeAs('public/uploads', $thumbnailFilename);

            $article->thumbnail_path = Storage::url($thumbnailPath);
        }


        // check if the embed_gmaps_link is new
        if ($request->google_maps_embeded != $article->google_maps_embed) {
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
            $article->google_maps_embed = $embed_gmaps_link;
        }

        // check if the title is new and update the slug
        if ($request->title != $article->title) {
            $article->title = $request->title;
            $article->slug = $this->slugify($request->title);
        }

        $clean_content = $validator->content;

        // saving the article
        $article->content = $clean_content;
        $article->whatsapp_name = $request->whatsapp_name;
        $article->whatsapp_number = $request->whatsapp_number;
        $article->price = $request->price;
        $article->unit = $request->unit;
        $article->address = $request->address;
        $article->google_maps = $request->google_maps;

        $article->category_id = $request->category;

        $article->save();

        // saving the tags
        $article->tags()->detach();
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

        $title = $article->title;

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

        return redirect()->route('articles.show', $article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $article = Article::where('slug', $slug)->first();
        try {
            $article->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return redirect()->route('management.index');
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
        $date = now()->format('Y-m-ds');
        $slug = (new SlugNormalizer())->normalize($text . "-" . $date);
        return $slug;
    }

    private function purify(string $html) : string
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'b,strong,i,em,u,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
        $purifier = new HTMLPurifier($config);

        return $purifier->purify($html);
    }
}
