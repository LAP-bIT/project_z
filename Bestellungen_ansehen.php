<?php 
#Session starten
session_start();

#Datenbankverbindung
include "DB_Verbindung.php";

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Webshop f&uuml;r Textilwaren | Meine Bestellungen</title>
    <link href="WebShopStyle.css" rel="stylesheet" type="text/css" />
    <link href="AuswahlStyle.css" rel="stylesheet" type="text/css" />
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script type='text/javascript' src='menu_jquery.js'></script>

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
        <form action="PWaendern.php" method="post">
        <div id="Auswahl">
            <button name="Suche" class="ButtonKontoKlein abrunden_15 HintergrundGrauVerlauf">Zur&uuml;ck<br />zur Suche</button>
            <button name="Bestell" class="ButtonKontoKlein abrunden_15 HintergrundGelbVerlauf">Meine<br />Bestellungen</button>
            <button name="PWandern" class="ButtonKontoKlein abrunden_15 HintergrundGelbVerlauf">Passwort<br />&auml;ndern</button>
            <button name="Kontoandern" class="ButtonKontoKlein abrunden_15 HintergrundGelbVerlauf">Kontodaten<br />&auml;ndern</button>
            
        </div>
        </form>

        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein">meine Bestellungen</label>
            </div>
            <div id="OverFunction">

            <?php 
            #Anzahl der Bestellungen plus alle Daten
            $stmtH = $mysqli->query('SELECT Bestellnummer, Bestelldatum, Kundennummer, Infotext, Bruttopreis, Nettopreis from Bestellungen where Bestellnummer!="Warenkorb" and Kundennummer="'.$_SESSION['Benutzer'].'" order by Bestellnummer desc');
            $zeileH=$stmtH->fetch_array();
            $a=$stmtH->num_rows;
            #$a=5;
            while($zeileH!=null)
            {
            	$Bestell=$zeileH['Bestellnummer'];
            	
            	#Anzahl der Artikel pro Bestellung
                $stmtA=$mysqli->query('SELECT count(Bestellte_Artikel_ID) as Anzahl from Bestellungen_Warenkorb where Bestellnummer="'.$Bestell.'" and Kundennummer="'.$_SESSION['Benutzer'].'"');
                $zeileA=$stmtA->fetch_array();
                
            echo'<div id="Uebersicht" class="abrunden_15 HintergrundGrauVerlauf">
                    <table>
                        <tr>
                            <td width="80px" class="W_Übersicht">Nr.: '.$a.'</td>
                            <td width="240px" class="W_Übersicht">Preis: '.str_replace('.', ',',number_format($zeileH['Bruttopreis'],2,',','.')).' &euro;</td>
                            <td width="170px" class="W_Übersicht">Artikel: '.$zeileA['Anzahl'].'</td>
                            <td width="170px" class="W_Übersicht">'.$zeileH['Bestelldatum'].'</td>
                        </tr>
                    </table>
                </div>
                
                <div id="Uebersicht" class="abrunden_15 HintergrundGrauVerlauf">
                    <table>
                        <tr>
                            <td width="80px" class="W_Übersicht">Bild</td>
                            <td width="240px" class="W_Übersicht">Beschreibung</td>
                            <td width="170px" class="W_Übersicht">Veredelung</td>
                            <td width="170px" class="W_Übersicht">Klein&uuml;bersicht</td>
                        </tr>
                    </table>
                </div>';
           	#Daten zum bestellten Artikel
            $stmt = $mysqli->query('SELECT c.Bestellte_Artikel_ID, a.Price, c.Stueck, b.SKU_StyleID, b.SKU_ColourID, b.SKU_SizeID, d.Caption as SizeText, e.Caption as ColourText, g.StyleDescription, g.StyleName2 from SKU_Price a, SKU b, Bestellungen_Warenkorb c, Size_ID_Text d, Colour_ID_Text e, Styles f, Styles_Description g where a.SKU_StyleID = b.SKU_StyleID and a.SKU_SizeID = b.SKU_SizeID and a.SKU_ColourID = b.SKU_ColourID and c.SKU_StyleID = b.SKU_StyleID and c.SKU_SizeID = b.SKU_SizeID and c.SKU_ColourID = b.SKU_ColourID and c.Bestellnummer="'.$Bestell.'" and c.Kundennummer="'.$_SESSION['Benutzer'].'" and a.VolumeScale=0 and b.SKU_SizeID =d.SKU_SizeID and b.SKU_ColourID = e.SKU_ColourID and b.SKU_StyleID = f.SKU_StyleID and f.SKU_StyleID = g.SKU_StyleID and g.LanguageISO="DE"');
            $zeile=$stmt->fetch_array();
            
            #Bild des Artikels
            $stmtB=$mysqli->query('SELECT PictureName from SKU_PS where SKU_StyleID="'.$zeile['SKU_StyleID'].'" and SKU_SizeID="'.$zeile['SKU_SizeID'].'" and SKU_ColourID="'.$zeile['SKU_ColourID'].'"');
            $zeileB=$stmtB->fetch_array();
            $b=1;
            #$_SESSION['GesamtP']=0;
            while($zeileA['Anzahl']>=$b)
            {
            	$_SESSION['GesamtPV']=0;
            	$stmtB=$mysqli->query('SELECT PictureName from SKU_PS where SKU_StyleID="'.$zeile['SKU_StyleID'].'" and SKU_SizeID="'.$zeile['SKU_SizeID'].'" and SKU_ColourID="'.$zeile['SKU_ColourID'].'"');
            	
            	#Veredelungen des Artikels
            	$stmt1 = $mysqli->query('SELECT b.Versandkosten, b.Hochgeladene_Datei, c.Veredelungsart, c.Veredelungsfläche, c.VeredelungenID, d.Preis, e.Position from Bestellungen_Warenkorb a, Bestellungen_Warenkorb_has_Veredelungen b, Veredelungen c, VeredelungenStück d, Positionen e where a.Bestellnummer="'.$Bestell.'" and a.Kundennummer="'.$_SESSION['Benutzer'].'" and a.Bestellte_Artikel_ID = b.Bestellte_ArtikelID and b.VeredelungenID = c.VeredelungenID and c.VeredelungenID = d.VeredelungenID and d.Stückzahl<5 and b.PositionID = e.PositionID and a.SKU_StyleID="'.$zeile['SKU_StyleID'].'" and a.SKU_ColourID="'.$zeile['SKU_ColourID'].'" and a.SKU_SizeID="'.$zeile['SKU_SizeID'].'" and a.Bestellte_Artikel_ID="'.$zeile['Bestellte_Artikel_ID'].'"');
            	$zeile1 = $stmt1->fetch_array();
            	
            	$Veredel="";
            	if($zeile1==null)
            	{
            		$Veredel="Keine Veredelungen!";
            		$UnterschiedVer=0;
            	}
            	else
            	{
            		$VA=1;
            		while($zeile1!=null)
            		{
            			
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
            			
            				
            				$UnterschiedVer=round($zeileP['Preis']*$zeile['Stueck']-$_SESSION['PV']*$zeile['Stueck'],2);
            			
            			$Veredel=$Veredel.'<u>Veredelung '.$VA.':</u> <br><b>Art:</b> '.$zeile1['Veredelungsart'].'<br><b>Fl&auml;che:</b> '.$zeile1['Veredelungsfläche'].'<br><b>Position:</b> '.$zeile1['Position'].'<br><b>Bild:</b> '.$zeile1['Hochgeladene_Datei'].'<br><br>';
            			$zeile1 = $stmt1->fetch_array();
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
            	if($zeileB!=null)
            	{
            		$PName=str_replace('\\','/',$zeileB['PictureName']);
            		$Pfad="Bilder/".$PName;
            	}
            	else
            	{
            		$Pfad='Kein_Bild.jpg';
            		$PName='Kein_Bild.jpg';
            	}
            	
            	
            	#VolumeScale bestimmen
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
            	
            	#Preis selecten und berechnen
            	$stmt2 = $mysqli->query('SELECT Price from SKU_Price where VolumeScale='.$Volume.' and SKU_ColourID="'.$zeile['SKU_ColourID'].'" and SKU_StyleID="'.$zeile['SKU_StyleID'].'" and SKU_SizeID="'.$zeile['SKU_SizeID'].'"');
            	$zeile2 = $stmt2->fetch_array();
            	#$_SESSION['GesamtP']+=$zeile2['Price']*$zeile['Stueck'];
            	$_SESSION['GesamtP1']=$zeile2['Price']*$zeile['Stueck'];
            	$Unterschied=$zeile['Price']*$zeile['Stueck']-$_SESSION['GesamtP1'];
            	$Unterschied=str_replace('.', ',',$Unterschied);
            	
            $Pfad=str_replace('\\','/',$Pfad);
            		
            		#-----Ändern---------
            		if(substr($PName,0,8)!="01/0002/")
            		{
            			$Pfad='Kein_Bild.jpg';
            		}
            	 
            	
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
                    <label class="TextSchein labelRabatt_2">Gesamtrabatt:</label></div>';
                    }
                    if($_SESSION['GesamtPV']>0)
                    {
                echo'
            		<div id="Warenkorb_ArtikelPreis_Gesamt_Artikel">
                    <label class="TextSchein labelArtikel_1">'.str_replace('.', ',',number_format(($_SESSION['GesamtP1']+$_SESSION['GesamtPV']),2,',','.')).' &euro;</label>
                    <label class="TextSchein labelArtikel_4">Artikelgesamtpreis:</label>
                </div>';}
                $zeile=$stmt->fetch_array();
                $b++;
            }
           $a--;
            $zeileH=$stmtH->fetch_array();
			}?>
                

            </div>

        </div>
<?php  include "zeile.php";?>
    </div>
</body>
</html>