<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Pekerja;
use App\Models\Shift;
use App\Models\Koridor;
use App\Models\Halte;
use App\Models\KendalaHalte;
use App\Models\LaporanHalte;
use App\Models\LaporanKendalaHalte;

class FormHalteController extends Controller
{
    public function formhalte()
    {
        $pekerja = Pekerja::all();
        $shift = Shift::all();
        $koridor = Koridor::all();
        $kendala_halte = KendalaHalte::all();
        return view('user.halteuser', compact('shift', 'pekerja', 'koridor', 'kendala_halte'));
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
            // 'tanggal_waktu_halte' => 'required|date',
            'lokasi_halte' => 'required|string|max:255',
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
                // function ($attribute, $value, $fail) {
                //     if (!preg_match('/^-?\d{1,3}\.\d{4,8}$/', $value)) {
                //         $fail('Format latitude tidak valid. Gunakan format desimal dengan 4-8 digit presisi.');
                //     }
                // },
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
                // function ($attribute, $value, $fail) {
                //     if (!preg_match('/^-?\d{1,3}\.\d{4,8}$/', $value)) {
                //         $fail('Format longitude tidak valid. Gunakan format desimal dengan 4-8 digit presisi.');
                //     }
                // },
            ],
            'bukti_kebersihan_lantai_halte' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
            'bukti_kebersihan_kaca_halte' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
            'bukti_kebersihan_sampah_halte' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
            'bukti_kondisi_halte' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
            'kendala_halte_ids' => 'nullable|array',
            'kendala_halte_ids.*' => 'exists:kendala_halte,kendala_halte_id',
            'bukti_kendala_halte' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
        ], [
            'bukti_kebersihan_lantai_halte.max' => 'Ukuran gambar lantai tidak boleh lebih dari 5MB.',
            'bukti_kebersihan_kaca_halte.max' => 'Ukuran gambar kaca tidak boleh lebih dari 5MB.',
            'bukti_kebersihan_sampah_halte.max' => 'Ukuran gambar sampah tidak boleh lebih dari 5MB.',
            'bukti_kondisi_halte.max' => 'Ukuran gambar kondisi halte tidak boleh lebih dari 5MB.',
            'bukti_kendala_halte.max' => 'Ukuran gambar kendala tidak boleh lebih dari 5MB.',
        ]);

        $kendalaDipilih = $request->filled('kendala_halte_ids');
        $fotoKendalaDiupload = $request->hasFile('bukti_kendala_halte');

        if ($kendalaDipilih && !$fotoKendalaDiupload) {
            return back()->withErrors([
                'bukti_kendala_halte' => 'Foto kendala halte wajib diunggah jika terdapat kendala yang dipilih.',
            ])->withInput();
        }

        if ($fotoKendalaDiupload && !$kendalaDipilih) {
            return back()->withErrors([
                'kendala_halte_ids' => 'Kendala halte harus dipilih jika mengunggah foto kendala.',
            ])->withInput();
        }

        // Simpan file
        $fotoLantaiPath = $request->file('bukti_kebersihan_lantai_halte')->store('foto_lantai', 'public');
        $fotoKacaPath = $request->file('bukti_kebersihan_kaca_halte')->store('foto_kaca', 'public');
        $fotoSampahPath = $request->file('bukti_kebersihan_sampah_halte')->store('foto_sampah', 'public');
        $fotoKondisiPath = $request->file('bukti_kondisi_halte')->store('foto_kondisi', 'public');
        $fotoKendalaPath = $request->file('bukti_kendala_halte') ? $request->file('bukti_kendala_halte')->store('foto_kendala', 'public') : null;

        // Simpan data
        $laporan = LaporanHalte::create([
            'pekerja_id' => $request->pekerja_id,
            'shift_id' => $request->shift_id,
            'koridor_id' => $request->koridor_id,
            'halte_id' => $request->halte_id,
            'tanggal_waktu_halte' => date('Y-m-d H:i:s'),
            'lokasi_halte' => $request->lokasi_halte,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'koordinat' => $request->latitude.','.$request->longitude, // Tetap simpan format lama jika diperlukan
            'bukti_kebersihan_lantai_halte' => $fotoLantaiPath,
            'bukti_kebersihan_kaca_halte' => $fotoKacaPath,
            'bukti_kebersihan_sampah_halte' => $fotoSampahPath,
            'bukti_kondisi_halte' => $fotoKondisiPath,
            'bukti_kendala_halte' => $fotoKendalaPath,
        ]);

        // Simpan kendala_halte yang dipilih ke tabel laporan_kendala_halte
        if ($request->has('kendala_halte_ids')) {
            foreach ($request->kendala_halte_ids as $kendalaId) {
                LaporanKendalaHalte::create([
                    'laporan_halte_id' => $laporan->laporan_halte_id,
                    'kendala_halte_id' => $kendalaId,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data kebersihan halte/shelter berhasil dikirim!');
    }
}