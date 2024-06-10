<?php
require '../config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM karty_dostepu WHERE karta_dostepu_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$card = $result->fetch_assoc();

echo json_encode($card);
$stmt->close();
$conn->close();
?>
