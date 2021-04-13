<!DOCTYPE html>
<html>
<head>
    <title>Agenzia Affitti</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <script src="js.js"></script>

    <?php
        //controlla che esista il login e che sia cliente
        session_start();
        if (!$_SESSION["logged_in"]) {
            header('Location: index.php');
            exit();
        }
        else if (!$_SESSION["isCliente"]) {
            header('Location: proprietario.php');
            exit();
        }
    ?>
    <header>
        <h1 id="titolo">Agenzia Affitti</h1>
        <?php
            echo "<h4 id='profile'>". "Benvenuto " . $_SESSION["username"] . " - Cliente ID: " . $_SESSION["id"] . "</h4>";
        ?>
        <a href='logout.php'><h4 id='logout'>Logout</h4></a>
    </header>
    <main>

        <h2>Appartamenti disponibili:</h2>
        
        <?php
            //connessione al db
            $db_servername = "localhost";
            $db_username = "root";
            $db_password = "X2iNI3moDURdHQeK";
            $db_name = "affitti";

            $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM appartamenti;";
            $result = $conn->query($sql);
            
            //se esistono appartamenti
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
                //crea tabella degli appartamenti
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
                    
                    //cerca disponibilità per ogni appartamento
                    $sql = "SELECT * FROM disponibilita WHERE id_appartamento =". $row["id_appartamento"] . ";";
                    $result2 = $conn->query($sql);

                    if (!empty($result) && $result->num_rows > 0) {
                        //crea tabella deglle disponibilità
                        while($row2 = $result2->fetch_assoc()) {
                            echo "
                            <tr>
                                <td class='disponibilitaAppartamento' colspan='8'>
                                Disponibile dal " . $row2["data_inizio"] . " al " . $row2["data_fine"] . "
                                </td>
                            </tr>
                            ";
                        }
                    }
                }
                echo "</form></table>";
            }
            else {
                echo "Non sono presenti appartamenti disponibili.<br>";
            }
        ?>

        <h2>Le tue prenotazioni:</h2>
        
        <?php

            $db_servername = "localhost";
            $db_username = "root";
            $db_password = "X2iNI3moDURdHQeK";
            $db_name = "affitti";

            $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            //seleziono tutte le prenotazioni e relativi dati dell'appartamento
            $sql = "
            SELECT id_prenotazione, prenotazioni.id_appartamento, data_inizio, data_fine, indirizzo, citta FROM prenotazioni
            INNER JOIN appartamenti ON appartamenti.id_appartamento = prenotazioni.id_appartamento
            WHERE prenotazioni.id_cliente = ". $_SESSION['id'] . ";
            ;";
            $result = $conn->query($sql);

            //visualizzo i dati di ogni prenotazione in una tabella
            if (!empty($result) && $result->num_rows > 0) {
                echo "
                    <table>
                        <tr>
                            <th colspan='2'>ID Prenotazione</th>
                            <th>Indirizzo</th>
                            <th>Citta</th>
                            <th>Data inizio</th>
                            <th>Data fine</th>
                        </tr>
                ";
                while($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>
                                <input type='radio' name='radio' onclick='changeToggledPrenotazione(" . $row["id_prenotazione"] . ")' required>
                            </td>
                            <td>" . $row["id_prenotazione"] . "</td>
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
                echo "Non hai prenotazioni effettuate.<br>";
            }

        ?>

        <button onclick="toggleAggiungiPrenotazione()">Aggiungi prenotazione</button>

        <button onclick="toggleRimuoviPrenotazione()">Rimuovi prenotazione</button>

        <h2 class="hidden" id="aggiungiPrenotazioneTitolo">Aggiungi prenotazione:</h2>
        <form action="aggiungiPrenotazione.php" method="POST" class="form appartamento hidden" id="aggiungiPrenotazioneForm">
            
            <?php
                //visualizza l'errore se esistente
                if (isset($_SESSION["prenotazione_error"])) {
                    echo "<script>toggleAggiungiPrenotazione()</script>";
                    echo "
                    <div id='errore'>
                    <h2>Errore:</h2>
                    <h4>". $_SESSION["prenotazione_error"] ."</h4>
                    </div>";
                }
            ?>

            <label for="id">ID appartamento selezionato:</label> <br>
            <input type="number" name="id" class="input" placeholder="ID" id="id" required readonly>
            <p class="info">Appartamento selezionato dal radio button.</p>

            <label for="dataInizio">Data inizio prenotazione:</label>
            <input type="date" name="dataInizio" class="inputData" required>

            <br>

            <label for="dataFine">Data fine prenotazione:</label>
            <input type="date" name="dataFine" class="inputData" required>

            <div class="center">
                <button type="submit" name="submit" class="submit">Aggiungi</button>
            </div>
        </form>

        <h2 class="hidden" id="rimuoviPrenotazioneTitolo">Rimuovi prenotazione:</h2>
        <form action="rimuoviPrenotazione.php" method="POST" class="form appartamento hidden" id="rimuoviPrenotazioneForm">

            <label for="id">ID prenotazione selezionato:</label> <br>
            <input type="number" name="id" class="input" placeholder="ID" id="idPrenotazione" required readonly>
            <p class="info">Prenotazione selezionato dal radio button.</p>

            <div class="center">
                <button type="submit" name="submit" class="submit">Rimuovi</button>
            </div>
        </form>

    </main>

</body>
</html>