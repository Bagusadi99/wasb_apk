<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Shift;
class Pekerja extends Authenticatable
{
    protected $table = 'pekerja'; // Nama tabel di database
    protected $primaryKey = 'pekerja_id'; // Primary Key
    protected $fillable = ['pekerja_id','nama_pekerja'];
    public $timestamps = false;

    public function shift()
    {
    return $this->hasMany(Shift::class, 'shift_id', 'shift_nama');
    }

}
