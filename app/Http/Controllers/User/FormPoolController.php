<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\Pekerja;
use App\Models\Shift;
use App\Models\Koridor;
use App\Models\KendalaPool;
use App\Models\Pool;
use App\Models\LaporanKendalaPool;
use App\Models\LaporanPool;
use Illuminate\Http\Request;

class FormPoolController extends Controller
{

    public function formpool()
    {
        $pekerja = Pekerja::all();
        $shift = Shift::all();
        $koridor = Koridor::all();
        $kendala_pool = KendalaPool::all();
        return view('user.pooluser', compact('shift', 'pekerja', 'koridor', 'kendala_pool'));
    } 
    public function getPoolByKoridor($koridorId)
    {
        $pool = Pool::where('koridor_id', $koridorId)->get();
        return response()->json($pool);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pekerja_id' => 'required|exists:pekerja,pekerja_id',
            'shift_id' => 'required|exists:shift,shift_id',
            'koridor_id' => 'required|exists:koridor,koridor_id',
            'pool_id' => 'required|exists:pool,pool_id',
            // 'tanggal_waktu_pool' => 'required|date',
            'lokasi_pool' => 'required|string|max:255',
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
            'bukti_kebersihan_lantai_pool' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
            'bukti_kebersihan_kaca_pool' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
            'bukti_kebersihan_sampah_pool' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
            'bukti_kondisi_pool' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
            'kendala_pool_ids' => 'nullable|array',
            'kendala_pool_ids.*' => 'exists:kendala_pool,kendala_pool_id',
            'bukti_kendala_pool' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:500',
        ], [
            'bukti_kebersihan_lantai_pool.max' => 'Ukuran gambar lantai tidak boleh lebih dari 5MB.',
            'bukti_kebersihan_kaca_pool.max' => 'Ukuran gambar kaca tidak boleh lebih dari 5MB.',
            'bukti_kebersihan_sampah_pool.max' => 'Ukuran gambar sampah tidak boleh lebih dari 5MB.',
            'bukti_kondisi_pool.max' => 'Ukuran gambar kondisi pool tidak boleh lebih dari 5MB.',
            'bukti_kendala_pool.max' => 'Ukuran gambar kendala tidak boleh lebih dari 5MB.',
        ]);

        $kendalaDipilih = $request->filled('kendala_pool_ids');
        $fotoKendalaDiupload = $request->hasFile('bukti_kendala_pool');

        if ($kendalaDipilih && !$fotoKendalaDiupload) {
            return back()->withErrors([
                'bukti_kendala_pool' => 'Foto kendala pool wajib diunggah jika terdapat kendala yang dipilih.',
            ])->withInput();
        }

        if ($fotoKendalaDiupload && !$kendalaDipilih) {
            return back()->withErrors([
                'kendala_pool_ids' => 'Kendala pool harus dipilih jika mengunggah foto kendala.',
            ])->withInput();
        }

        // dd($request->all());

        // Simpan file
        $fotoLantaiPath = $request->file('bukti_kebersihan_lantai_pool')->store('foto_lantai', 'public');
        $fotoKacaPath = $request->file('bukti_kebersihan_kaca_pool')->store('foto_kaca', 'public');
        $fotoSampahPath = $request->file('bukti_kebersihan_sampah_pool')->store('foto_sampah', 'public');
        $fotoKondisiPath = $request->file('bukti_kondisi_pool')->store('foto_kondisi', 'public');
        $fotoKendalaPath = $request->file('bukti_kendala_pool') ? $request->file('bukti_kendala_pool')->store('foto_kendala', 'public') : null;

        // Simpan data
        $laporan = LaporanPool::create([
            'pekerja_id' => $request->pekerja_id,
            'shift_id' => $request->shift_id,
            'koridor_id' => $request->koridor_id,
            'pool_id' => $request->pool_id,
            'tanggal_waktu_pool' => date('Y-m-d H:i:s'),
            'lokasi_pool' => $request->lokasi_pool,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'koordinat' => $request->latitude.','.$request->longitude, // Tetap simpan format lama jika diperlukan
            'bukti_kebersihan_lantai_pool' => $fotoLantaiPath,
            'bukti_kebersihan_kaca_pool' => $fotoKacaPath,
            'bukti_kebersihan_sampah_pool' => $fotoSampahPath,
            'bukti_kondisi_pool' => $fotoKondisiPath,
            'bukti_kendala_pool' => $fotoKendalaPath,
        ]);

        // Simpan kendala_pool yang dipilih ke tabel laporan_kendala_pool
        if ($request->has('kendala_pool_ids')) {
            foreach ($request->kendala_pool_ids as $kendalaId) {
                LaporanKendalaPool::create([
                    'laporan_pool_id' => $laporan->laporan_pool_id,
                    'kendala_pool_id' => $kendalaId,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data kebersihan pool berhasil dikirim!');
    }
}
