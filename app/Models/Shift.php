<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Shift extends Authenticatable
{
    protected $table = 'shift'; // Nama tabel di database
    protected $primaryKey = 'shift_id'; // Primary Key
    protected $fillable = ['shift_id', 'shift_nama'];
    public $timestamps = false;
}
