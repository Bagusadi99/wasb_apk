<?php

namespace App\Http\Controllers;
use App\Models\KendalaHalte;
use App\Models\KendalaPool;
use Illuminate\Http\Request;

class KendalaController extends Controller
{
    public function list_kendala()
    {
        $kendala_halte = KendalaHalte::orderBy('kendala_halte_id', 'desc')->get();
        $kendala_pool = KendalaPool::orderBy('kendala_pool_id', 'desc')->get();
        return view('admin.kendala.list_kendala', compact('kendala_halte', 'kendala_pool'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tipe' => 'required|in:pool,halte',
        ]);

        if ($request->tipe == 'pool') {
            KendalaPool::create([
                'kendala_pool' => $request->kendala_pool,
            ]);
        } else {
            KendalaHalte::create([
                'kendala_halte' => $request->kendala_halte,
            ]);
        }
        return redirect()->back()->with('success', 'Kendala berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'tipe' => 'required|in:pool,halte',
        ]);

        if ($request->tipe == 'pool') {
            KendalaPool::findOrFail($id)->update([
                'kendala_pool' => $request->kendala_pool,
            ]);
        } else {
            KendalaHalte::findOrFail($id)->update([
                'kendala_halte' => $request->kendala_halte,
            ]);
        }
        return redirect()->back()->with('success', 'Kendala berhasil diupdate.');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->tipe === 'halte') {
            $kendala = KendalaHalte::findOrFail($id);
        } elseif ($request->tipe === 'pool') {
            $kendala = KendalaPool::findOrFail($id);
        } else {
            return redirect()->back()->withErrors(['Tipe kendala tidak valid.']);
        }

        $kendala->delete();
        return redirect()->back()->with('success', 'Data kendala berhasil dihapus.');
    }
}
