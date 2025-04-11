<?php

namespace App\Exports;

use App\Models\LaporanHalte;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class HalteExport implements FromCollection, WithHeadings, WithDrawings
{
    protected $request;
    protected $data;

    public function __construct(Request $request)
    {
        $this->request = $request;

        // Ambil data sekali saja untuk digunakan di collection dan drawings
        $query = LaporanHalte::with(['pekerja', 'shift']);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_waktu_halte', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $this->data = $query->get();
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                'Nama Petugas' => $item->pekerja->nama_pekerja ?? '-',
                'Shift' => $item->shift->shift_nama ?? '-',
                'Tanggal & Waktu' => $item->tanggal_waktu_halte,
                'Bukti Foto (lihat gambar)' => 'Lihat Kolom Gambar',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Petugas',
            'Shift',
            'Tanggal & Waktu',
            'Bukti Foto (lihat gambar)',
        ];
    }

    public function drawings()
    {
        $drawings = [];

        foreach ($this->data as $index => $item) {
            if (!$item->bukti_kebersihan_lantai_halte) continue;

            $path = public_path('storage/' . $item->bukti_kebersihan_lantai_halte);
            if (!file_exists($path)) continue;

            $drawing = new Drawing();
            $drawing->setName('Bukti');
            $drawing->setDescription('Bukti Kebersihan');
            $drawing->setPath($path);
            $drawing->setHeight(100);
            $drawing->setCoordinates('E' . ($index + 2)); // Kolom E, baris mulai dari 2 (karena heading di baris 1)

            $drawings[] = $drawing;
        }

        return $drawings;
    }
}
