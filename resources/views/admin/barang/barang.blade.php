@extends('layouts.master')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Barang</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar Barang</h6>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0 mr-2" id="printBarcode">
                <i class="fas fa-solid fa-file-pdf fa-sm text-white-50"></i> Cetak Barcode
            </button>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0 mr-2" data-toggle="modal" data-target="#modalImport">
                <i class="fas fa-solid fa-file-excel fa-sm text-white-50"></i> Import 
            </button>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mr-2 mt-md-0" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-solid fa-clock fa-sm text-white-50"></i> Tambah
            </button>
        </div>
        
        <!-- Modal Import -->
        <div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.import.barang') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <!-- barang -->
                            <div class="form-group col-md-12">
                                <label for="file">Upload File <span class="text-danger">*</span></label>
                                <input 
                                    type="file" 
                                    name="file" 
                                    value="{{ old('file') }}" 
                                    class="form-control" 
                                    id="file">
                                @error('file')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.store_barang') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <!-- barang -->
                            <div class="form-group col-md-12">
                                <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    name="nama_barang" 
                                    value="{{ old('nama_barang') }}" 
                                    class="form-control" 
                                    id="nama_barang">
                                @error('nama_barang')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- jenis barang -->
                            <div class="form-group col-md-12">
                                <label for="paket">Jenis Barang <span class="text-danger">*</span></label>
                                <select class="form-control" name="jb_id" id="paket">
                                    <option value="" selected>-- Pilih Jenis Barang --</option>
                                    @foreach ($jb as $item)
                                        <option 
                                            value="{{ $item->id_jb }}" 
                                            {{ old('jb_id') == $item->id_jb ? 'selected' : '' }}>
                                            {{ $item->nama_jenis }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jb_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- merk -->
                            <div class="form-group col-md-12">
                                <label for="merk">Merk <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    name="merk" 
                                    value="{{ old('merk') }}" 
                                    class="form-control" 
                                    id="merk">
                                @error('merk')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- stok -->
                            <div class="form-group col-md-12">
                                <label for="stok">stok <span class="text-danger">*</span></label>
                                <input 
                                    type="number" 
                                    min="1"
                                    name="stok" 
                                    value="{{ old('stok') }}" 
                                    class="form-control" 
                                    id="stok">
                                @error('stok')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- harga Beli -->
                            <div class="form-group col-md-12">
                                <label for="harga_beli">Harga Beli <span class="text-danger">*</span></label>
                                <input 
                                    type="number" 
                                    min="1"
                                    name="harga_beli" 
                                    value="{{ old('harga_beli') }}" 
                                    class="form-control" 
                                    id="harga_beli">
                                @error('harga_beli')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- harga jual -->
                            <div class="form-group col-md-12">
                                <label for="harga_jual">Harga Jual <span class="text-danger">*</span></label>
                                <input 
                                    type="number" 
                                    min="1"
                                    name="harga_jual" 
                                    value="{{ old('harga_jual') }}" 
                                    class="form-control" 
                                    id="harga_jual">
                                @error('harga_jual')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" class="form-control" placeholder="Opsional" id="">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="barang" class="table table-bordered stripe row-border order-column nowrap" style="width:100%" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th></th>
                            {{-- <td></td> --}}
                            <th>No</th>
                            {{-- <th>Barcode</th> --}}
                            <th>Nama Jenis</th>
                            <th>Nama Barang</th>
                            <th>Merk</th>
                            <th>Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $item)
                            <tr class="text-center">
                                {{-- <td></td> --}}
                                <td><input type="checkbox" class="barang-checkbox" value="{{ $item->id_barang }}"></td>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>
                                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->id_barang, 'C39') }}" alt="Barcode">
                                </td> --}}

                                <td>{{ $item->jenis_barang->nama_jenis }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->merk }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>{{ 'Rp ' . number_format($item->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ 'Rp ' . number_format($item->harga_beli, 0, ',', '.') }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_barang }}" title="Update">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </a>
                                        <form action="{{ route('admin.delete_barang',$item->id_barang) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-circle btn-sm delete-btn mr-2" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            
                            {{-- SweetAlert Delete --}}
                            <script>
                                // Pilih semua tombol dengan kelas delete-btn
                                document.querySelectorAll('.delete-btn').forEach(button => {
                                    button.addEventListener('click', function (e) {
                                        e.preventDefault(); // Mencegah pengiriman form langsung
                            
                                        const form = this.closest('form'); // Ambil form terdekat dari tombol yang diklik
                            
                                        Swal.fire({
                                            title: 'Apakah data ini akan dihapus?',
                                            text: "Data yang dihapus tidak dapat dikembalikan!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Ya, hapus!',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                form.submit(); // Kirim form jika pengguna mengonfirmasi
                                            }
                                        });
                                    });
                                });
                            </script>

                            <!-- Modal Edit -->
                            {{-- @include('super-admin.pengguna.kelola-jamaah.modal-update-jamaah', ['item' => $item->agen]) --}}
                            <div class="modal fade" id="modalEdit{{ $item->id_barang }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.update_barang',$item->id_barang) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <!-- barang -->
                                                <div class="form-group col-md-12">
                                                    <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                                                    <input 
                                                        type="text" 
                                                        name="nama_barang" 
                                                        value="{{ old('nama_barang',$item->nama_barang) }}" 
                                                        class="form-control" 
                                                        id="nama_barang">
                                                    @error('nama_barang')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <!-- jenis barang -->
                                                <div class="form-group col-md-12">
                                                    <label for="paket">Jenis Barang <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="jb_id" id="paket">
                                                        <option value="">-- Pilih Jenis Barang --</option>
                                                        @foreach ($jb as $jbs)
                                                            <option 
                                                                value="{{ $jbs->id_jb }}" 
                                                                {{ old('jb_id',$item->jb_id) == $jbs->id_jb ? 'selected' : '' }}>
                                                                {{ $jbs->nama_jenis }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('jb_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <!-- merk -->
                                                <div class="form-group col-md-12">
                                                    <label for="merk">Merk <span class="text-danger">*</span></label>
                                                    <input 
                                                        type="text" 
                                                        name="merk" 
                                                        value="{{ old('merk',$item->merk) }}" 
                                                        class="form-control" 
                                                        id="merk">
                                                    @error('merk')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <!-- stok -->
                                                <div class="form-group col-md-12">
                                                    <label for="stok">stok <span class="text-danger">*</span></label>
                                                    <input 
                                                        type="number" 
                                                        min="1"
                                                        name="stok" 
                                                        value="{{ old('stok',$item->stok) }}" 
                                                        class="form-control" 
                                                        id="stok">
                                                    @error('stok')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <!-- harga Beli -->
                                                <div class="form-group col-md-12">
                                                    <label for="harga_beli">Harga Beli <span class="text-danger">*</span></label>
                                                    <input 
                                                        type="number" 
                                                        min="1"
                                                        name="harga_beli" 
                                                        value="{{ old('harga_beli',$item->harga_beli) }}" 
                                                        class="form-control" 
                                                        id="harga_beli">
                                                    @error('harga_beli')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <!-- harga jual -->
                                                <div class="form-group col-md-12">
                                                    <label for="harga_jual">Harga Jual <span class="text-danger">*</span></label>
                                                    <input 
                                                        type="number" 
                                                        min="1"
                                                        name="harga_jual" 
                                                        value="{{ old('harga_jual',$item->harga_jual) }}" 
                                                        class="form-control" 
                                                        id="harga_jual">
                                                    @error('harga_jual')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="keterangan">Keterangan</label>
                                                    <textarea name="keterangan" class="form-control" placeholder="Opsional" id="">{{ old('keterangan',$item->keterangan) }}</textarea>
                                                    @error('keterangan')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- <script>
        // Pastikan checkbox berfungsi setelah tabel dirender ulang oleh DataTables
        $('#barang tbody').on('change', '.barang-checkbox', function() {
            let $row = $(this).closest('tr');
            if (this.checked) {
                $row.addClass('selected'); // Tandai baris yang dipilih
            } else {
                $row.removeClass('selected'); // Hapus tanda jika tidak dipilih
            }
        });
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var table = new DataTable('#barang', {
                ordering: true, // Menonaktifkan fitur pengurutan
                columnDefs: [{
                    orderable: false,
                    targets: 0 // Menonaktifkan pengurutan pada kolom pertama (checkbox)
                }],
                fixedColumns: {
                    left: 3 // Mengunci 3 kolom pertama agar tetap terlihat saat di-scroll
                },
                order: [
                    [1, 'asc']
                ], // Urutan berdasarkan kolom kedua (No)
                paging: false, // Mengaktifkan pagination
                scrollCollapse: true,
                scrollX: true, // Mengaktifkan horizontal scrolling
                scrollY: 500, // Mengatur tinggi tabel
                select: {
                    style: 'multi', // Memungkinkan pemilihan beberapa baris
                    selector: 'td:first-child input[type="checkbox"]' // Target checkbox
                }
            });

            // Event listener untuk checkbox di dalam tabel
            document.querySelector("#barang tbody").addEventListener("change", function(event) {
                if (event.target.classList.contains("barang-checkbox")) {
                    let row = event.target.closest("tr");
                    if (event.target.checked) {
                        row.classList.add("selected"); // Tandai baris yang dipilih
                    } else {
                        row.classList.remove("selected"); // Hapus tanda jika tidak dipilih
                    }
                }
            });

            // Event listener untuk tombol print barcode
            document.querySelector("#printBarcode").addEventListener("click", function() {
                let selectedBarang = [];

                document.querySelectorAll('.barang-checkbox:checked').forEach(function(checkbox) {
                    selectedBarang.push(checkbox.value);
                });

                if (selectedBarang.length === 0) {
                    alert('Pilih setidaknya satu barang untuk dicetak.');
                    return;
                }

                // Redirect ke halaman cetak barcode dengan parameter barang yang dipilih
                window.open('/admin/print-barcode?barang=' + selectedBarang.join(','), '_blank');
            });
        });
    </script>


    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection