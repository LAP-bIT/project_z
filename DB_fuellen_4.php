<?php
include "DB_Verbindung.php";
echo'Insert Teil 4 von 4 in Progress...<br>';
#------------------XML Dateien Stocks------------------------
$ordner = "XML-Export/Stocks";
$alledateien = scandir($ordner);


$Anzahl=0;
$SKUAnzahl=0;
$a=1;
foreach ($alledateien as $datei)
{
	if($a>20)
	{
		echo'<meta http-equiv="refresh" content="10"; url="DB_fuellen_4.php" />';
	}
	else
	{
	$dateiinfo = pathinfo($ordner."/".$datei);
	$StyleDatei = $dateiinfo['basename'];

	if ($datei != "." && $datei != ".."  && $datei != "_notes")
	{
		$xmldatei = 'XML-Export\Stocks\\'.$StyleDatei;
		if(file_exists($xmldatei)!=false)
		{
			$xml = simplexml_load_file($xmldatei);
			#------------Tabellen Stocks----------------
			foreach($xml->stock as $stock)
			{
				$Werte=array();
				$Werte[] =$stock->sku;
				$Werte[] =$stock->count;
				$Werte[] =$stock->reacquisition_date;
				$Werte[] =$stock->reacquisition_days;
				$stmt = $mysqli->query("SELECT SKU_StyleID, SKU_SizeID, SKU_ColourID from SKU where SKU_StyleID LIKE ".substr($Werte[0],0,6)." and SKU_SizeID LIKE ".substr($Werte[0],9,2)." and SKU_ColourID LIKE ".substr($Werte[0],6,3));


				if($stmt == false)
				{
					#echo'SKU '.$Werte[0].' nicht gefunden!<br>';
					$SKUAnzahl++;
				}
				else
				{
					$zeile = $stmt->fetch_array();
					$SizeID =$zeile['SKU_SizeID'];

					$stmt = $mysqli->prepare("Insert into Stocks (SKU_StyleID, SKU_SizeID, SKU_ColourID, count, reacquisition_date, reacquistion_days) VALUES (?,?,?,?,?,?)");
					if($stmt === FALSE)
					{
						$Anzahl = $Anzahl+1;
						echo"Tabelle Colour_ID_Text konnte nicht befüllt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
						die(print_r( $mysqli->error ));
					}
					$stmt->bind_param("sssisi",substr($Werte[0],0,6), substr($Werte[0],9,2), substr($Werte[0],6,3), $Werte[1], $Werte[2], $Werte[3]);
					$stmt->execute();
					$Anzahl = $Anzahl +$stmt->affected_rows;
					$stmt->close();
				}
			}
			$a++;
			unlink($xmldatei);
			$files_count = count($alledateien)-2;
			if(($files_count-$a) == 0)
			{
				echo'Insert Teil 4 von 4 abgeschlossen';
				echo'<meta http-equiv="refresh" content="10; url=DB_fuellen_5.php" />';
			}
		}
			}
		}
	}
#echo"Tabelle Stocks wurde erfolgreich mit ".$Anzahl." Datensätzen befüllt.<br>";
#echo$SKUAnzahl." nicht gefundene SKU's";
?>