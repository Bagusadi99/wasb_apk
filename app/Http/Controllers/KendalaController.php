<?php

namespace App\Http\Controllers;
use App\Models\KendalaHalte;
use App\Models\KendalaPool;
use Illuminate\Http\Request;

class KendalaController extends Controller
{
    public function list_kendala()
    {
        $kendala_halte = KendalaHalte::all();
        $kendala_pool = KendalaPool::all();
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
}
