<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koridor;

class KoridorController extends Controller
{
    public function list_koridor()
    {
        $koridor = Koridor::all();
        return view('admin.koridor.list_koridor', compact('koridor'));
    }

}