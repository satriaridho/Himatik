<?php
requireLogin();
requireAdmin();
include '../config.php';

$sales_id = isset($_GET['sales_id']) ? intval($_GET['sales_id']) : null;

if ($sales_id === null) {
    echo "<script>alert('Invalid product ID!'); window.location.href='index.php?page=stok';</script>";
    exit;
}

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch existing data for the item
    $stmt = $pdo->prepare("SELECT product_id FROM sales_data WHERE sales_id = :sales_id");
    $stmt->bindParam(':sales_id', $sales_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "<script>alert('Product not found!'); window.location.href='index.php?page=stok';</script>";
        exit;
    }

    // Delete the item from the database
    $stmt = $pdo->prepare("DELETE FROM sales_data WHERE sales_id = :sales_id");
    $stmt->bindParam(':sales_id', $sales_id, PDO::PARAM_INT);
    $stmt->execute();

    // Insert notification
    $admin_name = getAdminName();
    $notification_message = "$admin_name deleted {$product['product_id']} from sales_data.";
    $stmt = $pdo->prepare("INSERT INTO notifications (message) VALUES (:message)");
    $stmt->bindParam(':message', $notification_message);
    $stmt->execute();

    echo "<script>alert('Item berhasil dihapus!'); window.location.href='index.php?page=penjualan';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>