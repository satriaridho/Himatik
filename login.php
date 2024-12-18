<?php
include 'config.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $login_password = $_POST['password'];

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "
            SELECT user_id, username, email, password, NULL as admin_id FROM users WHERE email = :email
            UNION
            SELECT admin_id as user_id, username, email, password, admin_id FROM admin WHERE email = :email
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (password_verify($login_password, $result['password'])) {
                session_start();
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['username'] = $result['username'];
                $_SESSION['role'] = isset($result['admin_id']) ? 'admin' : 'user';

                if ($_SESSION['role'] === 'admin') {
                    header("Location: ./admin/index.php");
                } else {
                    header("Location: ./user/index.php");
                }
                exit;
            } else {
                $error_message = "Login gagal, periksa email dan password!";
            }
        } else {
            $error_message = "Login gagal, periksa email dan password!";
        }
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/style/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@700&display=swap" rel="stylesheet">
  <title>Login Inventaris Barang</title>
</head>
<body>
  <div class="login-cont">
    <img src="./assets/img/test.jpeg" alt="Logo" width="50">
    <h1>Inventaris Barang</h1>
    <h2>Log In to Inventory Dashboard</h2>
    <h5>Enter Your Email and Password Below</h5>
    <!-- email | password -->
    <!-- admintest@gmail.com | admintest -->
    <!-- usertest@gmail.com | usertest -->

    <!-- Display error message if login fails -->
    <?php if (!empty($error_message)): ?>
      <div class="error-message" style="color: red; text-align: center; margin-bottom: 10px;">
        <?php echo htmlspecialchars($error_message); ?>
      </div>
    <?php endif; ?>

    <form method="post" action="login.php">
      <div class="email">
        <p>EMAIL</p>
        <input type="email" name="email" placeholder="Email address" required>
      </div>
      <div class="pass">
        <p>PASSWORD</p>
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <input type="submit" value="Login">
    </form>
    <p style="text-align: center;">Don't have an account? <a href="signup.php">Sign Up</a></p>
  </div>
</body>
</html>