<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOTA TRANSAKSI</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .header { text-align: left; margin-bottom: 20px; }
        .footer { margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="text-align: center;">NOTA TRANSAKSI</h2>
        <p>ID Transaksi: {{ $transaksi->id_transaksi }}</p>
        <p>Tanggal: {{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y') ?? '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>QTY</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($transaksi->detail_transaksi as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->barang->nama_barang ?? 'Barang Tidak Ditemukan' }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                </tr>
                @php $total += $detail->sub_total; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
            </tr>
            @if ($transaksi->diskon > 0)
                <tr>
                    <th colspan="4">Diskon</th>
                    <th>{{ $transaksi->diskon }}%</th>
                </tr>
                <tr>
                    <th colspan="4">Total Setelah Diskon</th>
                    <th>Rp {{ number_format($total - ($total * $transaksi->diskon / 100), 0, ',', '.') }}</th>
                </tr>
            @endif
        </tfoot>
    </table>

    <div class="footer">
        <p>Terima kasih telah berbelanja di toko kami</p>
    </div>
</body>
</html>
