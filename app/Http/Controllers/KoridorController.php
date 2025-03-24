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
    public function store(Request $request)
    {
        
        // Validasi data yang dikirim dari form
        $request->validate([
            'koridor_nama' => 'required|string|max:255', // Pastikan shift_id ada di tabel shifts
        ]);

        // Simpan data ke database
        Koridor::create([
            'koridor_nama' => $request->koridor_nama,
        ]);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data koridor berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Validasi request
        $request->validate([
            'koridor_nama' => 'required|string|max:255',
        ]);

        // Cari pengawas berdasarkan ID
        $koridor = Koridor::findOrFail($id);
        $koridor->update([
            'koridor_nama' => $request->koridor_nama,
        ]);

        // Redirect atau response sesuai kebutuhan
        return redirect()->route('admin.koridor.list_koridor')->with('success', 'Data koridor berhasil diupdate!.');
    }
    public function destroy($id)
    {
        $koridor = Koridor::findOrFail($id);
        $koridor->delete();

        return redirect()->route('admin.koridor.list_koridor')->with('success', 'Data koridor berhasil dihapus!');
    }

}