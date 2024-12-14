<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "himatic";

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch sales data
    $stmt = $pdo->prepare("SELECT sale_date, sales FROM sales_data ORDER BY sale_date");
    $stmt->execute();

    // Fetch data as an associative array
    $sales_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($sales_data);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
