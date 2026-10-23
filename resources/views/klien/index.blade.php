@extends('layouts.app')

@section('content')

<style>
    .client-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .client-hero {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        color: #fff;
        padding: 30px 32px;
        border-radius: 20px;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
    }
    .client-hero h2 {
        color: #fff;
        margin: 0 0 8px 0;
        font-weight: 700;
        font-size: 24px;
    }
    .client-hero p {
        margin: 0;
        opacity: 0.85;
        font-size: 15px;
    }
    .client-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 28px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .client-card-header {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .client-alert {
        padding: 16px 20px;
        border-radius: 14px;
        margin-bottom: 24px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #a7f3d0;
    }
    .client-form {
        display: grid;
        grid-template-columns: 1.5fr 2.5fr auto;
        gap: 20px;
        align-items: flex-start;
    }
    .client-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .client-label {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
    }
    .client-input {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 14px;
        color: #334155;
        outline: none;
    }
    .client-input:focus {
        background: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    }
    .client-btn {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        height: 45px;
        margin-top: 27px;
    }
    .client-btn:hover {
        background: #1d4ed8;
    }
    .client-table-wrapper {
        overflow-x: auto;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }
    .client-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }
    .client-table th {
        background: #f8fafc;
        padding: 16px 20px;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-align: left;
        border-bottom: 2px solid #e2e8f0;
        text-transform: uppercase;
    }
    .client-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .client-table tbody tr:hover {
        background: #f8fafc;
    }
    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 8px 14px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-delete:hover {
        background: #dc2626;
        color: #ffffff;
    }
</style>

<div class="client-container">

    <div class="client-hero">
        <h2>Database Klien (SPPG)</h2>
        <p>Kelola daftar Satuan Pelayanan Pelanggan/Gizi tujuan distribusi barang keluar.</p>
    </div>
    
    @if(session('success'))
        <div class="client-alert">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="client-card">
        <div class="client-card-header">
            Tambah Klien Baru
        </div>
        <form action="{{ url('/klien') }}" method="POST" class="client-form">
            @csrf
            <div class="client-form-group">
                <label class="client-label">Nama SPPG</label>
                <input type="text" name="nama_sppg" class="client-input" placeholder="Misal: SPPG Bogor Tengah 01" required>
            </div>
            
            <div class="client-form-group">
                <label class="client-label">Alamat Lengkap SPPG</label>
                <input type="text" name="alamat_sppg" class="client-input" placeholder="Jalan / Desa / Kecamatan" required>
            </div>
            
            <button type="submit" class="client-btn">
                Simpan
            </button>
        </form>
    </div>

    <div class="client-card" style="padding: 0;">
        <div style="padding: 24px 28px 16px;">
            <h3 class="client-card-header" style="margin-bottom: 0;">Daftar SPPG Terdaftar</h3>
        </div>
        
        <div class="client-table-wrapper">
            <table class="client-table">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 60px;">No</th>
                        <th style="width: 250px;">Nama SPPG</th>
                        <th>Alamat Pengiriman</th>
                        <th style="text-align: center; width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $index => $client)
                    <tr>
                        <td style="text-align: center; color: #64748b;">
                            {{ $index + 1 }}
                        </td>
                        <td style="font-weight: 700; color: #0f172a;">
                            {{ $client->nama_sppg }}
                        </td>
                        <td style="color: #475569;">
                            {{ $client->alamat_sppg }}
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ url('/klien/hapus/' . $client->client_id) }}" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data SPPG ini?')">
                                Hapus
                            </a>
                        </td>
                    </tr>
                    @endforeach

                    @if($clients->isEmpty())
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 48px; color: #94a3b8;">
                            Belum ada data klien / SPPG yang didaftarkan.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection