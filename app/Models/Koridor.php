<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Koridor extends Model
{
    protected $table = 'koridor';
    protected $primaryKey = 'koridor_id';
    protected $fillable = ['koridor_nama'];
    public $timestamps = false;
}
