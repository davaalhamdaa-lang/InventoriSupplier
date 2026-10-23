<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Item;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController
{
    public function index()
    {
        // Panggil relasi 'client' agar nama SPPG bisa ditampilkan di riwayat
        $transactions = Transaction::with(['item', 'user', 'client'])->orderBy('date_recorded', 'desc')->get();
        $items = Item::all();
        $clients = Client::all(); // Mengambil seluruh data SPPG
        
        return view('transaksi.index', compact('transactions', 'items', 'clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:tb_items,item_id',
            'type' => 'required|in:IN,OUT,REVISION',
            'qty' => 'required|numeric|min:0.01',
            'satuan_input' => 'required|string',
            'client_id' => 'required_if:type,OUT', // Wajib diisi JIKA tipenya OUT
            'catatan' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($request) {
            $item = Item::findOrFail($request->item_id);
            $qty_input = $request->qty;
            
            $isDecimalAllowed = in_array($item->jenis_satuan, ['WEIGHT', 'VOLUME']);
            if (!$isDecimalAllowed && fmod($qty_input, 1) !== 0.00) {
                return back()->withErrors(['error_trx' => 'Gagal! Satuan ' . $item->jenis_satuan . ' tidak boleh berupa pecahan desimal.']);
            }

            $multiplier = 1;
            if ($item->jenis_satuan === 'WEIGHT') {
                if ($request->satuan_input === 'KG') $multiplier = 1000;
                if ($request->satuan_input === 'Ons') $multiplier = 100;
            } elseif ($item->jenis_satuan === 'VOLUME') {
                if ($request->satuan_input === 'Liter') $multiplier = 1000;
            }

            $qty_base_unit = $qty_input * $multiplier;
            $stock_sebelum = $item->current_stock;

            if ($request->type === 'OUT') {
                if ($stock_sebelum < $qty_base_unit) {
                    return back()->withErrors(['error_trx' => 'Stok tidak mencukupi! Sisa: ' . (float)$stock_sebelum . ' ' . $item->satuan_dasar]);
                }
                $item->current_stock -= $qty_base_unit;
            } elseif ($request->type === 'IN') {
                $item->current_stock += $qty_base_unit;
            } elseif ($request->type === 'REVISION') {
                $item->current_stock = $qty_base_unit; 
            }

            $item->save(); 

            Transaction::create([
                'item_id' => $item->item_id,
                'user_id' => Auth::id(),
                'client_id' => $request->type === 'OUT' ? $request->client_id : null, // Simpan klien jika OUT
                'type' => $request->type,
                'qty' => $qty_input, 
                'satuan_transaksi' => $request->satuan_input,
                'stock_sebelum' => $stock_sebelum,
                'stock_sesudah' => $item->current_stock,
                'catatan' => $request->catatan
            ]);

            return back()->with('success', 'Transaksi berhasil diproses.');
        });
    }
}