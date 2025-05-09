<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\LaporanHalte;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\HalteExport;
use Maatwebsite\Excel\Facades\Excel;


class DataHalteController extends Controller
{

    public function data_halte()
    {
        $laporan_halte = LaporanHalte::all();
        return view('admin.dashboard.data_halte', compact('laporan_halte'));
    } 
    public function detail_datahalte($id)
    {
        $data = LaporanHalte::findOrFail($id);
        // dd($detail);
        return view('admin.dashboard.detail_datahalte', compact('data'));
    }
    public function filter_datahalte(Request $request)
    {
        $query = LaporanHalte::with(['pekerja', 'shift']);
        
        // Filter tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_waktu_halte', [
                $request->start_date, 
                $request->end_date
            ]);
        }
        
        $laporan_halte = $query->orderBy('tanggal_waktu_halte', 'desc')->get();
        
        return view('admin.dashboard.data_halte', compact('laporan_halte'));
    }

    private function filterLaporan(Request $request)
    {
        $query = LaporanHalte::with(['pekerja', 'shift']);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_waktu_halte', [
                $request->start_date,
                $request->end_date
            ]);
        }

        return $query->orderBy('tanggal_waktu_halte', 'desc')->get();
    }


    public function export_pdf(Request $request)
    {
        // Get the filter dates
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        
        // Query data with date filters if provided
        $query = LaporanHalte::with(['pekerja', 'shift']);
        
        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_waktu_halte', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        }
        
        $laporan_halte = $query->get();
        
        // Determine if this is a preview or download
        $isPreview = $request->has('preview');
        $isDownload = $request->has('download');
        
        // Get company info for header
        $company = [
            'name' => 'Trans Jawa Timur',
            'logo' => public_path('template/dist/assets/compiled/png/logotransjatim.png'),
            'address' => 'Jl. Ahmad Yani No. 268, Surabaya, Jawa Timur',
            'phone' => '(031) 8292959',
        ];
        
        // Get title based on date filter
        $title = 'Laporan Data Halte / Shalter';
        $subtitle = '';
        
        if ($start_date && $end_date) {
            $formatted_start = date('d F Y', strtotime($start_date));
            $formatted_end = date('d F Y', strtotime($end_date));
            $subtitle = "Periode: $formatted_start - $formatted_end";
        } else {
            $subtitle = "Periode: Semua Data";
        }
        
        // Generate PDF
        $pdf = PDF::loadView('admin.exports.halte_pdf', [
            'laporan_halte' => $laporan_halte,
            'company' => $company,
            'title' => $title,
            'subtitle' => $subtitle,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
        
        // Set PDF options for better quality
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
        ]);
        
        // Return as per request type
        if ($isDownload) {
            // For download
            return $pdf->download('laporan_halte_' . date('Y-m-d') . '.pdf');
        } else {
            // For preview - stream without forcing download
            return $pdf->stream('laporan_halte_' . date('Y-m-d') . '.pdf');
        }
    }

    public function export_excel(Request $request)
    {
        // Get filter dates
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
    
        // Generate filename
        $filename = 'laporan_halte_' . date('YmdHis') . '.xlsx';
        
        // Return excel file
        return Excel::download(new HalteExport($start_date, $end_date), $filename);
    }
}
