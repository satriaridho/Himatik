<?php
requireLogin();
requireAdmin();
include '../config.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

if ($user_id === null) {
    echo "<script>alert('Invalid user ID!'); window.location.href='index.php?page=users';</script>";
    exit;
}

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the user's username before deletion
    $stmt = $pdo->prepare("SELECT username FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<script>alert('User not found!'); window.location.href='index.php?page=users';</script>";
        exit;
    }

    // Delete the user from the database
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Insert notification
    $admin_name = getAdminName();
    $notification_message = "$admin_name deleted user {$user['username']}.";
    $stmt = $pdo->prepare("INSERT INTO notifications (message) VALUES (:message)");
    $stmt->bindParam(':message', $notification_message);
    $stmt->execute();

    echo "<script>alert('User berhasil dihapus!'); window.location.href='index.php?page=users';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>