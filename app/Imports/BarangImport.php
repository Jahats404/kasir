<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\JenisBarang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class BarangImport implements ToModel, WithHeadingRow
{
    /**
     * Proses setiap baris data dari Excel.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function generateUniqueIdBarang()
    {
        do {
            $id = 'B' . Str::upper(Str::random(4)); // Menghasilkan Bxxxx (5 digit)
        } while (Barang::where('id_barang', $id)->exists());
    
        return $id;
    }
    public function generateUniqueIdJenisBarang()
    {
        do {
            $id = 'JB' . Str::upper(Str::random(4)); // Menghasilkan Bxxxx (5 digit)
        } while (JenisBarang::where('id_jb', $id)->exists());
    
        return $id;
    }
    
    public function model(array $row)
    {
        // Mencari id_jenis_barang berdasarkan nama jenis
        $jenisBarang = JenisBarang::where('nama_jenis', 'like', '%' . $row['jenis_barang'] . '%')->first();

        // Jika jenis barang tidak ditemukan, buat yang baru
        if (!$jenisBarang) {
            $jenisBarang = new JenisBarang();
            $jenisBarang->id_jb = $this->generateUniqueIdJenisBarang();
            $jenisBarang->nama_jenis = $row['jenis_barang'];
            $jenisBarang->keterangan = $row['keterangan'] ?? null;
            $jenisBarang->save();
        }

        $jenisBarang = JenisBarang::where('nama_jenis', 'like', '%' . $row['jenis_barang'] . '%')->first();

        // Membuat instance Barang
        return new Barang([
            'id_barang' => $this->generateUniqueIdBarang(),
            'nama_barang' => $row['nama_barang'], // Nama Barang
            'jb_id' => $jenisBarang->id_jb, // ID Jenis Barang yang sudah ditemukan atau dibuat
            'merk' => $row['merk'], // Merek Barang
            'stok' => $row['stok'], // Stok Barang
            'harga_beli' => $row['harga_beli'], // Harga Beli Barang
            'harga_jual' => $row['harga_jual'], // Harga Jual Barang
            'keterangan' => $row['keterangan'] ?? null, // Keterangan Barang
        ]);
    }
}