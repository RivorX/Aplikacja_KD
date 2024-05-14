<?php
require '../config.php';

// Hasło do zahashowania
$password = 'zaq1@WSX';
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Zaktualizuj hasło w bazie danych
$stmt = $conn->prepare("UPDATE pracownicy SET password = ? WHERE email = ?");
$email = 'rafilix11@gmail.com';
$stmt->bind_param("ss", $hashedPassword, $email);
$stmt->execute();

if ($stmt->affected_rows === 1) {
    echo "Hasło zostało zaktualizowane.";
} else {
    echo "Wystąpił problem z aktualizacją hasła.";
}

$stmt->close();
$conn->close();
?>
