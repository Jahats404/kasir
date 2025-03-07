<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .barcode-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .barcode-container {
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background: #f9f9f9;
            display: inline-block; /* Agar container menyesuaikan ukuran barcode */
            margin-bottom: 20px;
        }
        .barcode-container p {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .barcode {
            display: block;
            margin: auto;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Barcode Produk</h2>
    
    <div class="barcode-wrapper">
        @foreach ($barangList as $barang)
            @if (!empty($barang->id_barang))
                <div class="barcode-container">
                    <p>{{ $barang->nama_barang }}</p>
                    {{-- <p>Bym 1,5kg 18x27 cm 5x20.</p> --}}
                    <div class="barcode">
                        {!! DNS1D::getBarcodeHTML($barang->id_barang, 'C39') !!}
                    </div>
                    <p>{{ 'Rp ' . number_format($barang->harga_jual, 0, ',', '.') }}</p>
                </div>
            @else
                <p style="text-align: center; color: red;">Barcode tidak tersedia untuk {{ $barang->nama_barang }}</p>
            @endif
        @endforeach
    </div>
</body>
</html>
