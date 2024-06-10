<?php
// Sprawdź, czy dane zostały przesłane z formularza
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sprawdź, czy wszystkie wymagane pola zostały przesłane
    if (isset($_POST['drzwi_id'])) {
        // Pobierz drzwi_id z formularza
        $drzwi_id = $_POST['drzwi_id'];

        // Połączenie z bazą danych
        require '../config.php';

        // Zapytanie SQL pobierające dane drzwi na podstawie drzwi_id
        $sql = "SELECT nr_drzwi, nazwa FROM drzwi WHERE Drzwi_id = ?";

        // Przygotowanie zapytania SQL z instrukcją prepare
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $drzwi_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Sprawdź, czy znaleziono drzwi o danym drzwi_id
        if ($result->num_rows > 0) {
            // Pobierz dane drzwi
            $row = $result->fetch_assoc();
            $nr_drzwi = $row['nr_drzwi'];
            $nazwa_drzwi = $row['nazwa'];

            // Zamknięcie połączenia z bazą danych
            $stmt->close();
            $conn->close();

            // Generowanie tekstu do kodu QR
            $qr_text = $drzwi_id . "\n";
            $qr_text .= $nr_drzwi . "\n";
            $qr_text .= $nazwa_drzwi;

            // Generowanie pliku z kodem QR
            require('../phpqrcode/qrlib.php');
            $qr_file = "../Zdj/qr_codes/qr_code_" . $drzwi_id . ".png"; // Ścieżka do pliku z kodem QR !!!!!!!!!!!

            QRcode::png($qr_text, $qr_file, QR_ECLEVEL_L, 10); // Generowanie kodu QR i zapis do pliku

            // Przekierowanie użytkownika do wygenerowanego kodu QR
            header("Location: ".$qr_file);
            exit;
        } else {
            // Jeśli nie znaleziono drzwi o danym drzwi_id, wyświetl komunikat o błędzie
            echo "Nie znaleziono drzwi o podanym ID.";
        }
    } else {
        // Jeśli brakuje wymaganych pól, wyświetl komunikat o błędzie
        echo "Wypełnij wszystkie wymagane pola.";
    }
} else {
    // Jeśli dane nie zostały przesłane metodą POST, przekieruj użytkownika z powrotem do formularza
    header("Location: ../Frontend/qr_code_generate.php");
    exit;
}
?>
