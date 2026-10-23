<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Transaction extends Model
{
    use Auditable;

    protected $table = 'tb_transactions';
    protected $primaryKey = 'trx_id';
    
    // Pastikan 'client_id' ditambahkan ke dalam array fillable
    protected $fillable = [
        'item_id', 'client_id', 'user_id', 'type', 'qty', 'satuan_transaksi', 
        'stock_sebelum', 'stock_sesudah', 'catatan', 'date_recorded'
    ];

    public function item() {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Ini adalah relasi yang hilang dan menyebabkan error
    public function client() {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }
}