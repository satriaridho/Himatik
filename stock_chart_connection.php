<?php
header('Content-Type: application/json');

include 'config.php';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data from database
    $sql = "
        SELECT p.category, p.stock, COALESCE(SUM(s.sales), 0) as sales
        FROM products p
        LEFT JOIN sales_data s ON p.product_id = s.product_id
        GROUP BY p.category, p.stock
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