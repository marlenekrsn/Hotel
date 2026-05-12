<?php

    session_start();

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
    <link rel="stylesheet" href="style_warenkorb.css">
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
    <h1>Ihr Warenkorb</h1>

    <table>
    <thead>
        <tr>
        <th>Einzelzimmer</th>
        <th>Doppelzimmer</th>
        <th>Dreierzimmer</th>
        <th>Viererzimmer</th>
        <th>Anzahl</th>
        <th>Datum Von</th>
        <th>Datum Bis</th>
        <th>Preis</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td><?php echo $_SESSION['einzelzimmer']; ?></td>
        <td><?php echo $_SESSION['doppelzimmer']; ?></td>
        <td><?php echo $_SESSION['dreierzimmer']; ?></td>
        <td><?php echo $_SESSION['viererzimmer']; ?></td>
        <td>Daten 5</td>
        <td><?php echo $_SESSION['anreise']; ?></td>
        <td><?php echo $_SESSION['abreise']; ?></td>
        <td><?php echo $_SESSION['gesamtpreis']; ?></td>
        </tr>
    </tbody>
    </table>
    <br>

    <input type="submit" value="Buchen" id="buchen" name="buchen">
    
</body>
</html>