<?php
requireLogin();
requireAdmin();
include '../config.php';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all product names and IDs
    $stmt = $pdo->prepare("SELECT product_id, product_name FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $sale_date = $_POST['sale_date'];
    $sales = $_POST['sales'];

    try {
        // Insert data into the database
        $stmt = $pdo->prepare("
            INSERT INTO sales_data (product_id, sale_date, sales)
            VALUES (:product_id, :sale_date, :sales)
        ");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':sale_date', $sale_date);
        $stmt->bindParam(':sales', $sales);
        $stmt->execute();

        // Fetch product name for notification
        $stmt = $pdo->prepare("SELECT product_name FROM products WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $product_name = $product ? $product['product_name'] : 'Unknown Product';

        // Insert notification
        $admin_name = getAdminName(); // Make sure this function returns the admin's name
        $notification_message = "$admin_name added a sale for $product_name (ID: $product_id) on $sale_date with quantity $sales.";
        $stmt = $pdo->prepare("INSERT INTO notifications (message) VALUES (:message)");
        $stmt->bindParam(':message', $notification_message);
        $stmt->execute();

        echo "<script>alert('Penjualan berhasil ditambahkan!'); window.location.href='index.php?page=penjualan';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<link rel="stylesheet" href="../assets/style/input.css">
<div class="col-md-9 content" style="margin-left: 400px;">
    <div class="row">
        <div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
            <i class="fa-solid fa-clipboard-list"></i> Tambah Penjualan
        </div>

        <!-- Form untuk menambah penjualan -->
        <div class="form-container" style="background-color: #76453B; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 50px;">Tambah Penjualan Baru</h3>
            <form id="addSaleForm" method="post" action="">
                
                <select id="productId" name="product_id" required style="width: 100%; padding: 12px; border-radius: 5px;">
                    <option value="">Pilih Produk</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?php echo htmlspecialchars($product['product_id']); ?>">
                            <?php echo htmlspecialchars($product['product_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="date" id="saleDate" name="sale_date" required placeholder="Tanggal Penjualan" style="width: 100%; padding: 12px; border-radius: 5px;">

                <input type="number" id="sales" name="sales" required placeholder="Jumlah Penjualan">

                <button type="submit" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B; margin-bottom: 10px;">Tambah Penjualan</button>
                <a href="index.php?page=penjualan" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B;">Kembali</a>
            </form>
        </div>
    </div>
</div>