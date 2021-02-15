<!DOCTYPE html>
<html>
<head>
    <title>Istituto scolastico</title>
</head>
<body>
    <style>
        body {
            text-align: center;
            background: gray;
        }
        table {
            border-collapse: collapse;
            margin: auto;
            margin-top: 20px;
        }
        tr {
            height: 30px;
        }
        td, th {
            text-align: center;
            border: 1px solid black;
            min-width: 60px;
        }
    </style>
    <form action="" method="get">
        <input type="radio" name="azione" id="visualizzaStudenti" value="visualizzaStudenti" checked="checked">
        <label for="visualizzaStudenti">Visualizza la lista degli studenti</label><br>

        <input type="radio" name="azione" id="visualizzaDocenti" value="visualizzaDocenti">
        <label for="visualizzaDocenti">Visualizza la lista dei docenti</label><br>

        <input type="radio" name="azione" id="visualizzaClassi" value="visualizzaClassi">
        <label for="visualizzaClassi">Visualizza la lista delle classi</label><br>
        
        <button type="submit" name="submit">Cerca</button>
    </form>




    <?php

    if ( isset( $_GET["submit"] ) ) {
        $azione = $_GET["azione"];
        
        if($azione == "visualizzaStudenti") {
            visualizzaStudenti();
        }
        if($azione == "visualizzaDocenti") {
            visualizzaDocenti();
        }
        if($azione == "visualizzaClassi") {
            visualizzaClassi();
        }
        
    }   


    function visualizzaStudenti() {
        $db = new SQLite3('IstitutoScolastico.sq3');
        $sql = "SELECT * FROM Studenti ORDER BY Cognome ASC;";
        $result = $db->query($sql);
        echo "<table>";
        echo
            "<tr>
                <th>ID Studente</td>
                <th>Nome</td>
                <th>Cognome</td>
                <th>Codice Fiscale</td>
                <th>Data di nascita</td>
                <th>Sesso (1=M)</td>
                <th>ID Classe</td>
            </tr>";
        while ($row = $result->fetchArray(SQLITE3_ASSOC)){ /* $row['StudenteID'] */
            echo
            "<tr>
                <td>" . $row['StudenteID'] . "</td>
                <td>" . $row['Nome'] . "</td>
                <td>" . $row['Cognome'] . "</td>
                <td>" . $row['CodiceFiscale'] . "</td>
                <td>" . $row['DataDiNascita'] . "</td>
                <td>" . $row['Sesso'] . "</td>
                <td>" . $row['ClasseID'] . "</td>
            </tr>";
        }
        echo "</table>";
        unset($db);
    }

    function visualizzaDocenti() {
        $db = new SQLite3('IstitutoScolastico.sq3');
        $sql = "SELECT * FROM Docenti ORDER BY Cognome ASC;";
        $result = $db->query($sql);
        echo "<table>";
        echo
            "<tr>
                <th>ID Docente</td>
                <th>Nome</td>
                <th>Cognome</td>
                <th>Codice Fiscale</td>
                <th>Sesso (1=M)</td>
                <th>Classe di Concorso</td>
            </tr>";
        while ($row = $result->fetchArray(SQLITE3_ASSOC)){ /* $row['StudenteID'] */
            echo
            "<tr>
                <td>" . $row['DocenteID'] . "</td>
                <td>" . $row['Nome'] . "</td>
                <td>" . $row['Cognome'] . "</td>
                <td>" . $row['CodiceFiscale'] . "</td>
                <td>" . $row['Sesso'] . "</td>
                <td>" . $row['ClasseDiConcorso'] . "</td>
            </tr>";
        }
        echo "</table>";
        unset($db);
    }

    function visualizzaClassi() {
        $db = new SQLite3('IstitutoScolastico.sq3');
        $sql = "SELECT * FROM Classi";
        $result = $db->query($sql);
        echo "<table>";
        echo
            "<tr>
                <th>ID Classe</td>
                <th>Anno</td>
                <th>Sezione</td>
                <th>Indirizzo</td>
                <th>Coordinatore (ID)</td>
                <th>Consiglio (ID)</td>
            </tr>";
        while ($row = $result->fetchArray(SQLITE3_ASSOC)){ /* $row['StudenteID'] */
            echo
            "<tr>
                <td>" . $row['ClasseID'] . "</td>
                <td>" . $row['Anno'] . "</td>
                <td>" . $row['Sezione'] . "</td>
                <td>" . $row['Indirizzo'] . "</td>
                <td>" . $row['CoordinatoreID'] . "</td>
                <td>" . $row['ConsiglioID'] . "</td>
            </tr>";
        }
        echo "</table>";
        unset($db);
    }
    ?>

</body>
</html>