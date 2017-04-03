<?php
#Session starten
session_start();

#Datenbankverbindung
include "DB_Verbindung.php";

#CSV Datei
$datei="Veredelungen_1.csv";

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
			
			$A=$felder[0];
			$B=$felder[1];
			$C=$felder[2];
			
			$stmt = $mysqli->prepare("Insert into VeredelungenStück (VeredelungenID, Stückzahl,Preis)  VALUES (?,?,?)");
			if($stmt === FALSE)
			{
				$Anzahl = $Anzahl+1;
				echo"Tabelle VeredelungenStück konnte nicht befüllt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
				die(print_r( $mysqli->error ));
			}
			$stmt->bind_param("sid",$A,$B,$C);
			$stmt->execute();
			$stmt->close();
		}
	}
	
}

?>