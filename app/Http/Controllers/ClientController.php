<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController
{
    public function index()
    {
        $clients = Client::all();
        return view('klien.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sppg'   => 'required|string|max:150',
            'alamat_sppg' => 'required|string',
        ]);

        Client::create([
            'nama_sppg'   => $request->nama_sppg,
            'alamat_sppg' => $request->alamat_sppg,
        ]);

        return back()->with('success', 'Klien / SPPG berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Client::findOrFail($id)->delete();
        return back()->with('success', 'Klien / SPPG berhasil dihapus!');
    }
}