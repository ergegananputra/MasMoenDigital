<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPesertaAuthKey extends Model
{
    use HasFactory;

    protected $table = 'data_peserta_auth_keys';
    protected $primaryKey = 'key';
    protected $fillable = [
        'key'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public $incrementing = false;
    
}
