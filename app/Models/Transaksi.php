<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaksi';
    protected $table = 'transaksi';
    protected $guarded = [];
    protected $casts = [
        'id_transaksi' => 'string',
    ];

    public function detail_transaksi()
    {
        return $this->hasMany(DetailTransaksi::class,'transaksi_id','id_transaksi');
    }
}