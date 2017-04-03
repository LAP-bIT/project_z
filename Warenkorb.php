<?php 
#Session starten
session_start();

#Datenbankverbindung
include "DB_Verbindung.php";

#Aus der neuen Suche
unset($_SESSION['Sortieren']);
unset($_SESSION['Caption']);
unset($_SESSION['Ref']);
unset($_SESSION['Sort']);
unset($_SESSION['Filt1']);
unset($_SESSION['Filt2']);
unset($_SESSION['Filt3']);
unset($_SESSION['Filt4']);
unset($_SESSION['Suchtext']);

#Error unseten
unset($_SESSION['ErrorB']);
unset($_SESSION['ErrorBP']);

#Variablen unseten
$a=20;
while($a>0)
{
	$ee=1;
	while($ee<=20)
	{
		unset($_SESSION['G'.$a.$ee]);
		$ee++;
	}
	unset($_SESSION['GAnzahl'.$a]);
	unset($_SESSION['F'.$a]);
	unset($_SESSION['EP'.$a]);
	unset($_SESSION['M'.$a]);
	$a--;
}

unset($_SESSION['EGP']);
unset($_SESSION['AnzahlA']);

$a=20;
while($a>0)
{
	unset($_SESSION['P'.$a]);
	unset($_SESSION['V'.$a]);
	unset($_SESSION['VP'.$a]);
	$a--;
}

unset($_SESSION['AnzahlB']);
unset($_SESSION['R']);
unset($_SESSION['L']);
$_SESSION['Checked']="Rech";
unset($_SESSION['Select']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Webshop f&uuml;r Textilwaren | Mein Warenkorb</title>
    <link href="WebShopStyle.css" rel="stylesheet" type="text/css" />
    <link href="AuswahlStyle.css" rel="stylesheet" type="text/css" />
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script type='text/javascript' src='menu_jquery.js'></script>
    
    <script type="text/javascript">

    function NeuF(Nummer,BAI)
    {
        var NeuFarbe=document.getElementsByName("F"+Nummer)[0].value;
    	window.location.href = "Warenkorb.php?NF=" + escape(NeuFarbe)+"&BAI="+escape(BAI);
    }

    function NeuG(Nummer,BAI)
    {
        var NeuGroesse=document.getElementsByName("G"+Nummer)[0].value;
    	window.location.href = "Warenkorb.php?NG=" + escape(NeuGroesse)+"&BAI="+escape(BAI);
    }

    function NeuS(Nummer,BAI)
    {
        var NeuStueck=document.getElementsByName("S"+Nummer)[0].value;
    	window.location.href = "Warenkorb.php?NeuesS=" + escape(NeuStueck)+"&BAI="+escape(BAI);
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
                    <label id="LabelP"><?php if(!isset($_SESSION['WK'])){ $_SESSION['WK']="0,00 ";}echo $_SESSION['WK']?> &euro;</label>
                  
               
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
        
       
       
			


<!-- #-----------------------------------------------------------------------------------------------------------------------------------------------# -->
        
        <div id="Auswahl">
 <form action="Suche.php"><div><button class="button180_30_Black abrunden_15">zur&uuml;ck zur Suche</button></div></form>
        <h2 style="margin-top:25px;margin-bottom:10px;font-style:oblique;text-decoration:underline;letter-spacing:2px;font-size:20px">KATEGORIEN</h2>
   <div id='cssmenu'>
      <ul>
      
      <?php
	  #Liefert alle Hauptkategorien
	  $stmt1 = $mysqli->query('SELECT DISTINCT Unterkate from Test_Kate where Hauptkate="Produkte"');
	  $zeile1 = $stmt1->fetch_array();
	  
	  while($zeile1!=null)
	  {
	  ?>
     
  
     
     
     <?php  if($zeile1['Unterkate']=="Baby" or $zeile1['Unterkate']=="Frottier" or $zeile1['Unterkate']=="Schirme" or $zeile1['Unterkate']=="Taschen")
	 		{
				echo"<li><a href='Suche.php?Caption=".urlencode($zeile1['Unterkate'])."&Ref=".urlencode($zeile1['Unterkate'])."'><span>".$zeile1['Unterkate']."</span></a>";
			}
			else
				{
					echo"<li class='has-sub'><a href='#'><span>".$zeile1['Unterkate']."</span></a>";
	 ?>
         <ul>
         		<?php
					#Liefert alle Kategorien der Hauptkategorie
				 $stmt2 = $mysqli->query('SELECT DISTINCT Unterkate, Unterunterkate, Anzahl from Test_Kate where Hauptkate="Produkte" and Unterkate="'.$zeile1['Unterkate'].'" order by Anzahl desc');
	  			 $zeile2 = $stmt2->fetch_array();
				 while($zeile2!=null)
				 {
					 #Schreibt die Liste
					 if(urlencode($zeile2['Unterunterkate'])=="Damen" or urlencode($zeile2['Unterunterkate'])=="Kinder")
					 {
					 echo"<li><a href='Suche.php?Caption=".urlencode($zeile2['Unterkate'])."&Ref=".urlencode($zeile2['Unterunterkate'])."'><span>".$zeile2['Unterunterkate']."</span></a></li>";
					 }
					 if(urlencode($zeile2['Unterunterkate'])=="Herren")
					 {
						 echo"<li><a href='Suche.php?Caption=".urlencode($zeile2['Unterkate'])."&Ref=".urlencode($zeile2['Unterunterkate']).'/Unisex'."'><span>".$zeile2['Unterunterkate']."-Unisex</span></a></li>";
					 }
					 $zeile2 = $stmt2->fetch_array();
				 }
				?>                                              
         </ul>
    </li>
    <?php
		
	  }
	  $zeile1 = $stmt1->fetch_array();
	  }
	?>
    </ul>
   </div>
   
   
   <div>
   </div>
   <img class="abrunden_15" src="hotline_11.jpg" />
  </div>
        
		<!-- #-----------------------------------------------------------------------------------------------------------------------------------------------# -->



        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein">warenkorb</label>
            </div>
            <?php 
            $stmt=$mysqli->query('SELECT * from Bestellungen_Warenkorb where Bestellnummer="Warenkorb" and Kundennummer="'.$_SESSION['Benutzer'].'"');
            $zeile=$stmt->fetch_array();
            if($zeile!=null)
            {
            ?>
            <form action="Warenkorb.php" method="post">	
            <div id="OverFunction">
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
           	$stmt1 = $mysqli->query('SELECT c.VeredelungenID, b.Versandkosten, b.Hochgeladene_Datei, c.Veredelungsart, c.Veredelungsfläche, d.Preis, e.Position from Bestellungen_Warenkorb a, Bestellungen_Warenkorb_has_Veredelungen b, Veredelungen c, VeredelungenStück d, Positionen e where a.Bestellnummer="Warenkorb" and a.Kundennummer="'.$_SESSION['Benutzer'].'" and a.Bestellte_Artikel_ID = b.Bestellte_ArtikelID and b.VeredelungenID = c.VeredelungenID and c.VeredelungenID = d.VeredelungenID and d.Stückzahl<5 and b.PositionID = e.PositionID and a.SKU_StyleID="'.$zeile['SKU_StyleID'].'" and a.SKU_ColourID="'.$zeile['SKU_ColourID'].'" and a.SKU_SizeID="'.$zeile['SKU_SizeID'].'" and a.Bestellte_Artikel_ID="'.$zeile['Bestellte_Artikel_ID'].'"');
           	$zeile1 = $stmt1->fetch_array();
           	$_SESSION['Size'.$a]=$zeile['SKU_SizeID'];
           	$_SESSION['Colour'.$a]=$zeile['SKU_ColourID'];
           	$_SESSION['Style'.$a]=$zeile['SKU_StyleID'];
           	$_SESSION['BAI']=$zeile['Bestellte_Artikel_ID'];
           	$UnterschiedVer=0;
           	$Veredel="";
           	if($zeile1==null)
           	{
           		$Veredel="Keine Veredelungen!";
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
           			
           			$Veredel=$Veredel.'<u>Veredelung '.$VA.':</u> <br><b>Art:</b> '.$zeile1['Veredelungsart'].' '.$zeile1['Veredelungsfläche'].'<br><b>Position:</b> '.$zeile1['Position'].'<br><b>Bild:</b> '.$zeile1['Hochgeladene_Datei'].'<br><br>';
           			$UnterschiedVer=round($zeileP['Preis']*$zeile['Stueck']-$_SESSION['PV']*$zeile['Stueck'],2);
           			
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
           
           	$stmtF = $mysqli->query('SELECT DISTINCT a.Caption, a.SKU_ColourID from Colour_ID_Text a, SKU b where b.SKU_StyleID="'.$zeile['SKU_StyleID'].'" and a.SKU_ColourID = b.SKU_ColourID');
           	if($stmtF === false)
           	{
           		die(print_r( $mysqli->error ));
           	}
           	$zeileF = $stmtF->fetch_array();
           	
           	$stmtG = $mysqli->query('SELECT DISTINCT a.Caption, a.SKU_SizeID from Size_ID_Text a, SKU b where b.SKU_StyleID="'.$zeile['SKU_StyleID'].'" and a.SKU_SizeID = b.SKU_SizeID');
           	if($stmtG === false)
           	{
           		die(print_r( $mysqli->error ));
           	}
           	$zeileG = $stmtG->fetch_array();
           	
           	if($zeileB['PictureName']!=null)
           	{
           		$PName=str_replace('\\','/',$zeileB['PictureName']);
				$Pfad="neue_Bilder/".$PName;
           	}
           	else 
           	{
           		$Pfad='Kein_Bild.jpg';
           		$PName='Kein_Bild.jpg';
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
           	
            $Pfad=str_replace('\\','/',$Pfad);
            		
            		#-----Ändern---------
            		if(substr($PName,0,2)!="01")
            		{
            			$Pfad='Kein_Bild.jpg';
            		}
           	
           	
           	
           	
           	
           echo' <div id="DIV_min_height_120_W" class="abrunden_15">
                        <div id="DIV_min_height_120_Bild" class="abrunden_20">
                            <img src="'.$Pfad.'" />
                        </div>
                        <div id="DIV_min_height_120_Besch" class="abrunden_20">
                            <span><b>Produkt:</b> '.$zeile['StyleName2'].'<br><b>Beschreibung:</b> '.$zeile['StyleDescription'].'</span>
                        </div>
                        <div id="DIV_min_height_120_Ver" class="abrunden_20">
                            <span>';
                            	echo$Veredel;
                            echo'</span>
                        </div>
                        <div id="DIV_Zeile_Warenkorb">
                            <span class="span40">Farbe:</span>
                            <div id="SelectFarbe" class="abrunden_15">
                                <select name="F'.$a.'" onchange="NeuF('.$a.','.$_SESSION['BAI'].')" style="cursor:pointer;">';
                                    while($zeileF!=null)
                                    {
                                    	echo'<option ';
                					if($zeile['SKU_ColourID']==$zeileF['SKU_ColourID'] ){echo'selected';}
									echo' value="'.$zeileF['SKU_ColourID'].'">'.$zeileF['Caption'].'</option>';
                                    	$zeileF = $stmtF->fetch_array();
                                    }
                                echo'</select>
                            </div>
                        </div>
                        <div id="DIV_Zeile_Warenkorb">
                            <span class="span40">Gr&ouml;&szlig;e:</span>
                            <div id="SelectFarbe" class="abrunden_15">
                                <select name="G'.$a.'" onchange="NeuG('.$a.','.$_SESSION['BAI'].')" style="cursor:pointer;">';
                                while($zeileG!=null)
                                {
                                	echo'<option ';
                                	if($zeile['SKU_SizeID']==$zeileG['SKU_SizeID'] ){echo'selected';}
                                	echo' value="'.$zeileG['SKU_SizeID'].'">'.$zeileG['Caption'].'</option>';
                                	$zeileG = $stmtG->fetch_array();
                                }
                                echo'</select>
                            </div>
                        </div>
                                    		
                        <span class="span40">St&uuml;ck:</span>
                        <input name="S'.$a.'" onchange="NeuS('.$a.','.$_SESSION['BAI'].')" value="'.$zeile['Stueck'].'" type="text" size="11" class="abrunden_15" /><br />
                        <span class="span40">einz.Preis:</span>
                        <input readonly value="'.str_replace('.', ',',$zeile['Price']).' &euro;" type="text" size="11" class="abrunden_15" /><br />
            		
                          	
                        <div id="Zeile_Klein_Auswahl_Links" style="margin-top:0px">
                            <button name="Weg'.$a.'" class="abrunden_6" style="background: url(loeschen_button_11.png) 100% 50% no-repeat #ffffff"></button>
                            <label>Artikel aus dem Warenkorb entfernen</label>
                        </div>
                      
                   </div>
                <div id="Warenkorb_ArtikelPreis_Artikel">
                    <label class="TextSchein labelArtikel_1">'.str_replace('.', ',',number_format($_SESSION['GesamtP1'],2,',','.')).' &euro;</label>
                    <label class="TextSchein labelArtikel_2">Artikelpreis:</label>
                </div>';
            		#echo'<div id="Warenkorb_ArtikelPreis_Rabatt">
                    #<label class="TextSchein labelRabatt_1">-'.$UnterschiedVer.' &euro;</label>
                    #<label class="TextSchein labelRabatt_2">Rabatt:</label>
                		#</div>';
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
                    <label class="TextSchein labelRabatt_1">-'.str_replace('.', ',',number_format(($Unterschied+$UnterschiedVer),2,',','.')).' &euro;</label>
                    <label class="TextSchein labelRabatt_2">Gesamtrabatt:</label>
                		</div>';
                    }
                  if($_SESSION['GesamtPV']>0)
                  {
            		echo'<div id="Warenkorb_ArtikelPreis_Gesamt_Artikel">
                    <label class="TextSchein labelArtikel_1">'.str_replace('.', ',',number_format(($_SESSION['GesamtP1']+$_SESSION['GesamtPV']),2,',','.')).' &euro;</label>
                    <label class="TextSchein labelArtikel_4">Artikelgesamtpreis:</label>
                </div>
            		';
            }
           $a++;
           }
           $stmt->close();
           #$stmt1->close();
           if($_SESSION['WK']!=str_replace('.',',',$_SESSION['GesamtP']))
           {
           	$_SESSION['WK']=str_replace('.',',',$_SESSION['GesamtP']);
           	echo'<meta http-equiv="refresh" content="0; url=Warenkorb.php" />';
           }
           
           ?>
                

                <div id="Warenkorb_ArtikelPreis_Gesamt">
                    <label class="TextSchein labelGesamt_1"><?php echo str_replace('.', ',',number_format($_SESSION['GesamtP'],2,',','.'));?> &euro;</label>
                    <label class="TextSchein labelGesamt_2">Gesamtpreis:</label>
                    <div><button name="Bestellen" class="button180_30_Korb HintergrundGelbVerlauf abrunden_15">zur Kassa</button></div>
                </div> 
                
                
                </div>
                 </form>
                 <form action="Warenkorb.php" method="post">	
                 <div style="margin-top:5px">
                 <button name="Leeren" class="button180_30_Korb HintergrundGelbVerlauf abrunden_15">Warenkorb leeren</button>
                 </div>
                 </form>
                 <?php }
                 else
                 {
                 	echo'<h3>Ihr Warenkorb ist leer.</h3>';
                 }?>
        </div>
<?php  include "zeile.php";?>
    </div>
</body>
</html>
<?php 
#Alles Löschen
if(isset($_POST['Leeren']))
{
	$stmt=$mysqli->query('Select Bestellte_Artikel_ID from Bestellungen_Warenkorb where Bestellnummer="Warenkorb" and Kundennummer="'.$_SESSION['Benutzer'].'"');
                	$zeile = $stmt->fetch_array();
                	$ID=$zeile['Bestellte_Artikel_ID'];
                	
                	while($zeile!=null)
                	{
                		
                	$stmt1 = $mysqli->prepare('DELETE from Bestellungen_Warenkorb_has_Veredelungen where Bestellte_ArtikelID=?');
                	if($stmt1 === FALSE)
                	{
                		echo"Fehler: ";
                		die(print_r( $mysqli->error ));
                	}
                	$stmt1->bind_param("s",$ID);
                	$stmt1->execute();
                	$stmt1->close();
                	$zeile = $stmt->fetch_array();
                	$ID=$zeile['Bestellte_Artikel_ID'];
                	}
                	
                	$stmt = $mysqli->prepare('DELETE from Bestellungen_Warenkorb where Bestellnummer=? and Kundennummer=?');
                	if($stmt === FALSE)
                	{
                		echo"Fehler: ";
                		die(print_r( $mysqli->error ));
                	}
                	$WK="Warenkorb";
                	$stmt->bind_param("ss",$WK,$_SESSION['Benutzer']);
                	$stmt->execute();
                	$stmt->close();
                	$_SESSION['WK1']="0";
                	$_SESSION['WK']="0,00";
                	echo'<meta http-equiv="refresh" content="0; url=Warenkorb.php" />';
}




#Einzeln Löschen
                $b=1;
                while($b<=$_SESSION['WK1'])
                {
                if(isset($_POST['Weg'.$b]))
                {
                	
                	#Produkt aus dem WK löschen
                	$stmt=$mysqli->query('Select Bestellte_Artikel_ID from Bestellungen_Warenkorb where Bestellnummer="Warenkorb" and Kundennummer="'.$_SESSION['Benutzer'].'" and SKU_StyleID="'.$_SESSION['Style'.$b].'" and SKU_SizeID="'.$_SESSION['Size'.$b].'" and SKU_ColourID="'.$_SESSION['Colour'.$b].'"');
                	$zeile = $stmt->fetch_array();
                	$ID=$zeile['Bestellte_Artikel_ID'];
                	$stmt->close();
                	
                	
                	$stmt = $mysqli->prepare('DELETE from Bestellungen_Warenkorb_has_Veredelungen where Bestellte_ArtikelID=?');
                	if($stmt === FALSE)
                	{
                		echo"Fehler: ";
                		die(print_r( $mysqli->error ));
                	}
                	$stmt->bind_param("s",$ID);
                	$stmt->execute();
                	$stmt->close();
                	
                	$stmt = $mysqli->prepare('DELETE from Bestellungen_Warenkorb where Bestellnummer=? and Kundennummer=? and SKU_StyleID=? and SKU_SizeID=? and SKU_ColourID=?');
                	if($stmt === FALSE)
                	{
                		echo"Fehler: ";
                		die(print_r( $mysqli->error ));
                	}
                	$WK="Warenkorb";
                	$stmt->bind_param("sssss",$WK,$_SESSION['Benutzer'],$_SESSION['Style'.$b],$_SESSION['Size'.$b],$_SESSION['Colour'.$b]);
                	$stmt->execute();
                	$stmt->close();
                	$_SESSION['WK1']--;
                	echo'<meta http-equiv="refresh" content="0; url=Warenkorb.php" />';
                }
                $b++;
                }
                
                if(isset($_POST['Bestellen']))
                {
                	echo'<meta http-equiv="refresh" content="0; url=Bestellen.php" />';
                }
                
                if(isset($_REQUEST['NF']))
                {
                	#Neue Farbe
                	$stmt = $mysqli->prepare('UPDATE Bestellungen_Warenkorb SET SKU_ColourID=? where Bestellte_Artikel_ID=?');
                	if($stmt === FALSE)
                	{
                		echo"Fehler: ";
                		die(print_r( $mysqli->error ));
                	}
                	$stmt->bind_param("si",$_REQUEST['NF'],$_REQUEST['BAI']);
                	$stmt->execute();
                	$stmt->close();
                	echo'<meta http-equiv="refresh" content="0; url=Warenkorb.php" />';
                }
                
                if(isset($_REQUEST['NG']))
                {
                	#Neue Größe
                	$stmt = $mysqli->prepare('UPDATE Bestellungen_Warenkorb SET SKU_SizeID=? where Bestellte_Artikel_ID=?');
                	if($stmt === FALSE)
                     {
                      echo"Fehler: ";
                      die(print_r( $mysqli->error ));
                      }
                      $stmt->bind_param("si",$_REQUEST['NG'],$_REQUEST['BAI']);
                      $stmt->execute();
                      $stmt->close();
                      echo'<meta http-equiv="refresh" content="0; url=Warenkorb.php" />';
                }
                
                if(isset($_REQUEST['NeuesS']))
                {
                	#Neue Anzahl
                	$stmt = $mysqli->prepare('UPDATE Bestellungen_Warenkorb SET Stueck=? where Bestellte_Artikel_ID=?');
                	if($stmt === FALSE)
                	{
                		echo"Fehler: ";
                		die(print_r( $mysqli->error ));
                	}
                	$stmt->bind_param("ii",$_REQUEST['NeuesS'],$_REQUEST['BAI']);
                	$stmt->execute();
                	$stmt->close();
                	echo'<meta http-equiv="refresh" content="0; url=Warenkorb.php" />';
                }
                
                ?>