<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pekerja;
use App\Models\Shift;

class ShiftController extends Controller
{
    // Menampilkan daftar pengawas
    public function list_shift()
    {
        $shifts = Shift::all(); // Ambil semua data shift
        return view('admin.shift.list_shift', compact('shifts')); // Kirim data ke view
    }

}