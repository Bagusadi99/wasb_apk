<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Pekerja;
use App\Models\Shift;

class ShiftController extends Controller
{
    // Menampilkan daftar pengawas
    public function list_shift()
    {
        $shift = Shift::all(); // Ambil semua data shift
        return view('admin.shift.list_shift', compact('shift')); // Kirim data ke view
    }
    public function store(Request $request)
    {
        
        // Validasi data yang dikirim dari form
        $request->validate([
            'shift_nama' => 'required|string|max:255', // Pastikan shift_id ada di tabel shifts
        ]);

        // Simpan data ke database
        Shift::create([
            'shift_nama' => $request->shift_nama,
        ]);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data shift berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Validasi request
        $request->validate([
            'shift_nama' => 'required',
        ]);

        // Cari pengawas berdasarkan ID
        $shift = Shift::findOrFail($id);
        $shift->update([
            'shift_nama' => $request->shift_nama,
        ]);

        // Redirect atau response sesuai kebutuhan
        return redirect()->route('admin.shift.list_shift')->with('success', 'Data shift berhasil diupdate!.');
    }

    public function destroy($id)
    {
        $shift = shift::findOrFail($id);
        $shift->delete();

        return redirect()->route('admin.shift.list_shift')->with('success', 'Data shift berhasil dihapus!');
    }

}