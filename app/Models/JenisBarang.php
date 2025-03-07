<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_jb';
    protected $table = 'jenis_barang';
    protected $guarded = [];
    protected $casts = [
        'id_jb' => 'string',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class,'jb_id','id_jb');
    }
}