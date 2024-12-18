<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_join_date = date("Y-m-d");
    $user_address = $_POST['address'];


    // Validate input
    if (!empty($username) && !empty($email) && !empty($password)) {
        try {
            // Connect to the database
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the email already exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $email_exists = $stmt->fetchColumn();

            if (!$email_exists) {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert the new user into the database
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, join_date, address) VALUES (:username, :email, :password,:join_date, :address)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':join_date', $user_join_date);
                $stmt->bindParam(':address', $user_address);
                $stmt->execute();

                // Redirect to login page after successful registration
                header("Location: login.php");
                exit;
            } else {
                $error_message = 'Email Sudah Ada!';
            }
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    } else {
        $error_message = 'All fields are required!';
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

    <h2>Register to Inventory Dashboard</h2>
    <h5>Enter Your Email and Password Below</h5>

    <!-- Display error message if registration fails -->
    <?php if (!empty($error_message)): ?>
      <div class="error-message" style="color: red; text-align: center; margin-bottom: 10px;">
        <?php echo htmlspecialchars($error_message); ?>
      </div>
    <?php endif; ?>

    <form method="post" action="signup.php">
      <div class="username" style="margin-top: -10px;">
        <p>USERNAME</p>
        <input type="text" name="username" placeholder="Username" style="width: 90%; padding: 10px; border: none; margin: -3px 0; border-radius: 5px;" required>
      </div>
      <div class="email">
        <p>EMAIL</p>
        <input type="email" name="email" placeholder="Email address" required>
      </div>
      <div class="email">
        <p>ADDRESS</p>
        <input type="text" name="address" placeholder="Address" required style="width: 90%; padding: 10px; border: none; margin: -3px 0; border-radius: 5px;">
      </div>
      <div class="pass">
        <p>PASSWORD</p>
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <input type="submit" value="Register">
    </form>
    <p style="text-align: center;">Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>