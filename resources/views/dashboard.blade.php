@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
/* =========================
   DASHBOARD ONLY (FIT FRAME)
========================= */

.dashboard-container {
    display: flex;
    flex-direction: column;
    height: 100%;
    max-height: calc(100vh - 120px); /* Sesuaikan dengan tinggi header/navbar layout utama */
    overflow: hidden;
    box-sizing: border-box;
}

.dashboard-header{
    margin-bottom: 16px;
    flex-shrink: 0;
}

.dashboard-hero{
    background: var(--gradient);
    color: white;
    padding: 20px 24px;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
}

.dashboard-hero h2{
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 4px;
}

.dashboard-hero p{
    font-size: 14px;
    opacity: .9;
    margin: 0;
}

.dashboard-stats{
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 16px;
    flex-shrink: 0;
}

.stat-card{
    background: white;
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--shadow);
    transition: .25s;
}

.stat-card:hover{
    transform: translateY(-2px);
}

.stat-icon{
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon svg{
    width: 22px;
    height: 22px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
}

.stat-icon.blue{
    background: #eff6ff;
    color: #2563eb;
}

.stat-icon.green{
    background: #ecfdf5;
    color: #10b981;
}

.stat-icon.orange{
    background: #fff7ed;
    color: #f59e0b;
}

.stat-label{
    font-size: 12px;
    font-weight: 600;
    color: var(--text-soft);
}

.stat-value{
    font-size: 28px;
    font-weight: 800;
    color: var(--text);
    line-height: 1.2;
}

.dashboard-grid{
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 16px;
    flex: 1;
    min-height: 0; /* Penting untuk flex container grid anak */
}

/* Memastikan card ikut mengisi tinggi grid dan tidak meluber */
.dashboard-grid .card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    height: 100%;
    box-sizing: border-box;
    overflow: hidden;
}

.section-header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
    flex-shrink: 0;
}

.section-header h3{
    font-size: 16px;
    font-weight: 700;
    margin: 0;
}

/* Scroll internal khusus list agar halaman utama tidak scroll */
.stock-list, .activity-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    overflow-y: auto;
    padding-right: 4px;
    flex: 1;
}

/* Styling Scrollbar tipis agar rapi */
.stock-list::-webkit-scrollbar, 
.activity-list::-webkit-scrollbar {
    width: 6px;
}
.stock-list::-webkit-scrollbar-thumb, 
.activity-list::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 4px;
}

.stock-item{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 14px;
    border-radius: 12px;
    background: #fff5f5;
    border: 1px solid #fecaca;
    flex-shrink: 0;
}

.stock-item-name{
    font-weight: 700;
    font-size: 14px;
    margin-bottom: 2px;
}

.stock-item-min{
    font-size: 11px;
    color: var(--text-soft);
}

.stock-value{
    background: var(--danger);
    color: white;
    min-width: 45px;
    padding: 6px 10px;
    text-align: center;
    border-radius: 8px;
    font-weight: 700;
    font-size: 14px;
}

.empty-state{
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 20px;
}

.empty-state h4{
    margin-bottom: 4px;
    font-size: 15px;
}

.empty-state p{
    font-size: 13px;
    color: var(--text-soft);
    margin: 0;
}

.activity-item{
    display: flex;
    gap: 12px;
    align-items: flex-start;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 12px 14px;
    flex-shrink: 0;
}

.activity-dot{
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-top: 6px;
    background: var(--primary);
    flex-shrink: 0;
}

.activity-content{
    flex: 1;
}

.activity-title{
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 2px;
    font-size: 14px;
}

.activity-desc{
    font-size: 12px;
    color: var(--text-soft);
}

.activity-time{
    font-size: 11px;
    color: var(--text-soft);
    white-space: nowrap;
}

.badge-primary{
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
    font-size: 11px;
    padding: 2px 6px;
    border-radius: 6px;
}

@media(max-width:1200px){
    .dashboard-container {
        max-height: none;
        overflow: visible;
    }
    .dashboard-grid{
        grid-template-columns: 1fr;
    }
    .dashboard-grid .card {
        height: auto;
    }
    .stock-list, .activity-list {
        max-height: 350px;
    }
}

@media(max-width:992px){
    .dashboard-stats{
        grid-template-columns: 1fr;
    }
}
</style>

<div class="dashboard-container">

    <div class="dashboard-header">
        <div class="dashboard-hero">
            <h2>Selamat Datang, {{ auth()->user()->name }}</h2>
            <p>Pantau inventori, distribusi barang, dan aktivitas operasional MBG secara real-time.</p>
        </div>
    </div>

    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="8" height="8"></rect>
                    <rect x="13" y="3" width="8" height="8"></rect>
                    <rect x="3" y="13" width="8" height="8"></rect>
                    <rect x="13" y="13" width="8" height="8"></rect>
                </svg>
            </div>
            <div>
                <div class="stat-label">Total Kategori</div>
                <div class="stat-value">{{ $totalKategori }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg viewBox="0 0 24 24">
                    <path d="M21 8L12 3L3 8"></path>
                    <path d="M3 8V16L12 21L21 16V8"></path>
                    <path d="M12 21V12"></path>
                </svg>
            </div>
            <div>
                <div class="stat-label">Jenis Barang</div>
                <div class="stat-value">{{ $totalBarang }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <svg viewBox="0 0 24 24">
                    <path d="M7 7H21"></path>
                    <path d="M17 3L21 7L17 11"></path>
                    <path d="M17 17H3"></path>
                    <path d="M7 13L3 17L7 21"></path>
                </svg>
            </div>
            <div>
                <div class="stat-label">Mutasi Bulan Ini</div>
                <div class="stat-value">{{ $totalTrxBulanIni }}</div>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="card">
            <div class="section-header">
                <h3>Peringatan Stok</h3>
                <span class="badge badge-danger">
                    {{ count($lowStockItems) }}
                </span>
            </div>

            @if(count($lowStockItems))
                <div class="stock-list">
                    @foreach($lowStockItems as $alert)
                    <div class="stock-item">
                        <div>
                            <div class="stock-item-name">{{ $alert->item_name }}</div>
                            <div class="stock-item-min">Minimum {{ (float)$alert->min_stock_alert }} {{ $alert->satuan_dasar }}</div>
                        </div>
                        <div class="stock-value">{{ (float)$alert->current_stock }}</div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <h4>Semua Stok Aman</h4>
                    <p>Tidak ada barang yang berada di bawah batas minimum.</p>
                </div>
            @endif
        </div>

        <div class="card">
            <div class="section-header">
                <h3>Aktivitas Sistem</h3>
            </div>

            @if(count($recentActivities))
                <div class="activity-list">
                    @foreach($recentActivities as $log)
                    <div class="activity-item">
                        <div class="activity-dot"></div>
                        <div class="activity-content">
                            <div class="activity-title">
                                <strong>{{ $log->user->name ?? 'Sistem' }}</strong>
                                <span class="badge badge-primary">{{ $log->action }}</span>
                            </div>
                            <div class="activity-desc">
                                {{ $log->action == 'LOGIN' ? 'Login ke sistem' : 'Aktivitas pada tabel '.$log->table_name }}
                            </div>
                        </div>
                        <div class="activity-time">
                            {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <h4>Belum Ada Aktivitas</h4>
                    <p>Sistem belum memiliki histori aktivitas.</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection