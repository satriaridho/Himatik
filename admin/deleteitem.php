<?php
requireLogin();
requireAdmin();
include '../config.php';

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;

if ($product_id === null) {
    echo "<script>alert('Invalid product ID!'); window.location.href='index.php?page=stok';</script>";
    exit;
}

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch existing data for the item
    $stmt = $pdo->prepare("SELECT product_name FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "<script>alert('Product not found!'); window.location.href='index.php?page=stok';</script>";
        exit;
    }

    // Delete related rows in the sales_data table
    $stmt = $pdo->prepare("DELETE FROM sales_data WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    // Delete the item from the database
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    // Insert notification
    $admin_name = getAdminName();
    $notification_message = "$admin_name deleted {$product['product_name']} from products.";
    $stmt = $pdo->prepare("INSERT INTO notifications (message) VALUES (:message)");
    $stmt->bindParam(':message', $notification_message);
    $stmt->execute();

    echo "<script>alert('Item berhasil dihapus!'); window.location.href='index.php?page=stok';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>