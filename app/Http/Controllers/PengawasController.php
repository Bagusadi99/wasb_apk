<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pekerja;
use App\Models\Shift;

class PengawasController extends Controller
{
    public function list_pengawas()
    {
        $pekerja = Pekerja::with('shift')->get();
        $shifts = Shift::all(); 
        return view('admin.pengawas.list_pengawas', compact('pekerja', 'shifts'));
    }

}