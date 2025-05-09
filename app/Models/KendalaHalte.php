<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KendalaHalte extends Model
{
    protected $table = 'kendala_halte';
    protected $primaryKey = 'kendala_halte_id';
    public $timestamps = false;
    protected $fillable = [
        'kendala_halte',
    ];
}
