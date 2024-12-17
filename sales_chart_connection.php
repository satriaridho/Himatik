<?php
include 'config.php';
try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch sales data from the past 7 days grouped by sale_date
    $stmt = $pdo->prepare("
        SELECT sale_date, SUM(sales) as total_sales 
        FROM sales_data 
        WHERE sale_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY sale_date 
        ORDER BY sale_date
    ");
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