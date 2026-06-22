<?php
session_start();



if (empty($_SESSION['bid'])) {
            echo "Bitte melden Sie sich an!";
            die(" <a href=\"login.php\"> Zum Login</a>");
}else{

    if ($_SESSION["bid"] == 1) {

        require_once("dbVerbindung.php");
        
        $sql = "SELECT benutzer.vorname, benutzer.nachname, 
                reservierungen.einzelzimmer, reservierungen.doppelzimmer, 
                reservierungen.dreierzimmer, reservierungen.viererzimmer, 
                reservierungen.anreise, reservierungen.abreise, reservierungen.gesamtpreis, reservierungen.reservierungs_nummer 
            FROM reservierungen 
            INNER JOIN benutzer ON reservierungen.bid = benutzer.bid
            order by reservierungen.anreise desc";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $reservierungen = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else{

        require_once("dbVerbindung.php");

        $sql = "SELECT benutzer.vorname, benutzer.nachname, 
                    reservierungen.einzelzimmer, reservierungen.doppelzimmer, 
                    reservierungen.dreierzimmer, reservierungen.viererzimmer, 
                    reservierungen.anreise, reservierungen.abreise, reservierungen.gesamtpreis, reservierungen.reservierungs_nummer
                FROM reservierungen 
                INNER JOIN benutzer ON reservierungen.bid = benutzer.bid 
                WHERE reservierungen.bid = :bid
                order by reservierungen.anreise desc";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['bid' => $_SESSION["bid"]]);
        $reservierungen = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    
    
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservierungen</title>
    <link rel="stylesheet" href="style_reservierungen.css">
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
    <h1>Ihre Reservierung/en</h1>

    <table>
    <thead>
        <tr>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Einzelzimmer</th>
        <th>Doppelzimmer</th>
        <th>Dreierzimmer</th>
        <th>Viererzimmer</th>
        <th>Datum von</th>
        <th>Datum bis</th>
        <th>Preis</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservierungen as $row): ?>
        <tr>
            <td><?=($row["vorname"])?></td>
            <td><?=($row["nachname"])?></td>
            <td><?=($row["einzelzimmer"])?></td>
            <td><?=($row["doppelzimmer"])?></td>
            <td><?=($row["dreierzimmer"])?></td>
            <td><?=($row["viererzimmer"])?></td>
            <td><?=($row["anreise"])?></td>
            <td><?=($row["abreise"])?></td>
            <td><?=($row["gesamtpreis"]);?></td>
        </tr>
        <?php endforeach; ?>


    </tbody>
    </table>
</body>
</html>