<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'slug',
        'title',
        'content',
        'whatsapp_name',
        'whatsapp_number',
        'price',
        'unit',
        'address',
        'google_maps',
        'google_maps_embed',

        'is_active',
        'is_featured',
        'featured_end_date',

        'category_id',
        'user_id',

        'thumbnail_path'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path
            ? asset($this->thumbnail_path)
            : asset('images/no-thumbnail.png');
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d F Y H:i');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->format('d F Y H:i');
    }

    public function getWhatsappLinkAttribute()
    {
        return 'https://wa.me/' . $this->whatsapp_number . '?text=' . rawurlencode('Halo, saya tertarik dengan iklan ' . $this->title);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getShortContentAttribute()
    {
        $cleanTextWithoutHTML = strip_tags($this->content);
        return substr($cleanTextWithoutHTML, 0, 100) . '...';
    }


}
