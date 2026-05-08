<?php

    //session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $einzelzimmer =  trim($_POST["einzelzimmer"]);
        $doppelzimmer =  trim($_POST["doppelzimmer"]);
        $dreierzimmer =  trim($_POST["dreierzimmer"]);
        $viererzimmer =  trim($_POST["viererzimmer"]);
        $preiseinzel = 20;
        $preisdoppel = 30;
        $preisdreier = 40;
        $preisvierer = 50;
        $datumvon =  trim($_POST["datumvon"]);
        $datumbis =  trim($_POST["datumbis"]);
        //&& empty($datumvon) && empty($datumbis)

        if (empty($einzelzimmer) && empty($doppelzimmer) && empty($dreierzimmer) && empty($viererzimmer)) {
           echo "Bitte wählen Sie ein Zimmer aus!";
        }else if(empty($einzelzimmer)){
//!==
        }else{

            /*
                require_once('dbVerbindung.php');

                try {

                $sql = "INSERT INTO reservierungen(anreise, abreise, gesamtpreis, einzelzimmer, doppelzimmer, dreierzimmer, viererzimmer) VALUES (:anreise, :abreise, :gesamtpreis, :einzelzimmer, :doppelzimmer, :dreierzimmer, :viererzimmer)";
                $stmt = $pdo->prepare($sql);

                if ($stmt->execute(['anreise' => $datumvon, 'abreise' => $datumbis, 'gesamtpreis' => $gesamtpreis, 'einzelzimmer' => $einzelzimmer, 'doppelzimmer' => $doppelzimmer, 'dreierzimmer' => $dreierzimmer, 'viererzimmer' => $viererzimmer,])) {
                    //$message = "Reservierung erfolgreich <a href=\"reservierungen.php\">Zu Ihrer Reservierung</a>";
                    header("Location: reservierungen.php");

                }

            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { //Code für Dublicated Entry

                    $message = "Email ist bereits im System";

                } else {

                    $message = "Es ist ein Fehler beim Registrieren aufgetreten: " . $e->getMessage();

                }

            }
            */
        }
        


    }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angebote</title>
</head>
<nav>
    <form action="" method="post">
        <input type="submit" value="Zurück" id="zurueck" name="zurueck">
    </form>
    <?php
        if(isset($_POST["zurueck"])){
            header("location:Menue.php");
        }
    ?>
</nav>
<body>

    <h1>Angebote an Zimmer</h1>

    <form action="" method="POST">

        <b>Einzelzimmer</b>
        <br>
        Pro Nacht 20,- €
        <br>
        <label for="einzelzimmer">Einzelzimmer mit einem Einzelbett</label>
        <input type="number" id="einzelzimmer" name="einzelzimmer" max=10 min=0>
        <br><br>

        <b>Doppelzimmer</b>
        <br>
        Pro Nacht 30,- €
        <br>
        <label for="doppelzimmer">Doppelzimmer mit zwei Einzelbetten</label>
        <input type="number" id="doppelzimmer" name="doppelzimmer" max=10 min=0>
        <br><br>

        <b>Dreierzimmer</b>
        <br>
        Pro Nacht 40,- €
        <br>
        <label for="dreierzimmer">Dreierzimmer mit zwei Einzelbetten und einem Doppelbett</label>
        <input type="number" id="dreierzimmer" name="dreierzimmer" max=10 min=0>
        <br><br>

        <b>Viererzimmer</b>
        <br>
        Pro Nacht 50,- €
        <br>
        <label for="viererzimmer">Viererzimmer mit zwei Einzelbetten und einem Doppelbett</label>
        <input type="number" id="viererzimmer" name="viererzimmer" max=10 min=0>
        <br><br>

        <b>Zeitraum</b>
        <br>
        <label for="datumvon">Von Wann </label>
        <input type="date" id="datumvon" name="datumvon">
        <br>
        <label for="datumbis">Bis Wann</label>
        <input type="date" id="datumbis" name="datumbis">
        <br>
        wollen Sie hier bleiben?

        <br><br><br>

        <input type="submit" name="submit" id="submit" value="In den Warenkorb">

    </form>
    
</body>
</html>