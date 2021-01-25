<!DOCTYPE html>
<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;700&display=swap" rel="stylesheet">
    <title>Login effettuato</title>
  </head>
  <style>
    body {
      background: #888;
      font-family: 'Roboto', sans-serif;
      text-align: center;
    }
  </style>
  <body>

    <?php
      error_reporting(E_ALL);
      $nome = $_GET["nome"];
      if (!controllaPattern($nome, "^[a-zA-Z\s]{2,}$")) {
        echo "Nome in formato errato";
      }
      else {
        echo "Nome: ${nome}";
      }
      $cognome = $_GET["cognome"];
      if (!controllaPattern($cognome, "^[a-zA-Z\s]{2,}$")) {
        echo "Cognome in formato errato";
      }
      else {
        echo "Cognome: ${cognome}";
      }
      $password1 = $_GET["password1"];
      $password2 = $_GET["password2"];
      if (!controllaPattern($password1, "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$"
      && !controllaPattern($password2, "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$"
      && !($password1 === $password2)))) {
        echo "Password in formato errato o diverse";
      }
      else {
        echo "Password: ${password1}";
      }
      $email = $_GET["email"];
      if (!controllaPattern($email, "^[\w\d._-]+@[\w.]+\.[\w]{2,}$")) {
        echo "Email in formato errato";
      }
      else {
        echo "Email: ${email}";
      }
      $telefono = $_GET["telefono"];
      if (!controllaPattern($email, "^[0-9]{2,3}\s[0-9]{7}$")) {
        echo "Telefono in formato errato";
      }
      else {
        echo "Telefono: ${telefono}";
      }

      function controllaPattern($elemento, $pattern) {
        if (!preg_match($pattern, $elemento)) {
            return true;
        } else {
            return false;
        }
      }

      ?>

    <h1>Login effettuato, complimenti!</h1>
    <h3>Ora puoi sfruttare al meglio i servizi del nostro sito</h3>
    <p id="nomeP"></p>
    <p id="cognomeP"></p>
    <p id="pswP"></p>
    <p id="emailP"></p>
    <p id="telefonoP"></p>
  </body>
</html>
