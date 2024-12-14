<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "
        SELECT user_id, email, password, NULL as admin_id FROM users WHERE email = '$email'
        UNION
        SELECT admin_id as user_id, email, password, admin_id FROM admin WHERE email = '$email'
    ";
    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = isset($user['admin_id']) ? 'admin' : 'user';

                if ($_SESSION['role'] === 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: user_dashboard.php");
                }
                exit;
            }
        }
        echo "Login gagal, periksa email dan password!";
    } else {
        echo "Error executing query: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@700&display=swap" rel="stylesheet">
  <title>Login Inventaris Barang</title>
</head>
<body>
  <div class="login-cont">
    <img src="./img/test.jpeg" alt="Logo" width="50">
    <h1 >Inventaris Barang</h1>
    <h2 >Log In to Inventory Dashboard</h2>
    <h5>Enter Your Email and Password Below</h5>

    <!-- admintest@gmail.com | admintest -->

    <form method="post" action="index.php">
      <div class="email">
        <p>EMAIL</p>
        <input type="email" name="email" placeholder="Email address">
      </div>
      <div class="pass">
        <p>PASSWORD</p>
        <input type="password" name="password" placeholder="Password">
      </div>
      <input type="submit">
    </form>
    <p style="text-align: center;">Don't have an account? <a href="">Sign Up</a></p>
  </div>
</body>
</html>