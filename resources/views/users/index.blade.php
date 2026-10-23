@extends('layouts.app')

@section('content')

<style>
    /* =========================================
       GLOBAL UI & CARD STYLES
    ========================================= */
    .user-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .user-hero {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        color: #fff;
        padding: 30px 32px;
        border-radius: 20px;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
    }
    
    .user-hero h2 {
        color: #fff;
        margin: 0 0 8px 0;
        font-weight: 700;
        font-size: 24px;
    }
    
    .user-hero p {
        margin: 0;
        opacity: 0.85;
        font-size: 15px;
    }

    .user-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 28px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.025);
    }

    .user-card-header {
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
    .user-alert {
        padding: 16px 20px;
        border-radius: 14px;
        margin-bottom: 24px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .user-alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .user-alert-success {
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #a7f3d0;
    }

    /* =========================================
       FORM STYLES
    ========================================= */
    .user-form {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 20px;
        align-items: flex-end;
    }

    .user-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .user-label {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
    }

    .user-input {
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

    .user-input:focus {
        background: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    }

    .user-btn {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 12px 28px;
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
    }

    .user-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* =========================================
       TABLE STYLES
    ========================================= */
    .user-table-wrapper {
        overflow-x: auto;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .user-table th {
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

    .user-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .user-table tbody tr:hover {
        background: #f8fafc;
    }

    .user-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* BADGES & TYPOGRAPHY */
    .badge-role {
        background: #f1f5f9;
        color: #475569;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        display: inline-block;
        border: 1px solid #e2e8f0;
    }

    .pin-code {
        font-family: 'Courier New', Courier, monospace;
        font-size: 18px;
        font-weight: 800;
        color: #2563eb;
        background: #eff6ff;
        padding: 6px 14px;
        border-radius: 10px;
        letter-spacing: 3px;
        border: 1px dashed #bfdbfe;
        display: inline-block;
    }

    .badge-status {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 12px;
        display: inline-block;
    }

    .status-active { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .status-inactive { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    /* ACTION BUTTONS */
    .btn-toggle {
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

    .toggle-off {
        background: #ffffff;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .toggle-off:hover { background: #fef2f2; border-color: #dc2626; }

    .toggle-on {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }
    .toggle-on:hover { background: #2563eb; color: #ffffff; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .user-form {
            grid-template-columns: 1fr;
        }
        .user-btn {
            width: 100%;
        }
    }
</style>

<div class="user-container">

    <!-- Hero Section -->
    <div class="user-hero">
        <h2>Manajemen Akun Operator</h2>
        <p>Buat akun baru dan kelola status akses masuk (Login) operator gudang.</p>
    </div>

    <!-- Error/Success Notifications -->
    @if($errors->has('akses'))
        <div class="user-alert user-alert-danger">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ $errors->first('akses') }}
        </div>
    @endif
    @if(session('success'))
        <div class="user-alert user-alert-success">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tambah Operator -->
    <div class="user-card">
        <div class="user-card-header">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Tambah Operator Baru
        </div>
        <form action="/users" method="POST" class="user-form">
            @csrf
            <div class="user-form-group">
                <label class="user-label">Nama Lengkap Operator</label>
                <input type="text" name="name" class="user-input" placeholder="Misal: Budi Santoso" required>
            </div>
            
            <button type="submit" class="user-btn">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                Buat Akun & Generate PIN
            </button>
        </form>
    </div>

    <!-- Tabel Data Pengguna -->
    <div class="user-card" style="padding: 0;">
        <div style="padding: 24px 28px 16px;">
            <h3 class="user-card-header" style="margin-bottom: 0;">Daftar Akun Sistem</h3>
        </div>
        
        <div class="user-table-wrapper">
            <table class="user-table">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th>Nama Lengkap</th>
                        <th style="text-align: center;">Role</th>
                        <th style="text-align: center;">PIN Login</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $u)
                    <tr>
                        <td style="text-align: center; color: #64748b;">
                            {{ $index + 1 }}
                        </td>
                        <td style="font-weight: 700; color: #0f172a;">
                            {{ $u->name }}
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-role">{{ $u->role }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="pin-code">{{ $u->pin }}</span>
                        </td>
                        <td style="text-align: center;">
                            @if($u->is_active)
                                <span class="badge-status status-active">AKTIF</span>
                            @else
                                <span class="badge-status status-inactive">NONAKTIF</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($u->id !== auth()->user()->id)
                                <a href="/users/toggle/{{ $u->id }}" class="btn-toggle {{ $u->is_active ? 'toggle-off' : 'toggle-on' }}">
                                    @if($u->is_active)
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        Matikan Akun
                                    @else
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                        Aktifkan Akun
                                    @endif
                                </a>
                            @else
                                <span style="font-size: 13px; font-weight: 600; color: #94a3b8; background: #f1f5f9; padding: 6px 12px; border-radius: 8px;">
                                    Akun Anda
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                    @if(count($users) == 0)
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 48px; color: #94a3b8;">
                            Data pengguna tidak ditemukan.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection