<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;

class Barang extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_barang';
    protected $table = 'barang';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'id_barang' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($barang) {
            $barang->barcode = self::generateBarcode($barang->id_barang);
        });
    }

    public static function generateBarcode($id)
    {
        return DNS1D::getBarcodePNGPath($id, 'C39');
    }

    public function jenis_barang()
    {
        return $this->belongsTo(JenisBarang::class,'jb_id','id_jb');
    }
    public function detail_transaksi()
    {
        return $this->hasMany(DetailTransaksi::class,'barang_id','id_barang');
    }

    public static $rules = [
        // 'id_barang' => 'required|string|unique:barang,id_barang|max:50',
        'nama_barang' => 'required|string|max:100',
        'jb_id' => 'required|exists:jenis_barang,id_jb',
        'merk' => 'required|string|max:50',
        'stok' => 'required|integer|min:0',
        'harga_beli' => 'required|integer|min:0',
        'harga_jual' => 'required|integer|min:0|gte:harga_beli',
        'keterangan' => 'nullable|string|max:255',
    ];
    
    public static $messages = [
        'id_barang.required' => 'ID Barang wajib diisi.',
        'id_barang.string' => 'ID Barang harus berupa string.',
        'id_barang.unique' => 'ID Barang sudah digunakan.',
        'id_barang.max' => 'ID Barang maksimal 50 karakter.',
        
        'nama_barang.required' => 'Nama Barang wajib diisi.',
        'nama_barang.string' => 'Nama Barang harus berupa string.',
        'nama_barang.max' => 'Nama Barang maksimal 100 karakter.',
        
        'jb_id.required' => 'Jenis Barang (ID) wajib diisi.',
        'jb_id.exists' => 'Jenis Barang tidak ditemukan dalam database.',
        
        'merk.required' => 'Merk wajib diisi.',
        'merk.string' => 'Merk harus berupa string.',
        'merk.max' => 'Merk maksimal 50 karakter.',
        
        'stok.required' => 'Stok wajib diisi.',
        'stok.integer' => 'Stok harus berupa angka.',
        'stok.min' => 'Stok tidak boleh kurang dari 0.',
        
        'harga_beli.required' => 'Harga Beli wajib diisi.',
        'harga_beli.integer' => 'Harga Beli harus berupa angka.',
        'harga_beli.min' => 'Harga Beli tidak boleh kurang dari 0.',
        
        'harga_jual.required' => 'Harga Jual wajib diisi.',
        'harga_jual.integer' => 'Harga Jual harus berupa angka.',
        'harga_jual.min' => 'Harga Jual tidak boleh kurang dari 0.',
        'harga_jual.gte' => 'Harga Jual harus lebih besar atau sama dengan Harga Beli.',
        
        'keterangan.string' => 'Keterangan harus berupa string.',
        'keterangan.max' => 'Keterangan maksimal 255 karakter.',
    ];
}