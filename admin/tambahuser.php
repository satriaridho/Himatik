<?php
requireLogin();
requireAdmin();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $user_address = $_POST['address'];

    // Hash password
    $user_hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // Get date
    $user_join_date = date("Y-m-d");

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert data into the database
        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password, join_date, address)
            VALUES (:username, :email, :password, :join_date, :address)
        ");
        $stmt->bindParam(':username', $user_name);
        $stmt->bindParam(':email', $user_email);
        $stmt->bindParam(':password', $user_hashed_password);
        $stmt->bindParam(':join_date', $user_join_date);
        $stmt->bindParam(':address', $user_address);
        $stmt->execute();

        // Insert notification
        $admin_name = getAdminName();
        $notification_message = "New User Signup by $admin_name: $user_name has joined.";
        $stmt = $pdo->prepare("INSERT INTO notifications (message) VALUES (:message)");
        $stmt->bindParam(':message', $notification_message);
        $stmt->execute();

        echo "<script>alert('User berhasil ditambahkan!'); window.location.href='index.php?page=users';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<link rel="stylesheet" href="../assets/style/input.css">
<div class="col-md-9 content" style="margin-left: 400px;">
    <div class="row">
        <div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
            <i class="fa-solid fa-clipboard-list"></i> Tambah User
        </div>

        <!-- Form untuk menambah User -->
        <div class="form-container" style="background-color: #76453B; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 50px;">Tambah User Baru</h3>
            <form id="addUserForm" method="post" action="">
                
                <input type="text" id="UserName" name="username" required placeholder="Username">

                <input type="text" id="UserEmail" name="email" required placeholder="Email">

                <input type="password" id="UserPassword" name="password" required placeholder="Password">

                <input type="text" id="UserAddress" name="address" required placeholder="Address">

                <button type="submit" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B; margin-bottom: 10px;">Tambah User</button>
                <a href="index.php?page=users" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B;">Kembali</a>
            </form>
        </div>
    </div>
</div>