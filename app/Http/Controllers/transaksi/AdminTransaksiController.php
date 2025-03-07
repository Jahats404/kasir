<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\JenisBarang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminTransaksiController extends Controller
{
    public function daftar_transaksi()
    {
        $transaksi = Transaksi::orderBy('created_at','DESC')->get();
        $jb = JenisBarang::all();
        $barang = Barang::all();

        return view('admin.transaksi.daftar-transaksi',compact('barang','jb','transaksi'));
    }
    
    public function transaksi()
    {
        $transaksi = Transaksi::all();
        $jb = JenisBarang::all();
        // $barang = Barang::orderBy('jb_id','asc')->get();
        $barang = Barang::select('barang.*')
                ->join('jenis_barang', 'barang.jb_id', '=', 'jenis_barang.id_jb')
                ->orderBy('jenis_barang.nama_jenis', 'asc')
                ->get();

        return view('admin.transaksi.transaksi',compact('barang','jb'));
    }

    public function store_transaksi(Request $request)
    {
        // Mulai transaksi database untuk memastikan semua data dimasukkan dengan benar
        DB::beginTransaction();
        try {
            // Membuat ID transaksi unik
            $idTransaksi = 'TRX-' . Str::upper(Str::random(6));

            // Membuat data transaksi
            $transaksi = new Transaksi();
            $transaksi->id_transaksi = $idTransaksi;
            $transaksi->tanggal = now()->toDateString();
            $transaksi->total_harga = (int) str_replace(['Rp', '.'], '', $request->total);
            $transaksi->diskon = $request->diskon ? (int) str_replace('%', '', $request->diskon) : 0;
            $transaksi->keterangan = $request->keterangan ?? null;
            $transaksi->save();

            // Loop untuk menyimpan detail transaksi dan mengurangi stok barang
            foreach ($request->barang as $barangData) {
                $barangId = $barangData['id']; 
                $jumlah = (int) $barangData['jumlah']; 
                $hargaSatuan = (int) $barangData['harga']; 
                $subTotal = $jumlah * $hargaSatuan; 

                // Cek stok barang sebelum mengurangi
                $barang = Barang::find($barangId);
                if (!$barang || $barang->stok < $jumlah) {
                    DB::rollback(); // Rollback jika stok tidak mencukupi
                    return redirect()->back()->with('error', "Stok barang {$barang->nama_barang} tidak mencukupi!");
                }

                // Simpan detail transaksi
                $detailTransaksi = new DetailTransaksi();
                $detailTransaksi->id_dt = 'DT-' . Str::upper(Str::random(6));
                $detailTransaksi->jumlah = $jumlah;
                $detailTransaksi->harga_satuan = $hargaSatuan;
                $detailTransaksi->sub_total = $subTotal;
                $detailTransaksi->transaksi_id = $idTransaksi;
                $detailTransaksi->barang_id = $barangId;
                $detailTransaksi->save();

                // Kurangi stok barang
                $barang->stok -= $jumlah;
                $barang->save();
            }

            // Commit transaksi jika berhasil
            DB::commit();
            return redirect()->back()->with('success', 'Transaksi berhasil disimpan');

        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete_transaksi($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->delete();

        return redirect()->back()->with('success','Transaksi berhasil dihapus');
    }

    public function cetakNota($id)
    {
        // Ambil data transaksi
        $transaksi = Transaksi::with('detail_transaksi.barang')->findOrFail($id);

        // Buat file PDF menggunakan view 'nota'
        $pdf = Pdf::loadView('admin.nota.nota', compact('transaksi'));

        // Unduh file PDF
        return $pdf->stream('Nota_Transaksi_' . $transaksi->id_transaksi . '.pdf');
    }

    public function scan()
    {
        return view('admin.barcode.scan');
    }

    public function getBarangByBarcode(Request $request)
    {
        $barcode = $request->barcode;
        $barang = Barang::with('jenis_barang')->where('id_barang',$barcode)->first();


        if ($barang) {
            return response()->json(['success' => true, 'data' => $barang]);
            // return response()->json(['success' => false, 'message' => 'Barang ditemukan ' . $barcode]);
        } else {
            return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan ' . $barcode]);
        }
    }
}