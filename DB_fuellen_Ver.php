<?php
#Session starten
session_start();

#Datenbankverbindung
include "DB_Verbindung.php";

#CSV Datei
$datei="Veredelungen2.csv";

#Trennzeichen in der Zeile
$trenner=";";

#Überprüfen ob Datei vorhanden
if (@file_exists($datei) == false)
{
	echo'Datei nicht vorhanden!';
}
else
{
	#Datei öffnen
	$file = fopen($datei,"r");
	
	while(! feof($file))
	{
		$zeilen=fgetcsv($file,";");
		
		foreach($zeilen as $zeile)
		{
		#Zeile in Felder aufteilen
		$felder=explode($trenner,$zeile);
		#print_r($felder);
		
		$Nummer=$felder[0];
		$Art=$felder[1];
		$Flaeche=$felder[2];
		$A=$felder[3];
		$B=$felder[4];
		$C=$felder[5];
		$D=$felder[6];
		$E=$felder[7];
		$F=$felder[8];
		
		$stmt = $mysqli->prepare("Insert into Veredelungen (VeredelungenID, Veredelungsart, Veredelungsfläche, Einzelverpackung, Auftragskosten, Klischeekosten, Superexpress, Express, Normal) VALUES (?,?,?,?,?,?,?,?,?)");
		if($stmt === FALSE)
		{
			$Anzahl = $Anzahl+1;
			echo"Tabelle Veredelungen konnte nicht befüllt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
			die(print_r( $mysqli->error ));
		}
		$stmt->bind_param("sssdddddd",$Nummer,$Art,$Flaeche,$A,$B,$C,$D,$E,$F);
		$stmt->execute();
		$stmt->close();
		
		}
		
	}
}
?>