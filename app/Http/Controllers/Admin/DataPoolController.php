<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Koridor;
use App\Models\LaporanPool;
use App\Models\LaporanKendalaPool;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

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
        $query = LaporanPool::with(['pekerja', 'shift']);
        
        // Filter tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_waktu_pool', [
                $request->start_date, 
                $request->end_date
            ]);
        }
        if ($request->filled('koridor')) {
            $query->where('koridor_id', $request->koridor);
        }
        
        $laporan_pool = $query->orderBy('tanggal_waktu_pool', 'desc')->get();
        
        return view('admin.dashboard.data_pool', compact('laporan_pool','koridor'));
    }

}
