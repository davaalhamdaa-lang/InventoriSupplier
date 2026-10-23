<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'tb_clients';
    protected $primaryKey = 'client_id';
    
    protected $fillable = [
        'nama_sppg',
        'alamat_sppg'
    ];
}