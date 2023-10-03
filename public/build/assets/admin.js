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

new DataTable('#dtBasicExample', {
    fixedHeader: {
        header: true
    },paging: true,
    scrollCollapse: true,
    scrollX: true,
    order: [[0, 'asc']],
    rowGroup: {
        dataSrc: 1
    }
});

new DataTable('#example', {
    fixedHeader: true
});
