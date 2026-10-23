<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Category extends Model
{
    use Auditable; // Mengaktifkan pencatatan otomatis ke tb_audit_logs

    protected $table = 'tb_categories';
    protected $primaryKey = 'category_id';
    
    // Tambahkan description agar diizinkan disimpan
    protected $fillable = ['category_name', 'description'];

    // Relasi untuk menghitung jumlah item di dalam kategori ini
    public function items()
    {
        return $this->hasMany(Item::class, 'category_id', 'category_id');
    }
}