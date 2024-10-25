<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPeserta extends Model
{
    protected $table = 'data_pesertas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nik',
        'namaLengkap',
        'nomorHandphone',
        'gender',
        'tanggalPendataan',
        'alamat',
        'imageUrl'
    ];

    protected function casts()
    {
        return [
            'tanggalPendataan' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }
}
