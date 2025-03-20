<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pekerja;
use App\Models\Shift;

class PengawasController extends Controller
{
    // Menampilkan daftar pengawas
    public function list_pengawas()
    {
        $pekerja = Pekerja::with('shift')->get(); // Ambil data pekerja beserta relasi shift
        $shift = Shift::all();
        // dd($shifts);
        return view('admin.pengawas.list_pengawas', compact('pekerja', 'shift')); // Kirim data ke view
    }
    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi data yang dikirim dari form
        $request->validate([
            'nama_pekerja' => 'required|string|max:255',
            'shift_id' => 'required|exists:shift,shift_id', // Pastikan shift_id ada di tabel shifts
        ]);

        // Simpan data ke database
        Pekerja::create([
            'nama_pekerja' => $request->nama_pekerja,
            'shift_id' => $request->shift_id,
        ]);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data pengawas berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Validasi request
        $request->validate([
            'nama_pekerja' => 'required|string|max:255',
            'shift_id' => 'required|exists:shift,shift_id',
        ]);

        // Cari pengawas berdasarkan ID
        $pekerja = Pekerja::findOrFail($id);
        // Update data pengawas
        $pekerja->update([
            'nama_pekerja' => $request->nama_pekerja,
            'shift_id' => $request->shift_id,
        ]);

        // Redirect atau response sesuai kebutuhan
        return redirect()->route('admin.pengawas.list_pengawas')->with('success', 'Data pengawas berhasil diupdate!.');
    }

    public function destroy($id)
    {
        $pekerja = Pekerja::findOrFail($id);
        $pekerja->delete();

        return redirect()->route('admin.pengawas.list_pengawas')->with('success', 'Data pengawas berhasil dihapus!');
    }

}