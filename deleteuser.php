<?php
include 'config.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

if ($user_id === null) {
    echo "<script>alert('Invalid user ID!'); window.location.href='index.php?page=users';</script>";
    exit;
}

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete the user from the database
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    echo "<script>alert('User berhasil dihapus!'); window.location.href='index.php?page=users';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>