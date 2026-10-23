<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Distribusi MBG</title>
    <style>
        body { font-family: 'Times New Roman', serif; color: #000; font-size: 12px; margin: 0; padding: 20px; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
        .kop-surat h1 { margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; }
        .kop-surat p { margin: 5px 0 0; font-size: 13px; }
        .laporan-title { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        th { background: #f2f2f2; text-align: center; }
        .ttd-box { width: 100%; margin-top: 40px; }
        .ttd-box table { border: none; width: 100%; }
        .ttd-box th, .ttd-box td { border: none; text-align: center; }
        @media print {
            @page { margin: 1cm; size: landscape; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="kop-surat">
        <h1>SISTEM INVENTORI DAN DISTRIBUSI MAKANAN BERGIZI GRATIS</h1>
        <p>Jl. Pahlawan Nasional No. 45, Indonesia | Telp: 0812-XXXX-XXXX</p>
        <p>Dokumen Resmi Riwayat Mutasi Operasional</p>
    </div>

    <div class="laporan-title">
        Laporan Histori Transaksi Barang<br>
        <span style="font-size: 12px; font-weight: normal; text-transform: none;">
            Dicetak pada: {{ now()->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB | Oleh: {{ auth()->user()->name }}
        </span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Waktu (WIB)</th>
                <th>Tipe</th>
                <th>Nama Barang</th>
                <th>Tujuan SPPG</th>
                <th>Input Mutasi</th>
                <th>Stok Sblm ➔ Ssdh (Base Unit)</th>
                <th>Operator</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $trx)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->date_recorded)->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                <td style="text-align: center;">{{ $trx->type }}</td>
                <td>{{ $trx->item->item_name ?? '-' }}</td>
                <td>{{ $trx->client ? $trx->client->nama_sppg : '-' }}</td>
                <td style="text-align: center;"><strong>{{ (float)$trx->qty }}</strong> {{ $trx->satuan_transaksi }}</td>
                <td style="text-align: center;">{{ (float)$trx->stock_sebelum }} ➔ {{ (float)$trx->stock_sesudah }} <span style="font-size: 10px;">{{ $trx->item->satuan_dasar ?? '' }}</span></td>
                <td>{{ $trx->user->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd-box">
        <table>
            <tr>
                <td style="width: 70%;"></td>
                <td style="width: 30%;">
                    Mengetahui,<br>
                    <strong>Manajer Operasional MBG</strong>
                    <br><br><br><br><br>
                    (.............................................)
                </td>
            </tr>
        </table>
    </div>

</body>
</html>