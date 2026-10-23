<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Item extends Model
{
    use Auditable; // Mengaktifkan pencatatan aktivitas otomatis

    protected $table = 'tb_items';
    protected $primaryKey = 'item_id';
    
    protected $fillable = [
        'category_id', 
        'item_name', 
        'description',
        'jenis_satuan', 
        'satuan_dasar', 
        'current_stock', 
        'min_stock_alert'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}