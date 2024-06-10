<?php
require '../config.php';

$id = $_POST['karta_dostepu_id'];
$numer_seryjny = $_POST['numer_seryjny'];
$data_wydania = $_POST['data_wydania'];
$data_waznosci = $_POST['data_waznosci'];
$strefy_dostepu = $_POST['strefy_dostepu'];
$karta_aktywna = $_POST['karta_aktywna'];

$sql = "UPDATE karty_dostepu SET numer_seryjny = ?, data_wydania = ?, data_waznosci = ?, strefy_dostepu = ?, karta_aktywna = ? WHERE karta_dostepu_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssii", $numer_seryjny, $data_wydania, $data_waznosci, $strefy_dostepu, $karta_aktywna, $id);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = 'Błąd podczas aktualizacji karty.';
}

echo json_encode($response);
$stmt->close();
$conn->close();
?>
