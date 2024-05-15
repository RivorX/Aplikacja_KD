<?php
session_start(); // Otwarcie sesji

header('Content-Type: application/json');
require '../config.php';

// Sprawdzenie, czy sesja user_id istnieje
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Niepoprawna sesja']);
    exit();
}

$user_id = $_SESSION['user_id']; // Pobranie user_id z sesji

// Debugowanie: sprawdź, czy user_id jest ustawione
if ($user_id === null) {
    echo json_encode(['error' => 'user_id is null']);
    exit();
}

$sql = "SELECT 
        kd.karta_dostepu_id,
        kd.numer_seryjny, 
        kd.data_wydania, 
        kd.data_waznosci, 
        GROUP_CONCAT(sd.nazwa_strefy SEPARATOR ', ') AS strefy_dostepu, 
        kd.karta_aktywna 
    FROM 
        karta_dostepu kd
    LEFT JOIN 
        karta_dostepu_has_strefy_dostepu kdh ON kd.karta_dostepu_id = kdh.karta_dostepu_id
    JOIN 
        strefy_dostepu sd ON sd.Strefy_Dostepu_id = kdh.Strefy_Dostepu_id
    WHERE
        kd.pracownicy_id = ?";

// Przygotowanie zapytania SQL z instrukcją prepare
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

$stmt->execute();
$result = $stmt->get_result();

$cards = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }
}

echo json_encode($cards);

$stmt->close();
$conn->close();
?>
