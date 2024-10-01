$(document).ready(function () {
    $('.datatable').each(function () {
        // Store reference to the current table
        let table = $(this);
        
        
        // Initialize DataTable for each table separately
        table.DataTable({
            responsive: true,
            pageLength: 10,
            columns: table.data('filter'),
            ajax: {
                url: table.data('get'), // Get the 'data-get' attribute specific to this table
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            },
            processing: true,
            serverSide: true,
            lengthChange: false,
        });
    }), $("#datatable-buttons").DataTable({

        buttons: ["copy", "excel", "pdf", "colvis"]
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $(".dataTables_length select").addClass("form-select form-select-sm")
});
