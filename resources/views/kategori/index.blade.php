@extends('layouts.app')

@section('content')

<style>
    /* =========================================
       GLOBAL UI & CARD STYLES
    ========================================= */
    .cat-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .cat-hero {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        color: #fff;
        padding: 30px 32px;
        border-radius: 20px;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
    }
    
    .cat-hero h2 {
        color: #fff;
        margin: 0 0 8px 0;
        font-weight: 700;
        font-size: 24px;
    }
    
    .cat-hero p {
        margin: 0;
        opacity: 0.85;
        font-size: 15px;
    }

    .cat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 28px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.025);
    }

    .cat-card-header {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* =========================================
       FORM STYLES
    ========================================= */
    .cat-form {
        display: grid;
        grid-template-columns: 1fr 2fr auto;
        gap: 20px;
        align-items: flex-start;
    }

    .cat-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .cat-label {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
    }

    .cat-input {
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

    textarea.cat-input {
        resize: vertical;
        min-height: 45px;
        line-height: 1.5;
    }

    .cat-input:focus {
        background: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    }

    .cat-btn {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        height: 45px;
        margin-top: 27px; /* Align with input boxes */
    }

    .cat-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* =========================================
       TABLE STYLES
    ========================================= */
    .cat-table-wrapper {
        overflow-x: auto;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }

    .cat-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .cat-table th {
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

    .cat-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .cat-table tbody tr:hover {
        background: #f8fafc;
    }

    .cat-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* BADGES & BUTTONS */
    .badge-count {
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
        display: inline-block;
        border: 1px solid #bfdbfe;
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

    /* RESPONSIVE */
    @media (max-width: 992px) {
        .cat-form {
            grid-template-columns: 1fr;
        }
        .cat-btn {
            margin-top: 8px;
            width: 100%;
        }
    }
</style>

<div class="cat-container">

    <!-- Hero Section -->
    <div class="cat-hero">
        <h2>Kelola Kategori Barang</h2>
        <p>Klasifikasi master data beserta deskripsi dan rekapitulasi jumlah barang.</p>
    </div>
    @if(session('warning'))
<div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm" role="alert" style="background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 16px 20px; border-radius: 14px; margin-bottom: 24px; font-weight: 500;">
    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
    <!-- Form Tambah Kategori -->
    <div class="cat-card">
        <div class="cat-card-header">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
            Tambah Kategori Baru
        </div>
        <form action="/kategori" method="POST" class="cat-form">
            @csrf
            <div class="cat-form-group">
                <label class="cat-label">Nama Kategori</label>
                <input type="text" name="category_name" class="cat-input" placeholder="Misal: Bumbu Dapur" required>
            </div>
            
            <div class="cat-form-group">
                <label class="cat-label">Deskripsi (Opsional)</label>
                <textarea name="description" class="cat-input" placeholder="Penjelasan singkat kategori ini..."></textarea>
            </div>
            
            <button type="submit" class="cat-btn">
                Simpan Data
            </button>
        </form>
    </div>

    <!-- Tabel Data Kategori -->
    <div class="cat-card" style="padding: 0;">
        <div style="padding: 24px 28px 16px;">
            <h3 class="cat-card-header" style="margin-bottom: 0;">Daftar Kategori</h3>
        </div>
        
        <div class="cat-table-wrapper">
            <table class="cat-table">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th style="width: 250px;">Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th style="width: 150px; text-align: center;">Jumlah Item</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $cat)
                    <tr>
                        <td style="text-align: center; color: #64748b;">
                            {{ $index + 1 }}
                        </td>
                        <td style="font-weight: 700; color: #0f172a;">
                            {{ $cat->category_name }}
                        </td>
                        <td style="color: #475569; white-space: normal; min-width: 200px;">
                            {{ $cat->description ?? '-' }}
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-count">
                                {{ $cat->items_count }} Barang
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="/kategori/hapus/{{ $cat->category_id }}" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if(count($categories) == 0)
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 48px; color: #94a3b8;">
                            <svg style="margin: 0 auto 12px; display: block;" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Belum ada data kategori.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection