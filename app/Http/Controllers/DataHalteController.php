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
        $laporan_halte = $this->filterLaporan($request);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $company = [
            'name' => 'Trans Jawa Timur',
            'logo' => public_path('template/dist/assets/compiled/png/logotransjatim.png'),
            'address' => 'Jl. Ahmad Yani No. 268, Surabaya, Jawa Timur',
            'phone' => '(031) 8292959',
        ];

        $title = 'Laporan Data Halte / Shalter';
        $subtitle = $start_date && $end_date
            ? 'Periode: ' . date('d F Y', strtotime($start_date)) . ' - ' . date('d F Y', strtotime($end_date))
            : 'Periode: Semua Data';

        $pdf = PDF::loadView('admin.exports.halte_pdf', [
            'laporan_halte' => $laporan_halte,
            'company' => $company,
            'title' => $title,
            'subtitle' => $subtitle,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);

        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
        ]);

        return $request->has('download')
            ? $pdf->download('laporan_halte_' . date('Y-m-d') . '.pdf')
            : $pdf->stream('laporan_halte_' . date('Y-m-d') . '.pdf');
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
