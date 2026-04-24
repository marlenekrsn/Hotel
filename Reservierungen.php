<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservierungen</title>
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
    (hier dann if, ob Hotelinhaber angemeldet, oder einfach Kunde)
    <h1>Ihre Reservierung/en</h1>

    <table>
    <thead>
        <tr>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Zimmer</th>
        <th>Datum</th>
        <th>Preis</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td>Daten 1</td>
        <td>Daten 2</td>
        <td>Daten 3</td>
        <td>Daten 4</td>
        <td>Daten 5</td>
        </tr>
    </tbody>
    </table>
</body>
</html>