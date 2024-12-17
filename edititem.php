<?php
include 'config.php';

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;

if ($product_id === null) {
    echo "<script>alert('Invalid product ID!'); window.location.href='index.php?page=stok';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $harga_barang = $_POST['harga_barang'];

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update data in the database
        $stmt = $pdo->prepare("
            UPDATE products 
            SET product_name = :product_name, category = :category, stock = :stock, harga_barang = :harga_barang 
            WHERE product_id = :product_id
        ");
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':harga_barang', $harga_barang);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        echo "<script>alert('Item berhasil diperbarui!'); window.location.href='index.php?page=stok';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch existing data for the item
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo "<script>alert('Product not found!'); window.location.href='index.php?page=stok';</script>";
            exit;
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<link rel="stylesheet" href="./style/input.css">
<div class="col-md-9 content" style="margin-left: 400px;">
    <div class="row">
        <div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
            <i class="fa-solid fa-clipboard-list"></i> Edit Item
        </div>

        <!-- Form untuk mengedit item -->
        <div class="form-container" style="background-color: #76453B; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 50px;">Edit Item</h3>
            <form id="editItemForm" method="POST" action="">
                
                <input type="text" name="product_name" id="itemName" required placeholder="Nama Barang" value="<?php echo htmlspecialchars($product['product_name']); ?>">

                <select name="category" id="itemCategory" required>
                    <option value="">Kategori Barang</option>
                    <option value="Makanan" <?php echo $product['category'] == 'Makanan' ? 'selected' : ''; ?>>Makanan</option>
                    <option value="Minuman" <?php echo $product['category'] == 'Minuman' ? 'selected' : ''; ?>>Minuman</option>
                    <option value="Alat Tulis" <?php echo $product['category'] == 'Alat Tulis' ? 'selected' : ''; ?>>Alat Tulis</option>
                    <option value="Lain Lain" <?php echo $product['category'] == 'Lain Lain' ? 'selected' : ''; ?>>Lain Lain</option>
                </select>

                <input type="number" name="stock" id="itemStock" required placeholder="Stok Barang" value="<?php echo htmlspecialchars($product['stock']); ?>">

                <input type="number" name="harga_barang" id="itemPrice" required placeholder="Harga" value="<?php echo htmlspecialchars($product['harga_barang']); ?>">

                <button type="submit" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B; margin-bottom: 10px;">Simpan</button>
                <a href="index.php?page=stok" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B;">Kembali</a>
            </form>
        </div>
    </div>
</div>