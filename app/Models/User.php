<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_users'; // Mengarahkan ke tabel baru kita

    protected $fillable = [
        'name',
        'pin',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];
}