<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class ItemController
{
    public function index()
    {
        $items = Item::with('category')->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        
        return view('barang.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'item_name' => 'required|string|max:200',
            'category_id' => 'required|exists:tb_categories,category_id',
            'jenis_satuan' => 'required|in:WEIGHT,VOLUME,PACK,BOX,PCS',
            'min_stock_alert' => 'required|numeric|min:0'
        ]);

        // 2. Validasi Ketat Logika Desimal
        $isDecimalAllowed = in_array($request->jenis_satuan, ['WEIGHT', 'VOLUME']);
        
        // fmod digunakan untuk mengecek apakah ada sisa pecahan dari sebuah angka
        if (!$isDecimalAllowed && fmod($request->min_stock_alert, 1) !== 0.00) {
            return back()->with('warning', 'Satuan ' . $request->jenis_satuan . ' tidak boleh mengandung angka pecahan/desimal. Harus bilangan bulat!');
        }

        // 3. Penentuan Satuan Dasar Otomatis (Standar Backend)
        $satuanDasar = $request->jenis_satuan; // Default
        if ($request->jenis_satuan == 'WEIGHT') $satuanDasar = 'Gram';
        if ($request->jenis_satuan == 'VOLUME') $satuanDasar = 'Mililiter';
        if ($request->jenis_satuan == 'PACK') $satuanDasar = 'Pack';
        if ($request->jenis_satuan == 'BOX') $satuanDasar = 'Box';
        if ($request->jenis_satuan == 'PCS') $satuanDasar = 'Pcs';

        // 4. Eksekusi Simpan
        Item::create([
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'description' => $request->description,
            'jenis_satuan' => $request->jenis_satuan,
            'satuan_dasar' => $satuanDasar,
            'current_stock' => 0, // Barang baru selalu 0
            'min_stock_alert' => $request->min_stock_alert
        ]);

        return back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        // Pengecekan: Barang tidak bisa dihapus jika stok masih ada (> 0)
        if ($item->current_stock > 0) {
            return back()->with('warning', 'Gagal menghapus! Barang "' . $item->item_name . '" masih memiliki stok tersisa (' . $item->current_stock . ' ' . $item->satuan_dasar . '). Habiskan stok terlebih dahulu melalui transaksi.');
        }

        $item->delete();
        
        return back()->with('success', 'Barang berhasil dihapus.');
    }
}