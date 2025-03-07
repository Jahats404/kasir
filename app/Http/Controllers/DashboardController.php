<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisBarang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jb = JenisBarang::count();
        $barang = Barang::count();
        $transaksi = Transaksi::count();
        
        return view('dashboard.dashboard',compact('jb','barang','transaksi'));
    }
}