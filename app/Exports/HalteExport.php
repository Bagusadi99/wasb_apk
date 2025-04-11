<?php

namespace App\Exports;

use App\Models\LaporanHalte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class HalteExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = LaporanHalte::with(['pekerja', 'shift']);

        if ($this->request->start_date && $this->request->end_date) {
            $query->whereBetween('tanggal_waktu_halte', [
                $this->request->start_date,
                $this->request->end_date
            ]);
        }

        return $query->get()->map(function ($item) {
            return [
                'Nama Petugas' => $item->pekerja->nama_pekerja ?? '-',
                'Shift' => $item->shift->shift_nama ?? '-',
                'Tanggal & Waktu' => $item->tanggal_waktu_halte,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Petugas',
            'Shift',
            'Tanggal & Waktu',
        ];
    }
}

?>