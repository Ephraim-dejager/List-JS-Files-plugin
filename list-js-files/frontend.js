jQuery(document).ready(function($) {
    $('#js-files-table').DataTable({
        "columnDefs": [
            { "type": "num", "targets": [0, 6] } // Assuming the 1st and 7th columns are numbers
        ]
    });
});
