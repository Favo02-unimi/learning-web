<!DOCTYPE html>
<html>
<head>
    <title>Agenzia Affitti</title>
    <link rel="stylesheet" href="css.css">

</head>
<body>
    <script src="js.js"></script>

    <?php
        //controllo se esiste il login e se è l'utente corretto
        session_start();
        if (!$_SESSION["logged_in"]) {
            header('Location: index.php');
            exit();
        }
        else if ($_SESSION["isCliente"]) {
            header('Location: cliente.php');
            exit();
        }
    ?>
    <header>
        <h1 id="titolo">Agenzia Affitti</h1>
        <?php
            echo "<h4 id='profile'>". "Benvenuto " . $_SESSION["username"] . " - Proprietario ID: " . $_SESSION["id"] . "</h4>";
        ?>
        <a href='logout.php'><h4 id='logout'>Logout</h4></a>
    </header>
    <main>
        <h2>I tuoi appartamenti:</h2>
        
        <?php
            //connessione db
            $db_servername = "localhost";
            $db_username = "root";
            $db_password = "X2iNI3moDURdHQeK";
            $db_name = "affitti";

            $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            //visualizzo tutti gli appartamenti del proprietario
            $sql = "SELECT * FROM appartamenti WHERE id_proprietario =". $_SESSION['id'] . ";";
            $result = $conn->query($sql);

            if (!empty($result) && $result->num_rows > 0) {
                echo "
                    <table>
                        <tr>
                            <th colspan='2'>ID Appartamento</th>
                            <th>Indirizzo</th>
                            <th>Città</th>
                            <th>Mq</th>
                            <th>Locali</th>
                            <th>Posti letto</th>
                            <th>Descrizione</th>
                        </tr>
                ";
                echo "<form>";
                while($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>
                                <input type='radio' name='radio' onclick='changeToggled(" . $row["id_appartamento"] . ")' required>
                            </td>
                            <td>" . $row["id_appartamento"] . "</td>
                            <td>" . $row["indirizzo"] . "</td>
                            <td>" . $row["citta"] . "</td>
                            <td>" . $row["mq"] . "</td>
                            <td>" . $row["locali"] . "</td>
                            <td>" . $row["posti_letto"] . "</td>
                            <td>" . $row["descrizione"] . "</td>
                        </tr>
                    ";

                    //visualizzo tutte le disponibilità per ogni appartamento del proprietario
                    $sql = "SELECT * FROM disponibilita WHERE id_appartamento =". $row["id_appartamento"] . ";";
                    $result2 = $conn->query($sql);

                    if (!empty($result) && $result->num_rows > 0) {
                        echo "<form>";
                        while($row2 = $result2->fetch_assoc()) {
                            echo "
                            <tr>
                                <td></td>
                                <td>
                                    <input type='radio' name='radio' onclick='changeToggledDisponibilita(" . $row2["id_disponibilita"] . ")' required>
                                </td>
                                <td class='disponibilitaAppartamento' colspan='6'>
                                Disponibile dal " . $row2["data_inizio"] . " al " . $row2["data_fine"] . "
                                </td>
                            </tr>
                            ";
                        }
                        echo "</form>";
                    }
                }
                echo "</form></table>";
            }
            else {
                echo "Non hai appartamenti registrati.<br>";
            }
        ?>

        <button onclick="toggleAggiungiAppartamento()">Aggiungi appartamento</button>

        <button onclick="toggleRimuoviAppartamento()">Rimuovi appartamento</button>

        <br>

        <button onclick="toggleDisponibilita()">Aggiungi disponibilità appartamento</button>

        <button onclick="toggleRimuoviDisponibilita()">Rimuovi disponibilità appartamento</button>

        <h2 class="hidden" id="aggiungiAppartamentoTitolo">Aggiungi appartamento:</h2>
        <form action="aggiungiAppartamento.php" method="POST" class="form appartamento hidden" id="aggiungiAppartamentoForm">
            <label for="indirizzo">Indirizzo:</label> <br>
            <input type="text" name="indirizzo" class="input" placeholder="Indirizzo" required>
            <p class="info">Da 4 a 20 caratteri alfanumerici, nessun carattere speciale.</p>

            <label for="citta">Città:</label> <br>
            <input type="text" name="citta" class="input" placeholder="Città" required>
            <p class="info">Da 4 a 20 caratteri alfanumerici, nessun carattere speciale.</p>

            <label for="mq">Metri quadri:</label> <br>
            <input type="number" name="mq" class="input" placeholder="Mq" required>
            <p class="info">Numero intero.</p>

            <label for="locali">Locali:</label> <br>
            <input type="number" name="locali" class="input" placeholder="Locali" required>
            <p class="info">Numero intero,escudere bagno e cucina.</p>

            <label for="postiLetto">Posti letto:</label> <br>
            <input type="number" name="postiLetto" class="input" placeholder="Posti letto" required>
            <p class="info">Numero intero.</p>

            <label for="descrizione">Descrizione:</label> <br>
            <input type="textarea" name="descrizione" class="input" placeholder="Descrizione" required>
            <p class="info">Breve descrizione dell'appartamento.</p>

            <div class="center">
                <button type="submit" name="submit" class="submit">Aggiungi</button>
            </div>
        </form>

        <h2 class="hidden" id="aggiungiDisponibilitaTitolo">Aggiungi disponibilità appartamento:</h2>
        <form action="aggiungiDisponibilita.php" method="POST" class="form appartamento hidden" id="aggiungiDisponibilitaForm">

            <?php
                //visualizza l'errore se esiste
                if (isset($_SESSION["disponibilita_error"])) {
                    echo "<script>toggleDisponibilita()</script>";
                    echo "
                    <div id='errore'>
                    <h2>Errore:</h2>
                    <h4>". $_SESSION["disponibilita_error"] ."</h4>
                    </div>";
                }
            ?> 

            <label for="id">ID appartamento selezionato:</label> <br>
            <input type="number" name="id" class="input" placeholder="ID" id="id" required readonly>
            <p class="info">Appartamento selezionato dal radio button.</p>

            <label for="dataInizio">Data inizio disponibilità:</label>
            <input type="date" name="dataInizio" class="inputData" required>

            <br>

            <label for="dataFine">Data fine disponibilità:</label>
            <input type="date" name="dataFine" class="inputData" required>

            <div class="center">
                <button type="submit" name="submit" class="submit">Aggiungi</button>
            </div>
        </form>

        <h2 class="hidden" id="rimuoviAppartamentoTitolo">Rimuovi appartamento:</h2>
        <form action="rimuoviAppartamento.php" method="POST" class="form appartamento hidden" id="rimuoviAppartamentoForm">

            <?php
                //visualizza l'errore se esiste
                if (isset($_SESSION["rimuoviAppartamento_error"])) {
                    echo "<script>toggleRimuoviAppartamento()</script>";
                    echo "
                    <div id='errore'>
                    <h2>Errore:</h2>
                    <h4>". $_SESSION["rimuoviAppartamento_error"] ."</h4>
                    </div>";
                }
            ?> 

            <label for="id">ID appartamento da rimuovere:</label> <br>
            <input type="number" name="id" class="input" placeholder="ID" id="id2" required readonly>
            <p class="info">Appartamento selezionato dal radio button.</p>

            <div class="center">
                <button type="submit" name="submit" class="submit">Rimuovi</button>
            </div>
        </form>

        <h2 class="hidden" id="rimuoviDisponibilitaTitolo">Rimuovi disponibilità appartamento:</h2>
        <form action="rimuoviDisponibilita.php" method="POST" class="form appartamento hidden" id="rimuoviDisponibilitaForm">

            <label for="id">ID disponibilità da rimuovere:</label> <br>
            <input type="number" name="id" class="input" placeholder="ID" id="idDisponibilita" required readonly>
            <p class="info">Disponibilità selezionata dal radio button.</p>

            <div class="center">
                <button type="submit" name="submit" class="submit">Rimuovi</button>
            </div>
        </form>

        <h2>Le prenotazioni suoi tuoi appartamenti:</h2>
        
        <?php

            $db_servername = "localhost";
            $db_username = "root";
            $db_password = "X2iNI3moDURdHQeK";
            $db_name = "affitti";

            $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            //seleziono tutte le prenotazioni sugli appartamenti del proprietario
            $sql = "
            SELECT id_prenotazione, prenotazioni.id_appartamento, data_inizio, data_fine, indirizzo, citta FROM prenotazioni
            INNER JOIN appartamenti ON appartamenti.id_appartamento = prenotazioni.id_appartamento
            WHERE appartamenti.id_proprietario = ". $_SESSION['id'] . ";
            ";
            $result = $conn->query($sql);

            //visualizzo le prenotazioni in una tabella
            if (!empty($result) && $result->num_rows > 0) {
                echo "
                    <table>
                        <tr>
                            <th>ID Appartamento</th>
                            <th>Indirizzo</th>
                            <th>Città</th>
                            <th>Data inizio</th>
                            <th>Data fine</th>
                        </tr>
                ";
                while($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>" . $row["id_appartamento"] . "</td>
                            <td>" . $row["indirizzo"] . "</td>
                            <td>" . $row["citta"] . "</td>
                            <td>" . $row["data_inizio"] . "</td>
                            <td>" . $row["data_fine"] . "</td>
                        </tr>
                    ";
                }
                echo "</table>";
            }
            else {
                echo "Non hai prenotazioni suoi tuoi appartamenti.<br>";
            }

        ?>

        

    </main>

</body>
</html>