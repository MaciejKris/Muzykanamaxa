<?php
session_start();
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = $_POST["imie"];
    $nazwisko = $_POST["nazwisko"];
    $email = $_POST["email"];
    $haslo = $_POST["haslo"];
    $nazwa_uzytkownika = $_POST["nazwa_uzytkownika"];

    // Sprawdź, czy użytkownik o podanej nazwie już istnieje
    $check_user_sql = "SELECT * FROM uzytkownicy WHERE nazwa_uzytkownika='$nazwa_uzytkownika'";
    $check_user_result = $conn->query($check_user_sql);

    if ($check_user_result->num_rows > 0) {
        echo "Użytkownik o podanej nazwie już istnieje.";
    } else {
        // Dodaj nowego użytkownika do bazy danych
        $hashed_password = password_hash($haslo, PASSWORD_BCRYPT);
        $insert_user_sql = "INSERT INTO uzytkownicy (imie, nazwisko, email, haslo, nazwa_uzytkownika) VALUES ('$imie', '$nazwisko', '$email', '$hashed_password', '$nazwa_uzytkownika')";

        if ($conn->query($insert_user_sql) === TRUE) {
            echo "Rejestracja zakończona pomyślnie.";

            // Przekierowanie do strony logowania
            header("Location:Logowanie.html");
            exit(); // Ważne, aby przerwać dalsze wykonywanie skryptu
        } else {
            echo "Błąd podczas rejestracji: " . $conn->error;
        }
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
