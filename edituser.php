<?php
include 'config.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

if ($user_id === null) {
    echo "<script>alert('Invalid user ID!'); window.location.href='index.php?page=users';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_username = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $user_address = $_POST['address'];

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update data in the database
        if (!empty($user_password)) {
            // Hash the new password
            $user_hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                UPDATE users 
                SET username = :username, email = :email, password = :password, address = :address 
                WHERE user_id = :user_id
            ");
            $stmt->bindParam(':password', $user_hashed_password);
        } else {
            $stmt = $pdo->prepare("
                UPDATE users 
                SET username = :username, email = :email, address = :address 
                WHERE user_id = :user_id
            ");
        }

        $stmt->bindParam(':username', $user_username);
        $stmt->bindParam(':email', $user_email);
        $stmt->bindParam(':address', $user_address);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        echo "<script>alert('User berhasil diperbarui!'); window.location.href='index.php?page=users';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
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

                <input type="text" name="email" id="UserEmail" required placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>">

                <input type="text" name="password" id="UserPassword" placeholder="Password Baru (biarkan kosong jika tidak mengubah password)">

                <input type="text" name="address" id="UserAddress" required placeholder="Address" value="<?php echo htmlspecialchars($user['address']); ?>">

                <button type="submit" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B; margin-bottom: 10px;">Simpan</button>
                <a href="index.php?page=users" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B;">Kembali</a>
            </form>
        </div>
    </div>
</div>