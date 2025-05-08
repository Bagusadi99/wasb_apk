<?php

namespace App\Exports;

use App\Models\LaporanHalte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HalteExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle, WithDrawings
{
    protected $start_date;
    protected $end_date;
    protected $rowNumber = 0;
    protected $imageCollection = [];

    /**
     * Constructor
     * 
     * @param string|null $start_date
     * @param string|null $end_date
     */
    public function __construct($start_date = null, $end_date = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = LaporanHalte::with(['pekerja', 'shift']);
        
        if ($this->start_date && $this->end_date) {
            $query->whereBetween('tanggal_waktu_halte', [
                $this->start_date . ' 00:00:00', 
                $this->end_date . ' 23:59:59'
            ]);
        }
        
        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Petugas',
            'Shift',
            'Tanggal & Waktu',
            'Keterangan',
            'Bukti Kebersihan',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        $this->rowNumber++;
        
        // Store the image path for later use in drawings
        if (!empty($row->bukti_kebersihan_lantai_halte) && Storage::exists('public/' . $row->bukti_kebersihan_lantai_halte)) {
            $this->imageCollection[] = [
                'row' => $this->rowNumber + 1, // +1 to account for header row
                'path' => storage_path('app/public/' . $row->bukti_kebersihan_lantai_halte)
            ];
        }
        
        return [
            $this->rowNumber,
            $row->pekerja->nama_pekerja ?? 'N/A',
            $row->shift->shift_nama ?? 'N/A',
            date('d/m/Y H:i', strtotime($row->tanggal_waktu_halte)),
            $row->keterangan ?? '-',
            'Lihat gambar', // Placeholder for image cell
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Data Halte';
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Set column widths
        $sheet->getColumnDimension('F')->setWidth(20);
        
        // Set row height for data rows to accommodate images
        for ($i = 2; $i <= $this->rowNumber + 1; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(80);
        }
        
        return [
            // Style the header row
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4A8939'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            // Style the data rows
            'A2:F' . ($this->rowNumber + 1) => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function drawings()
    {
        $drawings = [];
        
        foreach ($this->imageCollection as $key => $value) {
            // Only process if the file exists
            if (file_exists($value['path'])) {
                $drawing = new Drawing();
                $drawing->setName('Bukti_' . $key);
                $drawing->setDescription('Bukti Kebersihan');
                $drawing->setPath($value['path']);
                $drawing->setCoordinates('F' . $value['row']);
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