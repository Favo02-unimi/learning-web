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
    $password = $_POST["password"];
    if (isset($_POST["isCliente"])) {
        $isCliente = false;
    }
    else {
        $isCliente = true;
    }

    if ($isCliente) {
        $sql = "SELECT id_cliente, username, password FROM clienti WHERE username = '$username' AND password = '$password';";
    }
    else {
        $sql = "SELECT id_proprietario, username, password FROM proprietari WHERE username = '$username' AND password = '$password';";
    }

    $result = $conn->query($sql);

    //login a buon fine
    if(!empty($result) && $result->num_rows > 0) { 
        unset($_SESSION["login_error"]); // togliere eventuali errori precedenti login
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
    //login sbagliato
    else {
        $_SESSION["login_error"] = "Username o password errati.";
        header('Location: index.php');
        exit();
    }
}


?>
