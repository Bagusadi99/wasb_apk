<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LaporanKendalaHalte extends Model
{
    protected $table = 'laporan_kendala_halte'; // Nama tabel di database
    protected $primaryKey = 'laporan_kendala_halte_id'; // Primary Key
    protected $fillable = ['laporan_kendala_halte_id','laporan_halte_id', 'kendala_halte_id'];
    public $timestamps = false;

    public function laporanHalte()
    {
        return $this->belongsTo(LaporanHalte::class, 'laporan_halte_id');
    }

    public function kendalaHalte()
    {
        return $this->belongsTo(KendalaHalte::class, 'kendala_halte_id');
    }

}