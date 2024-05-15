<?php
// Połączenie z bazą danych
header('Content-Type: application/json');
require '../config.php';

// Zapytanie SQL do pobrania danych pracowników
$sql = "SELECT pracownicy_id, imie, nazwisko, email, g.nazwa_grupy, konto_aktywne 
FROM pracownicy p
LEFT JOIN grupy g ON p.Grupy_id = g.Grupy_id";
$result = $conn->query($sql);

$employees = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}

echo json_encode($employees);


$conn->close();
?>
