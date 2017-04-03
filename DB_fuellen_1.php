<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>

<?php
#---------------------------------------------------------Datenbankverbindung------------------------------------------------

include "DB_Verbindung.php";
$mysqli->set_charset("utf8");
echo'Insert Teil 1 von 4 in Progress...<br>';
#-----------------------------------------------------Insert-Statements----------------------------------------------------------
#-------------XMl Dateien Set_Option_List--------------------
#-------------Tabellen Colour_Id_Text, Size_Id_Text------------------
$xmldatei = "XML-Export/XML-Export/set_option_list/set_option_list.xml";
if(file_exists($xmldatei)!=false)
{
$xml = simplexml_load_file($xmldatei);
$Anzahl = 0;
foreach($xml->Colours->Colour as $colour)
{
	$ColourID = $colour->ColourID;
	$Caption = $colour->Caption;
	$stmt = $mysqli->prepare("Insert into Colour_ID_Text (Caption, SKU_ColourID) VALUES (?,?)");
	if($stmt === FALSE)
	{
		$Anzahl = $Anzahl+1;
		echo"Tabelle Colour_ID_Text konnte nicht befüllt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
		die(print_r( $mysqli->error ));
	}
	
		$Caption=str_replace('²', '&sup2;',$Caption);
		$Caption=str_replace('Ü', '&Uuml;',$Caption);
		$Caption=str_replace('ü', '&uuml;',$Caption);
		$Caption=str_replace('Ä', '&Auml;',$Caption);
		$Caption=str_replace('ä', '&auml;',$Caption);
		$Caption=str_replace('Ö', '&Ouml;',$Caption);
		$Caption=str_replace('ö', '&ouml;',$Caption);
		$Caption=str_replace('ß', '&szlig;',$Caption);
	
		$Caption=utf8_encode($Caption);

		$stmt->bind_param("ss",$Caption,$ColourID);
		$stmt->execute();
	    $Anzahl = $Anzahl +$stmt->affected_rows;
		$stmt->close();
}
#echo"<br>Tabelle Colour_ID_Text wurde erfolgreich mit ".$Anzahl." Datensätzen befüllt.<br>";
$Anzahl=0;
foreach ($xml->Sizes->Size as $Size)
{
	$SizeID = $Size->SizeID;
	$Caption = $Size->Caption;
	$stmt = $mysqli->prepare("Insert into Size_ID_Text (Caption, SKU_SizeID) VALUES (?,?)");
	if($stmt === FALSE)
	{
		$Anzahl = $Anzahl+1;
		echo"Tabelle Size_ID_Text konnte nicht befüllt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
		die(print_r( $mysqli->error ));
	}
	
		$Caption=str_replace('²', '&sup2;',$Caption);
		$Caption=str_replace('Ü', '&Uuml;',$Caption);
		$Caption=str_replace('ü', '&uuml;',$Caption);
		$Caption=str_replace('Ä', '&Auml;',$Caption);
		$Caption=str_replace('ä', '&auml;',$Caption);
		$Caption=str_replace('Ö', '&Ouml;',$Caption);
		$Caption=str_replace('ö', '&ouml;',$Caption);
		$Caption=str_replace('ß', '&szlig;',$Caption);
	
		$Caption=utf8_encode($Caption);
	
	$stmt->bind_param("ss",$Caption,$SizeID);
	$stmt->execute();
	$Anzahl = $Anzahl +$stmt->affected_rows;
	$stmt->close();
	}
	#echo"Tabelle Size_ID_Text wurde erfolgreich mit ".$Anzahl." Datensätzen befüllt.<br>";
}

#-----------XML Dateien update_categories----------------
$xmldatei = "XML-Export/XML-Export/update_categories/update_categories.xml";
if(file_exists($xmldatei)!=false)
{
	$xml = simplexml_load_file($xmldatei);
	$Anzahl=0;
	$Anzahl1=0;
	#---------Tabellen Categories_ID_Text--------
	foreach ($xml->Category as $Category)
	{
		$Werte = array();
		$Werte[] = $Category->CategoriesID;
		$Werte[] = $Category->SortOrder;
		$Werte[] = $Category->DateAdded;
		$Werte[] = $Category->DateModified;
		$Werte[] = $Category->Active;
		$CategoryID = $Werte[0];
		$stmt = $mysqli->prepare("INSERT INTO Categories_ID_Text (CategoriesID, SortOrder, DateAdded, DateModified, Active, Upper_Category_ID) VALUES(?, ?, ?, ?, ?, ?)");
		if($stmt === FALSE)
		{
			$Anzahl = $Anzahl+1;
			echo"Tabelle Categories_ID_Text konnte nicht befüllt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
			die(print_r( $mysqli->error ));
		}
		$stmt->bind_param("iissii",$Werte[0],$Werte[1],$Werte[2],$Werte[3],$Werte[4],$Werte[0]);
		$stmt->execute();
		$Anzahl = $Anzahl +$stmt->affected_rows;
		$stmt->close();
		#-------Tabellen Categories_Description--------
		foreach ($Category->Descriptions->Description as $Description)
		{
			$Werte = array();
			$Werte[] = $Description->LanguageISO;
			$Werte[] = $Description->Caption;
			$stmt = $mysqli->prepare("INSERT INTO Categories_Description (CategoriesID, LanguageISO, Caption) VALUES(?, ?, ?)");
			if($stmt === FALSE)
			{
				$Anzahl = $Anzahl+1;
				echo"Tabelle Categories_Description konnte nicht befüllt werden, Abbruch bei der ".$Anzahl1."."." Zeile. Fehler: ";
				die(print_r( $mysqli->error ));
			}
			
			$Werte[1]=str_replace('²', '&sup2;',$Werte[1]);
			$Werte[1]=str_replace('Ü', '&Uuml;',$Werte[1]);
			$Werte[1]=str_replace('ü', '&uuml;',$Werte[1]);
			$Werte[1]=str_replace('Ä', '&Auml;',$Werte[1]);
			$Werte[1]=str_replace('ä', '&auml;',$Werte[1]);
			$Werte[1]=str_replace('Ö', '&Ouml;',$Werte[1]);
			$Werte[1]=str_replace('ö', '&ouml;',$Werte[1]);
			$Werte[1]=str_replace('ß', '&szlig;',$Werte[1]);
	
			$Werte[1]=utf8_encode($Werte[1]);
			
			$stmt->bind_param("iss",$CategoryID,$Werte[0],$Werte[1]);
			$stmt->execute();
			$Anzahl1 = $Anzahl1 +$stmt->affected_rows;
			$stmt->close();
		}
		#---------Tabellen Categories_ID_Text (Subkategorien)--------
		foreach ($Category->SubCategories->Category as $SubCategories)
		{
			$Werte = array();
			$Werte[] = $SubCategories->CategoriesID;
			$Werte[] = $SubCategories->SortOrder;
			$Werte[] = $SubCategories->DateAdded;
			$Werte[] = $SubCategories->DateModified;
			$Werte[] = $SubCategories->Active;
			$SubCategoryID = $Werte[0];
			$stmt = $mysqli->prepare("INSERT INTO Categories_ID_Text (CategoriesID, SortOrder, DateAdded, DateModified, Active, Upper_Category_ID) VALUES(?, ?, ?, ?, ?, ?)");
			if($stmt === FALSE)
			{
				$Anzahl = $Anzahl+1;
				echo"Tabelle Categories_ID_Text konnte nicht befüllt werden, Abbruch bei der ".$Anzahl."."." Zeile. Fehler: ";
				die(print_r( $mysqli->error ));
			}
			$stmt->bind_param("iissii",$Werte[0],$Werte[1],$Werte[2],$Werte[3],$Werte[4],$CategoryID);
			$stmt->execute();
			$Anzahl = $Anzahl +$stmt->affected_rows;
			$stmt->close();
			
			#-------Tabellen Categories_Description (Subkategorien)--------
			foreach($SubCategories->Descriptions->Description as $SubDescription)
			{
				$Werte = array();
				$Werte[] = $SubDescription->LanguageISO;
				$Werte[] = $SubDescription->Caption;
				$stmt = $mysqli->prepare("INSERT INTO Categories_Description (CategoriesID, LanguageISO, Caption) VALUES(?, ?, ?)");
				if($stmt === FALSE)
				{
					$Anzahl = $Anzahl+1;
					echo"Tabelle Categories_Description konnte nicht befüllt werden, Abbruch bei der ".$Anzahl1."."." Zeile. Fehler: ";
					die(print_r( $mysqli->error ));
				}
				
				$Werte[1]=str_replace('²', '&sup2;',$Werte[1]);
				$Werte[1]=str_replace('Ü', '&Uuml;',$Werte[1]);
				$Werte[1]=str_replace('ü', '&uuml;',$Werte[1]);
				$Werte[1]=str_replace('Ä', '&Auml;',$Werte[1]);
				$Werte[1]=str_replace('ä', '&auml;',$Werte[1]);
				$Werte[1]=str_replace('Ö', '&Ouml;',$Werte[1]);
				$Werte[1]=str_replace('ö', '&ouml;',$Werte[1]);
				$Werte[1]=str_replace('ß', '&szlig;',$Werte[1]);
	
				$Werte[1]=utf8_encode($Werte[1]);
				
				$stmt->bind_param("iss",$SubCategoryID,$Werte[0],$Werte[1]);
				$stmt->execute();
				$Anzahl1 = $Anzahl1 +$stmt->affected_rows;
				$stmt->close();
			}
		}
	}
	#echo"Tabelle Categories_ID_Text wurde erfolgreich mit ".$Anzahl." Datensätzen befüllt.<br>";
	#echo"Tabelle Categories_Description wurde erfolgreich mit ".$Anzahl1." Datensätzen befüllt.<br>";
}
echo'Insert Teil 1 von 4 abgeschlossen';
echo'<meta http-equiv="refresh" content="2; url=DB_fuellen_2.php" />';
?></body>