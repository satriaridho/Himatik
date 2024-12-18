<?php
include '../config.php';

// Get current page and rows per page
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1; // Default to page 1
$rowsPerPage = isset($_GET['rows_per_page']) ? (int)$_GET['rows_per_page'] : 8; // Default to 8 rows per page
$offset = ($page - 1) * $rowsPerPage;

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch product and sales data with pagination, excluding rows where sale_date or sales is NULL
    $stmt = $pdo->prepare("
        SELECT p.product_id, p.product_name, s.sales_id, s.sale_date, s.sales
        FROM products p
        LEFT JOIN sales_data s ON p.product_id = s.product_id
        WHERE s.sale_date IS NOT NULL AND s.sales IS NOT NULL
        LIMIT :offset, :rowsPerPage
    ");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':rowsPerPage', $rowsPerPage, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch data as an associative array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<link rel="stylesheet" href="../assets/style/table.css">
<div class="col-md-9 content" style="margin-left: 400px;">
    <div class="row">
        <div class="contr">
            <div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
                <i class="fa-solid fa-clipboard-list"></i> Data Penjualan Barang
            </div>
            <div class="title">
                <button class="btn-add" style="margin-bottom: 20px; padding: 7px; border-radius: 5px;">
                    <a style="text-decoration: none; color: #DCD7C9;" href="./export_data_penjualan.php">Download Data Penjualan</a>
                </button>
            </div>
            <div class="hdr">
               
                <div class="search">
                    <div style="position: relative;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: -2px; top: 50%; transform: translateY(-50%); color: #76453B;"></i>
                        <input type="text" placeholder="Type to Search" class="inpt" style="padding-left: 40px; border-radius: 50px;">
                    </div>
                    <i class="fas fa-sort" style="margin:10px;"></i> Sort
                    <i class="fas fa-filter" style="margin:10px;"></i> Filter
                </div>
            </div>
            <table id="dataContainer">
                <thead style="color: #D5CEC0;">
                    <tr>
                        <th>No</th>
                        <th>Id Produk</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Penjualan</th>
                        <th>Penjualan</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    $i = $offset + 1;
                    if (!empty($products)):
                        foreach ($products as $product):
                            // Ensure that sale_date and sales are not NULL
                            if ($product['sale_date'] !== null && $product['sales'] !== null):
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($i++); ?></td>
                            <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($product['sale_date']); ?></td>
                            <td><?php echo htmlspecialchars($product['sales']); ?></td>
                            
                        </tr>
                    <?php
                            endif;
                        endforeach;
                    else:
                    ?>
                        <tr>
                            <td colspan="6">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>