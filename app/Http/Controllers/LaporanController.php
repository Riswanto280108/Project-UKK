<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::orderBy('periode', 'desc')->get();
        return view('laporan.index', compact('laporans'));
    }
}
