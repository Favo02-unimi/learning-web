<?php

//controllo se c'è già login
session_start();
if (isset($_SESSION["logged_in"]) and $_SESSION["logged_in"]) {
    if ($_SESSION["isCliente"]) {
        header('Location: cliente.php');
        exit();
    }
    else {
        header('Location: proprietario.php');
        exit();
    }
}

//restituzione dell'errore al  index.php
function registration_fail($error) {
    session_start();
    $_SESSION["registration_error"] = $error;
    header('Location: index.php');
    exit();
}

if (isset($_POST["submit"])) {
    //connessione al db
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "X2iNI3moDURdHQeK";
    $db_name = "affitti";
    
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $username = $_POST["username"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    if (isset($_POST["isCliente"])) {
        $isCliente = false;
    }
    else {
        $isCliente = true;
    }

    if (empty($username)) {
        registration_fail("L'username è un campo obbligatorio");
    }
    if (empty($password1)) {
        registration_fail("La password è un campo obbligatorio");
    }
    if (empty($password2)) {
        registration_fail("La conferma password è un campo obbligatorio");
    }
    if ($password1 != $password2) {
        registration_fail("Le password non corrispondono");
    }
    if (empty($nome)) {
        registration_fail("Il nome è un campo obbligatorio");
    }
    if (empty($cognome)) {
        registration_fail("Il cognome è un campo obbligatorio");
    }
    
    //controllo se l'username esiste già
    if ($isCliente == true) {
        $alreadyExistsQuery = "SELECT * FROM clienti WHERE username='$username' LIMIT 1";
    }
    else {
        $alreadyExistsQuery = "SELECT * FROM proprietari WHERE username='$username' LIMIT 1";
    }

    $result = $conn->query($alreadyExistsQuery);
 
    if (!empty($result) && $result->num_rows > 0) {    
        registration_fail("L'username esiste già");
    }
    

    //registrazione a buon fine
    unset($_SESSION["registration_error"]); //togliere eventuali precedenti registrazioni fallite
    if ($isCliente) {
        $query = "INSERT INTO clienti (id_cliente, username, nome, cognome, password) VALUES (NULL, '$username', '$nome', '$cognome', '$password1');";
    }
    else {
        $query = "INSERT INTO proprietari (id_proprietario, username, nome, cognome, password) VALUES (NULL, '$username', '$nome', '$cognome', '$password1');";
    }
    if ($conn->query($query)) {
        if ($isCliente) {
            $sql = "SELECT id_cliente, username, password FROM clienti WHERE username = '$username' AND password = '$password1';";
        }
        else {
            $sql = "SELECT id_proprietario, username, password FROM proprietari WHERE username = '$username' AND password = '$password1';";
        }

        $result = $conn->query($sql);

        //login per non ripetere il login dopo la registrazione
        if(!empty($result) && $result->num_rows > 0) { 
            $_SESSION["logged_in"] = true; 
            $_SESSION["username"] = $username;
            if (isset($_POST["isCliente"])) {
                $_SESSION["isCliente"] = false;
                while($row = $result->fetch_assoc()) {
                    $_SESSION["id"] = $row["id_proprietario"];
                }
                header('Location: proprietario.php');
                exit();
            }
            else {
                $_SESSION["isCliente"] = true;
                while($row = $result->fetch_assoc()) {
                    $_SESSION["id"] = $row["id_cliente"];
                }
                header('Location: cliente.php');
                exit();
            }
        }
    }
    else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    

}


?>