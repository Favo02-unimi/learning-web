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
    $indirizzo = $_POST["indirizzo"];
    $citta = $_POST["citta"];
    $mq = $_POST["mq"];
    $locali = $_POST["locali"];
    $postiLetto = $_POST["postiLetto"];
    $descrizione = $_POST["descrizione"];

    //inserisco nel db l'appartamento
    $sql = "INSERT INTO appartamenti (id_appartamento, id_proprietario, indirizzo, citta, mq, locali, posti_letto, descrizione) VALUES (NULL, '$proprietario', '$indirizzo', '$citta', '$mq', '$locali', '$postiLetto', '$descrizione')";

    if ($conn->query($sql)) {
        header('Location: proprietario.php');
        exit();
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}


?>