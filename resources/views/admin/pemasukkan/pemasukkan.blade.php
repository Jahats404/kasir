@extends('layouts.master')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar pemasukkan</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Daftar pemasukkan</h6>
            <button type="button" class="btn btn-sm btn-primary shadow-sm mt-2 mt-md-0" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-solid fa-clock fa-sm text-white-50"></i> Tambah pemasukkan
            </button>
        </div>
        

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah pemasukkan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.store_pemasukkan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <!-- Tanggal Pengeluaran -->
                            <div class="form-group col-md-12">
                                <label for="tanggal_pemasukkan">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                                <input 
                                    type="date" 
                                    name="tanggal_pemasukkan" 
                                    value="{{ old('tanggal_pemasukkan') }}" 
                                    class="form-control" 
                                    id="tanggal_pemasukkan">
                                @error('tanggal_pemasukkan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- jumlah -->
                            <div class="form-group col-md-12">
                                <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                                <input 
                                    type="number" 
                                    min="1"
                                    name="jumlah" 
                                    value="{{ old('jumlah') }}" 
                                    class="form-control" 
                                    id="jumlah">
                                @error('jumlah')
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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemasukkan as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>{{ 'Rp ' . number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-warning btn-circle btn-sm mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_pemasukkan }}" title="Update">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </a>
                                        <form action="{{ route('admin.delete_pemasukkan',$item->id_pemasukkan) }}" method="POST" class="delete-form">
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
                            <div class="modal fade" id="modalEdit{{ $item->id_pemasukkan }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.update_pemasukkan',$item->id_pemasukkan) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <!-- Tanggal Pengeluaran -->
                                                <div class="form-group col-md-12">
                                                    <label for="tanggal_pemasukkan">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                                                    <input 
                                                        type="date" 
                                                        name="tanggal_pemasukkan" 
                                                        value="{{ old('tanggal_pemasukkan',$item->tanggal_pemasukkan) }}" 
                                                        class="form-control" 
                                                        id="tanggal_pemasukkan">
                                                    @error('tanggal_pemasukkan')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <!-- jumlah -->
                                                <div class="form-group col-md-12">
                                                    <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                                                    <input 
                                                        type="number" 
                                                        min="1"
                                                        name="jumlah" 
                                                        value="{{ old('jumlah',$item->jumlah) }}" 
                                                        class="form-control" 
                                                        id="jumlah">
                                                    @error('jumlah')
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


    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection