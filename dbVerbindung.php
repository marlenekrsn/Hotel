<?php

$dsn = "mysql:host=localhost;dbname=hotelkamel;charset=utf8";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, 'root', '', $options);

} catch (PDOException $e) {
    echo $e->getMessage();
    die("FEHLER: Verbindung zur Datenbank konnte nicht hergestellt werden!");
}

?>