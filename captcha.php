<?php 
// Session starten (auch wenn vorher schonmal vorhanden)
session_start();
// Leeren des Wertes in der Session
unset($_SESSION['captchacode']);

// Zeichen, die der Captchacode enthalten darf
$moeglicheZeichen = "ABCDEFGHIJKLMNOPQRSTWXYZabcdefhiklmnprstwxy2346789";
// Anzahl der Zeichen, die der Captchacode enthalten soll
$anzahlZeichen = 4;

// Definieren der Captchacode-Variable und "vorsorgliches" Leeren
$captchacode = "";

// Füllen der Captchacode-Variable mit der festgelegten Anzahl zufälliger Zeichen
for($i = 0; $i < $anzahlZeichen; $i++)
{
$captchacode .= substr($moeglicheZeichen, (rand()%(strlen($moeglicheZeichen))), 1);
}

// Schreiben des Captchacodes in die Session
$_SESSION['captchacode'] = $captchacode;

// Dem Browser vormachen, das Dokument wäre eine .jpg-Datei (Bildtyp)
header('Content-type: image/png');

// Ein Bild aus einem vorhandenem Bild erstellen
$img = ImageCreateFromPNG('captcha.PNG');

// Festlegen einer Farbe für die Schrift (mit Zufallswerten)
$farbe = ImageColorAllocate($img, rand(0, 55), rand(0, 55), rand(0, 55));
// Bestimmen der Schriftart relativ zum Dokumentroot
$ttf = 'font.TTF';
// Schriftgröße
$groesse = 20;
// Winkel der Schrift (Zufallswert)
$winkel = rand(-10, 10);
// Horizontale Position (Zufallswert)
$x = rand(15, 40);
// Vertikale Position (Schriftgröße + Abstand zum Rand)
$y = 30;

// Belegen des Hintergrundbildes mit dem Code
imagettftext($img, $groesse, $winkel, $x, $y, $farbe, $ttf, $captchacode);
// Ausgabe des fertigen Bildes
imagePNG($img);
// Löschen des Bildes aus dem Zwischenspeicher
imagedestroy($img);
?>