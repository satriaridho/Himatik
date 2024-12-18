<?php
include 'config.php';

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

                header("Location: index.php");
                exit;
            } else {
                echo "Login gagal, periksa email dan password!";
            }
        } else {
            echo "Login gagal, periksa email dan password!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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
  <title>Register Inventaris Barang</title>
</head>
<body>
  <div class="login-cont">
    <img src="./img/test.jpeg" alt="Logo" width="50">
    <h1 >Inventaris Barang</h1>
    <h2 >Register to Inventory Dashboard</h2>
    <h5>Enter Your Email and Password Below</h5>

    <!-- admintest@gmail.com | admintest -->

    <form method="post" action="login.php">
    <div class="username" style="margin-top: -10px;">
        <p>USERNAME</p>
        <input type="text" name="username" placeholder="Username" style="width: 90%; padding: 10px; border: none; margin: -3px 0; border-radius: 5px;">
      </div>
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
    <p style="text-align: center;">Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>