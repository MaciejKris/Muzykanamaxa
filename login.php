<?php
session_start();
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwa_uzytkownika = $_POST["nazwa_uzytkownika"];
    $haslo = $_POST["haslo"];

    // Pobierz zahashowane hasło z bazy danych dla danego użytkownika
    $sql = "SELECT id, haslo FROM uzytkownicy WHERE nazwa_uzytkownika='$nazwa_uzytkownika'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["haslo"];

        // Sprawdź zgodność hasła za pomocą password_verify
        if (password_verify($haslo, $hashed_password)) {
            // Zalogowano pomyślnie
            $_SESSION["user_id"] = $row["id"];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Nieprawidłowa nazwa użytkownika lub hasło.";
        }
    } else {
        echo "Nieprawidłowa nazwa użytkownika lub hasło.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Stronagłówna.css">
    <title>Sklep Muzyczny</title>
</head>
<body>
</body>
</html>