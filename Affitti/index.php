<!DOCTYPE html>
<html>
<link>
    <title>Login</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <script src="js.js"></script>

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
    ?>

    <header>
        <h1 id="titolo">Agenzia Affitti</h1>
    </header>

    <main>

        <button id="login" class="formToggler active" onclick="toggleLogin()">Login</button>
        <button id="registrazione" class="formToggler" onclick="toggleRegistazione()">Registrazione</button>
        
        <div id="loginForm" class="form">

            <?php
                //visualizza l'errore se esistente
                if (isset($_SESSION["login_error"])) {
                    echo "<script>toggleLogin()</script>";
                    echo "
                    <div id='errore'>
                    <h2>Login fallito:</h2>
                    <h4>". $_SESSION["login_error"] ."</h4>
                    </div>";
                }
            ?>           

            <form action="login.php" method="post">
                <label for="username">Username:</label> <br>
                <input type="text" name="username" id="username" class="input" placeholder="Username" pattern="^[a-zA-Z0-9]{4,20}$" required>
                <p class="info">Da 4 a 20 caratteri alfanumerici, nessun carattere speciale.</p>
                <label for="passsword">Password:</label> <br>
                <input type="password" name="password" id="password" class="input" placeholder="Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" required>
                <p class="info">Da 8 a 20 caratteri alfanumerici, almeno una maiuscola e una minuscola, un numero e un carattere speciale.</p>
                <div class="center">
                    <span id="cliente1" class="colorViola">Cliente</span>
                    <label class="switch" onclick="toggleCheckbox()">
                        <input type="checkbox" name="isCliente" id="checkbox1">
                        <span class="slider round"></span>
                    </label>
                    <span id="proprietario1">Proprietario</span>
                    <br>
                    <button type="submit" name="submit" class="submit">Login</button>
                </div>
            </form>
        </div>

        <div id="registrazioneForm" class="form hidden">

            <?php
                //visualizza l'errore se esistente
                if (isset($_SESSION["registration_error"])) {
                    echo "<script>toggleRegistazione()</script>";
                    echo "
                    <div id='errore'>
                    <h2>Registrazione fallita:</h2>
                    <h4>". $_SESSION["registration_error"] ."</h4>
                    </div>";
                }
            ?>    

            <form action="registrazione.php" method="post">
                <label for="username">Username:</label> <br>
                <input type="text" name="username"class="input" placeholder="Username" pattern="^[a-zA-Z0-9]{4,20}$" required>
                <p class="info">Da 4 a 20 caratteri alfanumerici, nessun carattere speciale.</p>

                <label for="nome">Nome:</label> <br>
                <input type="nome" name="nome" class="input" placeholder="Nome" pattern="^[a-zA-Z0-9 ]{4,20}$" required>
                <p class="info">Da 2 a 20 caratteri, solo lettere. Spazi ammessi.</p>

                <label for="cognome">Cognome:</label> <br>
                <input type="cognome" name="cognome"class="input" placeholder="Cognome" pattern="^[a-zA-Z0-9 ]{4,20}$" required>
                <p class="info">Da 2 a 20 caratteri, solo lettere. Spazi ammessi.</p>

                <label for="passsword">Password:</label> <br>
                <input type="password" name="password1"class="input" placeholder="Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" required>
                <p class="info">Da 8 a 20 caratteri alfanumerici, almeno una maiuscola e una minuscola, un numero e un carattere speciale.</p>

                <label for="passsword">Conferma password:</label> <br>
                <input type="password" name="password2" class="input" placeholder="Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" required>
                <p class="info">Da 8 a 20 caratteri alfanumerici, almeno una maiuscola e una minuscola, un numero e un carattere speciale.</p>

                <div class="center">
                    <span id="cliente2" class="colorViola">Cliente</span>
                    <label class="switch" onclick="toggleCheckbox()">
                        <input type="checkbox" name="isCliente" id="checkbox2">
                        <span class="slider round"></span>
                    </label>
                    <span id="proprietario2">Proprietario</span>
                    <br>
                    <button type="submit" name="submit" class="submit">Registrati</button>
                </div>
            </form>
        </div>

    </main>
    
</body>
</html>