<?php
header('Content-Type: application/json');
require '../config.php';

$sql = "SELECT * FROM drzwi";

$result = $conn->query($sql);

$doors = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doors[] = $row;
    }
}

echo json_encode($doors);

$conn->close();
?>
