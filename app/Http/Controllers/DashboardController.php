<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;

class DashboardController
{
    public function index()
    {
        // 1. Widget Angka Cepat
        $totalKategori = Category::count();
        $totalBarang = Item::count();
        $totalTrxBulanIni = Transaction::whereMonth('date_recorded', date('m'))
                                       ->whereYear('date_recorded', date('Y'))
                                       ->count();

        // 2. Status Peringatan Stok (Stok Aktual <= Batas Minimum)
        $lowStockItems = Item::whereColumn('current_stock', '<=', 'min_stock_alert')->get();

        // 3. Ambil 6 Aktivitas Sistem Terakhir (Audit Log)
        $recentActivities = AuditLog::with('user')
                                    ->orderBy('created_at', 'desc')
                                    ->take(6)
                                    ->get();

        return view('dashboard', compact(
            'totalKategori', 'totalBarang', 'totalTrxBulanIni', 
            'lowStockItems', 'recentActivities'
        ));
    }
}