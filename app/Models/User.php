<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'user'; // Nama tabel di database
    protected $primaryKey = 'user_id'; // Primary Key
    protected $fillable = ['user_nama', 'user_password', 'user_role'];
    protected $hidden = ['user_password'];
    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->user_password;
    }
}
