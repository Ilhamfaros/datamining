<script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
    <!-- Tambahkan skrip untuk tombol ekspor -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function () {
            // Inisialisasi DataTable dengan plugin Buttons
            var table = $('#myTable').DataTable({
                scrollX: true,
                scrollY: '800px',
                scrollCollapse: true,
                responsive: true,
                dom: 'Bfrtip', // Tambahkan dom: 'Bfrtip' untuk menampilkan tombol ekspor
                buttons: [
                    'excel', 'csv', 'pdf', 'print', // Tambahkan tombol ekspor yang diinginka
                ]
            });

            // Mengaktifkan tombol ekspor saat tabel sudah selesai diinisialisasi
            table.buttons().container().appendTo('.export-buttons');

            // Tambahkan kode untuk tombol ekspor ke Excel
            $('#exportExcel').on('click', function () {
                table.button('.buttons-excel').trigger();
            });

            // Tambahkan kode untuk tombol ekspor ke CSV
            $('#exportCSV').on('click', function () {
                table.button('.buttons-csv').trigger();
            });

            // Tambahkan kode untuk tombol ekspor ke PDF
            $('#exportPDF').on('click', function () {
                table.button('.buttons-pdf').trigger();
            });
            $('#').DataTable({
                scrollX: true,
                scrollY: '300px',
                scrollCollapse: true,
                responsive: true,
            });
        });
    </script>