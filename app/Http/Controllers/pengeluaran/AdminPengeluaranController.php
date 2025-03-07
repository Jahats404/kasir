<?php

namespace App\Http\Controllers\pengeluaran;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminPengeluaranController extends Controller
{
    public function pengeluaran()
    {
        $pengeluaran = Pengeluaran::all();

        return view('admin.pengeluaran.pengeluaran',compact('pengeluaran'));
    }

    public function store_pengeluaran(Request $request)
    {
        $rules = [
            'tanggal_pengeluaran' => 'required|date',
            'jumlah' => 'required',
            'keterangan' => 'nullable|string',
        ];
        $messages = [
            'tanggal_pengeluaran.required' => 'Tanggal Pengeluaran tidak boleh kosong!',
            'tanggal_pengeluaran.date' => 'Tanggal Pengeluaran tidak valid!',
            'jumlah.required' => 'Jumlah tidak boleh kosong!',
            'keterangan.string' => 'Keterangan tidak valid!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pengeluaran = new Pengeluaran();
        $pengeluaran->id_pengeluaran = 'P' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $pengeluaran->tanggal_pengeluaran = $request->tanggal_pengeluaran;
        $pengeluaran->jumlah = $request->jumlah;
        $pengeluaran->keterangan = $request->keterangan;
        $pengeluaran->save();

        return redirect()->back()->with('success','Pengeluaran berhasil ditambahakan');
    }

    public function update_pengeluaran(Request $request,$id)
    {
        $rules = [
            'tanggal_pengeluaran' => 'required|date',
            'jumlah' => 'required',
            'keterangan' => 'nullable|string',
        ];
        $messages = [
            'tanggal_pengeluaran.required' => 'Tanggal Pengeluaran tidak boleh kosong!',
            'tanggal_pengeluaran.date' => 'Tanggal Pengeluaran tidak valid!',
            'jumlah.required' => 'Jumlah tidak boleh kosong!',
            'keterangan.string' => 'Keterangan tidak valid!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->id_pengeluaran = 'P' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $pengeluaran->tanggal_pengeluaran = $request->tanggal_pengeluaran;
        $pengeluaran->jumlah = $request->jumlah;
        $pengeluaran->keterangan = $request->keterangan;
        $pengeluaran->save();

        return redirect()->back()->with('success','Pengeluaran berhasil diperbarui');
    }

    public function delete_pengeluaran($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->delete();

        return redirect()->back()->with('success','Pengeluaran berhasil dihapus');
    }
}