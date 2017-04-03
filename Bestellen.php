<?php 
#Session starten
session_start();

#Datenbankverbindung
include "DB_Verbindung.php";


#Anker, Session usw. Variabeln Setzen
if(isset($_REQUEST['L']))
{
	$_SESSION['Liefer']=$_REQUEST['L'];
}

if(isset($_REQUEST['C']))
{
	$_SESSION['Checked']=$_REQUEST['C'];	
}

if(isset($_REQUEST['R']))
{
	$_SESSION['R']=$_REQUEST['R'];
}

if(!isset($_SESSION['R']))
{
	$_SESSION['R']="nein";
}

if(!isset($_SESSION['L']))
{
	$_SESSION['L']="nein";
}

if(isset($_GET['A']))
{
	echo'<meta http-equiv="refresh" content="0; url=Bestellen.php#'.$_GET['A'].'" />';
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Webshop f&uuml;r Textilwaren | Bestellvorgang</title>
    <link href="WebShopStyle.css" rel="stylesheet" type="text/css" />
    <link href="AuswahlStyle.css" rel="stylesheet" type="text/css" />
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script type='text/javascript' src='menu_jquery.js'></script>

    <script type="text/javascript">

function Lief1()
{
	if(document.getElementsByName("Lief")[0].checked==true)
	{
		document.getElementsByName("Rech")[0].checked=false;

		window.location.href = "Bestellen.php?L=" + escape("ja")+"&C="+escape("Lief")+"&R="+escape("ja");
	}
}

function Rech1()
{
	if(document.getElementsByName("Rech")[0].checked==true)
	{
		document.getElementsByName("Lief")[0].checked=false;

		window.location.href = "Bestellen.php?L=" + escape("nein")+"&C="+escape("Rech")+"&R="+escape("ja");
	}
}

    </script>
</head>
<body>
   <div id="topmost">
        <div id="header">
            <div id="Warenkorbanzeige" class="HintergrundGelbVerlauf">
                <div id="Warenkorblabel">
                   
                 
                    <label>Warenkorb:</label>
                        <label>(<?php if(!isset($_SESSION['WK1'])){ $_SESSION['WK1']="0";}echo $_SESSION['WK1']?>)</label>
                    <label><?php if(!isset($_SESSION['WK'])){ $_SESSION['WK']="0,00 ";}echo $_SESSION['WK']?> &euro;</label>
                  
               
                </div>
                 <?php if(isset($_SESSION['Benutzer']))
             {
             echo'<form action="Warenkorb.php">';
             }?>
                <div id="Warenkorbbutton">
                    <button style="background-image: url('webshop_maturaprojekt_nov2013_03.png')"></button>
                    <button style="background-image: url('weiter%20button.jpg')"></button>
                </div>
                 <?php if(isset($_SESSION['Benutzer']))
             {
             echo'</form>';
             }?>
            </div>
            <div id="AnmeldeLink">
            <?php if(isset($_SESSION['Benutzer']))
                   { 
                   	$link1="Abmelden.php";
                   	$text1="Abmelden";
                   	$link2="MeinKonto.php";
                    }
                    else 
                    {
                    $link1="Anmeldemaske.php";
                    $text1="Anmelden";
                    $link2="Anmeldemaske.php";
                    }?>
                <a href="<?php echo$link1;?>"><?php echo$text1;?></a>
                    <b>|</b>
                    <a href="<?php echo$link2;?>">Mein Konto</a>
            </div>
            <div style="clear:both;"></div>
        </div>

 		<form action="Suche.php" method="post">
        <div id="SucheSchwarz"class="abrunden_20">
            <div id="SucheZeile">
                <label>Produktsuche:</label>
                <input name="Produkt" type="text" />
                <button name="Produkt1" style="background-image: url('SucheButton_07.png')"></button>
            </div>
            <div style="clear:both;"></div>
        </div>
        </form>

        <form name="Bestell" action="Bestellen.php" method="post">  
        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein">Bestellelungs&uuml;bersicht</label>
                <div style="clear:both;"></div>
            </div>
            <div style="clear:both;"></div>

            <div id="Uebersicht" class="abrunden_15 HintergrundGrauVerlauf">
           	<table>
           	<tr>
           	<td width="80px" class="W_Übersicht">Bild</td>
           	<td width="240px" class="W_Übersicht">Beschreibung</td>
           	<td width="170px" class="W_Übersicht">Veredelung</td>
           	<td width="170px" class="W_Übersicht">Klein&uuml;bersicht</td>
           	</tr>
           	</table>
           	</div>
            <?php 
 #Informationen über das Produkt
            $_SESSION['GesamtP']=0;
           
            $Unterschied=0;
            $a=1;
            $stmt = $mysqli->query('SELECT c.Bestellte_Artikel_ID, a.Price, c.Stueck, b.SKU_StyleID, b.SKU_ColourID, b.SKU_SizeID, d.Caption as SizeText, e.Caption as ColourText, g.StyleDescription, g.StyleName2 from SKU_Price a, SKU b, Bestellungen_Warenkorb c, Size_ID_Text d, Colour_ID_Text e, Styles f, Styles_Description g where a.SKU_StyleID = b.SKU_StyleID and a.SKU_SizeID = b.SKU_SizeID and a.SKU_ColourID = b.SKU_ColourID and c.SKU_StyleID = b.SKU_StyleID and c.SKU_SizeID = b.SKU_SizeID and c.SKU_ColourID = b.SKU_ColourID and c.Bestellnummer="Warenkorb" and c.Kundennummer="'.$_SESSION['Benutzer'].'" and a.VolumeScale=0 and b.SKU_SizeID =d.SKU_SizeID and b.SKU_ColourID = e.SKU_ColourID and b.SKU_StyleID = f.SKU_StyleID and f.SKU_StyleID = g.SKU_StyleID and g.LanguageISO="DE"');
            while($a<=$_SESSION['WK1'])
            {
            	$_SESSION['GesamtPV']=0;
            	
            /*$stmtz=$mysqli->query('SELECT SKU_StyleID, SKU_SizeID, SKU_ColourID from Bestellungen_Warenkorb where Bestellnummer="Warenkorb" and Kundennummer="'.$_SESSION['Benutzer'].'"');
            $zeilez=$stmtz->fetch_array();
            
            $stmt=$mysqli->query('SELECT PictureName from SKU_PS where SKU_StyleID="'.$zeilez['SKU_StyleID'].'" and SKU_SizeID="'.$zeilez['SKU_SizeID'].'" and SKU_ColourID="'.$zeilez['SKU_ColourID'].'"');
           $zeile=$stmt->fetch_array();
            if($zeile!=null)
            {
           $stmt->close();
           $stmt = $mysqli->query('SELECT c.Bestellte_Artikel_ID, a.Price, c.Stueck, b.SKU_StyleID, b.SKU_ColourID, b.SKU_SizeID, d.Caption as SizeText, e.Caption as ColourText, g.StyleDescription, g.StyleName2, h.PictureName from SKU_Price a, SKU b, Bestellungen_Warenkorb c, Size_ID_Text d, Colour_ID_Text e, Styles f, Styles_Description g, SKU_PS h where a.SKU_StyleID = b.SKU_StyleID and a.SKU_SizeID = b.SKU_SizeID and a.SKU_ColourID = b.SKU_ColourID and c.SKU_StyleID = b.SKU_StyleID and c.SKU_SizeID = b.SKU_SizeID and c.SKU_ColourID = b.SKU_ColourID and c.Bestellnummer="Warenkorb" and c.Kundennummer="'.$_SESSION['Benutzer'].'" and a.VolumeScale=0 and b.SKU_SizeID =d.SKU_SizeID and b.SKU_ColourID = e.SKU_ColourID and b.SKU_StyleID = f.SKU_StyleID and f.SKU_StyleID = g.SKU_StyleID and g.LanguageISO="DE" and b.SKU_StyleID=h.SKU_StyleID and b.SKU_ColourID = h.SKU_ColourID and b.SKU_SizeID = h.SKU_SizeID and b.SKU_ColourID = h.SKU_ColourID');
            }
            else
            {
            	$stmt->close();
            	$stmt = $mysqli->query('SELECT c.Bestellte_Artikel_ID, a.Price, c.Stueck, b.SKU_StyleID, b.SKU_ColourID, b.SKU_SizeID, d.Caption as SizeText, e.Caption as ColourText, g.StyleDescription, g.StyleName2, h.PictureName from SKU_Price a, SKU b, Bestellungen_Warenkorb c, Size_ID_Text d, Colour_ID_Text e, Styles f, Styles_Description g, SKU_PS h where a.SKU_StyleID = b.SKU_StyleID and a.SKU_SizeID = b.SKU_SizeID and a.SKU_ColourID = b.SKU_ColourID and c.SKU_StyleID = b.SKU_StyleID and c.SKU_SizeID = b.SKU_SizeID and c.SKU_ColourID = b.SKU_ColourID and c.Bestellnummer="Warenkorb" and c.Kundennummer="'.$_SESSION['Benutzer'].'" and a.VolumeScale=0 and b.SKU_SizeID =d.SKU_SizeID and b.SKU_ColourID = e.SKU_ColourID and b.SKU_StyleID = f.SKU_StyleID and f.SKU_StyleID = g.SKU_StyleID and g.LanguageISO="DE" and b.SKU_StyleID=h.SKU_StyleID and b.SKU_SizeID = h.SKU_SizeID and b.SKU_ColourID = h.SKU_ColourID');
            }*/
           
           	$zeile = $stmt->fetch_array();
            
            
            $stmtB=$mysqli->query('SELECT PictureName from SKU_PS where SKU_StyleID="'.$zeile['SKU_StyleID'].'" and SKU_SizeID="'.$zeile['SKU_SizeID'].'" and SKU_ColourID="'.$zeile['SKU_ColourID'].'"');
            	
            $zeileB=$stmtB->fetch_array();
           	$stmt1 = $mysqli->query('SELECT c.VeredelungenID, b.Versandkosten, b.Hochgeladene_Datei, c.Veredelungsart, c.Veredelungsfläche, d.Preis, e.Position, e.PositionID from Bestellungen_Warenkorb a, Bestellungen_Warenkorb_has_Veredelungen b, Veredelungen c, VeredelungenStück d, Positionen e where a.Bestellnummer="Warenkorb" and a.Kundennummer="'.$_SESSION['Benutzer'].'" and a.Bestellte_Artikel_ID = b.Bestellte_ArtikelID and b.VeredelungenID = c.VeredelungenID and c.VeredelungenID = d.VeredelungenID and d.Stückzahl<5 and b.PositionID = e.PositionID and a.SKU_StyleID="'.$zeile['SKU_StyleID'].'" and a.SKU_ColourID="'.$zeile['SKU_ColourID'].'" and a.SKU_SizeID="'.$zeile['SKU_SizeID'].'" and a.Bestellte_Artikel_ID="'.$zeile['Bestellte_Artikel_ID'].'"');
           	$zeile1 = $stmt1->fetch_array();
           	$_SESSION['Size'.$a]=$zeile['SKU_SizeID'];
           	$_SESSION['Colour'.$a]=$zeile['SKU_ColourID'];
           	$_SESSION['Style'.$a]=$zeile['SKU_StyleID'];
           	$_SESSION['BAI']=$zeile['Bestellte_Artikel_ID'];
           	$_SESSION['Menge'.$a]=$zeile['Stueck'];
           	$Veredel="";
           	$UnterschiedVer=0;
           	$_SESSION['VerproPro'.$a]=0;
           	$_SESSION['VerID'.$a]=$zeile1['VeredelungenID'];
           	$_SESSION['Posi'.$a]=$zeile1['PositionID'];
           	$_SESSION['Hoch'.$a]=$zeile1['Hochgeladene_Datei'];
           	if($zeile1==null)
           	{
           		$Veredel="Keine Veredelungen!";
           	}
           	else 
           	{
           		$VA=1;
           		while($zeile1!=null)
           		{
           			$_SESSION['VerproPro'.$a]++;
           			if($zeile['Stueck']<21)
           			{
           				$VerAn=1;
           			}
           			else
           			{
           				if($zeile['Stueck']<51)
           				{
           					$VerAn=21;
           				}
           				else
           				{
           					if($zeile['Stueck']<101)
           					{
           						$VerAn=51;
           					}
           					else
           					{
           						if($zeile['Stueck']<251)
           						{
           							$VerAn=101;
           						}
           						else
           						{
           							if($zeile['Stueck']<501)
           							{
           								$VerAn=251;
           							}
           							else
           							{
           								if($zeile['Stueck']<1001)
           								{
           									$VerAn=501;
           								}
           								else
           								{
           									$VerAn=1001;
           								}
           							}
           						}
           							
           					}
           				}
           			}
           				
           			$stmtP=$mysqli->query('SELECT Preis from VeredelungenStück where VeredelungenID="'.$zeile1['VeredelungenID'].'" and Stückzahl='.$VerAn);
           			$zeileP=$stmtP->fetch_array();
           			$_SESSION['PV']=round($zeileP['Preis'],2);
           			$_SESSION['GesamtPV']=$_SESSION['GesamtPV']+round($zeileP['Preis']*$zeile['Stueck'],2);
           			$stmtP->close();
           			
           			$stmtP=$mysqli->query('SELECT Preis from VeredelungenStück where VeredelungenID="'.$zeile1['VeredelungenID'].'" and Stückzahl=1');
           			$zeileP=$stmtP->fetch_array();
           			
           			$Veredel=$Veredel.'<u>Veredelung '.$VA.':</u> <br><b>Art:</b> '.$zeile1['Veredelungsart'].' '.$zeile1['Veredelungsfläche'].'<br><b>Position:</b> '.$zeile1['Position'].'<br><b>Bild:</b> '.$zeile1['Hochgeladene_Datei'].'<br><br>';
           			$UnterschiedVer=$UnterschiedVer+round($zeileP['Preis']*$zeile['Stueck']-$_SESSION['PV']*$zeile['Stueck'],2);
           			
           			$zeile1 = $stmt1->fetch_array();
           			$stmtP->close();
           			$VA++;
           		}
           		$Veredel=str_replace('Ü', '&Uuml;',$Veredel);
           		$Veredel=str_replace('ü', '&Uuml;',$Veredel);
           		$Veredel=str_replace('Ä', '&Auml;',$Veredel);
           		$Veredel=str_replace('ä', '&auml;',$Veredel);
           		$Veredel=str_replace('Ö', '&Ouml;',$Veredel);
           		$Veredel=str_replace('ö', '&ouml;',$Veredel);
           		$Veredel=str_replace('ß', '&szlig;',$Veredel);
           		
           	
           	}
           	
           	if($zeile['Stueck']<10)
           	{
           		$Volume='0';
           	}
           	else
           	{
           		if($zeile['Stueck']<100)
           		{
           			$Volume='10';
           		}
           		else
           		{
           			if($zeile['Stueck']<500)
           			{
           				$Volume='100';
           			}
           			else
           			{
           				if($zeile['Stueck']<1000)
           				{
           					$Volume='500';
           				}
           				else
           				{
           					$Volume='1000';
           				}
           			}
           		}
           	}
           	
           	$stmt2 = $mysqli->query('SELECT Price from SKU_Price where VolumeScale='.$Volume.' and SKU_ColourID="'.$_SESSION['Colour'.$a].'" and SKU_StyleID="'.$_SESSION['Style'.$a].'" and SKU_SizeID="'.$_SESSION['Size'.$a].'"');
           	$zeile2 = $stmt2->fetch_array();
           	$_SESSION['GesamtP']+=$zeile2['Price']*$zeile['Stueck']+$_SESSION['GesamtPV'];
           	$_SESSION['GesamtP1']=$zeile2['Price']*$zeile['Stueck'];
           	$Unterschied=$zeile['Price']*$zeile['Stueck']-$_SESSION['GesamtP1'];
           	//$_SESSION['GesamtP']+=$_SESSION[$zeile['SKU_StyleID'].$zeile['SKU_ColourID'].$zeile['SKU_SizeID']];
           	//$Unterschied=($zeile['Price']-$_SESSION[$zeile['SKU_StyleID'].$zeile['SKU_ColourID'].$zeile['SKU_SizeID']]/$zeile['Stueck'])*$zeile['Stueck'];
           	$Unterschied=str_replace('.', ',',$Unterschied);
           
           	$stmtF = $mysqli->query('SELECT a.Caption, a.SKU_ColourID from Colour_ID_Text a, SKU b where b.SKU_StyleID="'.$zeile['SKU_StyleID'].'" and a.SKU_ColourID = b.SKU_ColourID and b.SKU_SizeID=01');
           	if($stmtF === false)
           	{
           		die(print_r( $mysqli->error ));
           	}
           	$zeileF = $stmtF->fetch_array();
           	
           	$stmtG = $mysqli->query('SELECT a.Caption, a.SKU_SizeID from Size_ID_Text a, SKU b where b.SKU_StyleID="'.$zeile['SKU_StyleID'].'" and a.SKU_SizeID = b.SKU_SizeID and b.SKU_ColourID=001');
           	if($stmtG === false)
           	{
           		die(print_r( $mysqli->error ));
           	}
           	$zeileG = $stmtG->fetch_array();
           	
           	if($zeileB['PictureName']!=null)
           	{
           		$PName=str_replace('\\','/',$zeileB['PictureName']);
				$Pfad="neue_Bilder/".$PName;
				
				$Pfad=str_replace('\\','/',$Pfad);
				
				#-----Ändern---------
				if(substr($PName,0,2)!="01")
				{
				$Pfad='Kein_Bild.jpg';
				}
           	}
           	else 
           	{
           		$Pfad='Kein_Bild.jpg';
           	}
           	/*$PName=$zeileB['PictureName'];
           	if($PName!=null)
           	{
           		$ordner ='Bilder';
           		$alledateien = scandir($ordner);
           		$z=0;
           		foreach ($alledateien as $datei)
           		{
           			if($datei==substr($PName,5,4))
           			{
           				$z=1;
           			}
           		}
           		if($z==1)
           		{
           			$y=0;
           			$ordner1 ='Bilder/'.substr($PName,5,4);
           			$alledateien1 = scandir($ordner1);
           			foreach ($alledateien1 as $datei1)
           			{
           				if($datei1==$PName)
           				{
           					$y=1;
           				}
           			}
           			if($y==1)
           			{
           					
           				$Pfad='Bilder/'.substr($PName,5,4).'/'.$PName;
           			}
           			else
           			{
           				$Pfad='Kein_Bild.jpg';
           			}
           	
           		}else
           		{
           			$Pfad='Kein_Bild.jpg';
           		}
           	}
           	else
           	{
           		$Pfad='Kein_Bild.jpg';
           	}*/
           	
           
           	
           	
           	
           	
           	
            echo'<div id="DIV_min_height_120_W" class="abrunden_15">
                    <div id="DIV_min_height_120_Bild" class="abrunden_20">
                        <img src="'.$Pfad.'" />
                    </div>
                    <div id="DIV_min_height_120_Besch" class="abrunden_20">
                        <span><b>Produkt:</b> '.$zeile['StyleName2'].'<br><b>Beschreibung:</b> '.$zeile['StyleDescription'].'</span>
                    </div>
                    <div id="DIV_min_height_120_Ver" class="abrunden_20">
                        <span>'.$Veredel.'</span>
                    </div>

                    <span class="span40">Farbe:</span>
                    <input readonly type="text" size="11" value="'.$zeile['ColourText'].'" class="abrunden_15" /><br />
                    <span class="span40">Gr&ouml;&szlig;e:</span>
                    <input readonly type="text" size="11" value="'.$zeile['SizeText'].'" class="abrunden_15" /><br />
                    <span class="span40">St&uuml;ck:</span>
                    <input readonly type="text" size="11" value="'.$zeile['Stueck'].'" class="abrunden_15" /><br />
                    <span class="span40">einz.Preis:</span>
                    <input readonly type="text" size="11" value="'.$zeile['Price'].'" class="abrunden_15" /><br />
                    <div id="Zeile_Klein_Auswahl_Links" style="margin-top:0px">
                    </div>
                </div>
                   
                <div id="Warenkorb_ArtikelPreis_Artikel">
                    <label class="TextSchein labelArtikel_1">'.str_replace('.', ',',number_format($_SESSION['GesamtP1'],2,',','.')).' &euro;</label>
                    <label class="TextSchein labelArtikel_2">Artikelpreis:</label>
                </div>';
            		#<div id="Warenkorb_ArtikelPreis_Rabatt">
                    #<label class="TextSchein labelRabatt_1">-'.$UnterschiedVer.' &euro;</label>
                    #<label class="TextSchein labelRabatt_2">Rabatt:</label>
                		#</div>
           	if($_SESSION['GesamtPV']>0)
           	{
                   echo'<div id="Warenkorb_ArtikelPreis_Artikel_Ver">
                    <label class="TextSchein labelArtikel_1">'.str_replace('.', ',',number_format($_SESSION['GesamtPV'],2,',','.')).' &euro;</label>
                    <label class="TextSchein labelArtikel_3">Veredelungspreis:</label>
                </div>';
           	}
                   if(($Unterschied+$UnterschiedVer)>1)
                   {
           			 echo'<div id="Warenkorb_ArtikelPreis_Rabatt">
                    <label class="TextSchein labelRabatt_1">-'.number_format(($Unterschied+$UnterschiedVer),2,',','.').' &euro;</label>
                    <label class="TextSchein labelRabatt_2">Gesamtrabatt:</label>
                		</div>';
                   }
                   if($_SESSION['GesamtPV']>0)
                   {
                		echo'
            		<div id="Warenkorb_ArtikelPreis_Gesamt_Artikel">
                    <label class="TextSchein labelArtikel_1">'.str_replace('.', ',',number_format(($_SESSION['GesamtP1']+$_SESSION['GesamtPV']),2,',','.')).' &euro;</label>
                    <label class="TextSchein labelArtikel_4">Artikelgesamtpreis:</label>
                </div>
            		';}
            $_SESSION['EP'.$a]=str_replace('.', ',',$_SESSION['GesamtP1']);
            $_SESSION['VP'.$a]=str_replace('.', ',',$_SESSION['GesamtPV']);
           $a++;
           }
            ?>
            
             <div id="Warenkorb_ArtikelPreis_Gesamt">
                    <label class="TextSchein labelGesamt_1"><?php echo str_replace('.', ',',number_format(($_SESSION['GesamtP']+$_SESSION['GesamtPV']),2,',','.'));?> &euro;</label>
                    <input type="hidden" value="<?php echo str_replace('.', ',',$_SESSION['GesamtP']+$_SESSION['GesamtPV']);?>" name="hiddenPreis"/>
                    <label class="TextSchein labelGesamt_2">Gesamtpreis:</label>
                </div> 
            
           <?php 
           #Überprüfen ob Benutzer Erst-Kunde ist
           $stmt = $mysqli->query('SELECT Bestellnummer from Bestellungen where Bestellnummer!="Warenkorb" and Kundennummer="'.$_SESSION['Benutzer'].'"');
           $zeile = $stmt->fetch_array();
           if($zeile==null)
           {
           	$Erster="Erstauftr&auml;ge nur mit 100% Anzahlung.";
           }
           else
           {
           	$Erster="";
           }
           
           ?>
           
           
            <div id="DIV_min_height_110_R" class="abrunden_15">
            <?php echo'<span class="span400 TextSchein"><h3>Bestellinformationen</h3></span>';?>
             <span class="span600">Ab einem Bestellwert von 200&euro; ist Ihre Bestellung versandkostenfrei. (Versandkosten: 20&euro;)</span>
             <span class="span600">Zahlungsm&ouml;glichkeit: <b>Auf Rechnung</b></span>
             <span class="span600"><?php echo$Erster;?></span></div>
             <div id="DIV_min_height_110_R" class="abrunden_15">
             <?php echo'<span class="span400 TextSchein"><h3>Kontaktdaten</h3></span>';?>
                <table>
                    <tr>
                        <th width="200px" height="20px" class="abrunden_6">Name</th>
                        <th width="200px" height="20px" class="abrunden_6">Stra&szlig;e</th>
                        <th width="50px" height="20px" class="abrunden_6">PLZ</th>
                        <th width="200px" height="20px" class="abrunden_6">ORT</th>
                        <th width="200px" height="20px" class="abrunden_6">Land</th>
                    </tr>
                    
                    <?php 
                    
                    	#Daten des Benutzers
                    	$stmt = $mysqli->query('SELECT Vorname, Nachname, Strasse, Postleitzahl, Ort, Land from Benutzer where Kundennummer="'.$_SESSION['Benutzer'].'"');
                    	$zeile = $stmt->fetch_array();
                    
                    	if($zeile['Land']=="AT")
                    	{
                    		$Land="&Ouml;sterreich";
                    	}
                    	if($zeile['Land']=="DE")
                    	{
                    		$Land="Deutschland";
                    	}
                    	if($zeile['Land']=="CH")
                    	{
                    		$Land="Schweiz";
                    	}
                    ?>
                    <tr>
                        <td width="200px" height="50px" class="abrunden_6"><?php echo$zeile['Vorname'].' '.$zeile['Nachname'];?></td>
                        <td width="200px" height="50px" class="abrunden_6"><?php echo$zeile['Strasse'];?></td>
                        <td width="50px" height="50px" class="abrunden_6"><?php echo$zeile['Postleitzahl'];?></td>
                        <td width="200px" height="50px" class="abrunden_6"><?php echo$zeile['Ort'];?></td>
                        <td width="200px" height="50px" class="abrunden_6"><?php echo$Land;$stmt->close();?></td>
                    </tr>
                </table>
                <!--<span class="span400ROT">Bitte wählen sie eine Adresse aus</span><br />-->
                <input onclick="Rech1()" type="checkbox" name="Rech" <?php if(isset($_SESSION['Checked'])){if($_SESSION['Checked']=="Rech"){echo' checked ';}}?>/>
                <label for="Rech">Rechnungsadresse verwenden</label><br />
                <input onclick="Lief1()" type="checkbox" name="Lief" <?php if(isset($_SESSION['Checked'])){if($_SESSION['Checked']=="Lief"){echo' checked ';}}?>/>
                <label for="Lief">Andere Lieferadresse w&auml;hlen</label><br />
                
                <?php 
                #Anker
                echo'<a name="Liefer"></a>';
                #Rechnungsadresse anzeigen wenn gewollt
                $stmt = $mysqli->query('SELECT Rechnungsadresse_Strasse, Rechnungsadresse_Postleitzahl, Rechnungsadresse_Ort, Rechnungsadresse_Land from Benutzer where Kundennummer="'.$_SESSION['Benutzer'].'"');
                $zeile = $stmt->fetch_array();
                if($zeile['Rechnungsadresse_Strasse']!="" and isset($_SESSION['Liefer']))
                {
                	if($_SESSION['Liefer']=="ja")
                	{
                	
                		echo'<span class="span66">Stra&szlige:</span>
                		<input name="NeuS" class="input25" size="25" value="'.$zeile['Rechnungsadresse_Strasse'].'" type="text" /><br />
                		<span class="span66">Postleitzahl:</span>
                		<input name="NeuPLZ" class="input25" size="10" value="'.$zeile['Rechnungsadresse_Postleitzahl'].'" type="text" /><br />
                		<span class="span66">Ort:</span>
                		<input name="NeuLand" class="input25" size="25" value="'.$zeile['Rechnungsadresse_Ort'].'" type="text" /><br />
                		<span class="span66">Land:</span>
                		<div id="SelectLand" class="abrunden_15">
                   			<select name="NeuOrt">
                        		<option ';if($zeile['Rechnungsadresse_Land']=="AT"){echo'selected';}
                        		echo' >&Ouml;sterreich</option>
                        		<option ';if($zeile['Rechnungsadresse_Land']=="DE"){echo'selected';}
                        		echo' >Deutschland</option>
                        		<option ';if($zeile['Rechnungsadresse_Land']=="CH"){echo'selected';}
                        		echo' >Schweiz</option>
                    		</select>
               		  </div>';
                	}
                	
                	if($_SESSION['R']=="ja")
                	{
                		echo'<meta http-equiv="refresh" content="0; url=Bestellen.php#Liefer" />';
                		$_SESSION['R']="nein";
                	}
                }
                
                if(isset($_SESSION['Liefer']) and $zeile['Rechnungsadresse_Strasse']=="")
                {
                	if($_SESSION['Liefer']=="ja")
                	{
                		echo'<span class="span66">Stra&szlige:</span>
                		<input name="NeuS" class="input25" size="25" type="text" /><br />
                		<span class="span66">Postleitzahl:</span>
                		<input name="NeuPLZ" class="input25" size="10" type="text" /><br />
                		<span class="span66">Ort:</span>
                		<input name="NeuLand" class="input25" size="25" type="text" /><br />
                		<span class="span66">Land:</span>
                		<div id="SelectLand" class="abrunden_15">
                    		<select name="NeuOrt">
                        		<option>&Ouml;sterreich</option>
                        		<option>Deutschland</option>
                        		<option>Schweiz</option>
                    		</select>
               		  </div>';
                	}
                	if($_SESSION['R']=="ja")
                	{
                		echo'<meta http-equiv="refresh" content="0; url=Bestellen.php#Liefer" />';
                		$_SESSION['R']="nein";
                	}
                }
                
                ?>

                <span class="span400">Bitte geben sie den Sicherheitscode darunter ein</span>
                <div id="DivIMG">
                    <img class="Captureimg" src="captcha.php" />
                    <a href=""><img class="reload" src="reload-icon.png" /></a>
                </div>
                <span class="span66">Sicherheitscode</span>
                <input name="Cap" class="input25" size="25" type="text" /><br />
                <?php echo'<a name="Fehler"></a>';?>
                <span class="span400ROT"><?php if(isset($_SESSION['ErrorBB1'])){echo$_SESSION['ErrorBB1'];}?></span><br />
                <span class="span400"><b>Kommentar zur Bestellung</b></span><br />
                <textarea class="input25a" name="Text"></textarea><br />
                <input type="checkbox" name="AGB" />
                <label for="AGB">AGB Akzeptieren</label><br />
                <button name="Bestellen" class="button_abbrunden15 button180_30_B HintergrundGelbVerlauf">Bestellung abschicken</button><br />
                <!--<div style="clear:both;">-->

                </div>
            </div>
			</form>
<?php  include "zeile.php";?>
        </div>
</body>
</html>

<?php 
if(isset($_POST['Bestellen']))
{
	#Stocks überprüfen
	$a=1;
	while($a<=$_SESSION['WK1'])
	{
		$stmt = $mysqli->query('SELECT count from Stocks where SKU_StyleID="'.$_SESSION['Style'.$a].'" and SKU_ColourID="'.$_SESSION['Colour'.$a].'" and SKU_SizeID="'.$_SESSION['Size'.$a].'"');
		if($stmt === FALSE)
		{
			echo"Fehler: ";
			die(print_r( $mysqli->error ));
		}
		$zeile = $stmt->fetch_array();
		if($zeile==null)
		{
			$_SESSION['ErrorBB1'] ='Kein Stockeintrag vorhanden.';
			echo'<meta http-equiv="refresh" content="0; url=Bestellen.php" />';
		}
		else
		{
			if($zeile['count']<$_SESSION['Menge'.$a])
			{
					$stmt1=$mysqli->query('Select StyleName2 from Styles_Description where SKU_StyleID="'.$_SESSION['Style'.$a].'"');
                	$zeile1 = $stmt1->fetch_array();
                				
                	$stmt2=$mysqli->query('Select Caption from Colour_ID_Text where SKU_ColourID="'.$_SESSION['Colour'.$a].'"');
                	$zeile2 = $stmt2->fetch_array();
                				
                	$stmt3=$mysqli->query('Select Caption from Size_ID_Text where SKU_SizeID="'.$_SESSION['Size'.$a].'"');
                	$zeile3 = $stmt3->fetch_array();
                				
                				
                	$_SESSION['ErrorBB1']='Vom Produkt <b>'.$zeile1['StyleName2'].'</b> mit der Farbe '.$zeile2['Caption'].' und der Gr&ouml;&szlig;e '.$zeile3['Caption'].' sind nur mehr '.$zeile['count'].' St&uuml;ck auf Lager.';
                				
				echo'<meta http-equiv="refresh" content="0; url=Bestellen.php" />';
			}
			else
			{
				$_SESSION['NeuCount'.$a]=$zeile['count']-$_SESSION['Menge'.$a];
			}
		}
		
		$a++;
	}
	
	
	
	
	
	#Captcha überprüfen
	if($_SESSION['captchacode'] != $_POST['Cap'])
	{
		$_SESSION['ErrorBB1'] ='Bitte geben sie den Captcha Code richtig an.';
		echo'<meta http-equiv="refresh" content="0; url=Bestellen.php?A=Fehler" />';
	}
	else
	{
		$_SESSION['EGP']=0;
		#AGB überprüfen
		if(!isset($_POST['AGB']))
		{
			$_SESSION['ErrorBB1'] ='Sie m&uuml;ssen die AGB akzeptieren um eine Bestellung durchzuf&uuml;hren.';
			echo'<meta http-equiv="refresh" content="0; url=Bestellen.php?A=Fehler" />';
		}
		else
		{	
			
			if(!isset($_POST['Lief']) and !isset($_POST['Rech']))
			{
				$_SESSION['ErrorBB1'] ='W&auml;hlen Sie bitte eine der 2 Optionen aus.';
				echo'<meta http-equiv="refresh" content="0; url=Bestellen.php?A=Fehler" />';
			}
			else 
			{
	#Eingabe überprüfen
	if(isset($_POST['Lief']))
	{
		if($_POST['NeuS']==null or $_POST['NeuPLZ']==null or $_POST['NeuLand']==null or $_POST['NeuOrt']==null)
		{
			$_SESSION['ErrorBB1'] ='Bitte geben Sie alle Felder Ihrer Lieferadresse an.';
			echo'<meta http-equiv="refresh" content="0; url=Bestellen.php?A=Fehler" />';
		}
		else 
		{
			if(strlen($_POST['NeuS'])>200 or strlen($_POST['NeuPLZ'])>20 or strlen($_POST['NeuLand'])>100 or strlen($_POST['NeuOrt'])>100)
			{
				$_SESSION['ErrorBB1'] ='Mindestens ein Feld Ihrer Lieferadresse ist zu lang.';
				echo'<meta http-equiv="refresh" content="0; url=Bestellen.php?A=Fehler" />';
			}
			else
			{
			
			
			
		#Lieferadresse ändern
		$stmt = $mysqli->prepare('UPDATE Benutzer SET Rechnungsadresse_Strasse=?, Rechnungsadresse_Postleitzahl=?, Rechnungsadresse_Land=?, Rechnungsadresse_Ort=? where Kundennummer=?');
		if($stmt === FALSE)
		{
			echo"Fehler: ";
			die(print_r( $mysqli->error ));
		}
		$stmt->bind_param("sssss",$_POST['NeuS'],$_POST['NeuPLZ'],$_POST['NeuLand'],$_POST['NeuOrt'],$_SESSION['Benutzer']);
		$stmt->execute();
		$stmt->close();
		}
		}
	}
	
				#Bestellnummer
				$stmt = $mysqli->query('SELECT Bestellnummer from Bestellungen where Bestellnummer!="Warenkorb" order by Bestellnummer desc');
				$zeile = $stmt->fetch_array();
				if($zeile==null)
				{
					$Bestell="Bestell0000000000001";	
				}
				else 
				{
				$Nummer=$zeile['Bestellnummer'];
				$Nummeralt = substr($Nummer,7,20);
				$Nummerneu = $Nummeralt+1;
				$Anzahl = strlen($Nummerneu)+7;
				$Bestell='Bestell';
				while($Anzahl<20)
				{
				$Bestell = $Bestell.'0';
				$Anzahl++;
				}
				$Bestell = $Bestell.$Nummerneu;
				}
				$stmt->close();
	
		#Bestellung erzeugen
	$stmt2 = $mysqli->prepare('INSERT INTO Bestellungen (Bestellnummer, Bestelldatum, Kundennummer, Infotext, Bruttopreis, Nettopreis, Vorname, Nachname, Strasse, Postleitzahl, Ort, Land) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)');
	if($stmt2 === FALSE)
	{
		echo"Fehler: ";
		die(print_r( $mysqli->error ));
	}
	
	if($_POST['Text']==null)
	{
		$Text=" ";
	}
	else
	{
		$Text=$_POST['Text'];
	}
	$Preis=$_POST['hiddenPreis'];
	if($Preis<200)
	{
		$Preis=$Preis+20;
	}
	#$Brutto=str_replace(',','.',$Preis)*1.2;
	#$Netto=$Preis;
	
	$Netto=$_SESSION['GesamtP'];
	$Brutto=($_SESSION['GesamtP'])*1.2;
	$BeDatum=date("Y.m.d");
	
	#Daten des Kunden
	$stmtK = $mysqli->query('SELECT Anrede, Vorname, Nachname, Strasse, Postleitzahl, Ort, Land, Telefonnummer, Fax, Email from Benutzer where Kundennummer="'.$_SESSION['Benutzer'].'"');
	if($stmt === FALSE)
	{
		echo"Fehler: ";
		die(print_r( $mysqli->error ));
	}
	$zeileK = $stmtK->fetch_array();
	$Tele=$zeileK['Telefonnummer'];
	$Email=$zeileK['Email'];
	#Email Klasse
	include'class.phpmailer.php';
	$mail = new PHPMailer();
	$mail1 = new PHPMailer();
	
	#---------------------------------------Email für Leeb-------------------------------------------
	#Sender
	$mail->SetFrom($zeileK['Email'], $zeileK['Anrede'].' '.$zeileK['Nachname']);
	
	#Empfänger
		include'Email_Adresse.php';
	
	#Betreff
	$mail->Subject    = "Bestellung";
	
	#Text zusammenbasteln
	$body='<h1>Bestellung von Benutzer: '.$zeileK['Vorname'].' '.$zeileK['Nachname'].'</h1><br><h2>Produkte:</h2><br>';
	
	#------------------------------------Email für Benutzer-------------------------------------------
	#Sender
	include'Email_Adresse_Sender.php';
	
	#Empfänger
	$mail1->AddAddress($zeileK['Email'], $zeileK['Anrede'].' '.$zeileK['Nachname']);
	
	#Betreff
	$mail1->Subject    = "Ihre Bestellung";
	
	#Text zusammenbasteln
	$body1='<h1>Ihre Bestellung: '.$Bestell.'</h1><br><h2>Produkte:</h2><br>';
	
	if(isset($_POST['Rech']))
	{
		$stmt2->bind_param("ssssddssssss",$Bestell,$BeDatum,$_SESSION['Benutzer'],$Text,$Brutto,$Netto,$zeileK['Vorname'],$zeileK['Nachname'],$zeileK['Strasse'],$zeileK['Postleitzahl'],$zeileK['Ort'],$zeileK['Land']);
	}
	else
	{
		$stmt2->bind_param("ssssddssssss",$Bestell,$BeDatum,$_SESSION['Benutzer'],$Text,$Brutto,$Netto,$zeileK['Vorname'],$zeileK['Nachname'],$_POST['NeuS'],$_POST['NeuPLZ'],$_POST['NeuOrt'],$_POST['NeuLand']);
	}
	$stmt2->execute();
	$stmt2->close();
	$stmtK->close();
	
	$a=1;
	while($a<=$_SESSION['WK1'])
	{
		#Artikel_ID generieren
		$stmt=$mysqli->query('Select Max(Bestellte_Artikel_ID) as MaxNummer from Bestellungen_Warenkorb');
		$zeile = $stmt->fetch_array();
		if($zeile==null)
		{
			$Nummer=0;
		}
		$Nummer=$zeile['MaxNummer'];
		$Nummer++;
		$stmt->close();
	
		#Produkte in der Bestellung
		$stmt3 = $mysqli->prepare('INSERT INTO Bestellungen_Warenkorb (Bestellnummer, Kundennummer, SKU_StyleID, SKU_ColourID, SKU_SizeID, Stueck, Bestellte_Artikel_ID) VALUES(?,?,?,?,?,?,?)');
		if($stmt3 === FALSE)
		{
			echo"Fehler: ";
			die(print_r( $mysqli->error ));
		}
		$stmt3->bind_param("sssssii",$Bestell,$_SESSION['Benutzer'],$_SESSION['Style'.$a],$_SESSION['Colour'.$a],$_SESSION['Size'.$a],$_SESSION['Menge'.$a],$Nummer);
		$stmt3->execute();
		$stmt3->close();
		
		#Stocks aktualisieren
		$stmt3 = $mysqli->prepare('UPDATE Stocks SET count=? where SKU_StyleID=? and SKU_ColourID=? and SKU_SizeID=?');
		$stmt3->bind_param("isss",$_SESSION['NeuCount'.$a],$_SESSION['Style'.$a],$_SESSION['Colour'.$a],$_SESSION['Size'.$a]);
		$stmt3->execute();
		$stmt3->close();
		
		
		#-------------------Email Text--------------------
		
		$stmt1 = $mysqli->query('SELECT Caption from Size_ID_Text where SKU_SizeID="'.$_SESSION['Size'.$a].'"');
		$zeile1 = $stmt1->fetch_array();
		
		$stmt2 = $mysqli->query('SELECT Caption from Colour_ID_Text where SKU_ColourID="'.$_SESSION['Colour'.$a].'"');
		$zeile2 = $stmt2->fetch_array();
		
		$stmt3 = $mysqli->query('SELECT StyleName2 from Styles_Description where SKU_StyleID="'.$_SESSION['Style'.$a].'"');
		$zeile3 = $stmt3->fetch_array();
		
		$body=$body.'<b>'.$a.'. Produkt '.$zeile3['StyleName2'].'</b><br>Größe: '.$zeile1['Caption'].'<br>Farbe: '.$zeile2['Caption'].'<br>Menge: '.$_SESSION['Menge'.$a].'<br>Preis: '.$_SESSION['EP'.$a].' &euro;<br>';
		$body1=$body1.'<b>'.$a.'. Produkt '.$zeile3['StyleName2'].'</b><br>Größe: '.$zeile1['Caption'].'<br>Farbe: '.$zeile2['Caption'].'<br>Menge: '.$_SESSION['Menge'.$a].'<br>Preis: '.$_SESSION['EP'.$a].' &euro;<br>';
		$_SESSION['EGP']=$_SESSION['EGP']+$_SESSION['EP'.$a];
		$stmt1->close();
		$stmt2->close();
		
		#Veredelungen der Produkte
		$b=1;
		if($_SESSION['VerproPro'.$a]>0)
		{
		while($b<=$_SESSION['VerproPro'.$a])
		{
			$stmt=$mysqli->query('Select Max(Veredelnummer) as MaxNummer from Bestellungen_Warenkorb_has_Veredelungen');
			$zeile = $stmt->fetch_array();
			if($zeile==null)
			{
				$Nummer1=0;
			}
			else
			{
				$Nummer1=$zeile['MaxNummer'];
			
				$Nummer1++;
			}
			$stmt->close();
			
			
			
			
			$stmt4 = $mysqli->prepare('INSERT INTO Bestellungen_Warenkorb_has_Veredelungen (Bestellte_ArtikelID, VeredelungenID, PositionID, Hochgeladene_Datei, Versandkosten, Einzelverpackung, Veredelnummer) VALUES(?,?,?,?,?,?,?)');
			if($stmt4 === FALSE)
			{
				echo"Fehler: ";
				die(print_r( $mysqli->error ));
			}
			$VK=0;
			$EV=false;
			$stmt4->bind_param("isisdsi",$Nummer,$_SESSION['VerID'.$b],$_SESSION['Posi'.$b],$_SESSION['Hoch'.$b],$VK,$EV,$Nummer1);
			$stmt4->execute();
			$stmt4->close();
			
			#-----------------Email Text-------------------
			$stmt1 = $mysqli->query('SELECT Veredelungsart, Veredelungsfläche from Veredelungen where VeredelungenID="'.$_SESSION['VerID'.$b].'"');
			$zeile1 = $stmt1->fetch_array();
				
			$stmt2 = $mysqli->query('SELECT Position from Positionen where PositionID="'.$_SESSION['Posi'.$b].'"');
			$zeile2 = $stmt2->fetch_array();
				
			$body=$body.'<b>'.$b.'. Veredelung</b> <br>Art: '.$zeile1['Veredelungsart'].' '.$zeile1['Veredelungsfläche'].'<br>Position: '.$zeile2['Position'].'<br>Bild: '.$_SESSION['Hoch'.$b].'<br>Preis: '.$_SESSION['VP'.$b].' &euro;<br>';
			$body1=$body1.'<b>'.$b.'. Veredelung</b> <br>Art: '.$zeile1['Veredelungsart'].' '.$zeile1['Veredelungsfläche'].'<br>Position: '.$zeile2['Position'].'<br>Bild: '.$_SESSION['Hoch'.$b].'<br>Preis: '.$_SESSION['VP'.$b].' &euro;<br>';
			$stmt1->close();
			$stmt2->close();
			$b++;
	}
		}
	
	#$zeile = $stmt->fetch_array();
	$a++;
	}
	#$stmt->close();
	
	#Warenkorb Veredelungen löschen
	
	$stmt1 = $mysqli->query('SELECT Bestellte_Artikel_ID from Bestellungen_Warenkorb where Bestellnummer="Warenkorb" and Kundennummer="'.$_SESSION['Benutzer'].'"');
	if($stmt1 === FALSE)
	{
		echo"Fehler: ";
		die(print_r( $mysqli->error ));
	}
	$zeile1=$stmt1->fetch_array();
	while($zeile1!=null)
	{
	

	$stmt = $mysqli->prepare('DELETE from Bestellungen_Warenkorb_has_Veredelungen where Bestellte_ArtikelID=?');
	if($stmt === FALSE)
	{
		echo"Fehler: ";
		die(print_r( $mysqli->error ));
	}
	$stmt->bind_param("s",$zeile1['Bestellte_Artikel_ID']);
	$stmt->execute();
	$stmt->close();
	$zeile1=$stmt1->fetch_array();
	}
	
	$WK="Warenkorb";
	#Warenkorb Artikel löschen
	$stmt = $mysqli->prepare('DELETE from Bestellungen_Warenkorb where Bestellnummer=? and Kundennummer=?');
	if($stmt === FALSE)
	{
		echo"Fehler: ";
		die(print_r( $mysqli->error ));
	}
	$stmt->bind_param("ss",$WK,$_SESSION['Benutzer']);
	$stmt->execute();
	$stmt->close();
		}
		
		$_SESSION['WK1']=0;
		$_SESSION['WK']=0.00;
		
		
		#-----------Email abschicken----------------
		$body=$body.'<br><h3>Gesamtpreis:</h3><br>';
		$body=$body.'Netto: '.str_replace('.',',',$_SESSION['GesamtP']).' &euro;<br>';
		$body=$body.'Brutto: '.str_replace('.',',',($_SESSION['GesamtP'])*(1.2)).' &euro;<br>';
		$body=$body.'<br><h3>Sonstige Informationen:</h3><br>';
		$body=$body.'Bestellnummer: '.$Bestell.'<br>Kundennummer: '.$_SESSION['Benutzer'].'<br>Datum: '.date("Y.m.d").' <br>Telefonnummer: '.$Tele.'<br>Email: '.$Email.'<br>';
		$body=$body.'Kommentar zur Bestellung: '.$Text;
		#echo$body;
		$body1=$body1.'<br><h3>Gesamtpreis:</h3><br>';
		$body1=$body1.'Netto: '.str_replace('.',',',$_SESSION['GesamtP']).' &euro;<br>';
		$body1=$body1.'Brutto: '.str_replace('.',',',($_SESSION['GesamtP'])*(1.2)).' &euro;<br>';
		$body1=$body1.'<br><h3>Sonstige Informationen:</h3><br>';
		$body1=$body1.'Bestellnummer: '.$Bestell.'<br>Kundennummer: '.$_SESSION['Benutzer'].'<br>Datum: '.date("Y.m.d").' <br>Telefonnummer: '.$Tele.'<br>Email: '.$Email.'<br>';
		$body1=$body1.'Kommentar zur Bestellung: '.$Text;
		#echo$body1;
		
		#Email senden
		$mail->MsgHTML($body);
		if(!$mail->Send())
		{
		
		}
		else
		{
		
		}
		$mail1->MsgHTML($body1);
		if(!$mail1->Send())
		{
		
		}
		else
		{
		
		}
		echo'<meta http-equiv="refresh" content="0; url=Bestellung_ab.php" />';
		
		
	}
	
	
	
}
}
?>