<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

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
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'halte_nama' => 'required|string|max:255',
            'koridor_id' => 'required|exists:koridor,koridor_id', 
        ]);

        Halte::create([
            'halte_nama' => $request->halte_nama,
            'koridor_id' => $request->koridor_id,
        ]);

        return redirect()->back()->with('success', 'Data halte berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Validasi request
        $request->validate([
            'halte_nama' => 'required|string|max:255',
            'koridor_id' => 'required|exists:koridor,koridor_id',
        ]);

        $halte = Halte::findOrFail($id);
        // Update data pengawas
        $halte->update([
            'halte_nama' => $request->halte_nama,
            'koridor_id' => $request->koridor_id,
        ]);

        return redirect()->route('admin.halte.list_halte')->with('success', 'Data halte berhasil diupdate!.');
    }
    public function destroy($id)
    {
        $halte = Halte::findOrFail($id);
        $halte->delete();

        return redirect()->route('admin.halte.list_halte')->with('success', 'Data halte berhasil dihapus!');
    }

}