<html>
<body style="background-color:#808080;">

  <form>

  </form>

  <form action="" method="get">
    <input type="radio" id="select" name="azione" value="Select" checked="checked">
    <label for="select">Select (Viene applicato l'OR tra le tre condizioni)</label><br>

    <input type="radio" id="selectall" name="azione" value="SelectAll">
    <label for="selectAll">Select tutto (Non inserire alcuna condizione)</label><br>

    <input type="radio" id="insert" name="azione" value="Insert">
    <label for="insert">Insert (Non inserire l'id, verrà generato automaticamente)</label><br>

    <input type="radio" id="update" name="azione" value="Update">
    <label for="update">Update (Viene aggiornata la stazione all'id inserito con il nome e la provincia inseriti)</label><br>

    <input type="radio" id="delete" name="azione" value="Delete">
    <label for="delete">Delete (Viene cancellata tramite id, inserire solo l'id)</label><br>

    <br>
    <label for="provincia">ID:</label><br>
    <input type="text" name="id" placeholder="Inserire ID" /><br>

    <label for="provincia">Nome:</label><br>
    <input type="text" name="nome" placeholder="Inserire Nome" /><br>

    <label for="provincia">Provincia:</label><br>
    <input type="text" name="provincia" placeholder="Inserire Provincia" /><br>

    <br>
    <input type="submit" name="submit" />
  </form>

  <?php

    if ( isset( $_GET["submit"] ) ) {

      $azione = $_GET["azione"];

      if ($azione == "Select") {
        $id = $_GET["id"];
        $nome = $_GET["nome"];
        $provincia = strtoupper($_GET["provincia"]);

        if ($id == null OR $nome == null OR $provincia == null) {
          echo "Non sono stati inseriti tutti i campi necessari (id, nome, provincia)";
          return;
        }

        select($id, $nome, $provincia);
      }

      else if ($azione == "SelectAll") {
        selectAll();
      }

      else if ($azione == "Insert") {
        $nome = $_GET["nome"];
        $provincia = strtoupper($_GET["provincia"]);

        if ($nome == null OR $provincia == null) {
          echo "Non sono stati inseriti tutti i campi necessari (nome, provincia)";
          return;
        }

        insert($nome, $provincia);
      }

      else if ($azione == "Update") {
        $id = $_GET["id"];
        $nome = $_GET["nome"];
        $provincia = strtoupper($_GET["provincia"]);

        if ($id == null OR $nome == null OR $provincia == null) {
          echo "Non sono stati inseriti tutti i campi necessari (ID, nome, provincia)";
          return;
        }

        update($id, $nome, $provincia);
      }

      else if($azione == "Delete") {
        $id = $_GET["id"];

        if ($id == null) {
          echo "Non sono stati inseriti tutti i campi necessari (ID)";
          return;
        }

        delete($id);
      }

    }

    function select($id, $nome, $provincia) {
      $db = new SQLite3('DatabaseMeteo.sq3');
      $sql = "SELECT * FROM Stazioni WHERE IdStazione = $id OR NomeStazione = \"$nome\" OR Provincia = \"$provincia\";";
      $result = $db->query($sql);
      while ($row = $result->fetchArray(SQLITE3_ASSOC)){
        echo $row['IdStazione'] . ' - ' . $row['NomeStazione'] . ': ' . $row['Provincia'] . '<br/>';
      }
      unset($db);
    }

    function selectAll() {
      $db = new SQLite3('DatabaseMeteo.sq3');
      $sql = "SELECT * FROM Stazioni";
      $result = $db->query($sql);
      while ($row = $result->fetchArray(SQLITE3_ASSOC)){
        echo $row['IdStazione'] . ' - ' . $row['NomeStazione'] . ': ' . $row['Provincia'] . '<br/>';
      }
      unset($db);
    }

    function insert($nome, $provincia) {
      $db = new SQLite3('DatabaseMeteo.sq3');
      $sql = "INSERT INTO Stazioni(NomeStazione, Provincia) VALUES(\"$nome\", \"$provincia\");";
      $db->query($sql);
      echo "Inserito";
      unset($db);
    }

    function update($id, $nome, $provincia) {
      $db = new SQLite3('DatabaseMeteo.sq3');
      $sql = "UPDATE Stazioni SET NomeStazione = \"$nome\", Provincia = \"$provincia\" WHERE IdStazione = $id";
      $db->query($sql);
      echo "Aggiornato";
      unset($db);
    }

    function delete($id) {
      $db = new SQLite3('DatabaseMeteo.sq3');
      $sql = "DELETE FROM Stazioni WHERE IdStazione = $id";
      $db->query($sql);
      echo "Cancellato";
      unset($db);
    }

    ?>

</body>
</html>
