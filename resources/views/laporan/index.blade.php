@extends('layouts.app')

@section('content')

<style>
    /* =========================================
       GLOBAL UI & CARD STYLES
    ========================================= */
    .report-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .report-hero {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        color: #fff;
        padding: 30px 32px;
        border-radius: 20px;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
    }
    
    .report-hero h2 {
        color: #fff;
        margin: 0 0 8px 0;
        font-weight: 700;
        font-size: 24px;
    }
    
    .report-hero p {
        margin: 0;
        opacity: 0.85;
        font-size: 15px;
    }

    .report-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 28px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.025);
    }

    .report-card-header {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* =========================================
       FORM FILTER STYLES
    ========================================= */
    .report-form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .report-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .report-label {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
    }

    .report-input {
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

    .report-input:focus {
        background: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    }

    /* =========================================
       BUTTONS
    ========================================= */
    .btn-group {
        grid-column: 1 / -1;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .report-btn {
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-filter {
        background: #334155;
        color: #ffffff;
    }
    .btn-filter:hover { background: #1e293b; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(51, 65, 85, 0.2); }

    .btn-pdf {
        background: #ef4444;
        color: #ffffff;
    }
    .btn-pdf:hover { background: #dc2626; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2); }

    .btn-excel {
        background: #10b981;
        color: #ffffff;
    }
    .btn-excel:hover { background: #059669; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); }

    /* =========================================
       TABLE STYLES
    ========================================= */
    .report-table-wrapper {
        overflow-x: auto;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .report-table th {
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

    .report-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .report-table tbody tr:hover {
        background: #f8fafc;
    }

    .report-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* BADGES */
    .badge-trx {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
        text-align: center;
        min-width: 60px;
    }
    .badge-in { background: #dcfce7; color: #166534; }
    .badge-out { background: #fee2e2; color: #991b1b; }
    .badge-revisi { background: #fef3c7; color: #92400e; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .btn-group {
            justify-content: stretch;
            flex-direction: column;
        }
        .btn-group .report-btn {
            width: 100%;
        }
    }
</style>

<div class="report-container">

    <!-- Hero Section -->
    <div class="report-hero">
        <h2>Filter & Ekspor Laporan</h2>
        <p>Saring riwayat mutasi stok dan unduh dalam format PDF atau Excel.</p>
    </div>

    <!-- Form Filter Dinamis -->
    <div class="report-card">
        <div class="report-card-header">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Kriteria Filter
        </div>
        
        <form action="/laporan" method="GET">
            <div class="report-form-grid">
                
                <div class="report-form-group">
                    <label class="report-label">Dari Tanggal</label>
                    <input type="date" name="start_date" class="report-input" value="{{ request('start_date') }}">
                </div>
                
                <div class="report-form-group">
                    <label class="report-label">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="report-input" value="{{ request('end_date') }}">
                </div>

                <div class="report-form-group">
                    <label class="report-label">Jenis Mutasi</label>
                    <select name="type" class="report-input">
                        <option value="">Semua Transaksi</option>
                        <option value="IN" {{ request('type') == 'IN' ? 'selected' : '' }}>Barang Masuk (IN)</option>
                        <option value="OUT" {{ request('type') == 'OUT' ? 'selected' : '' }}>Barang Keluar (OUT)</option>
                        <option value="REVISION" {{ request('type') == 'REVISION' ? 'selected' : '' }}>Penyesuaian (REVISI)</option>
                    </select>
                </div>

                <div class="report-form-group">
                    <label class="report-label">Pilih SPPG</label>
                    <select name="client_id" class="report-input">
                        <option value="">Semua SPPG</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->client_id }}" {{ request('client_id') == $client->client_id ? 'selected' : '' }}>{{ $client->nama_sppg }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="btn-group">
                    <button type="submit" class="report-btn btn-filter">
                        Terapkan Filter
                    </button>
                    
                    <a href="/laporan/pdf?{{ http_build_query(request()->all()) }}" target="_blank" class="report-btn btn-pdf">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Cetak PDF
                    </a>
                    
                    <a href="/laporan/excel?{{ http_build_query(request()->all()) }}" class="report-btn btn-excel">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Unduh Excel
                    </a>
                </div>
                
            </div>
        </form>
    </div>

    <!-- Tabel Pratinjau -->
    <div class="report-card" style="padding: 0;">
        <div style="padding: 24px 28px 16px;">
            <h3 class="report-card-header" style="margin-bottom: 0;">Pratinjau Data Laporan</h3>
        </div>
        
        <div class="report-table-wrapper">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Waktu (WIB)</th>
                        <th>Tipe</th>
                        <th>Nama Barang</th>
                        <th>Tujuan SPPG</th>
                        <th style="text-align: right;">Mutasi (Input)</th>
                        <th>Operator</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $trx)
                    <tr>
                        <td style="color: #64748b;">
                            {{ \Carbon\Carbon::parse($trx->date_recorded)->timezone('Asia/Jakarta')->format('d M y, H:i') }}
                        </td>
                        <td>
                            @if($trx->type == 'IN')
                                <span class="badge-trx badge-in">IN</span>
                            @elseif($trx->type == 'OUT')
                                <span class="badge-trx badge-out">OUT</span>
                            @else
                                <span class="badge-trx badge-revisi">REVISI</span>
                            @endif
                        </td>
                        <td style="font-weight: 600; color: #0f172a;">
                            {{ $trx->item->item_name ?? '-' }}
                        </td>
                        <td>
                            @if($trx->client)
                                <span style="color: #2563eb; font-weight: 500;">{{ $trx->client->nama_sppg }}</span>
                            @else
                                <span style="color: #94a3b8;">-</span>
                            @endif
                        </td>
                        <td style="text-align: right; font-weight: 700; color: #0f172a;">
                            {{ (float)$trx->qty }} <span style="font-size:12px; color:#64748b;">{{ $trx->satuan_transaksi }}</span>
                        </td>
                        <td style="font-size: 13px; color: #475569;">
                            {{ $trx->user->name ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                    
                    @if(count($transactions) == 0)
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 48px; color: #94a3b8;">
                            <svg style="margin: 0 auto 12px; display: block;" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Data transaksi tidak ditemukan untuk filter ini.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection