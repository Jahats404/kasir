<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_dt';
    protected $table = 'detail_transaksi';
    protected $guarded = [];
    protected $casts = [
        'id_dt' => 'string',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class,'barang_id','id_barang');
    }
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class,'transaksi_id','id_transaksi');
    }
}