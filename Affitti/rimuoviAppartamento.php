<?php

session_start();

if (isset($_POST["submit"])) {
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "X2iNI3moDURdHQeK";
    $db_name = "affitti";
    
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $proprietario = $_SESSION["id"];
    $appartamento = $_POST["id"];

    //controllo che l'appartamento non abbia disponibilita
    $sql = "SELECT * FROM disponibilita WHERE id_appartamento = '$appartamento';";

    $result = $conn->query($sql);

    if(!empty($result) && $result->num_rows > 0) {
        $_SESSION["rimuoviAppartamento_error"] = "Esistono disponibilita su questo appartamento. Rimuoverle prima di cancellare l'appartamento.";
        header('Location: proprietario.php');
        exit();
    }

    //controllo che l'appartamento non abbia prenotazioni
    $sql = "SELECT * FROM prenotazioni WHERE id_appartamento = '$appartamento';";

    $result = $conn->query($sql);

    if(!empty($result) && $result->num_rows > 0) {
        $_SESSION["rimuoviAppartamento_error"] = "Esistono prenotazioni su questo appartamento. Impossibile rimuovere appartamento";
        header('Location: proprietario.php');
        exit();
    }

    //rimuovo appartamento dal db
    $query = "DELETE FROM appartamenti WHERE id_appartamento = '$appartamento';";

    if ($conn->query($query)) {
        unset($_SESSION["rimuoviAppartamento_error"]);
        header('Location: proprietario.php');
        exit();
    }

    else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }


}



?>