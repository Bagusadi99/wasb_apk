<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shift;
class Pekerja extends Model
{
    protected $table = 'pekerja'; // Nama tabel di database
    protected $primaryKey = 'pekerja_id'; // Primary Key
    protected $fillable = ['pekerja_id','nama_pekerja'];
    public $timestamps = false;

}
