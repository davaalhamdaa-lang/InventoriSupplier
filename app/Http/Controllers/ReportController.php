<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Client;
use Illuminate\Support\Facades\Response;

class ReportController
{
    // Fungsi bantuan untuk filter data secara dinamis
    private function filterData($request) {
        $query = Transaction::with(['item', 'client', 'user'])->orderBy('date_recorded', 'desc');

        if ($request->start_date && $request->end_date) {
            // Karena date_recorded adalah timestamp, kita paskan ujung harinya
            $query->whereBetween('date_recorded', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }
        if ($request->type) {
            $query->where('type', $request->type);
        }
        if ($request->client_id) {
            $query->where('client_id', $request->client_id);
        }
        
        return $query->get();
    }

    public function index(Request $request)
    {
        $transactions = $this->filterData($request);
        $clients = Client::all();
        return view('laporan.index', compact('transactions', 'clients'));
    }

    public function exportPdf(Request $request)
    {
        $transactions = $this->filterData($request);
        return view('laporan.pdf', compact('transactions', 'request'));
    }

    public function exportExcel(Request $request)
    {
        $transactions = $this->filterData($request);
        $fileName = 'Laporan_Distribusi_MBG_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($transactions) {
            $file = fopen('php://output', 'w');
            
            // Header Excel
            fputcsv($file, [
                'Waktu', 'Tipe', 'Nama Barang', 'Tujuan SPPG', 
                'Input Mutasi', 'Satuan Input', 
                'Stok Sebelum (Base Unit)', 'Stok Sesudah (Base Unit)', 
                'Operator', 'Catatan'
            ]);
            
            // Isi Data Baris per Baris
            foreach ($transactions as $trx) {
                fputcsv($file, [
                    \Carbon\Carbon::parse($trx->date_recorded)->timezone('Asia/Jakarta')->format('Y-m-d H:i'),
                    $trx->type,
                    $trx->item->item_name ?? 'Barang Dihapus',
                    $trx->client ? $trx->client->nama_sppg : '-',
                    (float)$trx->qty,
                    $trx->satuan_transaksi,
                    (float)$trx->stock_sebelum . ' ' . ($trx->item->satuan_dasar ?? ''),
                    (float)$trx->stock_sesudah . ' ' . ($trx->item->satuan_dasar ?? ''),
                    $trx->user->name ?? 'Sistem',
                    $trx->catatan ?? '-'
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}