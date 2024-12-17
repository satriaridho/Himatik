<?php
// filepath: /c:/xampp/htdocs/Himatik/edituser.php
requireLogin();
requireAdmin();
include 'config.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

if ($user_id === null) {
    echo "<script>alert('Invalid user ID!'); window.location.href='index.php?page=users';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch existing data for the user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existing_user) {
            echo "<script>alert('User not found!'); window.location.href='index.php?page=users';</script>";
            exit;
        }

        // Update data in the database
        if (!empty($password)) {
            // Hash the new password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                UPDATE users 
                SET username = :username, email = :email, password = :password, address = :address
                WHERE user_id = :user_id
            ");
            $stmt->bindParam(':password', $hashed_password);
        } else {
            // Do not change the password
            $stmt = $pdo->prepare("
                UPDATE users 
                SET username = :username, email = :email, address = :address
                WHERE user_id = :user_id
            ");
        }
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Insert notification
        $admin_name = getAdminName(); // Function to get the admin's name
        $notification_message = "$admin_name updated user {$existing_user['username']}: ";

        $changes = [];
        if ($existing_user['username'] != $username) {
            $changes[] = "username from '{$existing_user['username']}' to '$username'";
        }
        if ($existing_user['email'] != $email) {
            $changes[] = "email from '{$existing_user['email']}' to '$email'";
        }
        if (!empty($password)) {
            $changes[] = "password changed";
        }
        if ($existing_user['address'] != $address) {
            $changes[] = "address from '{$existing_user['address']}' to '$address'";
        }

        if (!empty($changes)) {
            $notification_message .= implode(", ", $changes) . ".";

            $stmt = $pdo->prepare("INSERT INTO notifications (message) VALUES (:message)");
            $stmt->bindParam(':message', $notification_message);
            $stmt->execute();
        }

        echo "<script>alert('User berhasil diperbarui!'); window.location.href='index.php?page=users';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch existing data for the user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "<script>alert('User not found!'); window.location.href='index.php?page=users';</script>";
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
            <i class="fa-solid fa-clipboard-list"></i> Edit User
        </div>

        <!-- Form untuk mengedit user -->
        <div class="form-container" style="background-color: #76453B; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 50px;">Edit User</h3>
            <form id="editUserForm" method="POST" action="">
                
                <input type="text" name="username" id="UserName" required placeholder="Username" value="<?php echo htmlspecialchars($user['username']); ?>">

                <input type="email" name="email" id="UserEmail" required placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>">

                <input type="password" name="password" id="UserPassword" placeholder="Password Baru (biarkan kosong jika tidak mengubah password)">

                <input type="text" name="address" id="UserAddress" required placeholder="Address" value="<?php echo htmlspecialchars($user['address']); ?>">

                <button type="submit" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B; margin-bottom: 10px;">Simpan</button>
                <a href="index.php?page=users" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B;">Kembali</a>
            </form>
        </div>
    </div>
</div>