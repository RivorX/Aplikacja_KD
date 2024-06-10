<?php
require '../config.php';

$id = $_GET['id'];

$sql = "DELETE FROM karty_dostepu WHERE karta_dostepu_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = 'Błąd podczas usuwania karty.';
}

echo json_encode($response);
$stmt->close();
$conn->close();
?>
