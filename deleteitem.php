<?php
include 'config.php';

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;

if ($product_id === null) {
    echo "<script>alert('Invalid product ID!'); window.location.href='index.php?page=stok';</script>";
    exit;
}

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete the item from the database
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    echo "<script>alert('Item berhasil dihapus!'); window.location.href='index.php?page=stok';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>