<?php
include 'config.php';

// Get current page and rows per page
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1; // Default to page 1
$rowsPerPage = isset($_GET['rows_per_page']) ? (int)$_GET['rows_per_page'] : 8; // Default to 8 rows per page
$offset = ($page - 1) * $rowsPerPage;

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to count total number of products
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products");
    $stmt->execute();
    $totalProducts = $stmt->fetchColumn();

    // Calculate total pages
    $totalPages = ceil($totalProducts / $rowsPerPage);

    // Query to fetch product data with pagination
    $stmt = $pdo->prepare("SELECT product_id, product_name, category, stock, harga_barang FROM products LIMIT :offset, :rowsPerPage");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':rowsPerPage', $rowsPerPage, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch data as an associative array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<link rel="stylesheet" href="./style/table.css">
<div class="col-md-9 content" style="margin-left: 400px;">
    <div class="row">
        <div class="contr">
            <div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
                <i class="fa-solid fa-clipboard-list"></i> Manajemen Stok Barang
            </div>
            <div class="title">
                    <button class="btn-add" style="margin-bottom: 20px; padding: 7px; border-radius: 5px;"><a style="text-decoration: none; color: #DCD7C9;  " href="index.php?page=notif">Download Data Barang</a></button>
                </div>
            <div class="hdr">
                <div class="title">
                    <i class="fas fa-plus-circle" style="color: #DCD7C9;"></i>
                    <button class="btn-add"><a style="text-decoration: none; color: #DCD7C9;" href="index.php?page=tambahitem">ADD ITEM</a></button>
                </div>
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
                        <th>Nama Barang</th>
                        <th>Kategori Barang</th>
                        <th>Stok Barang</th>
                        <th>Harga Barang</th>
                        <th>Action Button</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    $i = $offset + 1; // Start the index from the correct number based on the current page
                    if (!empty($products)):
                        foreach ($products as $product):
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($i++); ?></td>
                            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($product['category']); ?></td>
                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            <td><?php echo "Rp " . number_format($product['harga_barang'], 0, ',', '.'); ?></td> <!-- Format harga_barang as currency -->
                            <td class="action-buttons">
                                <a class="edit-btn" href="index.php?page=edititem&product_id=<?php echo $product['product_id']; ?>" style="text-decoration: none;">EDIT</a>
                                <a class="delete-btn" href="index.php?page=deleteitem&product_id=<?php echo $product['product_id']; ?>" style="text-decoration: none;">DELETE</a>
                            </td>
                        </tr>

                    <?php
                        endforeach;
                    else:
                    ?>
                        <tr>
                            <td colspan="6">Tidak ada data barang</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="footer d-flex justify-content-center align-items-center" style="color: #DCD7C9;">
                <div>
                    Rows per page:
                    <select id="rowsPerPage" onchange="updateTable()" style="background-color: #76453B; color: #DCD7C9;">
                        <option value="8" <?php if ($rowsPerPage == 8) echo "selected"; ?>>8</option>
                        <option value="16" <?php if ($rowsPerPage == 16) echo "selected"; ?>>16</option>
                        <option value="32" <?php if ($rowsPerPage == 32) echo "selected"; ?>>32</option>
                    </select>
                </div>
                <div class="pagination" style="margin-left: 20px;">
                    <span id="pageInfo"><?php echo "1 - " . ($offset + count($products)) . " of $totalProducts"; ?></span>
                    <a href="index.php?page=products&page_num=<?php echo max(1, $page - 1); ?>&rows_per_page=<?php echo $rowsPerPage; ?>" class="pagination-btn" <?php if ($page <= 1) echo 'disabled'; ?>>
                        <i class="fas fa-chevron-left" style="color: white;"></i>
                    </a>
                    <a href="index.php?page=products&page_num=<?php echo min($totalPages, $page + 1); ?>&rows_per_page=<?php echo $rowsPerPage; ?>" class="pagination-btn" <?php if ($page >= $totalPages) echo 'disabled'; ?>>
                        <i class="fas fa-chevron-right" style="color: white;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
