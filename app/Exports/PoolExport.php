<?php

namespace App\Exports;

use App\Models\LaporanPool;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Carbon\Carbon; // Don't forget to import Carbon for date formatting
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PoolExport implements FromCollection, WithHeadings, WithDrawings, WithEvents, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $koridorId; // Add koridor filter
    protected $data; // Stores the fetched data for reuse
    protected $rowHeights = []; // Stores row heights for events

    /**
     * @param string|null $startDate
     * @param string|null $endDate
     * @param int|null $koridorId
     */
    public function __construct($startDate = null, $endDate = null, $koridorId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->koridorId = $koridorId;
    }

    /**
     * Define the data to be exported.
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = LaporanPool::with(['pekerja', 'shift', 'koridor', 'pool', 'kendalaPools']); // Include koridor and pool relationships

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal_waktu_pool', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay(),
            ]);
        }


        if ($this->koridorId) {
            $query->where('koridor_id', $this->koridorId);
        }

        $this->data = $query->get(); // Debugging line to check parameters


        // Remove the debugging line: dd($this->data->toJson());

        return $this->data->map(function ($item) {
            // Adjust columns based on headings and image placement
            return [
                $item->laporan_pool_id, // Use laporan_pool_id for consistency with detail view
                optional($item->pekerja)->nama_pekerja, // Use nama_pekerja
                optional($item->shift)->shift_nama, // Use shift_nama
                optional($item->koridor)->koridor_nama,
                optional($item->pool)->pool_nama,
                Carbon::parse($item->tanggal_waktu_pool)->format('d F Y H:i:s'),
                // 'Kegiatan Pool', // Assuming these are not directly from LaporanPool if not in original input
                // 'Keterangan Pool', // Assuming these are not directly from LaporanPool if not in original input
                // Placeholders for images - actual images are embedded by drawings()
                '',
                '',
                '',
                '',
                '',
                $item->kendalaPools->pluck('kendala_pool')->implode(', '), // Join kendala descriptions

            ];
        });
    }

    /**
     * Define the headings for the Excel sheet.
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Laporan',
            'Nama Pekerja',
            'Shift',
            'Koridor',
            'Pool',
            'Tanggal & Waktu',
            'Bukti Kebersihan Lantai', // Reserved for image
            'Bukti Kebersihan Kaca',   // Reserved for image
            'Bukti Kebersihan Sampah', // Reserved for image
            'Bukti Kondisi Pool',      // Reserved for image
            'Bukti Kendala Pool',      // Reserved for image
            'Kendala Pool',      // Reserved for image
        ];
    }

    /**
     * Define the drawings (images) to be embedded in the Excel sheet.
     * @return array
     */
    public function drawings()
    {
        $drawings = [];
        $imageColumnStartIndex = 7; // Assuming images start from the 7th column (column G in Excel)

        foreach ($this->data as $index => $item) {
            $row = $index + 2; // Data starts from row 2 (after headings)
            $maxHeightForRow = 0; // Track max height needed for current row

            $imagePaths = [
                $item->bukti_kebersihan_lantai_pool,
                $item->bukti_kebersihan_kaca_pool,
                $item->bukti_kebersihan_sampah_pool,
                $item->bukti_kondisi_pool,
                $item->bukti_kendala_pool, // Include kendala image
            ];

            foreach ($imagePaths as $colIndexOffset => $imagePath) {
                if ($imagePath) { // Check if path exists
                    $filePath = storage_path('app/public/' . $imagePath); // Correct path for storage
                    // Or, if using public_path for publicly accessible storage:
                    // $filePath = public_path('storage/' . $imagePath);

                    if (file_exists($filePath)) {
                        $drawing = new Drawing();
                        $drawing->setName('Bukti ' . ($colIndexOffset + 1));
                        $drawing->setDescription('Bukti Laporan');
                        $drawing->setPath($filePath);
                        $drawing->setHeight(100); // Set desired height in pixels
                        // Calculate column letter dynamically based on index offset
                        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($imageColumnStartIndex + $colIndexOffset);
                        $drawing->setCoordinates($colLetter . $row);
                        $drawing->setOffsetX(5); // Optional: add some padding
                        $drawing->setOffsetY(5); // Optional: add some padding
                        $drawings[] = $drawing;

                        $maxHeightForRow = max($maxHeightForRow, $drawing->getHeight() + $drawing->getOffsetY());
                    }
                }
            }

            // Store the calculated row height. Convert pixels to Excel row height units.
            // Excel row height units are roughly 0.75 pixels per unit.
            if ($maxHeightForRow > 0) {
                $this->rowHeights[$row] = round($maxHeightForRow * 00.75);
            }
        }

        // The imageCollection property from the constructor was for additional images.
        // I've removed the loop for $this->imageCollection because it's not being passed
        // in the current usage context, and it's better to explicitly add all images here.
        // If you need to add other external images, you can reintroduce that loop
        // and pass them via the constructor.

        return $drawings;
    }

    /**
     * Register events to modify the sheet, e.g., set row heights.
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Set column widths if needed (optional)
                // $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15);
                // $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20); // Example for image column

                foreach ($this->rowHeights as $row => $height) {
                    if ($height > 0) { // Ensure height is positive
                        $event->sheet->getDelegate()->getRowDimension($row)->setRowHeight($height);
                    }
                }
            },
        ];
    }
}