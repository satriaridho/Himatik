<?php
include '../config.php';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch all sales data along with product names
    $stmt = $pdo->prepare("
        SELECT s.sales_id, p.product_name, s.sale_date, s.sales
        FROM sales_data s
        INNER JOIN products p ON s.product_id = p.product_id
        WHERE s.sale_date IS NOT NULL AND s.sales IS NOT NULL
        ORDER BY s.sale_date DESC
    ");
    $stmt->execute();
    $salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<html>
<head>
    <title>Data Penjualan</title>
    <!-- Include necessary CSS and JS files -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
</head>

<body>
<div class="container mt-5">
    <h2>Data Penjualan</h2>
    <h4>(Sales Records)</h4>
    <div class="data-tables datatable-dark">
        <table id="salesData" class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Tanggal Penjualan</th>
                    <th>Jumlah Terjual</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if (!empty($salesData)):
                    foreach ($salesData as $sale):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($i++); ?></td>
                    <td><?php echo htmlspecialchars($sale['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($sale['sale_date']); ?></td>
                    <td><?php echo htmlspecialchars($sale['sales']); ?></td>
                </tr>
                <?php
                    endforeach;
                else:
                ?>
                <tr>
                    <td colspan="4">Tidak ada data penjualan</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <button class="btn btn-primary mt-3"><a href="index.php?page=notif" style="color: #fff; text-decoration: none;">Kembali</a></button>
</div>

<!-- Include necessary JS files -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<!-- JSZip -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!-- PDFMake -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<!-- VFS Fonts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<!-- Buttons HTML5 -->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<!-- Buttons Print -->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#salesData').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
</body>
</html>