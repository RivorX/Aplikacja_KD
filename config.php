<?php
$host = 'localhost';
$db = 'kontroladostepu';
$user = 'root';
$pass = '';

// Utworzenie połączenia
$conn = new mysqli($host, $user, $pass, $db);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}
?>
