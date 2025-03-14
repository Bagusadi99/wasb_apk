<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koridor;
use App\Models\Halte;

class HalteController extends Controller
{
    public function list_halte()
    {
        $halte = Halte::with('koridor')->get();
        // dd($halte->toArray());
        $koridor = Koridor::all();
        return view('admin.halte.list_halte', compact('koridor', 'halte'));
    }

}