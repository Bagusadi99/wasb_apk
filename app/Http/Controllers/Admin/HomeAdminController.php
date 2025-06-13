<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Halte;
use App\Models\Pool;
use App\Models\Pekerja;
use App\Models\Koridor;

use Illuminate\Http\Request;

class HomeAdminController extends Controller
{
    public function homeadmin(){
        $halte = Halte::count();
        $pool = Pool::count();
        $pekerja = Pekerja::count();
        $koridor = Koridor::count();
        return view('admin.homeadmin', compact('halte', 'pool', 'pekerja', 'koridor'));
    }
}
