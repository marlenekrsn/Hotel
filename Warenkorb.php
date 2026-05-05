<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
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
    <h1>Ihre Warenkorb</h1>

    <table>
    <thead>
        <tr>
        <th>Zimmer</th>
        <th>Personen</th>
        <th>Datum Von</th>
        <th>Datum Bis</th>
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
    <br>

    <input type="submit" value="Buchen" id="buchen" name="buchen">
    
</body>
</html>