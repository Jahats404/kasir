<?php

namespace App\Http\Controllers\barang;

use App\Http\Controllers\Controller;
use App\Imports\BarangImport;
use App\Models\Barang;
use App\Models\JenisBarang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AdminBarangController extends Controller
{
    public function jb()
    {
        $jb = JenisBarang::orderBy('nama_jenis','asc')->get();

        return view('admin.barang.jenis-barang',compact('jb'));
    }
    
    public function store_jb(Request $request)
    {
        $rules = [
            'nama_jenis' => 'required',
            'keterangan' => 'nullable|string',
        ];
        $messages = [
            'nama_jenis.required' => 'Nama Jenis Barang tidak boleh kosong!',
            'keterangan.string' => 'Keterangan tidak valid!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jb = new JenisBarang();
        $jb->id_jb = 'JB' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $jb->nama_jenis = $request->nama_jenis;
        $jb->keterangan = $request->keterangan;
        $jb->save();

        return redirect()->back()->with('success','Jenis Barang berhasil ditambahkan');
    }

    public function update_jb(Request $request,$id)
    {
        $rules = [
            'nama_jenis' => 'required',
            'keterangan' => 'nullable|string',
        ];
        $messages = [
            'nama_jenis.required' => 'Nama Jenis Barang tidak boleh kosong!',
            'keterangan.string' => 'Keterangan tidak valid!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jb = JenisBarang::find($id);
        $jb->nama_jenis = $request->nama_jenis;
        $jb->keterangan = $request->keterangan;
        $jb->save();

        return redirect()->back()->with('success','Jenis Barang berhasil diperbarui');
    }

    public function delete_jb($id)
    {
        $jb = JenisBarang::find($id);
        $jb->delete();

        return redirect()->back()->with('success','Jenis Barang berhasil dihapus');
    }


    // ====================================== BARANG ==========================================================================

    public function barang()
    {
        $jb = JenisBarang::all();
        // $barang = Barang::all();
        $barang = Barang::select('barang.*')
                ->join('jenis_barang', 'barang.jb_id', '=', 'jenis_barang.id_jb')
                ->orderBy('jenis_barang.nama_jenis', 'asc')
                ->get();

        return view('admin.barang.barang',compact('jb','barang'));
    }

    public function store_barang(Request $request)
    {
        // Lakukan validasi
        $validator = Validator::make($request->all(), Barang::$rules, Barang::$messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $barang = new Barang();
        $barang->id_barang = 'B' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $barang->nama_barang = $request->nama_barang;
        $barang->jb_id = $request->jb_id;
        $barang->merk = $request->merk;
        $barang->stok = $request->stok;
        $barang->harga_beli = $request->harga_beli;
        $barang->harga_jual = $request->harga_jual;
        $barang->keterangan = $request->keterangan;
        $barang->save();

        return redirect()->back()->with('success','Barang berhasil ditambahkan');
    }

    public function update_barang(Request $request, $id)
    {
         // Lakukan validasi
        $validator = Validator::make($request->all(), Barang::$rules, Barang::$messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $barang = Barang::find($id);
        $barang->nama_barang = $request->nama_barang;
        $barang->jb_id = $request->jb_id;
        $barang->merk = $request->merk;
        $barang->stok = $request->stok;
        $barang->harga_beli = $request->harga_beli;
        $barang->harga_jual = $request->harga_jual;
        $barang->keterangan = $request->keterangan;
        $barang->save();

        return redirect()->back()->with('success','Barang berhasil diperbarui');
    }

    public function delete_barang($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        return redirect()->back()->with('success','Barang berhasil dihapus');
    }

    public function import(Request $request)
    {
        // Validasi file Excel
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Proses import menggunakan BarangImport
        Excel::import(new BarangImport, $request->file('file'));

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data barang berhasil diimport!');
    }

    public function printBarcode(Request $request)
    {
        // Ambil ID barang dari request
        $barangIds = explode(',', $request->barang);

        // Ambil data barang berdasarkan ID yang dipilih
        $barangList = Barang::whereIn('id_barang', $barangIds)->get();

        // Generate PDF
        $pdf = Pdf::loadView('admin.barcode.barcode_pdf', compact('barangList'))
                    ->setPaper('a4', 'portrait');

        return $pdf->stream('barcode.pdf');
    }
}