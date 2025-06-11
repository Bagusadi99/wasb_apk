<?php

namespace App\Http\Controllers\Admin;

use App\Exports\HalteExport;
use App\Exports\PoolExport;
use App\Http\Controllers\Controller;
use App\Models\Koridor;
use App\Models\LaporanPool;
use App\Models\LaporanKendalaPool;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DataPoolController extends Controller
{
    public function data_pool()
    {
        $koridor = Koridor::all();
        $laporan_pool = LaporanPool::orderBy('tanggal_waktu_pool', 'desc')->get();
        return view('admin.dashboard.data_pool', compact('laporan_pool','koridor'));
    } 

    public function detail_datapool($id)
    {
        $data = LaporanPool::findOrFail($id);
        $kendala = LaporanKendalaPool::with('kendalaPool')
            ->where('laporan_pool_id', $id)
            ->get();
        // dd($detail);
        return view('admin.dashboard.detail_datapool', compact('data','kendala'));
    }

    public function filter_datapool(Request $request)
    {
        $koridor = Koridor::all();
        $query = LaporanPool::with(['pekerja', 'shift', 'koridor', 'pool']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query = $query->whereBetween('tanggal_waktu_pool', [
                $request->start_date, 
                $request->end_date
            ]);
        }

        if ($request->filled('koridor')) {
            $query = $query->where('koridor_id', $request->koridor);
        }

        $laporan_pool = $query->orderBy('tanggal_waktu_pool', 'desc')->get();

        
        return view('admin.dashboard.data_pool', compact('laporan_pool', 'koridor'));
    }

    public function destroy($id)
    {
        $laporan_pool = LaporanPool::findOrFail($id);

        $laporan_pool->kendalaPool()->delete();
        $laporan_pool->delete();
        
        return redirect()->route('admin.dashboard.data_pool')->with('success', 'Data pool berhasil dihapus.');
    }


    private function filterLaporan(Request $request)
    {

        $query = LaporanPool::with(['pekerja', 'shift', 'kendalaPools']);

        if ($request->start_date && $request->end_date) {
           $query =  $query->whereBetween('tanggal_waktu_pool', [
                $request->start_date,
                $request->end_date
            ]);
   
        }

        if($request->filled('koridor')) {
            $query = $query->where('koridor_id', $request->koridor);
        }

        $query = $query->orderBy('tanggal_waktu_pool', 'desc')->get();


        return $query;
    }
    public function export_pdf(Request $request)
    {
        $laporan_pool = $this->filterLaporan($request);

        

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $company = [
            'name' => 'Trans Jawa Timur',
            'logo' => public_path('template/dist/assets/compiled/png/logotransjatim.png'),
            'address' => 'Jl. Ahmad Yani No. 268, Surabaya, Jawa Timur',
            'phone' => '(031) 8292959',
        ];

        $title = 'Laporan Data Pool';
        $subtitle = $start_date && $end_date
            ? 'Periode: ' . date('d F Y', strtotime($start_date)) . ' - ' . date('d F Y', strtotime($end_date))
            : 'Periode: Semua Data';

           $laporan_pool = $laporan_pool->map(function ($item) {
            // Function to safely get base64 image data
            $getBase64Image = function ($imagePath) {
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    $path = Storage::disk('public')->path($imagePath);
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    return 'data:image/' . $type . ';base64,' . base64_encode($data);
                }
                return null;
            };


            // Apply to each image field
            $item->bukti_kebersihan_lantai_pool_base64 = $getBase64Image($item->bukti_kebersihan_lantai_pool);
            $item->bukti_kebersihan_kaca_pool_base64 = $getBase64Image($item->bukti_kebersihan_kaca_pool);
            $item->bukti_kebersihan_sampah_pool_base64 = $getBase64Image($item->bukti_kebersihan_sampah_pool);
            $item->bukti_kondisi_pool_base64 = $getBase64Image($item->bukti_kondisi_pool);
            $item->bukti_kendala_pool_base64 = $getBase64Image($item->bukti_kendala_pool); // Make sure this field exists on your model


            return $item;
        });

        $pdf = PDF::loadView('admin.exports.pool_pdf', [
            'laporan_pool' => $laporan_pool,
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
            ? $pdf->download('laporan_pool_' . date('Y-m-d') . '.pdf')
            : $pdf->stream('laporan_pool_' . date('Y-m-d') . '.pdf');
    }

    public function export_excel(Request $request)
    {
        // Get filter dates
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
    
        // Generate filename
        $filename = 'laporan_pool_' . date('YmdHis') . '.xlsx';
        
        // Return excel file
        return Excel::download(new PoolExport($start_date, $end_date), $filename);
    }

}
