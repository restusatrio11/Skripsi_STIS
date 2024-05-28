// $(document).ready(function () {
//     $("#dtBasicExample").DataTable({
//         pagingType: "simple", // "simple" option for 'Previous' and 'Next' buttons only
//     });
//     $(".dataTables_length").addClass("bs-select");
// });

// new DataTable('#dtBasicExample');

// $(document).ready(function() {
//     var table = $('#dtBasicExample').DataTable( {
//         responsive: true,
//         pageLength: 10
//     } );

//     new $.fn.dataTable.FixedHeader( table );
// } );

$(document).ready(function() {
    // Inisialisasi DataTables dengan state saving
    var table = $('#dtBasicExample').DataTable({
        stateSave: true, // Aktifkan state saving
        fixedColumns: {
            leftColumns: 3
        },
        paging: true,
        scrollCollapse: true,
        scrollX: true,
        scrollY: 400,
        order: [[2, 'asc']],
        rowGroup: {
            dataSrc: 2
        }
    });

    // Fungsi untuk menjaga posisi pagination setelah menyimpan penilaian pegawai
    function restorePaginationState() {
        var savedState = localStorage.getItem('DataTables_dtBasicExample');
        if (savedState) {
            table.state.clear(); // Hapus state yang ada saat ini
            table.state.add(JSON.parse(savedState)); // Tambahkan state yang dipulihkan
            table.draw(); // Muat ulang DataTables dengan state yang dipulihkan
        }
    }

    // Panggil fungsi untuk menjaga posisi pagination saat dokumen siap
    restorePaginationState();
});



new DataTable('#dtBasicExampleVisual', {
    fixedColumns: {
        leftColumns:3
    },paging: true,
    scrollCollapse: true,
    scrollX: true,
    scrollY: 400,
    rowGroup: {
        dataSrc: 1
    },
    responsive: true // Mengaktifkan responsivitas tabel
});

$('.dtrg-group th').attr('colspan', 2);

// Menggunakan event delegation untuk menangani klik tombol paginate
$(document).on('click', '.paginate_button', function() {
    // Memperbarui atribut colspan untuk semua elemen th dengan kelas .dtrg-group
    $('.dtrg-group th').attr('colspan', 2);
});

// Memperbarui atribut colspan saat halaman pertama dimuat
$(document).ready(function() {
    $('.dtrg-group th').attr('colspan', 2);
});

$(document).ready(function() {
    // Inisialisasi DataTables dengan state saving
    var table = new DataTable('#dtBasicExampleUser', {
        stateSave: true, // Aktifkan state saving
        fixedColumns: {
            leftColumns:2
        },paging: true,
        scrollCollapse: true,
        scrollX: true,
        scrollY: 400,
        order: [[3, 'asc']],
        rowGroup: {
            dataSrc: 3
        }
    });

    // Fungsi untuk menjaga posisi pagination setelah menyimpan penilaian pegawai
    function restorePaginationState() {
        var savedState = localStorage.getItem('DataTables_dtBasicExampleUser');
        if (savedState) {
            table.state.clear(); // Hapus state yang ada saat ini
            table.state.add(JSON.parse(savedState)); // Tambahkan state yang dipulihkan
            table.draw(); // Muat ulang DataTables dengan state yang dipulihkan
        }
    }

    // Panggil fungsi untuk menjaga posisi pagination saat dokumen siap
    restorePaginationState();
});

$('.dtrg-group th').attr('colspan', 2);

// Menggunakan event delegation untuk menangani klik tombol paginate
$(document).on('click', '.paginate_button', function() {
    // Memperbarui atribut colspan untuk semua elemen th dengan kelas .dtrg-group
    $('.dtrg-group th').attr('colspan', 2);
});

// Memperbarui atribut colspan saat halaman pertama dimuat
$(document).ready(function() {
    $('.dtrg-group th').attr('colspan', 2);
});

new DataTable('#example', {
    fixedHeader: true,
    order: [[1, 'asc']],
    scrollX: true,
    scrollCollapse: true
});

new DataTable('#dtBasicExamplee', {
    fixedHeader: true,
    order: [[1, 'asc']],
    scrollX: true,
    scrollCollapse: true
});

new DataTable('#dtBasicnilaiakhir', {
    fixedHeader: true,
    order: [[1, 'asc']]
});

new DataTable('#examplekpbs', {
    fixedHeader: true,
    order: [[1, 'asc']]
});


new DataTable('#examplepegawai', {
    fixedHeader: true,
    order: [[1, 'asc']]

});

new DataTable('#dtBasicExamplejp', {
    fixedHeader: true
});

new DataTable('#examplejt', {
    fixedHeader: true,
    // scrollX: true,
    // scrollCollapse: true
});

new DataTable('#examplejtim', {
    fixedHeader: true
});

new DataTable('#exampletimereport', {
    fixedHeader: true
});

new DataTable('#tableinsertpegawaitarget', {
    fixedHeader: true,
    paging: true
});
