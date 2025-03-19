<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koridor;
use App\Models\Pool;

class PoolController extends Controller
{
    public function list_pool()
    {
        $pool = Pool::with('koridor')->get();
        // dd($halte->toArray());
        $koridor = Koridor::all();
        return view('admin.pool.list_pool', compact('koridor', 'pool'));
    }

}