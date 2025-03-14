<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Koridor;

class Halte extends Model
{
    protected $table = 'halte';
    protected $primaryKey = 'halte_id';
    protected $fillable = ['halte_nama','koridor_id'];
    public $timestamps = false;

    public function koridor()
    {
        return $this->belongsTo(Koridor::class, 'koridor_id', 'koridor_id'); 
        
    }
}
