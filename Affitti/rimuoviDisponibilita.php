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
    $disponibilita = $_POST["id"];

    //controllo che l'appartamento sia del proprietario anche se non dovrebbe essere possibile aggirare i radio button
    $sql = "DELETE FROM disponibilita WHERE id_disponibilita = '$disponibilita'";

    if ($conn->query($sql)) {
        header('Location: proprietario.php');
        exit();
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


}



?>