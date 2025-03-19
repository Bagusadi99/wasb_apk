<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Koridor;

class Pool extends Model
{
    protected $table = 'pool';
    protected $primaryKey = 'pool_id';
    protected $fillable = ['pool_nama','koridor_id'];
    public $timestamps = false;

    public function koridor()
    {
        return $this->belongsTo(Koridor::class, 'koridor_id', 'koridor_id'); 
        
    }
}
