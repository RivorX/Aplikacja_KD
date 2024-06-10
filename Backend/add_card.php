<?php
require '../config.php';

if(isset($_POST['cardNumber']) && isset($_POST['issueDate']) && isset($_POST['expiryDate']) && isset($_POST['employee']) && isset($_POST['accessZones']) && isset($_POST['status'])) {
    $numer_seryjny = $_POST['cardNumber'];
    $data_wydania = $_POST['issueDate'];
    $data_waznosci = $_POST['expiryDate'];
    $pracownik_id = $_POST['employee'];
    $strefy_dostepu = $_POST['accessZones'];
    $karta_aktywna = $_POST['status'];

    $sql = "INSERT INTO karta_dostepu (numer_seryjny, data_wydania, data_waznosci, pracownicy_id, karta_aktywna) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $numer_seryjny, $data_wydania, $data_waznosci, $pracownik_id, $karta_aktywna);

    $response = array();
    if ($stmt->execute()) {
        // Pobierz ID ostatnio wstawionego rekordu
        $karta_dostepu_id = $stmt->insert_id;

        // Wstawienie stref dostępu do tabeli łączącej
        foreach ($strefy_dostepu as $strefa_id) {
            $sql_relacja = "INSERT INTO karta_dostepu_has_strefy_dostepu (Karta_Dostepu_id, Strefy_Dostepu_id) VALUES (?, ?)";
            $stmt_relacja = $conn->prepare($sql_relacja);
            $stmt_relacja->bind_param("ii", $karta_dostepu_id, $strefa_id);
            $stmt_relacja->execute();
            $stmt_relacja->close();
        }

        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = 'Błąd podczas dodawania karty.';
    }

    echo json_encode($response);
    $stmt->close();
} else {
    echo "Niektóre pola formularza nie zostały przesłane.";
}
$conn->close();
?>
