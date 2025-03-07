<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Barcode dengan Kamera</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <style>
        #scanner-container {
            width: 100%;
            max-width: 500px;
            height: 300px;
            margin: auto;
            border: 2px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }
        #barang-info {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h2 style="text-align: center;">Scan Barcode dengan Kamera</h2>
    
    <div id="scanner-container"></div>
    
    <div id="barang-info">
        <h3>Hasil Scan:</h3>
        <p id="barcode-result">Belum ada scan</p>
        <div id="barang-data"></div>
    </div>

    <script>
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector("#scanner-container"),
                constraints: {
                    width: 480,
                    height: 320,
                    facingMode: "environment" // Gunakan "user" jika ingin pakai kamera depan
                }
            },
            decoder: {
                readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader"]
            }
        }, function(err) {
            if (err) {
                console.error(err);
                return;
            }
            Quagga.start();
        });

        Quagga.onDetected(function(result) {
            let barcode = result.codeResult.code;
            document.getElementById("barcode-result").textContent = barcode;

            fetch("{{ route('admin.scan') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ barcode: barcode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("barang-data").innerHTML = `
                        <h4>Nama: ${data.data.nama_barang}</h4>
                        <p>Harga: Rp${data.data.harga}</p>
                        <p>Stok: ${data.data.stok}</p>
                    `;
                } else {
                    document.getElementById("barang-data").innerHTML = `<p style="color:red">${data.message}</p>`;
                }
            });
        });
    </script>

</body>
</html>
