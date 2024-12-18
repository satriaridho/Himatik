<?php
requireLogin();
requireAdmin();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $harga_barang = $_POST['harga_barang'];

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert data into the database
        $stmt = $pdo->prepare("
            INSERT INTO products (product_name, category, stock, harga_barang)
            VALUES (:product_name, :category, :stock, :harga_barang)
        ");
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':harga_barang', $harga_barang);
        $stmt->execute();

        // Insert notification
        $admin_name = getAdminName();
        $notification_message = "$admin_name added $product_name to products.";
        $stmt = $pdo->prepare("INSERT INTO notifications (message) VALUES (:message)");
        $stmt->bindParam(':message', $notification_message);
        $stmt->execute();

        echo "<script>alert('Item berhasil ditambahkan!'); window.location.href='index.php?page=stok';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<link rel="stylesheet" href="../assets/style/input.css">
<div class="col-md-9 content" style="margin-left: 400px;">
    <div class="row">
        <div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
            <i class="fa-solid fa-clipboard-list"></i> Tambah Item
        </div>

        <!-- Form untuk menambah item -->
        <div class="form-container" style="background-color: #76453B; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 50px;">Tambah Item Baru</h3>
            <form id="addItemForm" method="post" action="">
                
                <input  type="text" id="itemName" name="product_name" required placeholder="Nama Barang">

                <select id="itemCategory" name="category" required style="width: 100%; padding: 12px; border-radius: 5px;">
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Alat Tulis">Alat Tulis</option>
                    <option value="Lain Lain">Lain Lain</option>
                </select>

                <input type="number" id="itemStock" name="stock" required placeholder="Stok Barang">

                <input type="number" id="itemPrice" name="harga_barang" required placeholder="Harga">

                <button type="submit" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B; margin-bottom: 10px;">Tambah Item</button>
                <a href="index.php?page=stok" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B;">Kembali</a>
            </form>
        </div>
    </div>
</div>