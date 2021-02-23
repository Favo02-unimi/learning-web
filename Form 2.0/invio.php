<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invio dati</title>
    <link rel="stylesheet" href="css.css">

</head>
<body>
    <h1 style="width: 800px">Dati inseriti in FormSuperAccattivante.com</h1>
    <?php
        if (isset($_GET)) {
            $testo = $_GET["casellaDiTesto"];
            echo "Casella di testo: " . $testo . "<br>";
            if (isset($_GET["checkbox1"])) {
                $checkBox1 = $_GET["checkbox1"];
                echo "Chexckbox1: " . $checkBox1 . "<br>";
            }
            else {
                echo "Chexckbox1: non selezionato<br>";
            }
            if (isset($_GET["checkbox2"])) {
                $checkBox2 = $_GET["checkbox2"];
                echo "Chexckbox2: " . $checkBox2 . "<br>";
            }
            else {
                echo "Chexckbox2: non selezionato<br>";
            }
            $scelte = $_GET["scelte"];
            echo "Scelta: " . $scelte . "<br>";
            if (isset($_GET["radio1"])) {
                $radio1 = $_GET["radio1"];
                echo "Radio1: " . $radio1 . "<br>";
            }
            else {
                echo "Radio1: non selezionato<br>";
            }
            if (isset($_GET["radio2"])) {
                $radio2 = $_GET["radio2"];
                echo "Radio2: " . $radio2 . "<br>";
            }
            else {
                echo "Radio2: non selezionato<br>";
            }
            $textArea = $_GET["textArea"];
            echo "TextArea: " . $textArea . "<br>";
            if (isset($_GET["opzioni"])) {
                $opzioni = $_GET["opzioni"];
                echo "List box: " . $opzioni . "<br>";
            }
            else {
                echo "List box: nessuna selezione<br>";
            }
        }
    ?>
    
</body>
</html>