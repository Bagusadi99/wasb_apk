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


        public function exportPDF(Request $request)
    {
        $laporan_halte = $this->filterLaporan($request);

        $pdf = Pdf::loadView('admin.exports.halte_pdf', compact('laporan_halte'));
        return $pdf->stream('laporan_halte.pdf');
    }

        public function exportExcel(Request $request)
    {
        return Excel::download(new HalteExport($request), 'laporan_halte.xlsx');
    }
}
