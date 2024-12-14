<?php
header('Content-Type: application/json');

include 'config.php';

// Fetch data from database
$sql = "SELECT category, stock, sales FROM sales_data";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = [$row["category"], (int)$row["stock"], (int)$row["sales"]];
    }
} else {
    echo json_encode([]);
    exit;
}
$conn->close();

echo json_encode($data);
?>