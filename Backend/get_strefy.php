<?php
header('Content-Type: application/json');
require '../config.php';

// Zapytanie SQL do pobrania danych o strefach dostępu
$sql = "SELECT Strefy_Dostepu_id, nazwa_strefy 
        FROM strefy_dostepu";

$result = $conn->query($sql);

$zones = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $zones[] = $row;
    }
}

echo json_encode($zones);

$conn->close();
?>
