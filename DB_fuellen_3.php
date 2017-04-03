<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>

<?php
include "DB_Verbindung.php";
$mysqli->set_charset("utf8");
echo'Insert Teil 3 von 4 in Progress...<br>';
#-------------------XML Dateien update_references----------------------
$ordner = "XML-Export/XML-Export/update_references";
$alledateien = scandir($ordner);

$Anzahl=0;
$Anzahl1=0;
$a=1;
foreach ($alledateien as $datei)
{
	if($a>20)
	{
		echo'<meta http-equiv="refresh" content="2; url=DB_fuellen_3.php" />';
	}
	else
	{
	$dateiinfo = pathinfo($ordner."/".$datei);
	$StyleDatei = $dateiinfo['basename'];

	if ($datei != "." && $datei != ".."  && $datei != "_notes")
	{
		$xmldatei = 'XML-Export/XML-Export/update_references/'.$StyleDatei;
		if(file_exists($xmldatei)!=false)
		{
			$xml = simplexml_load_file($xmldatei);
			#----------Tabellen Product_References---------------
			$StyleID=$xml->StyleID;
			foreach($xml->References->Reference as $Ref)
			{
				$Werte=array();
				$Werte[] =$Ref->Index;
				$Werte[] =$Ref->ReferenceStyleID;
				$Werte[] =$Ref->SortOrder;
				$Werte[] =$Ref->ReferenceTypeID;
				$Index = $Werte[0];
				$stmt = $mysqli->prepare("INSERT INTO Product_References (Index1, SortOrder, ReferenceTypeID, SKU_StyleID, ReferenceStyleID) VALUES(?, ?, ?, ?, ?)");
				if($stmt === FALSE)
				{
					$Anzahl = $Anzahl+1;
					echo"Tabelle Product_References konnte nicht befüllt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
					die(print_r( $mysqli->error ));
				}
				$stmt->bind_param("iiisi",$Werte[0],$Werte[2],$Werte[3],$StyleID,$Werte[1]);
				$stmt->execute();
				$Anzahl = $Anzahl +$stmt->affected_rows;
				$stmt->close();
				#-----------Tabellen Product_References_Description-------------
				foreach($Ref->Descriptions->Description as $RefDes)
				{
					$Werte=array();
					$Werte[] =$RefDes->LanguageISO;
					$Werte[] =$RefDes->Caption;
					$stmt = $mysqli->prepare("INSERT INTO Product_References_Description (SKU_StyleID, Index1, Languages_ISO, Caption) VALUES(?, ?, ?, ?)");
					if($stmt === FALSE)
					{
						$Anzahl1 = $Anzahl1+1;
						echo"Tabelle Product_References_Description konnte nicht befüllt werden, Abbruch bei der ".$Anzahl1."."." Zeile. Fehler: ";
						die(print_r( $mysqli->error ));
					}
					
					$Werte[1]=str_replace('Ü', '&Uuml;',$Werte[1]);
                	$Werte[1]=str_replace('ü', '&uuml;',$Werte[1]);
               	 	$Werte[1]=str_replace('Ä', '&Auml;',$Werte[1]);
                	$Werte[1]=str_replace('ä', '&auml;',$Werte[1]);
                	$Werte[1]=str_replace('Ö', '&Ouml;',$Werte[1]);
                	$Werte[1]=str_replace('ö', '&ouml;',$Werte[1]);
                	$Werte[1]=str_replace('ß', '&szlig;',$Werte[1]);
                	$Werte[1]=str_replace('²', '&sup2;',$Werte[1]);
				
					$Werte[1]=utf8_encode($Werte[1]);

					$stmt->bind_param("siss",$StyleID,$Index,$Werte[0],$Werte[1]);
					$stmt->execute();
					$Anzahl1 = $Anzahl1 +$stmt->affected_rows;
					$stmt->close();
				}
				
			}
			$a++;
			unlink($xmldatei);
			$files_count = count($alledateien)-2;
			if(($files_count-$a) == 0)
			{
				echo'Insert Teil 3 von 4 abgeschlossen';
				echo'<meta http-equiv="refresh" content="2; url=DB_fuellen_5.php" />';
			}
		}
			}
		}
	}
#echo"Tabelle Product_References wurde erfolgreich mit ".$Anzahl." Datensätzen befüllt.<br>";
#echo"Tabelle Product_References_Description wurde erfolgreich mit ".$Anzahl1." Datensätzen befüllt.<br>";
?>