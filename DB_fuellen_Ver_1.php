<?php
#Session starten
session_start();

#Datenbankverbindung
include "DB_Verbindung.php";

#CSV Datei
$datei="Veredelungen_1.csv";

#Trennzeichen in der Zeile
$trenner=";";

#�berpr�fen ob Datei vorhanden
if (@file_exists($datei) == false)
{
	echo'Datei nicht vorhanden!';
}
else
{
	#Datei �ffnen
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
			
			$stmt = $mysqli->prepare("Insert into VeredelungenSt�ck (VeredelungenID, St�ckzahl,Preis)  VALUES (?,?,?)");
			if($stmt === FALSE)
			{
				$Anzahl = $Anzahl+1;
				echo"Tabelle VeredelungenSt�ck konnte nicht bef�llt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
				die(print_r( $mysqli->error ));
			}
			$stmt->bind_param("sid",$A,$B,$C);
			$stmt->execute();
			$stmt->close();
		}
	}
	
}

?>