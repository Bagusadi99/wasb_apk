<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KendalaPool extends Model
{
    protected $table = 'kendala_pool';
    protected $primaryKey = 'kendala_pool_id';
    public $timestamps = false;
    protected $fillable = [
        'kendala_pool',
    ];
}
