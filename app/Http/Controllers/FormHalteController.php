<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pekerja;
use App\Models\Shift;
use App\Models\Koridor;
use App\Models\Halte;
use App\Models\LaporanHalte;

class FormHalteController extends Controller
{
    public function formhalte()
    {
        $pekerja = Pekerja::all();
        $shift = Shift::all();
        $koridor = Koridor::all();
        return view('user.halteuser', compact('shift', 'pekerja', 'koridor'));
    } 

    public function getHalteByKoridor($koridorId)
    {
        $halte = Halte::where('koridor_id', $koridorId)->get();
        return response()->json($halte);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pekerja_id' => 'required|exists:pekerja,pekerja_id',
            'shift_id' => 'required|exists:shift,shift_id',
            'koridor_id' => 'required|exists:koridor,koridor_id',
            'halte_id' => 'required|exists:halte,halte_id',
            'tanggal_waktu_halte' => 'required|date',
            'lokasi_halte' => 'required|string|max:255',
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^-?\d{1,3}\.\d{4,8}$/', $value)) {
                        $fail('Format latitude tidak valid. Gunakan format desimal dengan 4-8 digit presisi.');
                    }
                },
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^-?\d{1,3}\.\d{4,8}$/', $value)) {
                        $fail('Format longitude tidak valid. Gunakan format desimal dengan 4-8 digit presisi.');
                    }
                },
            ],
            'bukti_kebersihan_lantai_halte' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bukti_kebersihan_kaca_halte' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bukti_kebersihan_sampah_halte' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bukti_kondisi_halte' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kendala_halte' => 'nullable|string',
            'bukti_kendala_halte' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan file
        $fotoLantaiPath = $request->file('bukti_kebersihan_lantai_halte')->store('foto_lantai', 'public');
        $fotoKacaPath = $request->file('bukti_kebersihan_kaca_halte')->store('foto_kaca', 'public');
        $fotoSampahPath = $request->file('bukti_kebersihan_sampah_halte')->store('foto_sampah', 'public');
        $fotoKondisiPath = $request->file('bukti_kondisi_halte')->store('foto_kondisi', 'public');
        $fotoKendalaPath = $request->file('bukti_kendala_halte') ? $request->file('bukti_kendala_halte')->store('foto_kendala', 'public') : null;

        // Simpan data
        LaporanHalte::create([
            'pekerja_id' => $request->pekerja_id,
            'shift_id' => $request->shift_id,
            'koridor_id' => $request->koridor_id,
            'halte_id' => $request->halte_id,
            'tanggal_waktu_halte' => $request->tanggal_waktu_halte,
            'lokasi_halte' => $request->lokasi_halte,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'koordinat' => $request->latitude.','.$request->longitude, // Tetap simpan format lama jika diperlukan
            'bukti_kebersihan_lantai_halte' => $fotoLantaiPath,
            'bukti_kebersihan_kaca_halte' => $fotoKacaPath,
            'bukti_kebersihan_sampah_halte' => $fotoSampahPath,
            'bukti_kondisi_halte' => $fotoKondisiPath,
            'kendala_halte' => $request->kendala_halte,
            'bukti_kendala_halte' => $fotoKendalaPath,
        ]);

        return redirect()->back()->with('success', 'Data kebersihan halte/shelter berhasil dikirim!');
    }
}