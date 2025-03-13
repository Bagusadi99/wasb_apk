<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Shift extends Model
{
    protected $table = 'shift'; 
    protected $primaryKey = 'shift_id';
    protected $fillable = ['shift_id', 'shift_nama'];
    public $timestamps = false;
}
