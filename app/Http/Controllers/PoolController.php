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
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'pool_nama' => 'required|string|max:255',
            'koridor_id' => 'required|exists:koridor,koridor_id', // Pastikan shift_id ada di tabel shifts
        ]);

        Pool::create([
            'pool_nama' => $request->pool_nama,
            'koridor_id' => $request->koridor_id,
        ]);

        return redirect()->back()->with('success', 'Data pool berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'pool_nama' => 'required|string|max:255',
            'koridor_id' => 'required|exists:koridor,koridor_id',
        ]);

        $pool = Pool::findOrFail($id);
        // Update data pengawas
        $pool->update([
            'pool_nama' => $request->pool_nama,
            'koridor_id' => $request->koridor_id,
        ]);

        return redirect()->route('admin.pool.list_pool')->with('success', 'Data pool berhasil diupdate!.');
    }

    public function destroy($id)
    {
        $pool = Pool::findOrFail($id);
        $pool->delete();

        return redirect()->route('admin.pool.list_pool')->with('success', 'Data pool berhasil dihapus!');
    }

}