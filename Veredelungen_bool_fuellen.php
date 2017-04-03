<?php
include "DB_Verbindung.php";
echo'Insert in Progress...<br>';
$ordner = "XML-Export/XML-Export/update_products";
$alledateien = scandir($ordner);
$Anzahl=0;
$a=1;
foreach ($alledateien as $datei)
{
	if($a>20)
	{
		echo'<meta http-equiv="refresh" content="2; url=DB_fuellen_5.php" />';
	}
	$dateiinfo = pathinfo($ordner."/".$datei);
	$StyleDatei = $dateiinfo['basename'];

	if ($datei != "." && $datei != ".."  && $datei != "_notes")
	{
		$xmldatei = 'XML-Export/XML-Export/update_products/'.$StyleDatei;
		if(file_exists($xmldatei)!=false)
		{
			$xml = simplexml_load_file($xmldatei);
			#----------Tabellen Styles------------------
			$Werte = array();
			$ProduktID = $xml->StyleID;
			$i=1;
			while($i< 19)
			{
			$stmt = $mysqli->prepare("INSERT INTO Styles_Description_bool (SKU_StyleID, VeredelungenID, Veredelung_machbar) Values(?, ?, ?)");
			if($stmt === FALSE)
			{
				$Anzahl = $Anzahl+1;
				echo"Tabelle Styles konnte nicht befüllt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
				die(print_r( $mysqli->error ));
			}
			$fu =1;
			$stmt->bind_param("ssi",$ProduktID,$i,$fu);
			$stmt->execute();
			$Anzahl = $Anzahl +$stmt->affected_rows;
			$stmt->close();
			$i=$i+1;
			}
			
			$a++;
			#unlink($xmldatei);
			$files_count = count($alledateien)-2;
			if(($files_count-$a) == 0)
			{
				echo'Insert abgeschlossen';
				echo'<meta http-equiv="refresh" content="2; url=DB_fuellen_5.php" />';
			}
		}
	}
}
#echo"<br>Tabelle Styles_Description_bool wurde erfolgreich mit ".$Anzahl." Datensätzen befüllt.<br>";
?>