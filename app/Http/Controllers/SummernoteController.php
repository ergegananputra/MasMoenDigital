<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Normalizer\SlugNormalizer;

class SummernoteController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $photo = $request->file;
    
        $originalName = $photo->getClientOriginalName();
        $extension = $photo->extension();
        $photoName = $this->slugify($originalName);
        $photoFilename = $photoName. "." . $extension;
        $photoPath = $photo->storeAs('public/uploads', $photoFilename);

    
        return response()->json([
            'url' => asset(Storage::url($photoPath)),
        ]);
    }

    private function slugify(string $text): string
    {
        $date = now()->format('Y-m-ds');
        $slug = (new SlugNormalizer())->normalize($text . "-" . $date);
        return $slug;
    }
}
