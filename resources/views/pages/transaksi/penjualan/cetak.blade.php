<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Faktur Penjualan #{{ $transaksi->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .invoice-title {
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f8f8f8;
        }
        .total-row td {
            font-weight: bold;
            border-top: 2px solid #ddd;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
        @media print {
            body {
                padding: 0;
            }
            .invoice-box {
                border: none;
                box-shadow: none;
                max-width: 100%;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="invoice-header">
            <div class="logo">
                TOKO BUDI
            </div>
            <div class="invoice-title">
                <h2>Faktur Penjualan</h2>
                <p>Nomor: INV-{{ $transaksi->id }}/{{ date('Y', strtotime($transaksi->tgl_transaksi)) }}</p>
                <p>Tanggal: {{ date('d/m/Y', strtotime($transaksi->tgl_transaksi)) }}</p>
            </div>
        </div>
        
        <table>
            <tr>
                <td width="20%"><strong>Pelanggan</strong></td>
                <td width="30%">: {{ $transaksi->pelanggan->nama }}</td>
                <td width="20%"><strong>Keterangan</strong></td>
                <td width="30%">: {{ $transaksi->keterangan }}</td>
            </tr>
        </table>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 25%">Nama Barang</th>
                    <th style="width: 10%">Jenis</th>
                    <th style="width: 10%">Jumlah</th>
                    <th style="width: 10%">Satuan</th>
                    <th style="width: 15%">Harga Satuan</th>
                    <th style="width: 10%">Diskon</th>
                    <th class="text-right" style="width: 15%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->barang->nama }}</td>
                    <td>{{ $detail->barangDetail->jenis->jenis ?? '-' }}</td>
                    <td>{{ $detail->jml_barang }}</td>
                    <td>{{ $detail->barangDetail->satuan->satuan ?? '-' }}</td>
                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }},-</td>
                    <td>
                        @if($detail->diskon)
                            <strong>{{ $detail->diskon->nama }}: {{ $detail->diskon->persen }}%</strong>
                        @else
                            0%
                        @endif
                    </td>
                    <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }},-</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="7" class="text-right">Total Bayar:</td>
                    <td class="text-right">Rp {{ number_format($transaksi->total, 0, ',', '.') }},-</td>
                </tr>
            </tbody>
        </table>
        
        <div style="display: flex; justify-content: space-between; margin-top: 50px;">
            <div style="width: 45%; text-align: center;">
                <p>Hormat Kami,</p>
                <br><br><br>
                <p>_____________________</p>
                <p>Toko Budi</p>
            </div>
            <div style="width: 45%; text-align: center;">
                <p>Pelanggan,</p>
                <br><br><br>
                <p>_____________________</p>
                <p>{{ $transaksi->pelanggan->nama }}</p>
            </div>
        </div>
        
        <div class="footer">
            <p>Terima kasih atas kepercayaan Anda berbelanja di Toko Budi.</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan.</p>
        </div>
        
        <div class="no-print" style="margin-top: 20px; text-align: center;">
            <button onclick="window.print()" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
                Cetak Faktur
            </button>
            <button onclick="window.close()" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; cursor: pointer; margin-left: 10px;">
                Tutup
            </button>
        </div>
    </div>
</body>
</html> 