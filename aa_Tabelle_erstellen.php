<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="WebShopStyle.css" rel="stylesheet" type="text/css" />
<link href="AuswahlStyle.css" rel="stylesheet" type="text/css" />
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script type='text/javascript' src='menu_jquery.js'></script>

</head>
<body>

<?php
include "DB_Verbindung.php";

$mysqli->set_charset("utf8");

#Liefert alle Kategorien + Hauptkategorie
$stmt1 = $mysqli->query('SELECT DISTINCT a.Caption, 
(Select y.Caption  
from Categories_Description y, Categories_ID_Text x 
where y.LanguageISO="DE" and y.CategoriesID=x.CategoriesID and y.CategoriesID=b.Upper_Category_ID) as Hauptkategorie 
from Categories_Description a, Categories_ID_Text b 
where a.LanguageISO="DE" and a.CategoriesID=b.CategoriesID and b.CategoriesID!=Upper_Category_ID');



$zeile1 = $stmt1->fetch_array();
$b=0;
$d=0;
while($zeile1!=null)
{
#Schreibt Hauptkategorie hinaus
echo $zeile1['Hauptkategorie'].'<br>';
$a=$zeile1['Hauptkategorie'];
while($a==$zeile1['Hauptkategorie'])
{
	#Schreibt Kategorie hinaus
	echo '---'.$zeile1['Caption'];
	
	if($a=='Farben')
	{
		#Anzahl wie viele Produkte in der Kategorie sind
		$stmtK = $mysqli->query('Select Count(a.SKU_StyleID) as Anzahl 
					from  Categories_ID_Text_has_Styles a, Categories_ID_Text b, Categories_Description c 
					where a.CategoriesID = b.CategoriesID 
					and b.CategoriesID = c.CategoriesID 
					and c.LanguageISO="DE" 
					and c.Caption="'.$zeile1['Caption'].'"');
		if($stmtK == false)
          {
            die(print_r( $mysqli->error ));
          }
		  $zeileK = $stmtK->fetch_array();
		$Anzahl = $zeileK['Anzahl'];
		echo ' ('.$Anzahl.')<br>';
		
		#Speichert die Kategorie + Anderes in der Datenbank
		$stmtInsert1 = $mysqli->prepare('INSERT INTO Test_Kate (Hauptkate, Unterkate, Unterunterkate, Anzahl) values (?,?,?,?)');
			if($stmtInsert1 === FALSE)
			{
				die(print_r( $mysqli->error ));
			}
			$b++;
			$c='NichtVorhanden'.$b;
			#$Anzahl=0;
			$stmtInsert1->bind_param('sssi',$a,$zeile1['Caption'],$c,$Anzahl);
			$stmtInsert1->execute();
		
	}
	else
	{
		echo'<br>';
	}
	
	
	
	#Liefert alle Referencen
	$stmt = $mysqli->query('SELECT DISTINCT a.Caption
FROM Product_References_Description a, Product_References b
WHERE a.Languages_ISO =  "DE"
AND a.Index1 = b.Index1
AND a.SKU_StyleID = b.SKU_StyleID');
	
	
	$zeile=$stmt->fetch_array();
	$d=0;
	while($zeile!=null and $a!='Farben' )
	{
		#Außer bei folgenden Hauptkategorien
		if($a=='Produkte' or $a=='Stile' or $a=='Marken' and $a!='Filter' and $a!='Veredelung' and $a!='Pflege')
		{
			#Schreibt Reference hinaus
		echo'------'.$zeile['Caption'];
		
		#Anzahl der Produkte in der Reference und Kategorie
		$stmtK1 = $mysqli->query('Select Count(a.SKU_StyleID) as Anzahl 
					from  Categories_ID_Text_has_Styles a, Categories_ID_Text b, Categories_Description c, Product_References d, Product_References_Description e
					where a.CategoriesID = b.CategoriesID 
					and b.CategoriesID = c.CategoriesID 
					and c.LanguageISO="DE" 
					and a.SKU_StyleID = d.SKU_StyleID
					and d.SKU_StyleID = e.SKU_StyleID
					and d.Index1 = e.Index1
					and e.Caption="'.$zeile['Caption'].'"
					and c.Caption="'.$zeile1['Caption'].'"');
		if($stmtK1 == false)
          {
            die(print_r( $mysqli->error ));
          }
		$zeileK1 = $stmtK1->fetch_array();
		$Anzahl1 = $zeileK1['Anzahl'];
		echo ' ('.$Anzahl1.')<br>';
		
		#Speichert die Kategorie + Anderes in der Datenbank
		$stmtInsert2 = $mysqli->prepare('INSERT INTO Test_Kate (Hauptkate, Unterkate, Unterunterkate, Anzahl) values (?,?,?,?)');
		
			if($stmtInsert2 === FALSE)
			{
				die(print_r( $mysqli->error ));
			}
			#$Anzahl=0;
			$stmtInsert2->bind_param('sssi',$a,$zeile1['Caption'],$zeile['Caption'],$Anzahl);
			$stmtInsert2->execute();
		
		}
		else
		{
			if($d==0)
			{
				#Anzahl der Produkte in der Kategorie
				$stmtK3 = $mysqli->query('Select Count(a.SKU_StyleID) as Anzahl 
					from  Categories_ID_Text_has_Styles a, Categories_ID_Text b, Categories_Description c 
					where a.CategoriesID = b.CategoriesID 
					and b.CategoriesID = c.CategoriesID 
					and c.LanguageISO="DE" 
					and c.Caption="'.$zeile['Caption'].'"');
		if($stmtK3 == false)
          {
            die(print_r( $mysqli->error ));
          }
		  $zeileK3 = $stmtK3->fetch_array();
			$Anzahl3 = $zeileK3['Anzahl'];
			echo ' ('.$Anzahl3.')<br>';
				$d=1;
				
			#Speichert die Kategorie + Anderes in der Datenbank	
			$stmtInsert3 = $mysqli->prepare('INSERT INTO Test_Kate (Hauptkate, Unterkate, Unterunterkate, Anzahl) values (?,?,?,?)');
		
			if($stmtInsert3 === FALSE)
			{
				die(print_r( $mysqli->error ));
			}
			$b++;
			$c='NichtVorhanden'.$b;
			#$Anzahl=0;
			$stmtInsert3->bind_param('sssi',$a,$zeile1['Caption'],$c,$Anzahl);
			$stmtInsert3->execute();
			}
			
		}

		$zeile=$stmt->fetch_array();
		
	}
	$zeile1 = $stmt1->fetch_array();
}
$zeile1 = $stmt1->fetch_array();

}

?>
</ul>
            </div>
            </div>
            </body>