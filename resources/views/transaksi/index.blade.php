@extends('layouts.app')

@section('content')

<style>
    /* =========================================
       GLOBAL UI & CARD STYLES
    ========================================= */
    .trx-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .trx-hero {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        color: #fff;
        padding: 30px 32px;
        border-radius: 20px;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
    }
    
    .trx-hero h2 {
        color: #fff;
        margin: 0 0 8px 0;
        font-weight: 700;
        font-size: 24px;
    }
    
    .trx-hero p {
        margin: 0;
        opacity: 0.85;
        font-size: 15px;
    }

    .trx-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 28px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.025);
    }

    /* =========================================
       ALERTS
    ========================================= */
    .trx-alert {
        padding: 16px 20px;
        border-radius: 14px;
        margin-bottom: 24px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .trx-alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .trx-alert-success {
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #a7f3d0;
    }

    /* =========================================
       FORM STYLES
    ========================================= */
    .trx-form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }

    .trx-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .trx-form-group.full-width {
        grid-column: 1 / -1;
    }

    .trx-label {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
    }

    .trx-input {
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

    .trx-input:focus {
        background: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    }

    .trx-btn {
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
    }

    .trx-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* =========================================
       TABLE STYLES
    ========================================= */
    .trx-table-header {
        margin-bottom: 16px;
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }

    .trx-table-wrapper {
        overflow-x: auto;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }

    .trx-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .trx-table th {
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

    .trx-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .trx-table tbody tr:hover {
        background: #f8fafc;
    }

    .trx-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* BADGES */
    .trx-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        display: inline-block;
        text-align: center;
        min-width: 60px;
    }
    .badge-in { background: #dcfce7; color: #166534; }
    .badge-out { background: #fee2e2; color: #991b1b; }
    .badge-revisi { background: #fef3c7; color: #92400e; }
    
    .stock-change { font-size: 13px; color: #64748b; }
    .stock-change strong { color: #0f172a; font-size: 14px; }
</style>

<div class="trx-container">

    <!-- Hero Section -->
    <div class="trx-hero">
        <h2>Transaksi Distribusi Barang</h2>
        <p>Catat barang masuk, distribusi ke SPPG, serta penyesuaian stok fisik inventori.</p>
    </div>
    
    <!-- Alerts -->
    @if($errors->has('error_trx'))
        <div class="trx-alert trx-alert-danger">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ $errors->first('error_trx') }}
        </div>
    @endif
    @if(session('success'))
        <div class="trx-alert trx-alert-success">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Transaksi -->
    <div class="trx-card">
        <form action="/transaksi" method="POST">
            @csrf
            
            <div class="trx-form-grid">
                
                <div class="trx-form-group">
                    <label class="trx-label">Jenis Transaksi</label>
                    <select name="type" id="trxType" class="trx-input" required onchange="toggleClientBox()">
                        <option value="IN">IN (Barang Masuk)</option>
                        <option value="OUT">OUT (Barang Keluar)</option>
                        <option value="REVISION">REVISION (Penyesuaian Fisik)</option>
                    </select>
                </div>

                <div class="trx-form-group">
                    <label class="trx-label">Pilih Barang</label>
                    <select id="itemSelect" name="item_id" class="trx-input" required onchange="updateSatuanOptions()">
                        <option value="" data-jenis="">-- Pilih Barang --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->item_id }}" data-jenis="{{ $item->jenis_satuan }}">
                                {{ $item->item_name }} (Stok: {{ (float)$item->current_stock }} {{ $item->satuan_dasar }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Box Klien (SPPG) - Disembunyikan secara default -->
                <div class="trx-form-group" id="clientBox" style="display: none;">
                    <label class="trx-label">Tujuan SPPG (Klien)</label>
                    <select id="clientInput" name="client_id" class="trx-input">
                        <option value="">-- Pilih Tujuan --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->client_id }}">{{ $client->nama_sppg }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="trx-form-group">
                    <label class="trx-label">Jumlah Kuantitas</label>
                    <input type="number" step="0.01" name="qty" class="trx-input" placeholder="Misal: 1.5 atau 10" required>
                </div>

                <div class="trx-form-group">
                    <label class="trx-label">Satuan Input</label>
                    <select id="satuanSelect" name="satuan_input" class="trx-input" required>
                        <option value="">Pilih barang dulu</option>
                    </select>
                </div>

                <div class="trx-form-group full-width">
                    <label class="trx-label">Catatan Opsional</label>
                    <input type="text" name="catatan" class="trx-input" placeholder="Keterangan pengiriman / alasan revisi...">
                </div>

                <div class="trx-form-group full-width" style="align-items: flex-end; margin-top: 8px;">
                    <button type="submit" class="trx-btn">
                        Proses Transaksi
                        <svg style="margin-left:8px;" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- Tabel Riwayat Transaksi -->
    <div class="trx-card" style="padding: 0;">
        <div style="padding: 24px 28px 16px;">
            <h3 class="trx-table-header">Riwayat Transaksi Terakhir</h3>
        </div>
        
        <div class="trx-table-wrapper">
            <table class="trx-table">
                <thead>
                    <tr>
                        <th>Waktu (WIB)</th>
                        <th>Tipe</th>
                        <th>Nama Barang</th>
                        <th>Tujuan SPPG</th>
                        <th style="text-align: right;">Input Qty</th>
                        <th style="text-align: right;">Stok (Sblm ➔ Ssdh)</th>
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
                                <span class="trx-badge badge-in">IN</span>
                            @elseif($trx->type == 'OUT')
                                <span class="trx-badge badge-out">OUT</span>
                            @else
                                <span class="trx-badge badge-revisi">REVISI</span>
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
                        <td style="text-align: right;" class="stock-change">
                            {{ (float)$trx->stock_sebelum }} ➔ <strong>{{ (float)$trx->stock_sesudah }}</strong> 
                            <span style="font-size: 11px;">{{ $trx->item->satuan_dasar ?? '' }}</span>
                        </td>
                    </tr>
                    @endforeach

                    @if(count($transactions) == 0)
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 48px; color: #94a3b8;">
                            <svg style="margin: 0 auto 12px; display: block;" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Belum ada riwayat transaksi.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Script Kombinasi: Satuan Dinamis & Toggle SPPG -->
<script>
    function updateSatuanOptions() {
        let itemSelect = document.getElementById('itemSelect');
        let selectedOption = itemSelect.options[itemSelect.selectedIndex];
        let jenisSatuan = selectedOption.getAttribute('data-jenis');
        
        let satuanSelect = document.getElementById('satuanSelect');
        satuanSelect.innerHTML = ''; 

        if (!jenisSatuan) {
            satuanSelect.add(new Option('Pilih barang dulu', ''));
            return;
        }

        if (jenisSatuan === 'WEIGHT') {
            satuanSelect.add(new Option('Gram', 'Gram'));
            satuanSelect.add(new Option('KG', 'KG'));
            satuanSelect.add(new Option('Ons', 'Ons'));
        } else if (jenisSatuan === 'VOLUME') {
            satuanSelect.add(new Option('Mililiter', 'Mililiter'));
            satuanSelect.add(new Option('Liter', 'Liter'));
        } else {
            satuanSelect.add(new Option(jenisSatuan, jenisSatuan));
        }
    }

    function toggleClientBox() {
        let type = document.getElementById('trxType').value;
        let clientBox = document.getElementById('clientBox');
        let clientInput = document.getElementById('clientInput');

        if (type === 'OUT') {
            clientBox.style.display = 'flex'; // Menggunakan flex agar label dan select tertata
            clientInput.required = true;
        } else {
            clientBox.style.display = 'none';
            clientInput.required = false;
            clientInput.value = ''; 
        }
    }

    // Jalankan saat halaman baru dimuat
    document.addEventListener('DOMContentLoaded', function() {
        toggleClientBox();
    });
</script>
@endsection