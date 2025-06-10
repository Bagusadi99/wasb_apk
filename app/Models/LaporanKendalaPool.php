<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKendalaPool extends Model
{
    protected $table = 'laporan_kendala_pool'; // Nama tabel di database
    protected $primaryKey = 'laporan_kendala_pool_id'; // Primary Key
    protected $fillable = ['laporan_kendala_pool_id','laporan_pool_id', 'kendala_pool_id'];
    public $timestamps = false;

    public function laporanPool()
    {
        return $this->belongsTo(LaporanPool::class, 'laporan_pool_id');
    }

    public function kendalaPool()
    {
        return $this->belongsTo(KendalaPool::class, 'kendala_pool_id');
    }
}
