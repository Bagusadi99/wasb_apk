<?php

namespace App\Exports;

use App\Models\LaporanHalte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class HalteExport implements FromCollection, WithHeadings, WithDrawings
{
    protected $start_date;
    protected $end_date;
    protected $data;
    protected $imageCollection = []; 
    public function __construct($start_date, $end_date, $imageCollection = [])
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->imageCollection = $imageCollection;
    }

    public function collection()
    {
        $query = LaporanHalte::with(['pekerja', 'shift']);

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('tanggal_waktu_halte', [
                $this->start_date . ' 00:00:00',
                $this->end_date . ' 23:59:59',
            ]);
        }

        $this->data = $query->get();
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pekerja',
            'Nama Shift',
            'Tanggal Waktu Halte',
            'Kegiatan Halte',
            'Keterangan Halte',
            'Foto Halte'
        ];
    }

    public function drawings()
    {
        $drawings = [];

        foreach ($this->data as $index => $item) {
            // Bukti kebersihan kaca halte
            $bukti_kaca = public_path('storage/' . $item->bukti_kebersihan_kaca_halte);
            if (file_exists($bukti_kaca)) {
                $drawing = new Drawing();
                $drawing->setName('Bukti Kaca');
                $drawing->setDescription('Bukti Kebersihan Kaca');
                $drawing->setPath($bukti_kaca);
                $drawing->setHeight(100);
                $drawing->setCoordinates('F' . ($index + 2));
                $drawings[] = $drawing;
            }

            // Bukti kebersihan sampah halte
            $bukti_sampah = public_path('storage/' . $item->bukti_kebersihan_sampah_halte);
            if (file_exists($bukti_sampah)) {
                $drawing = new Drawing();
                $drawing->setName('Bukti Sampah');
                $drawing->setDescription('Bukti Kebersihan Sampah');
                $drawing->setPath($bukti_sampah);
                $drawing->setHeight(100);
                $drawing->setCoordinates('G' . ($index + 2));
                $drawings[] = $drawing;
            }

            // Bukti kondisi halte
            $bukti_kondisi = public_path('storage/' . $item->bukti_kondisi_halte);
            if (file_exists($bukti_kondisi)) {
                $drawing = new Drawing();
                $drawing->setName('Bukti Kondisi');
                $drawing->setDescription('Bukti Kondisi Halte');
                $drawing->setPath($bukti_kondisi);
                $drawing->setHeight(100);
                $drawing->setCoordinates('H' . ($index + 2));
                $drawings[] = $drawing;
            }
        }

        // ✅ Tambahan jika kamu ingin menyisipkan gambar dari imageCollection
        foreach ($this->imageCollection as $key => $value) {
            if (file_exists($value['path'])) {
                $drawing = new Drawing();
                $drawing->setName('Bukti_' . $key);
                $drawing->setDescription('Bukti Kebersihan');
                $drawing->setPath($value['path']);
                $drawing->setCoordinates('F' . $value['row']); // Pastikan kolom/row sesuai
                $drawing->setOffsetX(5);
                $drawing->setOffsetY(5);
                $drawing->setWidth(80);
                $drawing->setHeight(70);
                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }
}
