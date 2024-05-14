<?php
session_start();
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Przygotowanie zapytania SQL
    $stmt = $conn->prepare("SELECT Pracownicy_id, email, password FROM pracownicy WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Hasło jest poprawne, ustawienie sesji
            $_SESSION['user_id'] = $row['Pracownicy_id'];
            $_SESSION['email'] = $row['email'];
            header("Location: ../Frontend/userpanel.php");
            exit();
        } else {
            // Niepoprawne hasło
            $_SESSION['error'] = "Nieprawidłowe dane logowania. Złe hasło.";
            header("Location: ../Frontend/login.php");
            exit();
        }
    } else {
        // Niepoprawny email
        $_SESSION['error'] = "Nieprawidłowe dane logowania.";
        header("Location: ../Frontend/login.php");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
