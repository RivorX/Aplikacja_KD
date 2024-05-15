<?php
header('Content-Type: application/json');
require '../config.php';

$sql = "SELECT 
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
    GROUP BY 
        kd.numer_seryjny, 
        kd.data_wydania, 
        kd.data_waznosci, 
        kd.karta_aktywna;
";
$result = $conn->query($sql);

$cards = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }
}

echo json_encode($cards);

$conn->close();
?>
