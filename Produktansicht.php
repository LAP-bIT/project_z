<?php

#-----------------------------------------------------------------------------------------------------------------------------------------#
#-----------------------------------------------------------------------------------------------------------------------------------------#
#------------------------------------------#Produkansicht NEU - AJAX & jQuery#------------------------------------------------------------#
#-----------------------------------------------------------------------------------------------------------------------------------------#
#-----------------------------------------------------------------------------------------------------------------------------------------#

#Session starten
session_start();


#Id des Produktes
if(isset($_GET['id']))
{
	$Style=$_GET['id'];
	$_SESSION['id']=$_GET['id'];
	
}
else 
{
	$Style=$_SESSION['id'];
}
	


#Datenbankverbindung
include "DB_Verbindung.php";

if(isset($_GET['A']))
{
	echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php#'.$_GET['A'].'" />';
}


$stmt1=$mysqli->query('Select StyleName2 from Styles_Description where SKU_StyleID="'.$_SESSION['id'].'"');
$zeile1 = $stmt1->fetch_array();
$Titel=$zeile1['StyleName2'];
$stmt1->close();
unset($_SESSION['Select']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Webshop f&uuml;r Textilwaren | <?php echo$Titel;?></title>
    <link href="WebShopStyle.css" rel="stylesheet" type="text/css" />
    <link href="AuswahlStyle.css" rel="stylesheet" type="text/css" />
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script type='text/javascript' src='menu_jquery.js'></script>
    
    <script type="text/javascript">

function Vllt() {
	var pos = $(".thumbs").position();
	if (pos.left < 0)
	{
		$( ".thumbs" ).animate({
		    left: "+=233"
		  }, 1000, function() {
		    // Animation complete.
		  });
	}
	
}

function Vllt1() {

	var breite = 0;
    $(".thumbs img").each(function(index){
    	breite += $(this).width();
    	breite += parseInt($(this).css("margin-right"));
    });
    $(".thumbs").width(breite);
    var breiteDiv = $("#weitere").width();
	
	var pos = $(".thumbs").position();
	if (pos.left > (breite * -1) + breiteDiv)
	{
		$( ".thumbs" ).animate({
		    left: "-=233"
		  }, 1000, function() {
		    // Animation complete.
		  });
	}
}



function Fenster()
{
	Info = window.open("VeredelINFO.php");
	Info.focus();
}


    
function Teil (Nummer,Gesamt,Hauptnummer)
{
	var Gesamtmenge=parseInt(document.getElementsByName("Menge"+Hauptnummer)[0].value);
	if(isNaN(Gesamtmenge)==true)
	{
		document.getElementById("Fehler").innerHTML="Geben sie nur ganze Zahlen in das Mengenfeld ein.";
		location.hash="Fehler";
	}
	else
	{
	var Hilfe=1;
	while(Hilfe<=Gesamt)
	{
		var Einzelmenge = (document.getElementById("Groessen"+Hauptnummer+Hilfe).value).replace('.',',');
		
		if(isNaN(Einzelmenge)==true )
		{
			document.getElementById("Fehler").innerHTML="Geben sie nur ganze Zahlen in das Mengenfeld ein.";
			location.hash="Fehler";
			Hilfe=Gesamt;
		}
		else
		{
			Einzelmenge = parseInt(Einzelmenge);
		if(Gesamtmenge<Einzelmenge)
		{
			document.getElementById("Fehler").innerHTML="Die Mengeeingabe im "+Hilfe+". Feld überschreitet die Gesamtmenge.";
			location.hash="Fehler";
			Hilfe=Gesamt;
		}
		else
		{
			document.getElementById("Fehler").innerHTML="";
		}
		Gesamtmenge=Gesamtmenge-Einzelmenge;
	}
		Hilfe=Hilfe+1;
	}
	}
}
    
function Rechne (Menge,Nummer,MengeG,VerID,MengeV) {
	MengeG=document.getElementsByClassName("bla1").length;
	MengeV=document.getElementsByClassName("bla").length;
	Menge=document.getElementsByName("Menge"+Nummer)[0].value;
	var Menge1=document.getElementsByName("Menge"+Nummer)[0].value;

	
	VerID=document.getElementsByName("Ver"+	MengeV)[0].value;
Menge = Menge.replace('.',',');
if(isNaN(Menge)==true )
{
	document.getElementById("Fehler").innerHTML="Geben sie nur ganze Zahlen in das Mengenfeld ein.";
	var Anzahl='Gesamt'+Nummer;
	document.getElementById(Anzahl).innerHTML=0;
	document.getElementsByName("GesamtH"+Nummer)[0].value=0;
	location.hash="Fehler";
}
else
{
	 var apfel=1;
	Menge=0;
	while(apfel<(MengeG+1))
	{
		Menge = parseInt(Menge)+parseInt(document.getElementsByName("Menge"+apfel)[0].value);
		apfel=apfel+1;
	}
		
		if(Menge<21)
		{
			var Index1=0;
		}
		else
		{
			if(Menge<51)
			{
				var Index1=6;
			}
			else
			{
				if(Menge<101)
				{
					var Index1=12;
				}
				else
				{
					if(Menge<251)
					{
						var Index1=18;
					}
					else
					{
						if(Menge<501)
						{
							var Index1=24;
						}
						else
						{
							if(Menge<1001)
							{
								var Index1=30;
							}
							else
							{
								var Index1=36;
							}
						}
					}
				}
			}
		}

		var Help=1;
		while(Help<(MengeV+1))
		{
			if(document.getElementsByName("Ver"+Help)[0].value!="Nix" && document.getElementsByName("Ver"+Help)[0].value!="KA")
			{
				var hidden="Veredel"+document.getElementsByName("Ver"+Help)[0].value;
				var VerKosten=document.getElementsByName(hidden)[0].value;
				var VerEinzel=VerKosten.substring(Index1,(Index1+5));
				document.getElementById("GesamtV"+Help).innerHTML=((VerEinzel*Menge).toFixed(2)).replace('.',',')+' \u20AC';
				document.getElementsByName("GesamtVH"+Help)[0].value=((VerEinzel*Menge).toFixed(2)).replace('.',',');
			}
			else
			{
				document.getElementById("GesamtV"+Help).innerHTML="0,00"+' \u20AC';
				document.getElementsByName("GesamtVH"+Help)[0].value="0,00";
			}
		Help=Help+1;
		}
		


	
	
	document.getElementById("Fehler").innerHTML="";
	if(Menge<10)
	{
		var Volume='0';
		var Index=0;
	}
	else
	{
		if(Menge<100)
		{
			var Volume='10';
			var Index=5;
		}
		else
		{
			if(Menge<500)
			{
				var Volume='100';
				var Index=10;
			}
			else
			{
				if(Menge<1000)
				{
					var Volume='500';
					var Index=15;
				}
				else
				{
					var Volume='1000';
					var Index=20;
				}
			}
		}
	}
	
	//var Produkt = 'A'+document.getElementsByName("Groessen"+Nummer)[0].value+document.getElementsByName("Farbe"+Nummer)[0].value+Volume;
	//var Produkt = 'A'+document.getElementsByName("Groessen"+Nummer)[0].value+document.getElementsByName("Farbe"+Nummer)[0].value;
	var Produkt = 'A'+document.getElementsByName("Farbe"+Nummer)[0].value;
	var Anzahl='Gesamt'+Nummer;
	var Inhalt = document.getElementsByName(Produkt)[0].value;
	var Inhalte = Inhalt.substring(Index,(Index+5));
	
	document.getElementById(Anzahl).innerHTML=((Inhalte*Menge1).toFixed(2)).replace('.',',')+' \u20AC';
	document.getElementsByName("GesamtH"+Nummer)[0].value=((Inhalte*Menge1).toFixed(2)).replace('.',',');

	
	
	//document.getElementById(Anzahl).innerHTML=((document.getElementsByName(Produkt)[0].value*Menge).toFixed(2)).replace('.',',')+' \u20AC';
	//document.getElementsByName("GesamtH"+Nummer)[0].value=((document.getElementsByName(Produkt)[0].value*Menge).toFixed(2)).replace('.',',')+' \u20AC';

	var Wert2=0;
	
	while(MengeG>0)
	{
		var Anzahl1='Gesamt'+MengeG;
		var Wert=(document.getElementById(Anzahl1).innerHTML).split(" ");
		var Wert1= Wert[0].replace(',','.');
		if(Wert1=="")
		{
		Wert1='0';
		}
		Wert2 =parseFloat(Wert2)+parseFloat(Wert1);

		MengeG=MengeG-1;
	}
	while(MengeV>0)
	{
		var Anzahl2='GesamtV'+MengeV;
		var Wert=(document.getElementById(Anzahl2).innerHTML).split(" ");
		var Wert1= Wert[0].replace(',','.');
		if(Wert1=="")
		{
		Wert1='0';
		}
		Wert2 =parseFloat(Wert2)+parseFloat(Wert1);

		
		MengeV=MengeV-1;
	}
	Wert2 = Wert2.toFixed(2);
	var Wert3 = Wert2.toString();
	document.getElementById("Einzigartig").innerHTML=Wert3.replace('.',',')+' \u20AC';
	document.getElementsByName("hiddenLabel")[0].value=Wert3.replace('.',',');
	
}
}

function Keine(Nummer)
{
	if(document.getElementsByName("Posi"+Nummer)[0].value=="Nix")
	{
		document.getElementsByName("Ver"+Nummer)[0].value="Nix";
	}

	if(document.getElementsByName("Posi"+Nummer)[0].value=="KA")
	{
		document.getElementsByName("Ver"+Nummer)[0].value="KA";
	}
	
}

function Pruef(e) {
	
    if (e.keyCode == 13) {
        return false;
    }
}

function Pruef1() {
    return false;}

function Neues_Bild(Nummer)
{
		//document.getElementById("Bild_"+Nummer).src="hacken_07.png";
}

function GrossesBild(Pfad)
{
	document.getElementsByName("GBild")[0].src=Pfad;
}

</script>

</head>
<body>
<script type="text/javascript" src="wz_tooltip.js"></script>
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
				if(isset($_SESSION['Caption']) or isset($_GET['Caption']))
				{
					if(isset($_GET['Caption']))
					{
						$_SESSION['Caption']=$_GET['Caption'];
					}
					
					if($_SESSION['Caption']==$zeile1['Unterkate'])
					{
						$xx="class='test'";
					}
					else
					{
						$xx="";
					}
				}
				else
				{
					$xx="";
				}
				
				
				echo"<li ".$xx."><a href='Suche.php?Caption=".urlencode($zeile1['Unterkate'])."&Ref=".urlencode($zeile1['Unterkate'])."'><span>".$zeile1['Unterkate']."</span></a>";
			}
			else
				{
					if(isset($_SESSION['Caption']) or isset($_GET['Caption']))
				{
					if(isset($_GET['Caption']))
					{
						$_SESSION['Caption']=$_GET['Caption'];
					}
					
					if($_SESSION['Caption']==$zeile1['Unterkate'])
					{
						$xx="test";
					}
					else
					{
						$xx="";
					}
				}
				else
				{
					$xx="";
				}
					
					echo"<li class='has-sub ".$xx."'><a href='#'><span>".$zeile1['Unterkate']."</span></a>";
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
						 if(isset($_SESSION['Ref']) or isset($_GET['Ref']))
				{
					if(isset($_GET['Ref']))
					{
						$_SESSION['Ref']=$_GET['Ref'];
					}
					
					if($_SESSION['Ref']==$zeile2['Unterunterkate'])
					{
						$xx=" class='test1' ";
					}
					else
					{
						$xx="";
					}
				}
				else
				{
					$xx="";
				}
						 
						 #$stmtExtra=$mysqli->query('SELECT COUNT(DISTINCT Styles_D.SKU_StyleID) as Anzahl from Styles_Description Styles_D, SKU_Price, Stocks where Styles_D.SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$zeile2['Unterkate'].'")) and Styles_D.SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$zeile2['Unterunterkate'].'")) and LanguageISO="DE" and Styles_D.SKU_StyleID=SKU_Price.SKU_StyleID and Styles_D.SKU_StyleID=Stocks.SKU_StyleID');
					 
					 #$zeileExtra=$stmtExtra->fetch_array();
						 
					 echo"<li ".$xx."><a href='Suche.php?Caption=".urlencode($zeile2['Unterkate'])."&Ref=".urlencode($zeile2['Unterunterkate'])."'><span>".$zeile2['Unterunterkate']."</span></a></li>";
					 }
					 if(urlencode($zeile2['Unterunterkate'])=="Herren")
					 {
						 if(isset($_SESSION['Ref']) or isset($_GET['Ref']))
				{
					if(isset($_GET['Ref']))
					{
						$_SESSION['Ref']=$_GET['Ref'];
					}
					
					if($_SESSION['Ref']==$zeile2['Unterunterkate']."/Unisex")
					{
						$xx=" class='test1' ";
					}
					else
					{
						$xx="";
					}
				}
				else
				{
					$xx="";
				}
						 
						 echo"<li ".$xx."><a href='Suche.php?Caption=".urlencode($zeile2['Unterkate'])."&Ref=".urlencode($zeile2['Unterunterkate']).'/Unisex'."'><span>".$zeile2['Unterunterkate']."-Unisex</span></a></li>";
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



        
        <?php 

        #Daten über das Produkt
#$stmt = $mysqli->query('SELECT b.PictureName, c.StyleName, c.StyleName2, c.StyleDescription, e.Price, f.PictureName as KleinPic from Styles a, Style_Pictures b, Styles_Description c, SKU d, SKU_Price e, SKU_PS f where a.SKU_StyleID="'.$Style.'" and a.SKU_StyleID = b.SKU_StyleID and a.SKU_STyleID = c.SKU_StyleID and a.SKU_StyleID = d.SKU_StyleID and d.SKU_StyleID = e.SKU_StyleID and d.SKU_ColourID = e.SKU_ColourID and d.SKU_SizeID = e.SKU_SizeID and c.LanguageISO ="DE" and e.VolumeScale=0 and d.SKU_StyleID = f.SKU_StyleID and d.SKU_ColourID = f.SKU_ColourID and d.SKU_SizeID = f.SKU_SizeID');

#echo 'SELECT b.PictureName, c.StyleName, c.StyleName2, c.StyleDescription, e.Price from Styles a, Style_Pictures b, Styles_Description c, SKU d, SKU_Price e where a.SKU_StyleID="'.$Style.'" and a.SKU_StyleID = b.SKU_StyleID and a.SKU_STyleID = c.SKU_StyleID and a.SKU_StyleID = d.SKU_StyleID and d.SKU_StyleID = e.SKU_StyleID and d.SKU_ColourID = e.SKU_ColourID and d.SKU_SizeID = e.SKU_SizeID and c.LanguageISO ="DE" and e.VolumeScale=0 and b.PictureType="PR" and d.SKU_SizeID="01" and d.SKU_ColourID="001"';

$stmtExtra= $mysqli->query('Select * from Style_Pictures where SKU_StyleID="'.$Style.'"');

$zeileExtra=$stmtExtra->fetch_array();

if($zeileExtra!=null)
{

	$stmt = $mysqli->query('SELECT b.PictureName, c.StyleName, c.StyleName2, c.StyleDescription, e.Price from Styles a, Style_Pictures b, Styles_Description c, SKU d, SKU_Price e where a.SKU_StyleID="'.$Style.'" and a.SKU_StyleID = b.SKU_StyleID and a.SKU_STyleID = c.SKU_StyleID and a.SKU_StyleID = d.SKU_StyleID and d.SKU_StyleID = e.SKU_StyleID and d.SKU_ColourID = e.SKU_ColourID and d.SKU_SizeID = e.SKU_SizeID and c.LanguageISO ="DE" and e.VolumeScale=0 ');
$zeile = $stmt->fetch_array();        
$Bild=$zeile['PictureName'];
}
else
{

	$stmt = $mysqli->query('SELECT c.StyleName, c.StyleName2, c.StyleDescription, e.Price from Styles a, Styles_Description c, SKU d, SKU_Price e where a.SKU_StyleID="'.$Style.'" and a.SKU_STyleID = c.SKU_StyleID and a.SKU_StyleID = d.SKU_StyleID and d.SKU_StyleID = e.SKU_StyleID and d.SKU_ColourID = e.SKU_ColourID and d.SKU_SizeID = e.SKU_SizeID and c.LanguageISO ="DE" and e.VolumeScale=0');
         $Bild='Kein_Bild.jpg';
$zeile = $stmt->fetch_array();
}


        
if($stmt === false)
{
	die(print_r( $mysqli->error ));
}

$BEN=$zeile['StyleName2'];
$_SESSION['BEN']=$BEN;
$Be=$zeile['StyleDescription'];
$Price = str_replace('.', ',',$zeile['Price']);
/*while($zeile!=null)
{
	$BildZeile=$zeile['KleinPic'];
	#echo$BildZeile;
	$zeile = $stmt->fetch_array();
}*/

if($Bild!=null)
{
	$PName=str_replace('\\','/',$Bild);
	$Pfad="neue_Bilder/".$PName;
	$Pfad1="neue_Bilder/".$PName;
	
}
else
{
	$Pfad='Kein_Bild.jpg';
	$PName='Kein_Bild.jpg';
}

$stmt->close();


#$Pfad="Bilder/01/0003/PR01.0003.540_FR_1.jpg";
$Pfad=str_replace('\\','/',$Pfad);
            		
            		#-----Ändern---------
            		if(substr($PName,0,2)!="01")
            		{
            			$Pfad='Kein_Bild.jpg';
            		}

?>

        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein"><?php echo$BEN;?></label>
            </div>
            <div id="OverFunction">
                <div id="DivDetailBildBesch">
                    <div id="DivDetailimg">
                        <img name="GBild" src="<?php echo$Pfad;?>">
                    </div>
                    <div id="DivDetailText">
                        <h3>Beschreibung</h3><br />
                        <p><?php 
								echo$Be;?></p>
                    </div>
                    <div id="DivDetailPreis">
                    
                    <?php 
                    #echo'<br><br><br>';
                    
                    if(strpos($Price,',')!=false)
                    {
                    list ($vor, $nach) = split(',',$Price);
                    if(strlen($nach)==1)
                    {
                    	$nach.='0';
                    	$kom=$vor.','.$nach;
                    }
                    else
                    {
                    	$kom=$Price;
                    }
                    }
                    else
                    {
                    	$kom=$Price;
                    }
                    
                    
                    ?>
                        <label class="TextSchein"><?php echo'  '.$kom.' &euro;'?></label><br />
                        <p>zzgl. Mwst</p>
                    </div>
                </div>
                <div id="Slidebar" class="abrunden_15 HintergrundGelbVerlauf" style="width:45%;height:110px;margin-left:50px;margin-bottom: 5px">
				<div id="Slidebar1" style="width:100%;">

                <?php
                $stmt = $mysqli->query('SELECT PictureName from SKU_PS where SKU_StyleID="'.$_SESSION['id'].'"');
                #$zeile=$stmt->fetch_array();
                
#$bilder = array('Bilder/5131/PR04.5131.410_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg');
?>
<span class="zuruck" onclick="Vllt()" style="float:left;margin-top:5px;height:100px;width:35px;margin-left:5px;text-align:center;background:white;border-bottom-left-radius: 15px;cursor:pointer;"><br><br> <img style="width: 7px" src="pfeil_2.png"> <br><br></span>
<span class="vor" onclick="Vllt1()" style="float:right;height:100px;margin-right:5px;width:35px;margin-top:5px;text-align:center;background:white;border-bottom-right-radius: 15px;border-top-right-radius: 15px;cursor:pointer;"><br><br> <img style="width: 7px" src="pfeil_1.png"> <br><br></span>
<div class="weitereProdukte" id="test" style="height:105px;padding: 5px 45px;vertical-align:middle;margin-top: 5px;">

<div id="weitere" style="zoom:1;position:relative;max-width:960px;z-index:90;text-align:left;margin-top:0px;">
<div class="produkteWeiter"  style="overflow:hidden;left:0;width:100%;height:100px;position:absolute;z-index:70;background:white;">
<div class="thumbs" style="top:0px;left:0px;position:relative;height:100%;letter-spacing:-4px; width:800px;">
<?php
$stmt1=$mysqli->query('SELECT DISTINCT PictureName from SKU_PS where SKU_StyleID="'.$Style.'"');
$zeile1=$stmt1->fetch_array();
$Gbild=1;
$Kbild=0;
$breite=1;
if($zeile1==null)
{
	$Kbild=1;
}
while($zeile1!=null or $Kbild==1)
{
	if($Kbild==1)
	{
		$Pfad=$Pfad1;
		$Kbild=0;
	}
	else
	{
	if($Gbild!=1)
	{
		$PName=str_replace('\\','/',$zeile1['PictureName']);
		$Pfad="neue_Bilder/".$PName;
	}
	else
	{
		
		$Pfad=$Pfad1;
	}
	}
	
$Pfad=str_replace('\\','/',$Pfad);
            		
            		#-----Ändern---------
            		if(substr($PName,0,2)!="01")
            		{
            			$Pfad='Kein_Bild.jpg';
            		}
	
	
	?>
	 <span style="position:relative;text-indent:-4000px;opacity:0.85;">
	<?php 
	if($Pfad=='Kein_Bild.jpg' and $Gbild==0)
	{
		
	}
	else
	{
		$Gbild=0;
		echo'<img name="KBild" id="Bild'.$breite.'" onclick="GrossesBild(\''.$Pfad.'\')" src="'.$Pfad.'" height="100px"  alt="Bild" style="cursor:pointer;" />';
	}
	
	
	
	
	?>
	 </span>
<?php
$breite++;
$zeile1=$stmt1->fetch_array();

}?>
</div></div></div>
</div>

</div>

<script>
$(window).load(function() {
var breite = 0;
$(".thumbs img").each(function(index){
	breite += $(this).width();
	breite += parseInt($(this).css("margin-right"));
});
$(".thumbs").width(breite);
var breiteDiv = $("#weitere").width();
});
</script>


                
                </div>
                <?php echo'<a name="Fehler"></a>';?>
                 <span id="Fehler" class="span400ROT_Ansicht" style="width: 100%;"><?php if(isset($_SESSION['ErrorBP'])){echo$_SESSION['ErrorBP'];}?></span>
                <div id="DetailLabel">
               
                    <label><b>Detailauswahl</b></label>
                </div>
<!--  <form name="FormProdukte" action="Produktansicht.php" method="post" enctype="multipart/form-data">   -->          

                
                <div>

                <?php 
                $stmt = $mysqli->query('SELECT Stückzahl, Preis, VeredelungenID from VeredelungenStück order by VeredelungenID, Stückzahl');
                if($stmt === false)
                {
                	die(print_r( $mysqli->error ));
                }
                $zeile = $stmt->fetch_array();
                
                while($zeile!=null)
                {
                	$Vol=0;
                	$Preis="";
                	$text=$zeile['VeredelungenID'];
                	while($Vol<7)
                	{
                		$ex=explode(".",round($zeile['Preis'],2));
                		if(strlen($ex[0])<2)
                		{
                			$Preis=$Preis."0";
                		}
                
                		$Preis=$Preis.round($zeile['Preis'],2);
                		$Punkt=strpos($zeile['Preis'],".");
                		#if($Punkt==true)
                		if(array_key_exists(1,$ex))
                		{
                				
                			if(strlen($ex[1])<2)
                			{
                				$Preis=$Preis."0";
                			}
                				
                			 
                		}
                		else
                		{
                			$Preis=$Preis.".00";
                		}
                
                		if($Vol<6)
                		{
                			$Preis=$Preis.' ';
                		}
                
                		$zeile = $stmt->fetch_array();
                
                		$Vol++;
                	}
                
                	echo'<input type="hidden" name="Veredel'.$text.'" value="'.$Preis.'">';
                	#echo'<input type="hidden" name="A'.$zeile['SKU_SizeID'].$zeile['SKU_ColourID'].$zeile['VolumeScale'].'" value="'.$zeile['Price'].'">';
                }
                
                
                if(isset($_SESSION['Benutzer']))
                {
                	echo'<input type="hidden" name="Benutzer" id="Benutzer" value="Ja">';
                }
                else
                {
                	echo'<input type="hidden" name="Benutzer" id="Benutzer" value="Nein">';
                }
                
                
                
                #echo'<div id="result"></div>';
                include("Ver_DIV.php");
                ?>

                
<!---------------------------------------------AJAX / jQuery------------------------------------------------------------->
                
                <script> 

                //Beim Laden der Seite
        //        $(window).load(function() {
        //            $.ajax({
        //            type: "POST",
        //            url: 'Ver_DIV.php',
        //            data: 'test=1',
        //            success: function(data)
        //            {
         //               $("#result").load('Ver_DIV.php');
          //           }                    
           //     });
          //         });
                    
				//Beim Click auf den + Button
                $(document).on("click",".NochEins", function () {
					var Anzahl = $(".bla").length;
					var Anzahl1 = Anzahl+1;	
                    $.ajax({
                        type: "POST",
                        url: 'Ver_DIV.php',
                        data: 'test='+Anzahl1,
                        success: function(data)
                        {
                        	
                            $("."+Anzahl).after(data);
                        }                    
                    });
                        });

				//Beim Click auf den x Button
                $(document).on("click",".EinsWeg", function () {
                    var Nummer = $( this ).attr("class");
                    Nummer = Nummer.substring(9,10)
                    if ($(".bla").length>1)
                    {
                    	$("."+Nummer).remove();
                    }
                });

                </script>
               
<!-----------------------------------------AJAX / jQuery - ENDE------------------------------------------------------------>                
                
				<?php 
				$stmt = $mysqli->query('SELECT Price, SKU_StyleID, SKU_SizeID, SKU_ColourID, VolumeScale from SKU_Price where SKU_StyleID="'.$_SESSION['id'].'" and SKU_SizeID="01" order by SKU_ColourID, Price desc');
				if($stmt === false)
				{
					die(print_r( $mysqli->error ));
				}
				$zeile = $stmt->fetch_array();
				
				while($zeile!=null)
				{
					$Vol=0;
					$Preis="";
					$text=$zeile['SKU_ColourID'];
					while($Vol<5)
					{
						$Preis=$Preis.$zeile['Price'];
						$ex=explode(".",$zeile['Price']);
						if(strpos($zeile['Price'],'.')!=null)
						{
						if(strlen($ex[1])<2)
						{
							$Preis=$Preis."0";
						}
						}
						else
						{
							$Preis=$Preis.".00";
							
						}
						if($Vol<4)
						{
							$Preis=$Preis.' ';
						}
						
				
						$zeile = $stmt->fetch_array();
				
						$Vol++;
					}
				
					echo'<input type="hidden" name="A'.$text.'" value="'.$Preis.'">';
					#echo'<input type="hidden" name="A'.$zeile['SKU_SizeID'].$zeile['SKU_ColourID'].$zeile['VolumeScale'].'" value="'.$zeile['Price'].'">';
				}
				
				
				include("Pro_DIV.php");
				#echo'<div id="result1"></div>';

          		 ?>
          		 
<!---------------------------------------------AJAX / jQuery------------------------------------------------------------->
                
                <script> 

                //Beim Laden der Seite
     //           $(window).load(function() {
     //               $.ajax({
     //               type: "POST",
     //               url: 'Pro_DIV.php',
     //               data: 'test=1',
     //               success: function(data)
     //               {
    //                   $("#result1").load('Pro_DIV.php');
     //               }                    
    //            });
    //                });

				//Beim Click auf den + Button
                $(document).on("click",".Plus", function () {
					var Anzahl = $(".bla1").length;
					var Anzahl1 = Anzahl+1;	
                    $.ajax({
                        type: "POST",
                        url: 'Pro_DIV.php',
                        data: 'test='+Anzahl1,
                        success: function(data)
                        {
                        	
                            $(".x"+Anzahl).after(data);
                        }                    
                    });
                        });

				//Beim Click auf den x Button
                $(document).on("click",".Minus", function () {
                    var Nummer = $( this ).attr("class");
                    Nummer = Nummer.substring(7,8)
                    if ($(".bla1").length>1)
                    {
                    	$(".x"+Nummer).remove();
                    }
                });
		
                </script>
               
<!-----------------------------------------AJAX / jQuery - ENDE------------------------------------------------------------>
                
                
                <div id="GesamtPreis">
                    <div id="GesamtPreis_label">
                        <label id="Einzigartig" class="TextSchein"><?php if(isset($_SESSION['EGP'])){echo str_replace('.',',',$_SESSION['EGP']).' &euro;';}else{echo$Price.' &euro;';}?></label><br />
                        <input type="hidden" id="hidden1" value="<?php if(isset($_SESSION['EGP'])){echo$_SESSION['EGP'];}else{echo$Price;}?>" name="hiddenLabel"/>
                        <p>zzgl. Mwst</p>
                    </div>
                    
                    
                    
                </div>
                <div id="Korb_Anfrage">
                    <button name="WKLegen" id="Legen" class="button180_30_Korb abrunden_8 HintergrundGelbVerlauf">in den Warenkorb legen</button>
                    <div id="Korb_UnvAnfrage">
                        <img src="Fragen_15.jpg" /><br>
                        <button name="Anfrage" id="Anfrage" class="HintergrundGrauVerlauf abrunden_8" style="cursor:pointer;">Unverbindliche Anfrage senden</button>
                    </div>
                    </div>
                </div>
                <!--  </form> -->
                </div>
    </div>
    
    
    
        
        <?php  include "zeile.php";?>
    </div>
    
    <!---------------------------------------------AJAX / jQuery------------------------------------------------------------->
    
    <script> 
    
    
    //Beim Klicken auf den Warenkorb Button
    $(document).on("click","#Legen", function () {

    	
		if($("#Benutzer").val()=="Nein")
		{
			$("#Fehler").text("Sie müssen angemeldet sein.");
			 location.hash="Fehler";
			//window.location="Produktansicht.php";
		}
		else
		{
		
    	 if($("#Fehler").val()=="")
         {
        
        //Anzahl der Produkte / Veredelungen / Größen
    	var AnzahlV = $(".bla").length;
    	var AnzahlP = $(".bla1").length;
    	var AnzahlM = $(".input15").length/AnzahlP;
    	
    	//Veredelungen
    	var Fehler="";
    	var a=1;
    	var Teil1="WKLegen=Ja&A="+AnzahlP+"&B="+AnzahlV+"&";
    	while(a<=AnzahlV)
    	{
        	var Posi=$("#Posi"+a).val();
        	var Ver=$("#Ver"+a).val();
        	var Preis=$("#GesamtVH"+a).val();
        	var Bild=$("#JSdatei"+a).val();
        	
				if((Preis=="" || Bild=="") && (Posi!="Nix" && Posi!="KA"))
				{
					document.getElementById("Fehler").innerHTML="Mind. ein Feld ist leer!";
	        		Fehler="ja";
	        		break;
				}
				else
				{
					
					Teil1=Teil1+"Posi"+a+"="+Posi+"&Ver"+a+"="+Ver+"&GesamtVH"+a+"="+Preis+"&datei"+a+"="+Bild+"&";
				}
        	
			a++;
    	}

    	//Produkte
    	a=1;
    	while(a<=AnzahlV)
    	{
        	var Farbe=$("#Farbe"+a).val();
        	var GMenge=$("#Menge"+a).val();
        	Teil1=Teil1+"Farbe"+a+"="+Farbe+"&Menge"+a+"="+GMenge+"&";
        	var e=1;
        	var GGesamt=0;
        	while(e<=AnzahlM)
        	{
        		var GMenge1=$("#Groessen"+a+e).val();
        		GGesamt = parseInt(GGesamt)+parseInt(GMenge1);
        		var GSize=$("#Groessen"+a+e).attr("name");

        		if(Farbe=="" || GMenge=="" || GMenge1=="")
            	{
            		document.getElementById("Fehler").innerHTML="Mind. ein Feld ist leer!";
            		Fehler="ja";
            		break;
            	}
            	
        		Teil1 = Teil1+"Groessen"+a+e+"="+GMenge1+"&GSize"+a+e+"="+GSize+"&";
				e++;
        	}
        	if(GGesamt<GMenge)
        	{
        		document.getElementById("Fehler").innerHTML="Mind. 1 Mengenanzahl unterschreitet die Gesamtmenge!";
        		Fehler="ja";
        		break;
        	}
        	if(GMenge<1)
        	{
        		document.getElementById("Fehler").innerHTML="Geben Sie nur positive Mengen ein!";
        		Fehler="ja";
        		break;
        	}
			a++;
    	}
    	if(Fehler=="")
    	{
    		var Ende=Teil1.length-1;
    		Teil1 =Teil1.substring(0,Ende);

    	
    		$.ajax({
                type: "POST",
                url: 'Produktansicht_Test.php',
                data: Teil1,
                success: function(data)
                {
                    var bla = data.search('Error1_A');
                    var bla1 = data.search('Error1_E');
                    if(bla==-1)
                    {
                    	 window.location="Warenkorb.php";
                    }
                    else
                    {
                    	document.getElementById("Fehler").innerHTML= data.substring(bla+8,bla1);
                    	location.hash="Fehler";
                    }
                   
                },
                error: function(data)
                {
                    location.hash="Fehler";
                	 window.location="Produktansicht.php";
                }          
            });
    	}
    	else
    	{
             location.hash="Fehler";
    	}

         }
    	    else
    	    {
    	    	 location.hash="Fehler";
    	    }
		}
    });
    

  //Beim Klicken auf den Anfrage Button
    $(document).on("click","#Anfrage", function () {

    	if($("#Benutzer").val()=="Nein")
		{
    		if($("#Fehler").val()=="")
            {

//-------------------------------------NICHT ANGEMELDET---------------------------------------------------
 	           
           //Anzahl der Produkte / Veredelungen / Größen
       	var AnzahlV = $(".bla").length;
       	var AnzahlP = $(".bla1").length;
       	var AnzahlM = $(".input15").length/AnzahlP;

   		var Gesamt = $("#hidden1").val();
       	
       	//Veredelungen
       	var Fehler="";
       	var a=1;
       	var Teil1="Anfrage=Ja&A="+AnzahlP+"&B="+AnzahlV+"&hiddenLabel="+Gesamt+"&";
       	while(a<=AnzahlV)
       	{
           	var Posi=$("#Posi"+a).val();
           	var Ver=$("#Ver"+a).val();
           	var Preis=$("#GesamtVH"+a).val();
           	var Bild=$("#JSdatei"+a).val();
           	
           	if((Preis=="" || Bild=="") && (Posi!="Nix" && Posi!="KA"))
			{
   					document.getElementById("Fehler").innerHTML="Mind. ein Feld ist leer!";
   	        		Fehler="ja";
   	        		break;
   				}
   				else
   				{
   					Teil1=Teil1+"Posi"+a+"="+Posi+"&Ver"+a+"="+Ver+"&GesamtH"+a+"="+Preis+"&datei"+a+"="+Bild+"&";
   				}
           	
   			a++;
       	}

       	//Produkte
       	a=1;
       	while(a<=AnzahlV)
       	{
           	var Farbe=$("#Farbe"+a).val();
           	var GMenge=$("#Menge"+a).val();
           	Teil1=Teil1+"Farbe"+a+"="+Farbe+"&Menge"+a+"="+GMenge+"&";
           	var e=1;
           	while(e<AnzahlM)
           	{
           		var GMenge1=$("#Groessen"+a+e).val();
           		var GSize=$("#Groessen"+a+e).attr("name");

           		if(Farbe=="" || GMenge=="" || GMenge1=="")
               	{
               		document.getElementById("Fehler").innerHTML="Mind. ein Feld ist leer!";
               		Fehler="ja";
               		break;
               	}
               	
           		Teil1 = Teil1+"Groessen"+a+e+"="+GMenge1+"&GSize"+a+e+"="+GSize+"&";
   				e++;
           	}
   			a++;
       	}
       	if(Fehler=="")
       	{
       		var Ende=Teil1.length-1;
       		Teil1 =Teil1.substring(0,Ende);

       		$.ajax({
                   type: "POST",
                   url: 'Formular.php',
                   data: Teil1,
                   success: function(data)
                   {
                       window.location="Formular.php";
                   },
                   error: function(data)
                   {
                   	 window.location="Produktansicht.php?A=Fehler";
                   }          
               });
       	}
       	else
       	{
       	 location.hash="Fehler";
       	}

            }
    		else
    	    {
    			 location.hash="Fehler";
    	    }
		}
		else
		{

			//-------------------------------------------ANGEMELDET---------------------------------------
    	 if($("#Fehler").val()=="")
         {
        
        //Anzahl der Produkte / Veredelungen / Größen
    	var AnzahlV = $(".bla").length;
    	var AnzahlP = $(".bla1").length;
    	var AnzahlM = $(".input15").length/AnzahlP;

		var Gesamt = $("#hidden1").val();
    	
    	//Veredelungen
    	var Fehler="";
    	var a=1;
    	var Teil1="Anfrage=Ja&A="+AnzahlP+"&B="+AnzahlV+"&hiddenLabel="+Gesamt+"&";
    	while(a<=AnzahlV)
    	{
        	var Posi=$("#Posi"+a).val();
        	var Ver=$("#Ver"+a).val();
        	var Preis=$("#GesamtVH"+a).val();
        	var Bild=$("#JSdatei"+a).val();
        	
        	if((Preis=="" || Bild=="") && (Posi!="Nix" && Posi!="KA"))
			{
					document.getElementById("Fehler").innerHTML="Mind. ein Feld ist leer!";
	        		Fehler="ja";
	        		break;
				}
				else
				{
					Teil1=Teil1+"Posi"+a+"="+Posi+"&Ver"+a+"="+Ver+"&GesamtH"+a+"="+Preis+"&datei"+a+"="+Bild+"&";
				}
        	
			a++;
    	}

    	//Produkte
    	a=1;
    	while(a<=AnzahlV)
    	{
        	var Farbe=$("#Farbe"+a).val();
        	var GMenge=$("#Menge"+a).val();
        	Teil1=Teil1+"Farbe"+a+"="+Farbe+"&Menge"+a+"="+GMenge+"&";
        	var e=1;
        	while(e<AnzahlM)
        	{
        		var GMenge1=$("#Groessen"+a+e).val();
        		var GSize=$("#Groessen"+a+e).attr("name");

        		if(Farbe=="" || GMenge=="" || GMenge1=="")
            	{
            		document.getElementById("Fehler").innerHTML="Mind. ein Feld ist leer!";
            		Fehler="ja";
            		break;
            	}
            	
        		Teil1 = Teil1+"Groessen"+a+e+"="+GMenge1+"&GSize"+a+e+"="+GSize+"&";
				e++;
        	}
			a++;
    	}
    	if(Fehler=="")
    	{
    		var Ende=Teil1.length-1;
    		Teil1 =Teil1.substring(0,Ende);

    		$.ajax({
                type: "POST",
                url: 'Produktansicht_Test.php',
                data: Teil1,
                success: function(data)
                {
                	  var bla = data.search('Error1_A');
                      var bla1 = data.search('Error1_E');
                      if(bla==-1)
                      {
                    	  window.location="Formular_ab.php";
                      }
                      else
                      {
                      	document.getElementById("Fehler").innerHTML= data.substring(bla+8,bla1);
                      	location.hash="Fehler";
                      }
                },
                error: function(data)
                {
                	 window.location="Produktansicht.php?A=Fehler";
                }          
            });
    	}
    	else
    	{
    		 location.hash="Fehler";
    	}

         }
    	    else
    	    {
    	    	 location.hash="Fehler";
    	    }
		}
       
    });

	//-------------------UPLOAD-----------------------------
	
	$('body').on('change', '.warum', function() {
	// Post-Daten vorbereiten
	
	var data = new FormData();

	data.append('file1', this.files[0]);
	data.append('foo', 1);
	var test = $(this).attr("id");
	test = test.substring(7,8);
	// Ajax-Call
	$.ajax({
	url: 'upload.php',
	data: data,
	type: 'POST',
	processData: false,
	contentType: false,
	success: function(evt) { 
		var bla = evt.search('Error');
		if(bla!=-1)
		{
			document.getElementById("Fehler").innerHTML="Fehler beim Upload, Datei wurde nicht hochgeladen.";
			document.getElementById("Bild_"+test).src="hacken_07_error.jpg";
		}
		else
		{
			document.getElementById("Bild_"+test).src="hacken_07.png";
		}
		
	}
	});
	});

    
    </script>
    <!------------------------------------------AJAX / jQuery - Ende--------------------------------------------------------->
    
</body>
</html>