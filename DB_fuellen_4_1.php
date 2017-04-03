<?php
#Session starten
session_start();

#Datenbankverbindung
include "DB_Verbindung.php";

#CSV Datei
$datei="stock.csv";

#Trennzeichen in der Zeile
$trenner=";";

if(!isset($_SESSION['SAnzahl']))
{
	$_SESSION['SAnzahl']=0;
}

$Faktor=1000;
$Anzahl=0;
#Überprüfen ob Datei vorhanden
if (@file_exists($datei) == false) 
{
	echo'Datei nicht vorhanden!';
}
else 
{
	#Datei öffnen
	$file = fopen($datei,"r");
	
	$Anzahl=0;
	
	while(! feof($file))
	{
	#Zeile für Zeile einlesen
	$zeilen=fgetcsv($file,";");
	
	#echo$zeilen[0].'<br>';
	#Zeile für Zeile durchgehen
	foreach($zeilen as $zeile)
	{
		#Zeile in Felder aufteilen
		$felder=explode($trenner,$zeile);
		
		if($felder[0]!="SKU")
		{
		
		#SKU aufsplitten
		$Style=substr($felder[0],0,6);
		
		$Colour=substr($felder[0],6,3);
		
		$Size=substr($felder[0],9,2);
		
		#--------------Datei ausgeben
		#echo$felder[0].' '.$Style.' '.$Colour.' '.$Size.' - '.$felder[1].' '.$felder[2].'<br>';
		#----------------------------
		
		#Insert
		$stmt = $mysqli->prepare("Insert into Stocks (SKU_StyleID, SKU_SizeID, SKU_ColourID, count, reacquisition_date, reacquistion_days) VALUES (?,?,?,?,?,?)");
		if($stmt === FALSE)
		{
			$Anzahl = $Anzahl+1;
			echo"Tabelle Stocks konnte nicht befüllt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
			die(print_r( $mysqli->error ));
		}
		
		#Tage festlegen
		$Days=0;
		
		#Anazahl in integer convertieren
		$zahl=(int)$felder[1];
		
		#Datum formatieren
		$datum=date_create($felder[2]);
		$datumr=date_format($datum, 'Y-m-d H:i:s');
		
		$stmt->bind_param("sssisi",$Style,$Size,$Colour,$zahl,$datumr,$Days);
		$stmt->execute();
		$Anzahl = $Anzahl +$stmt->affected_rows;
		#echo'Datensatz '.$Anzahl.' erfolgreich eingelesen.<br>';
		$stmt->close();
		$Anzahl++;
		/*if($Anzahl==$Faktor)
		{
			$Anzahl=0;
			echo'fertig------------------------------------------------------------------------------------------';
			echo'<meta http-equiv="refresh" content="1000; url=DB.php" />';
		}*/
		
		}
		
	}
	

	}
	fclose($file);
}


?>