<?php
#---------------------------------------------------------Datenbankverbindung------------------------------------------------

include "DB_Verbindung.php";

#-----------------------------------------------------------Delete-Statements-------------------------------------------------
#--------------Tabelle Stocks---------------
$stmt = $mysqli->prepare("Delete from Stocks");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle Stocks konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle Stocks wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle Product_References_Description---------------
$stmt = $mysqli->prepare("Delete from Product_References_Description");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle Product_References_Description konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle Product_References_Description wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle Product_References---------------
$stmt = $mysqli->prepare("Delete from Product_References");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle Product_References konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle Product_References wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle Style_Pictures---------------
$stmt = $mysqli->prepare("Delete from Style_Pictures");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle Style_Pictures konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle Style_Pictures wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle Styles_Description---------------
$stmt = $mysqli->prepare("Delete from Styles_Description");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle Styles_Description konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle Styles_Description wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle SKU_PS---------------
$stmt = $mysqli->prepare("Delete from SKU_PS");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle SKU_PS konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle SKU_PS wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle SKU_Price---------------
$stmt = $mysqli->prepare("Delete from SKU_Price");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle SKU_Price konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle SKU_Price wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle SKU---------------
$stmt = $mysqli->prepare("Delete from SKU");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle SKU konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle SKU wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle Categories_Description---------------
$stmt = $mysqli->prepare("Delete from Categories_Description");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle Categories_Description konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle Categories_Description wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle categories_id_text_has_styles---------------
$stmt = $mysqli->prepare("Delete from Categories_ID_Text_has_Styles");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle Categories_id_text_has_styles konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle categories_id_text_has_styles wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle Categories_ID_Text---------------
$stmt = $mysqli->prepare("Delete from Categories_ID_Text");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle Categories_ID_Text konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle Categories_ID_Text wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle Styles---------------
$stmt = $mysqli->prepare("Delete from Styles");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle Styles konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle Styles wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle Colour_ID_Text---------------
$stmt = $mysqli->prepare("Delete from Colour_ID_Text");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle Colour_ID_Text konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle Colour_ID_Text wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();
#--------------Tabelle Size_ID_Text---------------
$stmt = $mysqli->prepare("Delete from Size_ID_Text");
if($stmt === FALSE)
{
	echo"Daten aus der Tabelle Size_ID_Text konnten nicht gelöscht werden. Fehler: ";
	die(print_r( $mysqli->error ));
}
$stmt->execute();
#echo"Alle Daten aus der Tabelle Size_ID_Text wurden erfolgreich gelöscht.<br>";
#echo "Gelöschte Zeilen: ".$stmt->affected_rows."<br>";
$stmt->close();

echo'Delete Vorgang abgeschlossen.';
echo'<meta http-equiv="refresh" content="2; url=DB_fuellen_1.php" />';
?>