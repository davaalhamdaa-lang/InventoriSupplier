<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController
{
    // Menampilkan halaman/daftar kategori
    public function index()
    {
        $categories = Category::withCount('items')->latest()->get();
        return view('kategori.index', compact('categories'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'category_name' => 'required|string|max:100|unique:tb_categories,category_name',
            'description'   => 'nullable|string'
        ], [
            'category_name.unique' => 'Nama kategori sudah digunakan.'
        ]);
        
        Category::create($request->only(['category_name', 'description']));

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy($id) 
    {
        $category = Category::findOrFail($id);
        
        // Cek apakah kategori masih digunakan oleh barang (relasi items)
        if ($category->items()->count() > 0) {
            return back()->with('warning', 'Gagal menghapus! Kategori "' . $category->category_name . '" sedang digunakan oleh beberapa barang.');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}