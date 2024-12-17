<?php
header('Content-Type: application/json');

include 'config.php';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data from database
    $sql = "
        SELECT p.category, SUM(p.stock) AS stock, COALESCE(SUM(s.sales), 0) AS sales
        FROM products p
        LEFT JOIN sales_data s ON p.product_id = s.product_id
        GROUP BY p.category
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [$row["category"], (int)$row["stock"], (int)$row["sales"]];
    }

    echo json_encode($data);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>