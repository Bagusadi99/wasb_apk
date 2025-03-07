<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Koridor extends Authenticatable
{
    protected $table = 'koridor'; // Nama tabel di database
    protected $primaryKey = 'koridor_id'; // Primary Key
    protected $fillable = ['koridor_id', 'koridor_nama'];
    public $timestamps = false;
}
