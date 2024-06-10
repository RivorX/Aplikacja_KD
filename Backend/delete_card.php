<?php
require '../config.php';

$id = $_GET['id'];

$response = array();

// Usunięcie rekordów z tabeli karta_dostepu_has_strefy_dostepu
$sql_delete_relation = "DELETE FROM karta_dostepu_has_strefy_dostepu WHERE Karta_Dostepu_id = ?";
$stmt_delete_relation = $conn->prepare($sql_delete_relation);
$stmt_delete_relation->bind_param("i", $id);

if ($stmt_delete_relation->execute()) {
    // Jeśli udało się usunąć powiązane rekordy, usuń rekord z tabeli karta_dostepu
    $sql_delete_card = "DELETE FROM karta_dostepu WHERE karta_dostepu_id = ?";
    $stmt_delete_card = $conn->prepare($sql_delete_card);
    $stmt_delete_card->bind_param("i", $id);

    if ($stmt_delete_card->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = 'Błąd podczas usuwania karty.';
    }

    $stmt_delete_card->close();
} else {
    $response['success'] = false;
    $response['message'] = 'Błąd podczas usuwania powiązań.';
}

echo json_encode($response);

$stmt_delete_relation->close();
$conn->close();
?>
