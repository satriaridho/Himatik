<?php
requireLogin();
requireAdmin();
include 'config.php';

$sales_id = isset($_GET['sales_id']) ? intval($_GET['sales_id']) : null;

if ($sales_id === null) {
    echo "<script>alert('Invalid sales ID!'); window.location.href='index.php?page=penjualan';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $sale_date = $_POST['sale_date'];
    $sales = $_POST['sales'];

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch existing data for the sale
        $stmt = $pdo->prepare("SELECT * FROM sales_data WHERE sales_id = :sales_id");
        $stmt->bindParam(':sales_id', $sales_id, PDO::PARAM_INT);
        $stmt->execute();
        $existing_sale = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existing_sale) {
            echo "<script>alert('Sale not found!'); window.location.href='index.php?page=penjualan';</script>";
            exit;
        }

        // Update data in the database
        $stmt = $pdo->prepare("
            UPDATE sales_data 
            SET product_id = :product_id, sale_date = :sale_date, sales = :sales 
            WHERE sales_id = :sales_id
        ");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':sale_date', $sale_date);
        $stmt->bindParam(':sales', $sales);
        $stmt->bindParam(':sales_id', $sales_id);
        $stmt->execute();

        // Fetch product name
        $stmt = $pdo->prepare("SELECT product_name FROM products WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $product_name = $product ? $product['product_name'] : 'Unknown Product';

        // Insert notification
        $admin_name = getAdminName();
        $notification_message = "$admin_name updated sale for $product_name (ID: $product_id): ";

        $changes = [];
        if ($existing_sale['sale_date'] != $sale_date) {
            $changes[] = "sale date from '{$existing_sale['sale_date']}' to '$sale_date'";
        }
        if ($existing_sale['sales'] != $sales) {
            $changes[] = "sales from '{$existing_sale['sales']}' to '$sales'";
        }

        if (!empty($changes)) {
            $notification_message .= implode(", ", $changes) . ".";

            $stmt = $pdo->prepare("INSERT INTO notifications (message) VALUES (:message)");
            $stmt->bindParam(':message', $notification_message);
            $stmt->execute();
        }

        echo "<script>alert('Penjualan berhasil diperbarui!'); window.location.href='index.php?page=penjualan';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch existing data for the sale
        $stmt = $pdo->prepare("SELECT * FROM sales_data WHERE sales_id = :sales_id");
        $stmt->bindParam(':sales_id', $sales_id, PDO::PARAM_INT);
        $stmt->execute();
        $sale = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sale) {
            echo "<script>alert('Sale not found!'); window.location.href='index.php?page=penjualan';</script>";
            exit;
        }

        // Fetch all product names and IDs
        $stmt = $pdo->prepare("SELECT product_id, product_name FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<link rel="stylesheet" href="./style/input.css">
<div class="col-md-9 content" style="margin-left: 400px;">
    <div class="row">
        <div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
            <i class="fa-solid fa-clipboard-list"></i> Edit Penjualan
        </div>

        <!-- Form untuk mengedit penjualan -->
        <div class="form-container" style="background-color: #76453B; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 50px;">Edit Penjualan</h3>
            <form id="editSaleForm" method="post" action="">
                
                <select id="productId" name="product_id" required>
                    <option value="">Pilih Produk</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?php echo htmlspecialchars($product['product_id']); ?>" <?php echo $sale['product_id'] == $product['product_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($product['product_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="date" id="saleDate" name="sale_date" required placeholder="Tanggal Penjualan" value="<?php echo htmlspecialchars($sale['sale_date']); ?>">

                <input type="number" id="sales" name="sales" required placeholder="Jumlah Penjualan" value="<?php echo htmlspecialchars($sale['sales']); ?>">

                <button type="submit" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B; margin-bottom: 10px;">Simpan</button>
                <a href="index.php?page=penjualan" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B;">Kembali</a>
            </form>
        </div>
    </div>
</div>