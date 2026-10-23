<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'tb_audit_logs';
    public $timestamps = false; // Karena di migration kita hanya pakai created_at manual

    protected $fillable = [
        'user_id', 'action', 'table_name', 'record_id', 'old_data', 'new_data', 'created_at'
    ];

    // Otomatis mengubah string JSON di database menjadi Array PHP
    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    // Relasi untuk mengetahui siapa User (Admin/Operator) yang melakukan aksi
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}