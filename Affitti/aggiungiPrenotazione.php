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

    $cliente = $_SESSION["id"];
    $appartamento = $_POST["id"];
    $dataInizio = $_POST["dataInizio"];
    $dataFine = $_POST["dataFine"];

    //controllo che le date non siano impossibili
    if (!$dataFine > $dataInizio) {
        $_SESSION["prenotazione_error"] = "La data di fine non può essere prima della data di inizio";
        header('Location: cliente.php');
        exit();
    }

    //controllo che l'appartamento sia disponibile nella data fornita
    $sql = "SELECT id_disponibilita, data_inizio, data_fine FROM disponibilita WHERE id_appartamento = '$appartamento' and '$dataInizio' >= data_inizio and '$dataFine' <= data_fine;";

    $result = $conn->query($sql);

    if(empty($result) || $result->num_rows == 0) {
        $_SESSION["prenotazione_error"] = "L'appartamento non è disponibile in questa data";
        header('Location: cliente.php');
        exit();
    }
    
    //tolgo la disponibilità dall'appartamento dividendo in due disponibilità diverse (prima e dopo)
    while($row = $result->fetch_assoc()) {
        $idVecchia = $row["id_disponibilita"];
        $dataInizioVecchia = $row["data_inizio"];
        $dataFineVecchia = $row["data_fine"];
    }

    //cancello la disp vecchia
    $sql = "DELETE FROM disponibilita WHERE id_disponibilita = '$idVecchia';";
    $conn->query($sql);

    //creo le due metà nuove
    if($dataInizio > $dataInizioVecchia) { //controllo che le due date non siano uguali, altrimenti non serve la parte prima
        $dataFineNuova = date('Y-m-d',(strtotime ('-1 day', strtotime ($dataInizio))));
        $sql = "INSERT INTO disponibilita (id_disponibilita, id_appartamento, data_inizio, data_fine) VALUES (NULL, '$appartamento', '$dataInizioVecchia', '$dataFineNuova')";
        $conn->query($sql);
    }
    if($dataFine < $dataFineVecchia) { //controllo che le due date non siano uguali, altrimenti non serve la parte dopo
        $dataInizioNuova = date('Y-m-d',(strtotime ('+1 day', strtotime ($dataFine))));
        $sql = "INSERT INTO disponibilita (id_disponibilita, id_appartamento, data_inizio, data_fine) VALUES (NULL, '$appartamento', '$dataInizioNuova', '$dataFineVecchia')";
        $conn->query($sql);
    }

    //aggiungo la prenotazione nel db
    $sql = "INSERT INTO prenotazioni (id_prenotazione, id_cliente, id_appartamento, data_inizio, data_fine) VALUES (NULL, '$cliente', '$appartamento', '$dataInizio', '$dataFine')";

    if ($conn->query($sql)) {
        unset($_SESSION["prenotazione_error"]);
        header('Location: cliente.php');
        exit();
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    



}


?>