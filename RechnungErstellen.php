<?php
// FPDF Bibliothek einbinden
require('fpdf.php');

// Eine neue Klasse erstellen, um Kopf- und Fußzeile zu definieren
class PDF_Rechnung extends FPDF {
    // Kopfzeile der Rechnung
    function Header() {
        // Schriftart setzen (Arial, Fett, 20)
        $this->SetFont('Arial', 'B', 20);
        // Titel rechtsbündig
        $this->Cell(0, 10, 'RECHNUNG', 0, 1, 'R');
        
        // Firmendaten (Absender)
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, 'Meine Firma GmbH - Musterstraße 123 - 12345 Musterstadt', 0, 1, 'R');
        $this->Cell(0, 5, 'Email: info@meinefirma.de - Web: www.meinefirma.de', 0, 1, 'R');
        
        // Trennlinie
        $this->Line(10, 32, 200, 32);
        $this->Ln(15);
    }

    // Fußzeile der Rechnung
    function Footer() {
        // Position 1,5 cm von unten
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        // Bankverbindung und Seitenzahl
        $this->Cell(0, 5, 'Bankverbindung: Musterbank IBAN: DE12 3456 7890 1234 5678 90 BIC: ABCDEF1XXX', 0, 1, 'C');
        $this->Cell(0, 5, 'Seite ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Instanz der Klasse erstellen (A4, Maße in mm)
$pdf = new PDF_Rechnung('P', 'mm', 'A4');
$pdf->AliasNbPages(); // Für die Gesamtzahl der Seiten ({nb})
$pdf->AddPage();

// --- EMPFÄNGERADRESSE ---
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 5, 'Empfänger:', 0, 1);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 5, 'Max Mustermann', 0, 1);
$pdf->Cell(0, 5, 'Kundenstraße 45', 0, 1);
$pdf->Cell(0, 5, '54321 Kundenstadt', 0, 1);
$pdf->Ln(10);

// --- RECHNUNGSDATEN ---
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 6, 'Rechnungsnummer: RE-2026-0001', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'Datum: ' . date('d.m.Y'), 0, 1);
$pdf->Cell(0, 5, 'Kundennummer: KD-98765', 0, 1);
$pdf->Ln(10);

// --- TABELLENKOPF ---
$pdf->SetFont('Arial', 'B', 10);
// Spaltenbreiten definieren
$w = array(30, 90, 15, 25, 30); // Gesamt: 190mm (A4 Breite minus Ränder)

$pdf->Cell($w[0], 7, 'Art.-Nr.', 1, 0, 'L');
$pdf->Cell($w[1], 7, 'Bezeichnung', 1, 0, 'L');
$pdf->Cell($w[2], 7, 'Anz.', 1, 0, 'C');
$pdf->Cell($w[3], 7, 'Einzel EUR', 1, 0, 'R');
$pdf->Cell($w[4], 7, 'Gesamt EUR', 1, 1, 'R');

// --- ARTIKELLISTE (BEISPIELDATEN) ---
$pdf->SetFont('Arial', '', 10);
$artikel = array(
    array('1001', 'Webdesign Dienstleistung (Stundensatz)', 5, 80.00),
    array('1002', 'Premium Webhosting (Jahresabo)', 1, 120.00),
    array('1003', 'Support-Pauschale', 2, 45.00)
);

$netto_gesamt = 0;

foreach($artikel as $item) {
    $gesamtpreis = $item[2] * $item[3];
    $netto_gesamt += $gesamtpreis;
    
    $pdf->Cell($w[0], 6, $item[0], 1, 0, 'L');
    // utf8_decode nutzen, falls Umlaute im Text sind
    $pdf->Cell($w[1], 6, utf8_decode($item[1]), 1, 0, 'L');
    $pdf->Cell($w[2], 6, $item[2], 1, 0, 'C');
    $pdf->Cell($w[3], 6, number_format($item[3], 2, ',', '.'), 1, 0, 'R');
    $pdf->Cell($w[4], 6, number_format($gesamtpreis, 2, ',', '.'), 1, 1, 'R');
}

$pdf->Ln(5);

// --- RECHNUNGSENDSUMME ---
$ust_satz = 19; // 19% MwSt.
$ust_betrag = $netto_gesamt * ($ust_satz / 100);
$brutto_gesamt = $netto_gesamt + $ust_betrag;

// Netto
$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3], 6, 'Gesamt Netto:', 0, 0, 'R');
$pdf->Cell($w[4], 6, number_format($netto_gesamt, 2, ',', '.') . ' EUR', 0, 1, 'R');

// MwSt.
$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3], 6, 'zzgl. ' . $ust_satz . '% MwSt.:', 0, 0, 'R');
$pdf->Cell($w[4], 6, number_format($ust_betrag, 2, ',', '.') . ' EUR', 0, 1, 'R');

// Brutto (Fett)
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3], 6, 'Endbetrag Brutto:', 0, 0, 'R');
$pdf->Cell($w[4], 6, number_format($brutto_gesamt, 2, ',', '.') . ' EUR', 0, 1, 'R');

// --- AUSGABE ---
// 'I' schickt die Datei direkt an den Browser (Anzeige), 'D' erzwingt den Download
$pdf->Output('I', 'Rechnung_RE-2026-0001.pdf');
?>