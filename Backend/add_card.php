<?php
require '../config.php';

$numer_seryjny = $_POST['numer_seryjny'];
$data_wydania = $_POST['data_wydania'];
$data_waznosci = $_POST['data_waznosci'];
$strefy_dostepu = $_POST['strefy_dostepu'];
$karta_aktywna = $_POST['karta_aktywna'];

$sql = "INSERT INTO karty_dostepu (numer_seryjny, data_wydania, data_waznosci, strefy_dostepu, karta_aktywna) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $numer_seryjny, $data_wydania, $data_waznosci, $strefy_dostepu, $karta_aktywna);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = 'Błąd podczas dodawania karty.';
}

echo json_encode($response);
$stmt->close();
$conn->close();
?>
