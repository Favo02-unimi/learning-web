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
    $dataInizio = $_POST["dataInizio"];
    $dataFine = $_POST["dataFine"];

    //controllo che l'appartamento sia del proprietario anche se non dovrebbe essere possibile aggirare i radio button
    $sql = "SELECT id_proprietario, id_appartamento FROM appartamenti WHERE id_proprietario = '$proprietario';";

    $result = $conn->query($sql);

    $trovato = false;
    if(!empty($result) && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($row["id_appartamento"] == $appartamento) {
                $trovato = true;
            }
        }
    }

    //errore che l'appartamento selezionato non esiste, non necessario
    if (!$trovato) {
        $_SESSION["disponibilita_error"] = "Non possiedi l'appartamento selezionato";
        header('Location: proprietario.php');
        exit();
    }

    //controllo che le date non siano impossibili
    if (!$dataFine > $dataInizio) {
        $_SESSION["disponibilita_error"] = "La data di fine non può essere prima della data di inizio";
        header('Location: proprietario.php');
        exit();
    }

    //controllo che non esista nessun'altra disponibilità nelle stesse date
    $sql = "SELECT data_inizio, data_fine FROM disponibilita WHERE id_appartamento = '$appartamento' and '$dataInizio' < data_fine and '$dataFine' > data_inizio;";

    $result = $conn->query($sql);

    if(!empty($result) && $result->num_rows > 0) {
        $_SESSION["disponibilita_error"] = "Questa disponibilità si accavalla con un'altra già esistente";
        header('Location: proprietario.php');
        exit();
    }

    //controllo che non esista nessuna prenotazione nelle stesse date
    $sql = "SELECT data_inizio, data_fine FROM prenotazioni WHERE id_appartamento = '$appartamento' and '$dataInizio' < data_fine and '$dataFine' > data_inizio;";

    $result = $conn->query($sql);

    if(!empty($result) && $result->num_rows > 0) {
        $_SESSION["disponibilita_error"] = "Questa disponibilità si accavalla con una prenotazione già esistente";
        header('Location: proprietario.php');
        exit();
    }

    //aggiungo la disponibilità nel db
    $query = "INSERT INTO disponibilita (id_disponibilita, id_appartamento, data_inizio, data_fine) VALUES (NULL, '$appartamento', '$dataInizio', '$dataFine')";

    if ($conn->query($query)) {
        unset($_SESSION["disponibilita_error"]);
        header('Location: proprietario.php');
        exit();
    }

    else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }


}



?>