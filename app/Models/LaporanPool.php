<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pekerja;
use App\Models\Shift;
use App\Models\Koridor;
use App\Models\Pool;
use App\Models\User;

class LaporanPool extends Model
{
    protected $table = 'laporan_pool';
    protected $primaryKey = 'laporan_pool_id';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'pekerja_id',
        'shift_id',
        'koridor_id',
        'pool_id',
        'tanggal_waktu_pool',
        'lokasi_pool',
        'koordinat',
        'latitude',
        'longitude',
        'bukti_kebersihan_lantai_pool',
        'bukti_kebersihan_kaca_pool',
        'bukti_kebersihan_sampah_pool',
        'bukti_kondisi_pool',
        'bukti_kendala_pool',
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

    public function pool()
    {
        return $this->belongsTo(Pool::class, 'pool_id');
    }

    public function kendalaPool()
    {
        return $this->hasMany(LaporanKendalaPool::class, 'laporan_pool_id');
    }

    public function kendalaPools()
    {
        return $this->belongsToMany(KendalaPool::class, 'laporan_kendala_pool', 'laporan_pool_id', 'kendala_pool_id');
    }
}
