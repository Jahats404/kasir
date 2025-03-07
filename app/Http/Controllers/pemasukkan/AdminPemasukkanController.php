<?php

namespace App\Http\Controllers\pemasukkan;

use App\Http\Controllers\Controller;
use App\Models\JenisBarang;
use App\Models\Pemasukkan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminPemasukkanController extends Controller
{
    public function pemasukkan()
    {
        $pemasukkan =Pemasukkan::all();
        // // $row = 'plastik';
        // // $cekJb = JenisBarang::where('nama_jenis','like', '%' . $row . '%')->first()->id_jb;
        // dd($cekJb);
        return view('admin.pemasukkan.pemasukkan',compact('pemasukkan'));
    }

    public function store_pemasukkan(Request $request)
    {
        $rules = [
            'tanggal_pemasukkan' => 'required|date',
            'jumlah' => 'required',
            'keterangan' => 'nullable|string',
        ];
        $messages = [
            'tanggal_pemasukkan.required' => 'TanggalPemasukkan tidak boleh kosong!',
            'tanggal_pemasukkan.date' => 'TanggalPemasukkan tidak valid!',
            'jumlah.required' => 'Jumlah tidak boleh kosong!',
            'keterangan.string' => 'Keterangan tidak valid!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pemasukkan = new Pemasukkan();
        $pemasukkan->id_pemasukkan = 'P' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $pemasukkan->tanggal_pemasukkan = $request->tanggal_pemasukkan;
        $pemasukkan->jumlah = $request->jumlah;
        $pemasukkan->keterangan = $request->keterangan;
        $pemasukkan->save();

        return redirect()->back()->with('success','Pemasukkan berhasil ditambahakan');
    }

    public function update_pemasukkan(Request $request,$id)
    {
        $rules = [
            'tanggal_pemasukkan' => 'required|date',
            'jumlah' => 'required',
            'keterangan' => 'nullable|string',
        ];
        $messages = [
            'tanggal_pemasukkan.required' => 'TanggalPemasukkan tidak boleh kosong!',
            'tanggal_pemasukkan.date' => 'TanggalPemasukkan tidak valid!',
            'jumlah.required' => 'Jumlah tidak boleh kosong!',
            'keterangan.string' => 'Keterangan tidak valid!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pemasukkan =Pemasukkan::find($id);
        $pemasukkan->id_pemasukkan = 'P' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $pemasukkan->tanggal_pemasukkan = $request->tanggal_pemasukkan;
        $pemasukkan->jumlah = $request->jumlah;
        $pemasukkan->keterangan = $request->keterangan;
        $pemasukkan->save();

        return redirect()->back()->with('success','Pemasukkan berhasil diperbarui');
    }

    public function delete_pemasukkan($id)
    {
        $pemasukkan =Pemasukkan::find($id);
        $pemasukkan->delete();

        return redirect()->back()->with('success','Pemasukkan berhasil dihapus');
    }
}