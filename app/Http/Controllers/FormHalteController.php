<?php

namespace App\Http\Controllers;
use App\Models\Pekerja;
use App\Models\Shift;
use App\Models\Koridor;
use App\Models\Halte;


class FormHalteController extends Controller
{

    public function formhalte()
    {
        $pekerjas = Pekerja::all();
        $shifts = Shift::all();
        $koridors = Koridor::all();
        return view('user.halteuser', compact('shifts', 'pekerjas', 'koridors'));
    } 
    public function getHalteByKoridor($koridorId)
    {
        $haltes = Halte::where('koridor_id', $koridorId)->get();
        return response()->json($haltes);
    }
}
