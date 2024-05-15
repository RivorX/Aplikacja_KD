<?php
// Połączenie z bazą danych
header('Content-Type: application/json');
require '../config.php';

// Zapytanie SQL do pobrania danych pracowników
$sql = "SELECT imie, nazwisko, email, g.nazwa_grupy, konto_aktywne 
FROM pracownicy p
LEFT JOIN grupy g ON p.Grupy_id = g.Grupy_id";
$result = $conn->query($sql);

// Sprawdzenie czy dane zostały poprawnie pobrane
if ($result->num_rows > 0) {
    // Wyświetlenie danych w tabeli
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["imie"] . "</td>";
        echo "<td>" . $row["nazwisko"] . "</td>";
        echo "<td>" . $row["stanowisko"] . "</td>";
        echo "<td>" . $row["dzial"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Brak pracowników w bazie danych.</td></tr>";
}
$conn->close();
?>
