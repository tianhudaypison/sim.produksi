<!-- Required datatable js -->
<script src="{plugins_path}datatables/jquery.dataTables.min.js"></script>
<script src="{plugins_path}datatables/dataTables.bootstrap4.min.js"></script>

<!-- Buttons examples -->
<script src="{plugins_path}datatables/dataTables.buttons.min.js"></script>
<script src="{plugins_path}datatables/buttons.bootstrap4.min.js"></script>
<script src="{plugins_path}datatables/jszip.min.js"></script>
<script src="{plugins_path}datatables/pdfmake.min.js"></script>
<script src="{plugins_path}datatables/vfs_fonts.js"></script>
<script src="{plugins_path}datatables/buttons.html5.min.js"></script>
<script src="{plugins_path}datatables/buttons.print.min.js"></script>

<!-- Key Tables -->
<script src="{plugins_path}datatables/dataTables.keyTable.min.js"></script>

<!-- Responsive examples -->
<script src="{plugins_path}datatables/dataTables.responsive.min.js"></script>
<script src="{plugins_path}datatables/responsive.bootstrap4.min.js"></script>

<!-- Selection table -->
<script src="{plugins_path}datatables/dataTables.select.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        // Default Datatable
        $('#datatable').DataTable();

        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf']
        });

        // Key Tables

        $('#key-table').DataTable({
            keys: true
        });

        // Responsive Datatable
        $('#responsive-datatable').DataTable();

        // Multi Selection Datatable
        $('#selection-datatable').DataTable({
            select: {
                style: 'multi'
            }
        });

        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    } );

</script>
