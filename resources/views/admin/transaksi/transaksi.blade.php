@extends('layouts.master')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
    </div>

    <form action="{{ route('admin.store_transaksi') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="hidden-inputs"></div>
        <div class="row">
            <!-- Daftar Barang -->
            <div class="col-xl-8 col-md-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-wrap align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Barang</h6>
                        <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0 mr-2" data-toggle="modal" data-target="#modalTambah">
                            <i class="fas fa-solid fa-clock fa-sm text-white-50"></i> Tambah Barang
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary shadow-sm mt-2 mt-md-0" id="btn-scan-barcode">Scan Barcode</button>
                        <div id="scanner-container" style="display: none;">
                            <canvas id="barcode-scanner" style="width: 100%; height: 300px;"></canvas>
                        </div>
                    </div>

                    <!-- Modal Tambah -->
                    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTableTransaksi" width="100%" cellspacing="0">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>No</th>
                                                    <th>Nama Jenis</th>
                                                    <th>Nama Barang</th>
                                                    <th>Merk</th>
                                                    <th>Stok</th>
                                                    <th>Harga Jual</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($barang as $item)
                                                    <tr class="text-center">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->jenis_barang->nama_jenis }}</td>
                                                        <td>{{ $item->nama_barang }}</td>
                                                        <td>{{ $item->merk }}</td>
                                                        <td>{{ $item->stok }}</td>
                                                        <td>{{ 'Rp ' . number_format($item->harga_jual, 0, ',', '.') }}</td>
                                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <button 
                                                                    type="button" 
                                                                    class="btn btn-warning btn-circle btn-sm mr-2 add-to-cart" 
                                                                    title="Tambah"
                                                                    data-id="{{ $item->id_barang }}"
                                                                    data-nama="{{ $item->nama_barang }}"
                                                                    data-jenis="{{ $item->jenis_barang->nama_jenis }}"
                                                                    data-merk="{{ $item->merk }}"
                                                                    data-harga="{{ $item->harga_jual }}"
                                                                    data-stok="{{ $item->stok }}"
                                                                >
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTableBarang" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Jenis</th>
                                        <th>Nama Barang</th>
                                        <th>Merk</th>
                                        <th>Harga Jual</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data barang akan ditambahkan di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <!-- Total -->
                        <div class="form-group">
                            <label for="total">Total <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                readonly
                                name="total" 
                                value="{{ old('total') }}" 
                                class="form-control" 
                                id="total">
                        </div>

                        <!-- Diskon -->
                        <div class="form-group">
                            <label for="diskon">Diskon</label>
                            <input 
                                type="number" 
                                name="diskon" 
                                placeholder="Opsional"
                                value="{{ old('diskon') }}" 
                                class="form-control" 
                                id="diskon">
                        </div>

                        <!-- Bayar -->
                        <div class="form-group">
                            <label for="bayar">Bayar</label>
                            <input 
                                type="text" 
                                name="bayar" 
                                readonly
                                value="{{ old('bayar') }}" 
                                class="form-control" 
                                id="bayar">
                        </div>

                        <!-- Diterima -->
                        <div class="form-group">
                            <label for="diterima">Diterima <span class="text-danger">*</span></label>
                            <input 
                                type="number" 
                                name="diterima" 
                                value="{{ old('diterima') }}" 
                                class="form-control" 
                                required
                                id="diterima">
                        </div>

                        <!-- Kembalian -->
                        <div class="form-group">
                            <label for="kembalian">Kembalian <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                readonly
                                name="kembalian" 
                                value="{{ old('kembalian') }}" 
                                class="form-control" 
                                id="kembalian">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Simpan Transaksi</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')

    <script>
        $(document).ready(function () {
            let debounceTimeout;

            // Fungsi untuk memformat angka ke format mata uang
            function formatCurrency(value) {
                return 'Rp ' + parseInt(value).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
            }

            // Tambah barang ke tabel utama
            $(document).on('click', '.add-to-cart', function () {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const jenis = $(this).data('jenis');
                const merk = $(this).data('merk');
                const harga = $(this).data('harga');
                const stok = $(this).data('stok');

                // Cek apakah barang sudah ada di tabel
                if ($(`#row-${id}`).length) {
                    alert('Barang sudah ada di daftar!');
                    return;
                }

                // Tambahkan baris baru ke tabel
                const newRow = `
                    <tr id="row-${id}" class="text-center">
                        <td>${$('#dataTableBarang tbody tr').length + 1}</td>
                        <td>${jenis}</td>
                        <td>${nama}</td>
                        <td>${merk}</td>
                        <td class="harga-barang">${formatCurrency(harga)}</td>
                        <td>
                            <input 
                                type="number" 
                                class="form-control jumlah-barang" 
                                min="1" 
                                max="${stok}" 
                                value="1" 
                                data-harga="${harga}" 
                                data-id="${id}" 
                                style="width: 80px; margin: auto;">
                        </td>
                        <td class="sub-total">${formatCurrency(harga)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row" data-id="${id}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                `;

                // Tambahkan input hidden ke form
                const hiddenInputs = `
                    <div id="hidden-${id}">
                        <input type="hidden" name="barang[${id}][id]" value="${id}">
                        <input type="hidden" name="barang[${id}][nama]" value="${nama}">
                        <input type="hidden" name="barang[${id}][jumlah]" class="hidden-jumlah" value="1">
                        <input type="hidden" name="barang[${id}][harga]" value="${harga}">
                    </div>
                `;

                $('#dataTableBarang tbody').append(newRow); // Tambahkan baris ke tabel
                $('#hidden-inputs').append(hiddenInputs);   // Tambahkan input hidden ke form
                calculateTotal(); // Hitung ulang total setelah menambah barang
                $('#modalTambah').modal('hide');
            });

            // Hapus barang dari tabel dan input hidden
            $(document).on('click', '.remove-row', function () {
                const id = $(this).data('id');
                $(`#row-${id}`).remove(); // Hapus baris dari tabel
                $(`#hidden-${id}`).remove(); // Hapus input hidden

                // Perbarui nomor urut setelah penghapusan
                $('#dataTableBarang tbody tr').each(function (index, row) {
                    $(row).find('td:first').text(index + 1);
                });

                calculateTotal(); // Hitung ulang total setelah menghapus barang
            });

            // Update input hidden saat jumlah barang diubah
            $(document).on('input', '.jumlah-barang', function () {
                const inputField = $(this);
                const id = inputField.data('id');
                const jumlah = parseInt(inputField.val(), 10);

                // Update nilai hidden jumlah
                $(`#hidden-${id} .hidden-jumlah`).val(jumlah);

                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(function () {
                    const max = parseInt(inputField.attr('max'), 10);
                    const min = parseInt(inputField.attr('min'), 10);
                    const harga = parseFloat(inputField.data('harga'));

                    if (jumlah > max) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan',
                            text: 'Jumlah tidak boleh melebihi stok!',
                        });
                        inputField.val(max);
                    } else if (jumlah < min || isNaN(jumlah)) {
                        inputField.val(min);
                    }

                    const subTotal = jumlah * harga;
                    inputField.closest('tr').find('.sub-total').text(formatCurrency(subTotal));
                    calculateTotal(); // Hitung ulang total
                }, 300);
            });

            // Hitung total harga dari semua barang
            function calculateTotal() {
                let total = 0;
                $('#dataTableBarang tbody .sub-total').each(function () {
                    const value = $(this).text().replace(/[^0-9]/g, ''); // Hapus format mata uang
                    total += parseFloat(value);
                });

                let diskon = parseFloat($('#diskon').val()) || 0;
                let totalSetelahDiskon = total - (total * (diskon / 100));

                $('#total').val(formatCurrency(total)); // Masukkan total ke input total
                $('#bayar').val(formatCurrency(totalSetelahDiskon)); // Masukkan total setelah diskon ke input bayar
            }

            // Hitung kembalian secara otomatis
            $('#diterima').on('input', function () {
                const diterima = parseFloat($(this).val());
                const bayar = parseFloat($('#bayar').val().replace(/[^0-9]/g, '')); // Hapus format mata uang
                const kembalian = diterima - bayar;

                if (!isNaN(kembalian)) {
                    $('#kembalian').val(formatCurrency(kembalian >= 0 ? kembalian : 0)); // Kembalian tidak boleh negatif
                }
            });

            // Update total saat diskon berubah
            $('#diskon').on('input', function () {
                calculateTotal(); // Recalculate total after discount change
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script>
        $(document).ready(function() {
            let scannerActive = false;
            let videoStream = null;
            let canvas = document.getElementById("barcode-scanner");
            let context = canvas.getContext("2d");
            let lastScannedCode = ""; // Untuk mencegah pemindaian berulang
    
            $('#btn-scan-barcode').click(function() {
                if (!scannerActive) {
                    $('#scanner-container').show();
                    startScanner();
                } else {
                    $('#scanner-container').hide();
                    stopScanner();
                }
                scannerActive = !scannerActive;
            });
    
            function startScanner() {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                    .then(function(stream) {
                        videoStream = stream;
                        let video = document.createElement("video");
                        video.srcObject = stream;
                        video.play();
    
                        function captureFrame() {
                            if (!scannerActive) return;
                            context.drawImage(video, 0, 0, canvas.width, canvas.height);
                            
                            Quagga.decodeSingle({
                                src: canvas.toDataURL(),
                                numOfWorkers: 0,
                                decoder: { readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader"] }
                            }, function(result) {
                                if (result && result.codeResult) {
                                    let barcode = result.codeResult.code;
                                    
                                    if (barcode !== lastScannedCode) {
                                        lastScannedCode = barcode; // Simpan barcode agar tidak terbaca berulang
                                        findProductByBarcode(barcode);
                                        
                                        setTimeout(() => {
                                            lastScannedCode = ""; // Reset agar bisa scan barang lain
                                        }, 2000); // Tunggu 2 detik sebelum bisa scan barang lain
                                    }
                                }
                                requestAnimationFrame(captureFrame);
                            });
                        }
    
                        captureFrame();
                    })
                    .catch(function(err) {
                        alert("Akses kamera ditolak: " + err.message);
                    });
            }
    
            function stopScanner() {
                if (videoStream) {
                    videoStream.getTracks().forEach(track => track.stop());
                    videoStream = null;
                }
                $('#scanner-container').hide();
                scannerActive = false;
            }
    
            function findProductByBarcode(barcode) {
                $.ajax({
                    url: "{{ route('admin.get_barang_by_barcode') }}",
                    type: "GET",
                    data: { barcode: barcode },
                    success: function(response) {
                        if (response.success) {
                            addItemToTable(response.data);
                        } else {
                            alert('Barang tidak ditemukan');
                        }
                    }
                });
            }
    
            function addItemToTable(item) {
                let newRow = `
                    <tr>
                        <td>${$('#dataTableBarang tbody tr').length + 1}</td>
                        <td>${item.nama_jenis}</td>
                        <td>${item.nama_barang}</td>
                        <td>${item.merk}</td>
                        <td>Rp ${item.harga_jual.toLocaleString()}</td>
                        <td><input type="number" class="jumlah-barang" value="1" data-harga="${item.harga_jual}"></td>
                        <td class="sub-total">Rp ${item.harga_jual.toLocaleString()}</td>
                        <td><button class="btn-remove btn btn-danger btn-sm">Hapus</button></td>
                    </tr>`;
                $('#dataTableBarang tbody').append(newRow);
                calculateTotal();
            }
    
            // Hitung total harga dari semua barang
            function calculateTotal() {
                let total = 0;
                $('#dataTableBarang tbody .sub-total').each(function () {
                    const value = $(this).text().replace(/[^0-9]/g, ''); // Hapus format mata uang
                    total += parseFloat(value);
                });
    
                let diskon = parseFloat($('#diskon').val()) || 0;
                let totalSetelahDiskon = total - (total * (diskon / 100));
    
                $('#total').val(formatCurrency(total)); // Masukkan total ke input total
                $('#bayar').val(formatCurrency(totalSetelahDiskon)); // Masukkan total setelah diskon ke input bayar
            }
    
            // Format mata uang
            function formatCurrency(value) {
                return 'Rp ' + value.toLocaleString();
            }
    
            // Hitung kembalian secara otomatis
            $('#diterima').on('input', function () {
                const diterima = parseFloat($(this).val());
                const bayar = parseFloat($('#bayar').val().replace(/[^0-9]/g, '')); // Hapus format mata uang
                const kembalian = diterima - bayar;
    
                if (!isNaN(kembalian)) {
                    $('#kembalian').val(formatCurrency(kembalian >= 0 ? kembalian : 0)); // Kembalian tidak boleh negatif
                }
            });
    
            // Update total saat diskon berubah
            $('#diskon').on('input', function () {
                calculateTotal(); // Recalculate total after discount change
            });
    
            // Event handler untuk menghapus item
            $('#dataTableBarang').on('click', '.btn-remove', function() {
                $(this).closest('tr').remove();
                calculateTotal();
            });
    
            // Update total saat jumlah barang berubah
            $('#dataTableBarang').on('input', '.jumlah-barang', function() {
                const harga = parseFloat($(this).data('harga'));
                const jumlah = parseInt($(this).val());
                const subtotal = harga * jumlah;
                $(this).closest('tr').find('.sub-total').text('Rp ' + subtotal.toLocaleString());
                calculateTotal();
            });
        });
    </script>
@endsection
