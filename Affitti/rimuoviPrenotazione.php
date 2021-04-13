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
    $prenotazione = $_POST["id"];

    //aggiungo la disponibilità dove c'era la prenotazione
    $sql = "SELECT id_prenotazione, id_appartamento, data_inizio, data_fine FROM prenotazioni WHERE id_prenotazione = '$prenotazione';";

    $result = $conn->query($sql);

    if (!empty($result) && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $appartamento = $row["id_appartamento"];
            $dataInizio = $row["data_inizio"];
            $dataFine = $row["data_fine"];
        }
    }

    $sql = "INSERT INTO disponibilita (id_disponibilita, id_appartamento, data_inizio, data_fine) VALUES (NULL, '$appartamento', '$dataInizio', '$dataFine');";

    if (!$conn->query($sql)) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //cancello la prenotazione
    $sql = "DELETE FROM prenotazioni WHERE id_prenotazione = '$prenotazione'";

    if ($conn->query($sql)) {
        header('Location: cliente.php');
        exit();
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


}



?>