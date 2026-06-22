<?php
// 1. Puffer aktivieren gegen unsichtbare Zeichen aus der DB-Datei
ob_start();

session_start();

// 2. Schutz: Wenn nicht eingeloggt, direkt zum Login umleiten
if (empty($_SESSION['bid'])) {
    header("Location: Login.php");
    exit;
}

// 3. Prüfen: Wenn keine Rechnungsnummer da ist, zurück zum Menü
if (empty($_GET['rechnungs_nummer'])) {
    header("Location: Menue.php");
    exit;
}

// FPDF und DB einbinden
define('FPDF_FONTPATH', dirname(__FILE__) . '/font/font/');
require('fpdf.php');
require_once('dbVerbindung.php');

$req_rechnungs_nummer = $_GET['rechnungs_nummer'];

// 4. DATEN HOLEN
$sql = "SELECT r.*, b.vorname, b.nachname, b.strasse, b.plz, b.ort 
        FROM reservierungen r
        INNER JOIN benutzer b ON r.bid = b.bid
        WHERE r.rechnungs_nummer = :rechnungs_nummer";

$stmt = $pdo->prepare($sql);
$stmt->execute(['rechnungs_nummer' => $req_rechnungs_nummer]);
$daten = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$daten) {
    ob_end_clean();
    die("Rechnung nicht gefunden.");
}

if ($_SESSION['bid'] != 1 && $_SESSION['bid'] != $daten['bid']) {
    ob_end_clean();
    die("Zugriff verweigert.");
}

// Daten vorbereiten
$rechnungs_nummer = $daten['rechnungs_nummer'];
$rechnungs_datum = date("d.m.Y");
$kunde_name = $daten['vorname'] . " " . $daten['nachname'];
$kunde_strasse = $daten['strasse'];
$kunde_ort = $daten['plz'] . " " . $daten['ort'];

$anreise = date("d.m.Y", strtotime($daten['anreise']));
$abreise = date("d.m.Y", strtotime($daten['abreise']));

$start = new DateTime($daten['anreise']);
$end = new DateTime($daten['abreise']);
$naechte = (int)$start->diff($end)->days;

$gesamt_brutto = $daten['gesamtpreis'];
$mwst_satz = 10; 
$gesamt_netto = $gesamt_brutto / (1 + ($mwst_satz / 100));
$mwst_betrag = $gesamt_brutto - $gesamt_netto;


// 5. PDF-KLASSE DEFINIEREN
class PDF extends FPDF {
    function Header() {
        // Wir nutzen 'Courier' mit 'B' (Bold) – Courier benötigt NIEMALS externe Dateien!
        $this->SetFont('Courier', 'B', 15); 
        $this->Cell(80);
        $this->Cell(30, 10, utf8_decode('Hotel Kamel'), 0, 0, 'C');
        $this->Ln(20);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Courier', 'I', 8); 
        $this->Cell(0, 10, 'Seite ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// 6. PDF GENERIEREN
$pdf = new PDF();

// TRICK: Wir überschreiben die Font-Core-Definitionen manuell, 
// damit FPDF nicht im kaputten Font-Ordner nach .json-Dateien sucht!
$pdf->AddFont('Courier', '', '');
$pdf->AddFont('Courier', 'B', '');
$pdf->AddFont('Courier', 'I', '');
$pdf->AddFont('Courier', 'BI', '');

$pdf->aliasNbPages();
$pdf->AddPage();

// Ab jetzt nutzen wir im gesamten Dokument NUR noch 'Courier'
$pdf->SetFont('Courier', '', 11);

// Absender
$pdf->SetFont('Courier', 'B', 10);
$pdf->Cell(0, 5, utf8_decode("Hotel Kamel * Oasenstrasse 5 * 9800 Spittal"), 0, 1);
$pdf->SetFont('Courier', '', 11);
$pdf->Ln(10);

// Empfänger
$pdf->Cell(0, 5, utf8_decode($kunde_name), 0, 1);
$pdf->Cell(0, 5, utf8_decode($kunde_strasse), 0, 1);
$pdf->Cell(0, 5, utf8_decode($kunde_ort), 0, 1);
$pdf->Ln(20);

// Details
$pdf->SetFont('Courier', 'B', 14);
$pdf->Cell(0, 10, utf8_decode("Rechnung Nr.: " . $rechnungs_nummer), 0, 1);
$pdf->SetFont('Courier', '', 11);
$pdf->Cell(0, 5, "Datum: " . $rechnungs_datum, 0, 1);
$pdf->Ln(10);

// Tabelle Kopf
$pdf->SetFont('Courier', 'B', 11);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(95, 8, 'Zimmer-Auswahl', 1, 0, 'L', true);
$pdf->Cell(25, 8, 'Dauer', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'Zeitraum', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'Gesamt (Brutto)', 1, 1, 'R', true);

// Tabelle Inhalt
$pdf->SetFont('Courier', '', 11);

$zimmer_text = "";
if($daten['einzelzimmer'] > 0) $zimmer_text .= $daten['einzelzimmer'] . "x EZ ";
if($daten['doppelzimmer'] > 0) $zimmer_text .= $daten['doppelzimmer'] . "x DZ ";
if($daten['dreierzimmer'] > 0) $zimmer_text .= $daten['dreierzimmer'] . "x 3-Bett ";
if($daten['viererzimmer'] > 0) $zimmer_text .= $daten['viererzimmer'] . "x 4-Bett ";

if (empty($zimmer_text)) {
    $zimmer_text = "Hotelaufenthalt";
}

$pdf->Cell(95, 8, utf8_decode($zimmer_text), 1, 0, 'L');
$pdf->Cell(25, 8, utf8_decode($naechte . ' Naechte'), 1, 0, 'C'); 
$pdf->Cell(35, 8, $anreise . ' - ' . $abreise, 1, 0, 'C');
$pdf->Cell(35, 8, number_format($gesamt_brutto, 2, ',', '.') . ' EUR', 1, 1, 'R');
$pdf->Ln(5);

// Summen-Block
$pdf->Cell(120);
$pdf->Cell(35, 8, 'Netto Gesamt:', 0, 0, 'R');
$pdf->Cell(35, 8, number_format($gesamt_netto, 2, ',', '.') . ' EUR', 0, 1, 'R');

$pdf->Cell(120);
$pdf->Cell(35, 8, 'zzgl. 10% MwSt:', 0, 0, 'R');
$pdf->Cell(35, 8, number_format($mwst_betrag, 2, ',', '.') . ' EUR', 0, 1, 'R');

$pdf->SetFont('Courier', 'B', 12);
$pdf->Cell(120);
$pdf->Cell(35, 10, 'Gesamtbetrag:', 'T', 0, 'R');
$pdf->Cell(35, 10, number_format($gesamt_brutto, 2, ',', '.') . ' EUR', 'T', 1, 'R');

$pdf->Ln(20);
$pdf->SetFont('Courier', '', 11);
$pdf->Cell(0, 5, utf8_decode("Vielen Dank fuer Ihre Buchung im Hotel Kamel! Bitte ueberweisen Sie den Betrag innerhalb von 14 Tagen."), 0, 1);

// Puffer entleeren vor Ausgabe
ob_end_clean();

// Sicherstellen, dass der Ordner "Rechnungen" existiert
if (!is_dir(dirname(__FILE__) . '/Rechnungen')) {
    mkdir(dirname(__FILE__) . '/Rechnungen', 0777, true);
}

// PDF im Ordner "Rechnungen" speichern
$pdf->Output('F', dirname(__FILE__) . '/Rechnungen/Rechnung_' . $rechnungs_nummer . '.pdf');

// Zurück zum Hauptmenü weiterleiten
header("Location: Menue.php");
exit;
?>