<?php

namespace App\Http\Controllers;
use App\Models\Pekerja;
use App\Models\Shift;
use App\Models\Koridor;


class FormPoolController extends Controller
{

    public function formpool()
    {
        $pekerjas = Pekerja::all();
        $shifts = Shift::all();
        $koridors = Koridor::all();
        return view('user.pooluser', compact('shifts', 'pekerjas', 'koridors'));
    } 
}
