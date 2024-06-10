<?php
// Sprawdź, czy dane zostały przesłane metodą POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sprawdź, czy dane zostały przesłane jako JSON
    $data = json_decode(file_get_contents("php://input"));

    // Sprawdź, czy przesłano klucz 'qr_code' w danych JSON
    if (isset($data->qr_code)) {
        // Rozdziel dane z kodu QR na linie
        $qr_lines = explode("\n", $data->qr_code);

        // Sprawdź, czy kod QR ma wymaganą liczbę linii
        if (count($qr_lines) >= 3) {
            // Pobierz door_id z pierwszej linii kodu QR
            $door_id = $qr_lines[0];

            // Pozostałe linie mogą być innymi informacjami, które możesz użyć w swojej aplikacji

            // ...
        } else {
            // Jeśli kod QR nie ma wystarczającej liczby linii, wyślij odpowiedź o błędzie
            http_response_code(400); // Ustaw kod odpowiedzi na 400 (Bad Request)
            echo json_encode(array("error" => "Nieprawidłowy format kodu QR"));
            exit;
        }

        // Pobierz user_id z sesji
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403); // Ustaw kod odpowiedzi na 403 (Forbidden)
            echo json_encode(array("error" => "Brak dostępu do sesji użytkownika"));
            exit;
        }
        $user_id = $_SESSION['user_id'];

        // Pobierz numer karty użytkownika na podstawie user_id
        require '../config.php';
        $sql_get_user_card = "SELECT numer_seryjny FROM karta_dostepu WHERE pracownicy_id = ?";
        $stmt_get_user_card = $conn->prepare($sql_get_user_card);
        $stmt_get_user_card->bind_param("s", $user_id);
        $stmt_get_user_card->execute();
        $result_user_card = $stmt_get_user_card->get_result();

        // Sprawdź, czy użytkownik ma przypisaną kartę dostępu
        if ($result_user_card->num_rows == 0) {
            http_response_code(403); // Ustaw kod odpowiedzi na 403 (Forbidden)
            echo json_encode(array("error" => "Brak przypisanej karty dostępu dla użytkownika"));
            exit;
        }

        // Pobierz numer seryjny karty użytkownika
        $row_user_card = $result_user_card->fetch_assoc();
        $qr_code = $row_user_card['numer_seryjny'];

        // Przygotowanie zapytania SQL
        $sql = "SELECT kd.karta_aktywna 
                FROM karta_dostepu kd
                JOIN karta_dostepu_has_strefy_dostepu kdh ON kdh.Karta_Dostepu_id = kd.Karta_Dostepu_id
                JOIN drzwi d ON d.Strefy_Dostepu_id = kdh.Strefy_Dostepu_id
                WHERE kd.numer_seryjny = ? AND d.Drzwi_id = ?";

        // Przygotowanie zapytania SQL z instrukcją prepare
        $stmt = $conn->prepare($sql);

        // Związanie parametrów
        $stmt->bind_param("ss", $qr_code, $door_id);

        // Wykonanie zapytania
        $stmt->execute();

        // Pobranie wyniku zapytania
        $result = $stmt->get_result();

        // Zdefiniowanie zmiennej na wynik
        $access_granted = false;

        // Sprawdzenie wyniku zapytania
        if ($result->num_rows > 0) {
            // Pobranie wiersza wynikowego
            $row = $result->fetch_assoc();
            // Sprawdzenie statusu karty dostępu
            if ($row["karta_aktywna"] == 1) {
                // Dostęp przyznany
                $access_granted = true;
            }
        }

        // Zakończenie zapytania
        $stmt->close();
        $stmt_get_user_card->close();

        // Zamykanie połączenia z bazą danych
        $conn->close();

        // Zwrócenie odpowiedzi jako JSON
        echo json_encode(array("access_granted" => $access_granted, "qr_code" => $qr_code, "door_id" => $door_id, "user_id" => $user_id));
        exit;
    } else {
        // Jeśli brakuje klucza 'qr_code' w danych JSON, wyślij odpowiedź o błędzie
        http_response_code(400); // Ustaw kod odpowiedzi na 400 (Bad Request)
        echo json_encode(array("error" => "Klucz 'qr_code' nie został przekazany w danych JSON"));
        exit;
    }
} else {
    // Jeśli dane nie zostały przesłane metodą POST, wyślij odpowiedź o błędzie
    http_response_code(405); // Ustaw kod odpowiedzi na 405 (Method Not Allowed)
    echo json_encode(array("error" => "Metoda żądania nieobsługiwana"));
    exit;
}
?>
