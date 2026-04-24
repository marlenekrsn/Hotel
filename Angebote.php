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
        <label for="doppelzimmer1">Doppelzimmer mit Doppelbett</label>
        <input type="number" id="doppelzimmer1" name="doppelzimmer1" max=10 min=0>
        <br><br>

        <label for="doppelzimmer2">Doppelzimmer mit zwei Einzelbetten</label>
        <input type="number" id="doppelzimmer2" name="doppelzimmer2" max=10 min=0>
        <br><br>

        <b>Viererzimmer</b>
        <br>
        Pro Nacht 50,- €
        <br>
        <label for="viererzimmer1">Viererzimmer mit einem Doppelbett und zwei Einzelbetten</label>
        <input type="number" id="viererzimmer1" name="viererzimmer1" max=10 min=0>
        <br><br>

        <label for="viererzimmer2">Viererzimmer mit zwei Stockbetten</label>
        <input type="number" id="viererzimmer2" name="viererzimmer2" max=10 min=0>
        <br><br>

        <b>Gruppenzimmer</b>
        <br>
        Pro Nacht 70,- €
        <br>
        <label for="gruppenzimmer">Gruppenzimmer mit vier Stockbetten</label>
        <input type="number" id="viererzimmer2" name="viererzimmer2" max=10 min=0>
        <br><br><br>

        <input type="submit" name="submit" id="submit" value="In den Warenkorb">

    </form>
    
</body>
</html>