<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pekerja;
use App\Models\Shift;
use App\Models\Koridor;
use App\Models\Halte;
use App\Models\User;
use App\Models\KendalaHalte;


class LaporanHalte extends Model
{
    protected $table = 'laporan_halte';
    protected $primaryKey = 'laporan_halte_id';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'pekerja_id',
        'shift_id',
        'koridor_id',
        'halte_id',
        'tanggal_waktu_halte',
        'lokasi_halte',
        'koordinat',
        'latitude',
        'longitude',
        'bukti_kebersihan_lantai_halte',
        'bukti_kebersihan_kaca_halte',
        'bukti_kebersihan_sampah_halte',
        'bukti_kondisi_halte',
        'bukti_kendala_halte',
    ];
    protected $attributes = [
        'user_id' => 2,
    ];

    public function pekerja()
    {
        return $this->belongsTo(Pekerja::class, 'pekerja_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function koridor()
    {
        return $this->belongsTo(Koridor::class, 'koridor_id');
    }

    public function halte()
    {
        return $this->belongsTo(Halte::class, 'halte_id');
    }

    public function kendalaHalte()
    {
        return $this->hasMany(LaporanKendalaHalte::class);
    }
}