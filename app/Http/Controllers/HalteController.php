<?php

namespace App\Http\Controllers;
use App\Models\Pekerja;
use App\Models\Shift;
use App\Models\Koridor;


class HalteController extends Controller
{

    public function formhalte()
    {
        $pekerjas = Pekerja::all();
        $shifts = Shift::all();
        $koridors = Koridor::all();
        return view('user.halteuser', compact('shifts', 'pekerjas', 'koridors'));
    } 
}
