<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanHalte;
use App\Exports\HalteExport;
use App\Models\Koridor;
use App\Models\LaporanKendalaHalte;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\fileExists;

class DataHalteController extends Controller
{

    public function data_halte()
    {
        $koridor = Koridor::all();
        $laporan_halte = LaporanHalte::orderBy('tanggal_waktu_halte', 'desc')->get();
        return view('admin.dashboard.data_halte', compact('laporan_halte','koridor'));
    } 
    public function detail_datahalte($id)
    {
        $data = LaporanHalte::findOrFail($id);
        $kendala = LaporanKendalaHalte::with('kendalaHalte')
            ->where('laporan_halte_id', $id)
            ->get();
        // dd($detail);
        return view('admin.dashboard.detail_datahalte', compact('data','kendala'));
    }
    public function filter_datahalte(Request $request)
    {
        $koridor = Koridor::all();
        $query = LaporanHalte::with(['pekerja', 'shift', 'koridor', 'halte']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_waktu_halte', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay() 
            ]);
        }

        if ($request->filled('koridor')) {
            $query->where('koridor_id', $request->koridor);
        }

        $laporan_halte = $query->orderBy('tanggal_waktu_halte', 'desc')->get();

        return view('admin.dashboard.data_halte', compact('laporan_halte', 'koridor'));
    }


    private function filterLaporan(Request $request)
    {

        $query = LaporanHalte::with(['pekerja', 'shift', 'kendalaHaltes']);

        if ($request->start_date && $request->end_date) {
           $query =  $query->whereBetween('tanggal_waktu_halte', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
   
        }

        $query = $query->where('koridor_id', $request->koridor)->orderBy('tanggal_waktu_halte', 'desc')->get();


        return $query;
    }
    public function export_pdf(Request $request)
    {
        $laporan_halte = $this->filterLaporan($request);

         $getBase64Image = function ($imagePath) {
                if ($imagePath && fileExists(public_path($imagePath))) {
                   
                    $path = public_path($imagePath);
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);

                    return 'data:image/' . $type . ';base64,' . base64_encode($data);
                }
                return null;
            };

        $logo_base64 = $getBase64Image('template/dist/assets/compiled/png/logotransjatim.png'); // Adjust the path to your
        




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

           $laporan_halte = $laporan_halte->map(function ($item) {
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
            $item->bukti_kebersihan_lantai_halte_base64 = $getBase64Image($item->bukti_kebersihan_lantai_halte);
            $item->bukti_kebersihan_kaca_halte_base64 = $getBase64Image($item->bukti_kebersihan_kaca_halte);
            $item->bukti_kebersihan_sampah_halte_base64 = $getBase64Image($item->bukti_kebersihan_sampah_halte);
            $item->bukti_kondisi_halte_base64 = $getBase64Image($item->bukti_kondisi_halte);
            $item->bukti_kendala_halte_base64 = $getBase64Image($item->bukti_kendala_halte); // Make sure this field exists on your model

            return $item;
        });

        $pdf = PDF::loadView('admin.exports.halte_pdf', [
            'laporan_halte' => $laporan_halte,
            'company' => $company,
            'title' => $title,
            'subtitle' => $subtitle,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'logo_base64' => $logo_base64, // Pass the base64 logo
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

    public function destroy($id)
    {
        $data = LaporanHalte::findOrFail($id);

        $data->kendalaHalte()->delete(); // Delete related kendala records
        $data->delete();
        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }    
}
