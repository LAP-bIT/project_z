<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
<?php
#-----------------------Datenbankverbindung---------------
include "DB_Verbindung.php";
$mysqli->set_charset("utf8");
echo'Insert Teil 2 von 4 in Progress...<br>';
#-----------XMl Dateien update_products-------------------
$ordner = "XML-Export/XML-Export/update_products";
$alledateien = scandir($ordner);


$Anzahl=0;
$Anzahl1=0;
$Anzahl2=0;
$Anzahl3=0;
$Anzahl4=0;
$Anzahl5=0;
$Anzahl6=0;
$a=1;
foreach ($alledateien as $datei)
{
	if($a>20)
	{
		echo'<meta http-equiv="refresh" content="2; url=DB_fuellen_2.php" />';
	}
	else 
	{
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
			$Werte[] = $xml->StyleID;
			$Werte[] = $xml->StyleDateAdded;
			$Werte[] = $xml->StyleDateModified;
			$Werte[] = $xml->StyleDateAvailable;
			$Werte[] = $xml->StyleDefaultPicture;
			$Werte[] = $xml->StyleStatus;
			$Werte[] = $xml->StyleTaxClassID;
			$Werte[] = $xml->ManufacturersID;
			$Werte[] = $xml->CataloguePage;
			$Werte[] = $xml->StylePackContent;
			$Werte[] = $xml->StyleCartonContent;
			$Werte[] = $xml->SalesUnit;
			$Werte[] = $xml->StyleOrientationPrice;
			$StyleID = $Werte[0];
			$stmt = $mysqli->prepare("INSERT INTO Styles (SKU_StyleID, StyleDateAdded, StyleDateModified, StyleDateAvaible, StyleDefaultPicture, StyleStatus, StyleTaxClassID, ManufacturesID, CataloguePage, StylePackContent,  SalesUnit, StyleOrientationPrice) Values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			if($stmt === FALSE)
			{
				$Anzahl = $Anzahl+1;
				echo"Tabelle Styles konnte nicht bef�llt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
				die(print_r( $mysqli->error ));
			}
			$stmt->bind_param("sssssssssssi",$Werte[0],$Werte[1],$Werte[2],$Werte[3],$Werte[4],$Werte[5],$Werte[6],$Werte[7],$Werte[8],$Werte[9],$Werte[11],$Werte[11]);
			$stmt->execute();
			$Anzahl = $Anzahl +$stmt->affected_rows;
			$stmt->close();
			#------------Tabellen SKU----------------
			foreach($xml->SKUList->SKU as $SKU)
			{
				$Werte=array();
				$Werte[] = $SKU->SKU;
				$Werte[] = $SKU->ManufacturerSKU;
				$Werte[] = $SKU->SKUIsActive;
				$Werte[] = $SKU->SKUIsNotDiscontinued;
				$Werte[] = $SKU->SKUItemnumber;
				$Werte[] = $SKU->SKUColourType;
				$Werte[] = $SKU->SKUSizeType;
				$Werte[] = $SKU->SKUStatus;
				$SKUID = $Werte[0];
				$stmt = $mysqli->prepare("INSERT INTO SKU (ManufacturerSKU, SKUIsActive, SKUIsNotDiscontinued, SKUItemnumber, SKUColourType, SKUSizeType, SKUStatus, SKU_StyleID, SKU_ColourID, SKU_SizeID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				if($stmt === FALSE)
				{
					$Anzahl1 = $Anzahl1+1;
					echo"Tabelle SKU konnte nicht bef�llt werden, Abbruch bei der ".$Anzahl1."."." Zeile. Fehler: ";
					die(print_r( $mysqli->error ));
				}
				$stmt->bind_param("siiissssss",$Werte[0],$Werte[1],$Werte[2],$Werte[3],$Werte[4],$Werte[5],$Werte[6],substr($SKUID,0,6),substr($SKUID,6,3),substr($SKUID,9,2));
				$stmt->execute();
				$Anzahl1 = $Anzahl1 +$stmt->affected_rows;
				$stmt->close();
				#----------------Tabellen SKU_PS-------------------
				foreach($SKU->Packshots->Packshot as $PS)
				{
					$Werte=array();
					$Werte[] = $PS->PictureType;
					$Werte[] = $PS->PictureName;
					$Werte[] = $PS->PicturePerspective;
					$Werte[] = $PS->ColourID;
					$stmt = $mysqli->prepare("INSERT INTO SKU_PS (PictureType, PictureName, PicturePerspective, ColourID, SKU_StyleID, SKU_ColourID, SKU_SizeID) VALUES(?, ?, ?, ?, ?, ?, ?)");
					if($stmt === FALSE)
					{
						$Anzahl2 = $Anzahl2+1;
						echo"Tabelle SKU_PS konnte nicht bef�llt werden, Abbruch bei der ".$Anzahl2."."." Zeile. Fehler: ";
						die(print_r( $mysqli->error ));
					}
					$stmt->bind_param("sssssss",$Werte[0],$Werte[1],$Werte[2],$Werte[3],substr($SKUID,0,6),substr($SKUID,6,3),substr($SKUID,9,2));
					$stmt->execute();
					$Anzahl2 = $Anzahl2 +$stmt->affected_rows;
					$stmt->close();
				}
				#---------------Tabellen SKU_Price--------------------
				foreach ($SKU->SKUPricing->Price as $Price)
				{
					$Werte=array();
					$Werte[] = $Price->VolumeScale;
					$Werte[] = $Price->Price;
					$P = str_replace(',', '.', $Werte[1]);
					$stmt = $mysqli->prepare('INSERT INTO SKU_Price (VolumeScale, Price, SKU_StyleID, SKU_ColourID, SKU_SizeID) VALUES(?,?,?,?,?)');
					if($stmt === FALSE)
					{
						$Anzahl3 = $Anzahl3+1;
						echo"Tabelle SKU_Price konnte nicht bef�llt werden, Abbruch bei der ".$Anzahl3."."." Zeile. Fehler: ";
						die(print_r( $mysqli->error ));
					}
					$stmt->bind_param("sdsss",$Werte[0],$P,substr($SKUID,0,6),substr($SKUID,6,3),substr($SKUID,9,2));
					$stmt->execute();
					$Anzahl3 = $Anzahl3 +$stmt->affected_rows;
					$stmt->close();
				}
			}
			#-----------Tabellen Styles_Description--------------
			foreach($xml->Descriptions->Description as $Des)
			{
				$Werte=array();
				$Werte[] =$Des->LanguageISO;
				$Werte[] =$Des->StyleName;
				$Werte[] =$Des->StyleName2;
				$Werte[] =$Des->StyleDescription;
				$help="INSERT INTO Styles_Description (SKU_StyleID, LanguageISO, StyleName, StyleName2, StyleDescription) VALUES(?, ?, ?, ?, ?)";
				$stmt = $mysqli->prepare($help);
				if($stmt === FALSE)
				{
					$Anzahl4 = $Anzahl4+1;
					echo"Tabelle Styles_Description konnte nicht bef�llt werden, Abbruch bei der ".$Anzahl4."."." Zeile. Fehler: ";
					die(print_r( $mysqli->error ));
				}
				
				#Sonderzeichen ersetzen
				$Werte[2]=str_replace('Ü', '&Uuml;',$Werte[2]);
                $Werte[2]=str_replace('ü', '&uuml;',$Werte[2]);
                $Werte[2]=str_replace('Ä', '&Auml;',$Werte[2]);
                $Werte[2]=str_replace('ä', '&auml;',$Werte[2]);
                $Werte[2]=str_replace('Ö', '&Ouml;',$Werte[2]);
                $Werte[2]=str_replace('ö', '&ouml;',$Werte[2]);
                $Werte[2]=str_replace('ß', '&szlig;',$Werte[2]);
                $Werte[2]=str_replace('²', '&sup2;',$Werte[2]);
				
				$Werte[2]=utf8_encode($Werte[2]);
                
                $Werte[3]=str_replace('Ü', '&Uuml;',$Werte[3]);
                $Werte[3]=str_replace('ü', '&uuml;',$Werte[3]);
                $Werte[3]=str_replace('Ä', '&Auml;',$Werte[3]);
                $Werte[3]=str_replace('ä', '&auml;',$Werte[3]);
                $Werte[3]=str_replace('Ö', '&Ouml;',$Werte[3]);
                $Werte[3]=str_replace('ö', '&ouml;',$Werte[3]);
                $Werte[3]=str_replace('ß', '&szlig;',$Werte[3]);
                $Werte[3]=str_replace('²', '&sup2;',$Werte[3]);
				
				$Werte[3]=utf8_encode($Werte[3]);
				
				$stmt->bind_param("sssss",$StyleID,$Werte[0],$Werte[1],$Werte[2],$Werte[3]);
				$stmt->execute();
				$Anzahl4 = $Anzahl4 +$stmt->affected_rows;
				$stmt->close();
			}
			#----------Tabellen Styles_Pictures-----------------
			foreach($xml->Pictures->Picture as $Pic)
			{
			$Werte=array();
			$Werte[] =$Pic->PictureType;
			$Werte[] =$Pic->PictureName;
			$Werte[] =$Pic->PicturePerspective;
			$Werte[] =$Pic->ColourID;
			$stmt = $mysqli->prepare("INSERT INTO Style_Pictures (SKU_StyleID, PictureType, PictureName, PicturePerspective, ColourID) VALUES(?, ?, ?, ?, ?)");
			if($stmt === FALSE)
				{
				$Anzahl5 = $Anzahl5+1;
			echo"Tabelle Style_Pictures konnte nicht bef�llt werden, Abbruch bei der ".$Anzahl5."."." Zeile. Fehler: ";
			die(print_r( $mysqli->error ));
			}
			$stmt->bind_param("sssss",$StyleID,$Werte[0],$Werte[1],$Werte[2],$Werte[3]);
			$stmt->execute();
			$Anzahl5 = $Anzahl5 +$stmt->affected_rows;
			$stmt->close();
		}
		#----------Tabellen categories_id_text_has_styles
		foreach($xml->Categories->Category as $Cat)
		{
		$Werte=array();
		$Werte[] =$Cat->CategoriesID;
		$stmt = $mysqli->prepare("INSERT INTO Categories_ID_Text_has_Styles (SKU_StyleID, CategoriesID) VALUES(?, ?);");
		if($stmt === FALSE)
		{
		$Anzahl6 = $Anzahl6+1;
				echo"Tabelle Categories_ID_Text_has_Styles konnte nicht bef�llt werden, Abbruch bei der ".$Anzahl6."."." Zeile. Fehler: ";
				die(print_r( $mysqli->error ));
		}
		$stmt->bind_param("si",$StyleID,$Werte[0]);
		$stmt->execute();
		$Anzahl6 = $Anzahl6 +$stmt->affected_rows;
		$stmt->close();
		}
		$a++;
		
		unlink($xmldatei);
		$files_count = count($alledateien)-2;
		if(($files_count-$a) == 0)
		{
			echo'Insert Teil 2 von 4 abgeschlossen';
			echo'<meta http-equiv="refresh" content="2; url=DB_fuellen_3.php" />';
		}
		}
	}
	
	}
}

#echo"Tabelle Styles wurde erfolgreich mit ".$Anzahl." Datens�tzen bef�llt.<br>";
#echo"Tabelle SKU wurde erfolgreich mit ".$Anzahl1." Datens�tzen bef�llt.<br>";
#echo"Tabelle SKU_PS wurde erfolgreich mit ".$Anzahl2." Datens�tzen bef�llt.<br>";
#echo"Tabelle SKU_Price wurde erfolgreich mit ".$Anzahl3." Datens�tzen bef�llt.<br>";
#echo"Tabelle Styles_Description wurde erfolgreich mit ".$Anzahl4." Datens�tzen bef�llt.<br>";
#echo"Tabelle Style_Pictures wurde erfolgreich mit ".$Anzahl5." Datens�tzen bef�llt.<br>";
#echo"Tabelle categories_id_text_has_styles wurde erfolgreich mit ".$Anzahl6." Datens�tzen bef�llt.<br>";
?></body>