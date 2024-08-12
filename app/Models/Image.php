<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';
    protected $primaryKey = 'id';
    protected $fillable = [
        'path',
        'name',
        'slug',
        'article_id'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function getPathAttribute($value)
    {
        return $value
            ? asset('storage/' . $value)
            : asset('images/no-thumbnail.png');
    }


}
