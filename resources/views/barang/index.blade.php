@extends('layouts.app')

@section('content')

<style>
    /* =========================================
       GLOBAL UI & CARD STYLES
    ========================================= */
    .item-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .item-hero {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        color: #fff;
        padding: 30px 32px;
        border-radius: 20px;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
    }
    
    .item-hero h2 {
        color: #fff;
        margin: 0 0 8px 0;
        font-weight: 700;
        font-size: 24px;
    }
    
    .item-hero p {
        margin: 0;
        opacity: 0.85;
        font-size: 15px;
    }

    .item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 28px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.025);
    }

    .item-card-header {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* =========================================
       ALERTS
    ========================================= */
    .item-alert {
        padding: 16px 20px;
        border-radius: 14px;
        margin-bottom: 24px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .item-alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* =========================================
       FORM STYLES
    ========================================= */
    .item-form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }

    .item-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .item-form-group.full-width {
        grid-column: 1 / -1;
    }

    .item-label {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
    }

    .item-input {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 14px;
        color: #334155;
        transition: all 0.2s ease;
        box-sizing: border-box;
        outline: none;
    }

    .item-input:focus {
        background: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    }

    .item-btn {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 12px 32px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .item-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* =========================================
       TABLE STYLES
    ========================================= */
    .item-table-wrapper {
        overflow-x: auto;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }

    .item-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .item-table th {
        background: #f8fafc;
        padding: 16px 20px;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-align: left;
        border-bottom: 2px solid #e2e8f0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .item-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .item-table tbody tr:hover {
        background: #f8fafc;
    }

    .item-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* BADGES & BUTTONS */
    .badge-type {
        background: #f1f5f9;
        color: #475569;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        display: inline-block;
        border: 1px solid #e2e8f0;
    }

    .badge-stock {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
        display: inline-block;
    }

    .badge-stock-safe {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .badge-stock-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
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
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }
</style>

<div class="item-container">

    <!-- Hero Section -->
    <div class="item-hero">
        <h2>Master Data Barang</h2>
        <p>Kelola klasifikasi barang, satuan pengukuran, dan peringatan batas stok.</p>
    </div>
    
    <!-- Error Notification -->
    @if($errors->has('error_satuan'))
        <div class="item-alert item-alert-danger">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ $errors->first('error_satuan') }}
        </div>
    @endif

    <!-- Form Tambah Barang -->
    <div class="item-card">
        <div class="item-card-header">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            Tambah Barang Baru
        </div>
        
        <form action="/barang" method="POST">
            @csrf
            <div class="item-form-grid">
                
                <div class="item-form-group">
                    <label class="item-label">Nama Barang</label>
                    <input type="text" name="item_name" class="item-input" placeholder="Misal: Beras Premium" required>
                </div>

                <div class="item-form-group">
                    <label class="item-label">Kategori</label>
                    <select name="category_id" class="item-input" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="item-form-group">
                    <label class="item-label">Jenis Satuan</label>
                    <select name="jenis_satuan" class="item-input" required>
                        <option value="">-- Pilih Satuan --</option>
                        <option value="WEIGHT">WEIGHT (Gram/Kg/Ons)</option>
                        <option value="VOLUME">VOLUME (Liter/Mililiter)</option>
                        <option value="PACK">PACK (Bilangan Bulat)</option>
                        <option value="BOX">BOX (Bilangan Bulat)</option>
                        <option value="PCS">PCS (Bilangan Bulat)</option>
                    </select> 
                </div>

                <div class="item-form-group">
                    <label class="item-label">Min. Stok Alert</label>
                    <input type="number" step="0.01" name="min_stock_alert" class="item-input" placeholder="Misal: 10 atau 0.5" required>
                </div>

                <div class="item-form-group full-width">
                    <label class="item-label">Deskripsi Opsional</label>
                    <input type="text" name="description" class="item-input" placeholder="Catatan tambahan barang...">
                </div>

                <div class="item-form-group full-width" style="align-items: flex-end; margin-top: 8px;">
                    <button type="submit" class="item-btn">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Barang
                    </button>
                </div>

            </div>
        </form>
        
    </div>

    <!-- Tabel Data Barang --><!-- Flash Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Alert Warning untuk Stok Masih Ada / Kategori Dipakai -->
@if(session('warning'))
<div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm" role="alert" style="background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a;">
    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
    <div class="item-card" style="padding: 0;">
        <div style="padding: 24px 28px 16px;">
            <h3 class="item-card-header" style="margin-bottom: 0;">Daftar Barang</h3>
        </div>
        
        <div class="item-table-wrapper">
            <table class="item-table">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 60px;">No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th style="text-align: center;">Tipe Satuan</th>
                        <th style="text-align: center;">Stok (Base Unit)</th>
                        <th style="text-align: center; width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $index => $item)
                    <tr>
                        <td style="text-align: center; color: #64748b;">
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;">{{ $item->item_name }}</div>
                            @if($item->description)
                                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">{{ $item->description }}</div>
                            @endif
                        </td>
                        <td style="color: #475569; font-weight: 500;">
                            {{ $item->category->category_name ?? '-' }}
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-type">
                                {{ $item->jenis_satuan }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <!-- Penentuan kelas CSS berdasarkan batas minimum stok -->
                            <span class="badge-stock {{ $item->current_stock <= $item->min_stock_alert ? 'badge-stock-danger' : 'badge-stock-safe' }}">
                                {{ (float)$item->current_stock }} {{ $item->satuan_dasar }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="/barang/hapus/{{ $item->item_id }}" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </a>
                        </td>
                    </tr>
                    @endforeach

                    @if(count($items) == 0)
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 48px; color: #94a3b8;">
                            <svg style="margin: 0 auto 12px; display: block;" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Belum ada data barang.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection