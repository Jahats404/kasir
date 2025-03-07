$('#dataTable').DataTable({
    ordering: false,
});
$('#dataTableTransaksi').DataTable({
    ordering: true,
    paging: false,
});


// $(document).ready(function() {
//     var table = $('#barang').DataTable({
//         ordering: false, // Menonaktifkan fitur pengurutan
//         columnDefs: [{
//             orderable: false,
//             // render: DataTable.render.select(),
//             targets: 0 // Menonaktifkan pengurutan pada kolom pertama (checkbox)
//         }],
//         fixedColumns: {
//             left: 3 // Mengunci 3 kolom pertama agar tetap terlihat saat di-scroll
//         },
//         order: [
//             [1, 'asc']
//         ], // Urutan berdasarkan kolom kedua (No)
//         paging: true, // Mengaktifkan pagination
//         scrollCollapse: true,
//         scrollX: true, // Mengaktifkan horizontal scrolling
//         scrollY: 300, // Mengatur tinggi tabel
//         select: {
//             style: 'multi', // Memungkinkan pemilihan beberapa baris
//             selector: 'td:first-child input[type="checkbox"]' // Target checkbox
//         }
//     });

//     // Pastikan checkbox berfungsi setelah tabel dirender ulang oleh DataTables
//     $('#barang tbody').on('change', '.barang-checkbox', function() {
//         let $row = $(this).closest('tr');
//         if (this.checked) {
//             $row.addClass('selected'); // Tandai baris yang dipilih
//         } else {
//             $row.removeClass('selected'); // Hapus tanda jika tidak dipilih
//         }
//     });

//     // Event klik tombol print barcode
//     $('#printBarcode').on('click', function() {
//         let selectedBarang = [];

//         // Ambil nilai checkbox yang dicentang
//         $('.barang-checkbox:checked').each(function() {
//             selectedBarang.push($(this).val());
//         });

//         if (selectedBarang.length === 0) {
//             alert('Pilih setidaknya satu barang untuk dicetak.');
//             return;
//         }

//         // Redirect ke halaman cetak barcode dengan parameter barang yang dipilih
//         window.open('/admin/print-barcode?barang=' + selectedBarang.join(','), '_blank');
//     });
// });


$('#dataTableBaran').DataTable({
    language: {
        emptyTable: "",
    },
    columnDefs: [{
        targets: 0,
        orderable: false,
        searchable: false,
        render: function(data, type, row, meta) {
            // Reset nomor berdasarkan halaman
            var pageInfo = $('#example').DataTable().page.info();
            return pageInfo.start + meta.row + 1;
        },
    }, ],
});

$('#aarang').DataTable({
    columnDefs: [{
        orderable: false,
        render: DataTable.render.select(),
        targets: 0
    }],
    fixedColumns: {
        start: 2
    },
    order: [
        [1, 'asc']
    ],
    paging: false,
    scrollCollapse: true,
    scrollX: true,
    scrollY: 300,
    select: {
        style: 'os',
        selector: 'td:first-child'
    }
});