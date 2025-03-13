<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shift;
class Pekerja extends Model
{
    protected $table = 'pekerja';
    protected $primaryKey = 'pekerja_id';
    protected $fillable = ['pekerja_id','nama_pekerja'];
    public $timestamps = false;

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'shift_id'); 
        
    }

}
