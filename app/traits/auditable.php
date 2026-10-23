<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            self::logAudit('CREATE', $model, null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $original = $model->getOriginal();
            $changes = $model->getChanges();
            self::logAudit('UPDATE', $model, $original, $changes);
        });

        static::deleted(function ($model) {
            self::logAudit('DELETE', $model, $model->getAttributes(), null);
        });
    }

    protected static function logAudit($action, $model, $oldData, $newData)
    {
        DB::table('tb_audit_logs')->insert([
            'user_id' => Auth::id() ?? null,
            'action' => $action,
            'table_name' => $model->getTable(),
            'record_id' => $model->getKey(),
            'old_data' => $oldData ? json_encode($oldData) : null,
            'new_data' => $newData ? json_encode($newData) : null,
            'created_at' => now(),
        ]);
    }
}