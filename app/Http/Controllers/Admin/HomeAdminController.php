<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Halte;
use App\Models\Pool;
use App\Models\Pekerja;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class HomeAdminController extends Controller
{
    public function homeadmin(Request $request)
    {
        $halte = Halte::count();
        $pool = Pool::count();
        $pekerja = Pekerja::count();

        $kategori = $request->kategori ?? 'halte';
        $bulan = $request->bulan ?? Carbon::now()->month;

        if ($kategori == 'halte') {
            $laporanPerUser = DB::table('laporan_halte')
                ->join('pekerja', 'laporan_halte.pekerja_id', '=', 'pekerja.pekerja_id')
                ->whereMonth('laporan_halte.tanggal_waktu_halte', $bulan)
                ->select('pekerja.nama_pekerja', DB::raw('count(*) as total_laporan'))
                ->groupBy('laporan_halte.pekerja_id', 'pekerja.nama_pekerja')
                ->get();
        } else {
            $laporanPerUser = DB::table('laporan_pool')
                ->join('pekerja', 'laporan_pool.pekerja_id', '=', 'pekerja.pekerja_id')
                ->whereMonth('laporan_pool.tanggal_waktu_pool', $bulan)
                ->select('pekerja.nama_pekerja', DB::raw('count(*) as total_laporan'))
                ->groupBy('laporan_pool.pekerja_id', 'pekerja.nama_pekerja')
                ->get();
        }

        return view('admin.homeadmin', compact('halte', 'pool', 'pekerja', 'laporanPerUser', 'kategori', 'bulan'));
    }

    
}
