<?php
#Session starten
session_start();

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

#Id des Produktes
if(isset($_GET['id']))
{
	$Style=$_GET['id'];
	$_SESSION['id']=$_GET['id'];
	
	#Notlösung weil Chrome -.-
	#echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php" />';
}
else 
{
	$Style=$_SESSION['id'];
}

if(!isset($_GET['PlusW']))
{
	$_GET['PlusW']=0;
}

#Anzahl der Produkte oder Veredelungen
if(!isset($_SESSION['AnzahlA']) or $_SESSION['AnzahlA']<1)
{
	$_SESSION['AnzahlA']=1;
}
if(!isset($_SESSION['AnzahlB'])or $_SESSION['AnzahlB']<1)
{
	$_SESSION['AnzahlB']=1;
}
if(isset($_GET['A']))
{
	echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php#'.$_GET['A'].'" />';
}

#Datenbankverbindung
include "DB_Verbindung.php";


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
		    left: "+=250"
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
		    left: "-=250"
		  }, 1000, function() {
		    // Animation complete.
		  });
	}
	
}

//Geht ah net -.-
//window.onload = function() {
//var breite = 0;
//$(".thumbs img").each(function(index){
// 	breite += $(this).width();
// 	breite += parseInt($(this).css("margin-right"));
// });
//  $(".thumbs").width(breite);
//  var breiteDiv = $("#weitere").width();
//}



function Fenster()
{
	Info = window.open("VeredelINFO.php");
	Info.focus();
}


    
function Teil (Nummer,Gesamt,Hauptnummer)
{
	var Gesamtmenge=parseInt(document.getElementsByName("Menge"+Hauptnummer)[0].value);
	var Hilfe=1;
	while(Hilfe<=Gesamt)
	{
		var Einzelmenge = (document.getElementsByName("Groessen"+Hauptnummer+Hilfe)[0].value).replace('.',',');
		
		if(isNaN(Einzelmenge)==true )
		{
			document.getElementById("Fehler").innerHTML="Geben sie nur ganze Zahlen in das Mengenfeld ein.";
			Hilfe=Gesamt;
		}
		else
		{
			Einzelmenge = parseInt(Einzelmenge);
		if(Gesamtmenge<Einzelmenge)
		{
			document.getElementById("Fehler").innerHTML="Die Mengeeingabe im "+Hilfe+". Feld überschreitet die Gesamtmenge.";
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
    
function Rechne (Menge,Nummer,MengeG,VerID,MengeV) {
	
Menge = Menge.replace('.',',');
if(isNaN(Menge)==true )
{
	document.getElementById("Fehler").innerHTML="Geben sie nur ganze Zahlen in das Mengenfeld ein.";
	var Anzahl='Gesamt'+Nummer;
	document.getElementById(Anzahl).innerHTML=0;
	document.getElementsByName("GesamtH"+Nummer)[0].value=0;
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
				document.getElementsByName("GesamtVH"+Help)[0].value=((VerEinzel*Menge).toFixed(2)).replace('.',',')+' \u20AC';
			}
			else
			{
				document.getElementById("GesamtV"+Help).innerHTML="0,00"+' \u20AC';
				document.getElementsByName("GesamtVH"+Help)[0].value="0,00"+' \u20AC';
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
	
	document.getElementById(Anzahl).innerHTML=((Inhalte*Menge).toFixed(2)).replace('.',',')+' \u20AC';
	document.getElementsByName("GesamtH"+Nummer)[0].value=((Inhalte*Menge).toFixed(2)).replace('.',',')+' \u20AC';

	
	
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
		document.getElementById("Bild"+Nummer).src="hacken_07.png";
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
        <h2>KATEGORIEN</h2>
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



        
        <?php 

        #Daten über das Produkt
#$stmt = $mysqli->query('SELECT b.PictureName, c.StyleName, c.StyleName2, c.StyleDescription, e.Price, f.PictureName as KleinPic from Styles a, Style_Pictures b, Styles_Description c, SKU d, SKU_Price e, SKU_PS f where a.SKU_StyleID="'.$Style.'" and a.SKU_StyleID = b.SKU_StyleID and a.SKU_STyleID = c.SKU_StyleID and a.SKU_StyleID = d.SKU_StyleID and d.SKU_StyleID = e.SKU_StyleID and d.SKU_ColourID = e.SKU_ColourID and d.SKU_SizeID = e.SKU_SizeID and c.LanguageISO ="DE" and e.VolumeScale=0 and d.SKU_StyleID = f.SKU_StyleID and d.SKU_ColourID = f.SKU_ColourID and d.SKU_SizeID = f.SKU_SizeID');

#echo 'SELECT b.PictureName, c.StyleName, c.StyleName2, c.StyleDescription, e.Price from Styles a, Style_Pictures b, Styles_Description c, SKU d, SKU_Price e where a.SKU_StyleID="'.$Style.'" and a.SKU_StyleID = b.SKU_StyleID and a.SKU_STyleID = c.SKU_StyleID and a.SKU_StyleID = d.SKU_StyleID and d.SKU_StyleID = e.SKU_StyleID and d.SKU_ColourID = e.SKU_ColourID and d.SKU_SizeID = e.SKU_SizeID and c.LanguageISO ="DE" and e.VolumeScale=0 and b.PictureType="PR" and d.SKU_SizeID="01" and d.SKU_ColourID="001"';

$stmtExtra= $mysqli->query('Select * from Style_Pictures where SKU_StyleID="'.$Style.'"');

$zeileExtra=$stmtExtra->fetch_array();

if($zeileExtra!=null)
{

	$stmt = $mysqli->query('SELECT b.PictureName, c.StyleName, c.StyleName2, c.StyleDescription, e.Price from Styles a, Style_Pictures b, Styles_Description c, SKU d, SKU_Price e where a.SKU_StyleID="'.$Style.'" and a.SKU_StyleID = b.SKU_StyleID and a.SKU_STyleID = c.SKU_StyleID and a.SKU_StyleID = d.SKU_StyleID and d.SKU_StyleID = e.SKU_StyleID and d.SKU_ColourID = e.SKU_ColourID and d.SKU_SizeID = e.SKU_SizeID and c.LanguageISO ="DE" and e.VolumeScale=0 and b.PictureType="PR"');
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
/*if($PName!=null)
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
                        <label class="TextSchein"><?php echo'  '.$Price.' &euro;'?></label><br />
                        <p>zzgl. Mwst</p>
                    </div>
                </div>
                <div id="Slidebar" class="abrunden_20" style="width:45%;height:120px;background-color:#ffef70;margin-left:50px;">
<div id="Slidebar1" style="width:100%;">

                <?php
                $stmt = $mysqli->query('SELECT PictureName from SKU_PS where SKU_StyleID="'.$_SESSION['id'].'"');
                #$zeile=$stmt->fetch_array();
                
#$bilder = array('Bilder/5131/PR04.5131.410_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg','Bilder/5131/PS04.5131.001_FR_1.jpg');
?>
<span class="zuruck" onclick="Vllt()" style="float:left;margin-top:10px;height:100px;width:30px;margin-left:10px;text-align:center;background:white;border-bottom-left-radius: 20px;cursor:pointer;"><br><br><<br><br></span>
<span class="vor" onclick="Vllt1()" style="float:right;height:100px;margin-right:10px;width:30px;margin-top:10px;text-align:center;background:white;border-bottom-right-radius: 20px;border-top-right-radius: 20px;cursor:pointer;"><br><br>><br><br></span>
<div class="weitereProdukte" id="test" style="height:100px;padding-right:50px;padding-left:50px;vertical-align:middle;padding-top:10px;">

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
		$Gbild=0;
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
	<?php echo'<img name="KBild" id="Bild'.$breite.'" onclick="GrossesBild(\''.$Pfad.'\')" src="'.$Pfad.'" height="100px"  alt="Bild" style="cursor:pointer;" />';?>
	 </span>
<?php
$breite++;
$zeile1=$stmt1->fetch_array();

}?>
</div></div></div>
</div>

</div>




                
                </div>
                <?php echo'<a name="Fehler"></a>';?>
                 <span id="Fehler" class="span400ROT_Ansicht"><?php if(isset($_SESSION['ErrorBP'])){echo$_SESSION['ErrorBP'];}?></span>
                <div id="DetailLabel">
               
                    <label><b>Detailauswahl</b></label>
                </div>
<form name="FormProdukte" action="Produktansicht.php" method="post" enctype="multipart/form-data">                
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
                
                
                
                
                
                $b=1;
                while($b<=$_SESSION['AnzahlB'])
                {
                	#Positionen der Veredelungen
                	$stmt = $mysqli->query('SELECT Position, PositionID from Positionen order by Position');
                	if($stmt === false)
                	{
                		die(print_r( $mysqli->error ));
                	}
                	$zeile = $stmt->fetch_array();
					echo'<a name="VerPosi'.$b.'"></a>
					<div id="DIV_min_height_180D" class="abrunden_15">
                    <div id="ZeileDetailauswahl">
                        <button onclick="return Pruef1()" onmouseover="Tip(\'W&auml;hlen Sie hier Ihre gew&uumlnschte Position f&uuml;r Ihr Logo auf dem Produkt.\')" onmouseout="UnTip()" class="abrunden_6" style="background: url(inf_button.png) 100% 50% no-repeat #ffffff"></button>
                        <span class="span90D">Druckposition:</span>
                        <div id="SelectDetail" class="abrunden_15">
                            <select onchange="Keine('.$b.')" name="Posi'.$b.'">';
					
					if($zeile==null)
					{
						echo'<option value="'.Nix.'">Keine Veredelungen verf&uuml;gbar</option>';
					}
					else
					{
						echo'<option value="Nix">Keine Veredelung</option>';
						echo'<option value="KA">Keine Ahnung</option>';
					}
					while($zeile!=null)
					{
					$Posi=$Pr = str_replace('ü', '&uuml;',$zeile['Position']);
					$Posi=$Pr = str_replace('Ü', '&uuml;',$Posi);
					$Posi=$Pr = str_replace('Ä', '&Auml;',$Posi);
					$Posi=$Pr = str_replace('ä', '&auml;',$Posi);
					$Posi=$Pr = str_replace('Ö', '&Ouml;',$Posi);
					$Posi=$Pr = str_replace('ö', '&ouml;',$Posi);
					$Posi=$Pr = str_replace('ß', '&szlig;',$Posi);
					$PosiID=$zeile['PositionID'];
					echo'<option ';
					if(isset($_SESSION['P'.$b]))
					{
					if($_SESSION['P'.$b]==$PosiID){echo'selected';}}
					echo' value="'.$PosiID.'">'.$Posi.'</option>';
					$zeile = $stmt->fetch_array();
					}
					$stmt->close();
					
					$stmt = $mysqli->query('SELECT a.VeredelungenID, a.Veredelungsart, a.Veredelungsfläche, b.Veredelung_machbar from Veredelungen a, Styles_Description_bool b where a.VeredelungenID = b.VeredelungenID and b.SKU_StyleID = "'.$Style.'" order by a.VeredelungenID');
					if($stmt === false)
					{
						die(print_r( $mysqli->error ));
					}
					$zeile = $stmt->fetch_array();
                            echo'</select>
                        </div>
                        <div id="ZeileDetailauswahl">
                            <button onclick="return Pruef1()" onmouseover="Tip(\'W&auml;hlen Sie hier die Art der gew&uuml;nschten Veredelung aus.\')" onmouseout="UnTip()" class="abrunden_6" style="background: url(inf_button.png) 100% 50% no-repeat #ffffff"></button>
                            <span class="span90D">Veredelungsart:</span>
                            <div id="SelectDetail" class="abrunden_15">
                                <select name="Ver'.$b.'" onchange="Rechne(document.FormProdukte.Menge'.$b.'.value,'.$b.','.$_SESSION['AnzahlA'].',document.FormProdukte.Ver'.$b.'.value,'.$_SESSION['AnzahlB'].')">';
                			if($zeile==null)
							{
								echo'<option value="'.Nix.'">Keine Veredelungen verf&uuml;gbar</option>';
							}
								else
							{
								echo'<option value="Nix">Keine Veredelung</option>';
								echo'<option value="KA">Keine Ahnung</option>';
							}
                            
                            while($zeile!=null)
                            {
                            	#Art der Veredelungen
                            	$Ver=$zeile['Veredelungsart'].' '.$zeile['Veredelungsfläche'].'';
                            	$Ver=str_replace('Ü', '&Uuml;',$Ver);
                            	$Ver=str_replace('ü', '&uuml;',$Ver);
                            	$Ver=str_replace('Ä', '&Auml;',$Ver);
                            	$Ver=str_replace('ä', '&auml;',$Ver);
                            	$Ver=str_replace('Ö', '&Ouml;',$Ver);
                            	$Ver=str_replace('ö', '&ouml;',$Ver);
                            	$Ver=str_replace('ß', '&szlig;',$Ver);
                            	$VerID=$zeile['VeredelungenID'];
                            	$Vermach=$zeile['Veredelung_machbar'];
                            	if($Vermach==1)
                            	{
                            		echo'<option ';
                            		if(isset($_SESSION['V'.$b]))
                            		{
                            		if( $_SESSION['V'.$b]==$VerID){echo'selected';}}
                            		echo' value="'.$VerID.'">'.$Ver.'</option>';
                            	}
                            	$zeile = $stmt->fetch_array();
                            }
                            $stmt->close();
                                echo'</select>
                            </div> 
                        </div>';
                                
                               
                                
                        echo'<div id="ZeileDetailauswahl">
                            <button onclick="return Pruef1()" onmouseover="Tip(\'W&auml;hlen Sie hier Ihr gew&uuml;nschtes Logo von Ihrem PC aus.\')" onmouseout="UnTip()" class="abrunden_6" style="background: url(inf_button.png) 100% 50% no-repeat #ffffff"></button>
                            <span class="span90D">Logo-hochladen:</span>
                            <div id="divLogohochladen">';
                                echo'<input id="JSdatei'.$b.'" onchange="Neues_Bild('.$b.')" name="datei'.$b.'" type="file">';
                               echo'<img id="Bild'.$b.'" src="hacken_07_def.png" />';
                            echo'</div>
                        </div>
            		
            		 <div id="ZeileDetailauswahl_Berechnen">
                        <label id="GesamtV'.$b.'">';
                        if(isset($_SESSION['VP'.$b])){echo$_SESSION['VP'.$b];}
                        echo'</label><br>
                        <input type="hidden" value="';if(isset($_SESSION['VP'.$b])){echo$_SESSION['VP'.$b];} echo'" name="GesamtVH'.$b.'"/>
                    </div>
            		
                        <div id="Zeile_Klein_Auswahl_Links">
                            <button name="EinsWeg'.$b.'" class="abrunden_6" style="background: url(loeschen_button_11.png) 100% 50% no-repeat #ffffff"></button>
                            <label>Diese Auswahl entfernen</label>
                        </div>
                        <div id="Zeile_Klein_Auswahl_Rechts">
                            <button name="NochEins'.$b.'" class="abrunden_6" style="background: url(plus-button_11.png) 100% 50% no-repeat #ffffff"></button>
                            <label>weitere Druckposition hinzuf&uuml;gen</label>
                        </div>
                    </div>
                </div>';
                            $b++;
                }
               /* $test=$_SESSION['AnzahlB'];
                while($test>0)
                {
                	if(isset($_FILES['datei']['name']))
                	{
                		echo'<meta http-equiv="refresh" content="0; url=Upload.php" />';
                	}
                	$test--;
                }*/
                
                
				$test1=1;
				while($test1<=$_SESSION['AnzahlB'])
				{
					#Zwischenspeichern
					if(isset($_POST['EinsWeg'.$test1]))
					{	
						$_SESSION['EGP']=str_replace(',','.',$_POST['hiddenLabel'])-str_replace(',','.',$_POST['GesamtVH'.$test1]);
						$testa=1;
						while($testa<=$_SESSION['AnzahlA'])
						{
							$ee=1;
							while($ee<=$_SESSION['GAnzahl'.$bb])
							{
								$_SESSION['G'.$bb.$ee]=$_POST['Groessen'.$bb.$ee];
								$ee++;
							}
							
							
							$_SESSION['F'.$testa]=$_POST['Farbe'.$testa];
							$_SESSION['M'.$testa]=$_POST['Menge'.$testa];
							$_SESSION['EP'.$testa]=$_POST['GesamtH'.$testa];
							$testa++;
						}

						$testa=1;
						while($testa<=$_SESSION['AnzahlB'])
						{
							$_SESSION['P'.$testa]=$_POST['Posi'.$testa];
							$_SESSION['V'.$testa]=$_POST['Ver'.$testa];
							$_SESSION['VP'.$testa]=$_POST['GesamtVH'.$testa];
							$_SESSION['D'.$testa]=$_FILES['datei'.$testa]['name'];
							
							$testa++;
						}
						if($_SESSION['AnzahlB']==1)
						{
							
						}
						else
						{
							#Löscht eine Veredelung
							$test0=$_SESSION['AnzahlB'];
							while($test1<$test0)
							{
								$_SESSION['P'.$test1]=$_SESSION['P'.($test1+1)];
								$_SESSION['V'.$test1]=$_SESSION['V'.($test1+1)];
								$_SESSION['VP'.$test1]=$_SESSION['VP'.($test1+1)];
								$test1++;
							}
							if($test1==$_SESSION['AnzahlB'])
							{
								unset($_SESSION['P'.$test1]);
								unset($_SESSION['V'.$test1]);
								unset($_SESSION['VP'.$test1]);
							}
							while($test1<=$_SESSION['AnzahlB'])
							{
								if($test1==$_SESSION['AnzahlB'])
								{
									unset($_SESSION['P'.$test1]);
									unset($_SESSION['V'.$test1]);
									unset($_SESSION['VP'.$test1]);
								}
								else 
								{
								$_SESSION['P'.$test1]=$_SESSION['P'.($test1+1)];
								$_SESSION['V'.$test1]=$_SESSION['V'.($test1+1)];
								$_SESSION['VP'.$test1]=$_SESSION['VP'.($test1+1)];
								}
								$test1++;
							}
							
						}
						$_SESSION['AnzahlB']--;
						echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php?A=VerPosi1" />';
					}
					$test1++;
				}
                
				$bb=1;
				
				while($bb<=$_SESSION['AnzahlB'])
				{
                if(isset($_POST['NochEins'.$bb]))
                {
                	$bb=1;
                	#Zwischenspeichern
                	while($bb<=$_SESSION['AnzahlB'])
                	{
                		$_SESSION['P'.$bb]=$_POST['Posi'.$bb];
                		$_SESSION['V'.$bb]=$_POST['Ver'.$bb];
                		$_SESSION['D'.$bb]=$_FILES['datei'.$bb]['name'];
                		$_SESSION['VP'.$bb]=$_POST['GesamtVH'.$bb];
                		$bb++;
                	}
                	$bb=1;
                		while($bb<=$_SESSION['AnzahlA'])
                		{
                			
                			$_SESSION['F'.$bb]=$_POST['Farbe'.$bb];
                			$_SESSION['M'.$bb]=$_POST['Menge'.$bb];
                			$_SESSION['EP'.$bb]=$_POST['GesamtH'.$bb];
                			
                			$ee=1;
                			while($ee<=$_SESSION['GAnzahl'.$bb])
                			{
                				$_SESSION['G'.$bb.$ee]=$_POST['Groessen'.$bb.$ee];
                				$ee++;
                			}
                				
                			$bb++;
                		}
                		$_SESSION['EGP']=$_POST['hiddenLabel'];
                	$_SESSION['AnzahlB']++;
                	echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php?A=VerPosi'.$b.'" />';
                }
                $bb++;
				}
                ?>
                
                
                
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
						if(strlen($ex[1])<2)
						{
							$Preis=$Preis."0";
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
				
				
				
				$a=1;
				while($a<=$_SESSION['AnzahlA'])
				{
					$stmt = $mysqli->query('SELECT a.Caption, a.SKU_ColourID from Colour_ID_Text a, SKU b where b.SKU_StyleID="'.$Style.'" and a.SKU_ColourID = b.SKU_ColourID and b.SKU_SizeID=01 order by a.Caption');
					if($stmt === false)
					{
						die(print_r( $mysqli->error ));
					}
					$zeile = $stmt->fetch_array();
                echo'<a name="Pro'.$a.'"></a>
					<div id="DIV_min_height_210D" class="abrunden_15">
                    <div id="ZeileDetailauswahl">
                        <button onclick="return Pruef1()" onmouseover="Tip(\'W&auml;hlen Sie hier die gew&uuml;nschte Farbe des Produktes aus.\')" onmouseout="UnTip()" class="abrunden_6" style="background: url(inf_button.png) 100% 50% no-repeat #ffffff"></button>
                        <span class="span90D">Farbe:</span>
                        <div id="SelectDetail" class="abrunden_15">
                            <select onchange="Rechne(document.FormProdukte.Menge'.$a.'.value,'.$a.','.$_SESSION['AnzahlA'].',document.FormProdukte.Ver'.$a.'.value,'.$_SESSION['AnzahlB'].')" name="Farbe'.$a.'">';
                if($zeile==null)
                {
                	echo'<option value="'.Nix.'">Keine Farbe verf&uuml;gbar</option>';
                }
                while($zeile!=null)
                {
                	#Farben des Produktes
                	$ColourCap=$zeile['Caption'];
                	
                	$ColourID=$zeile['SKU_ColourID'];
                	$_SESSION['ColourID'.$a]=$ColourID;
                	$zeile = $stmt->fetch_array();
                	echo'<option ';
                	if(isset($_SESSION['F'.$a]))
                	{
                	if($_SESSION['F'.$a]==$ColourID){echo'selected';}}
                	echo' value="'.$ColourID.'">'.$ColourCap.'</option>';
                }
                $stmt->close();
                            echo'</select>
                        </div>
                    </div>';
			
			/*echo'<div id="ZeileDetailauswahl">
                        <button onclick="return Pruef1()" onmouseover="Tip(\'W&auml;hlen Sie hier die gew&uuml;nschte Gr&ouml;&szlig;e des Produktes aus.\')" onmouseout="UnTip()" class="abrunden_6" style="background: url(inf_button.png) 100% 50% no-repeat #ffffff"></button>
                        <span class="span90D">Gr&ouml;&szlig;e:</span>
                        <div id="SelectDetail" class="abrunden_15">
                            <select onchange="Rechne(document.Produkte.Menge'.$a.'.value,'.$a.','.$_SESSION['AnzahlA'].')" name="Groessen'.$a.'">';
                            $stmt = $mysqli->query('SELECT a.Caption, a.SKU_SizeID from Size_ID_Text a, SKU b where b.SKU_StyleID="'.$Style.'" and a.SKU_SizeID = b.SKU_SizeID and b.SKU_ColourID=001 order by a.Caption');
                            if($stmt === false)
                            {
                            	die(print_r( $mysqli->error ));
                            }
                            $zeile = $stmt->fetch_array();
                            if($zeile==null)
                            {
                            	echo'<option value="'.Nix.'">Keine Gr&ouml;&szlig;e verf&uuml;gbar</option>';
                            }
                            while($zeile!=null)
                            {
                            	#Größen des Produktes
                            	$SizeCap=$zeile['Caption'];
                            	$SizeID=$zeile['SKU_SizeID'];
                            	$zeile = $stmt->fetch_array();
                            	echo'<option ';
                            	if(isset($_SESSION['G'.$a]))
                            	{
                            	if($_SESSION['G'.$a]==$SizeID){echo'selected';}}
                            	echo' value="'.$SizeID.'">'.$SizeCap.'</option>';
                            }
                            $stmt->close();
                            echo'</select>';
                            $stmt = $mysqli->query('SELECT Price, SKU_StyleID, SKU_SizeID, SKU_ColourID, VolumeScale from SKU_Price where SKU_StyleID="'.$_SESSION['id'].'"');
                            if($stmt === false)
                            {
                            	die(print_r( $mysqli->error ));
                            }
                            $zeile = $stmt->fetch_array();
                            $text="";
                            
                            while($zeile!=null)
                            {
                            	$Vol=0;
                            	$Preis="";
                            	$text=$zeile['SKU_SizeID'].$zeile['SKU_ColourID'];
                            	while($Vol<5)
                            	{
                            		$Preis=$Preis.$zeile['Price'];
                            		$ex=explode(".",$zeile['Price']);
                            		if(strlen($ex[1])<2)
                            		{
                            			$Preis=$Preis."0";
                            			
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
                            $stmt->close();
                        echo'</div>
                    </div>';*/
                            
                            
                            
                            $stmt = $mysqli->query('SELECT a.Caption, a.SKU_SizeID from Size_ID_Text a, SKU b where b.SKU_StyleID="'.$Style.'" and a.SKU_SizeID = b.SKU_SizeID and b.SKU_ColourID=001 order by a.SKU_SizeID');
                            if($stmt === false)
                            {
                            	die(print_r( $mysqli->error ));
                            }
                            $zeile = $stmt->fetch_array();
                            $_SESSION['GAnzahl'.$a]=$mysqli->affected_rows;
                            
                            
                    echo'<div id="ZeileDetailauswahl">	
                        <span class="span90D">Gesamtmenge:</span>
                        <input onkeypress="return Pruef(event)" value="';
                        if(isset($_SESSION['M'.$a])){echo$_SESSION['M'.$a];}else{echo'0';}
                        echo'" onchange="Rechne(this.value,'.$a.','.$_SESSION['AnzahlA'].',document.FormProdukte.Ver1.value,'.$_SESSION['AnzahlB'].');Teil(1,'.$_SESSION['GAnzahl'.$a].','.$a.')" name="Menge'.$a.'"';
                        echo'" type="text" size="15" class="abrunden_15 input26" />
                        <label>St&uuml;ck</label>
                            </div>';
                        
                        
                        $e=0;
                        while($zeile!=null)
                        {
                        	$e++;
                        	$_SESSION['GSize'.$a.$e]=$zeile['SKU_SizeID'];
                		echo'<div id="ZeileDetailauswahl">';
                		 echo'<span class="span90DU">Gr&ouml;&szlig;e: '.$zeile['Caption'].'</span>
                		<input name="Groessen'.$a.$e.'" onchange="Teil('.$e.','.$_SESSION['GAnzahl'.$a].','.$a.')" value="';
                		
                		if(isset($_SESSION['G'.$a.$e]))
                		{
                			echo$_SESSION['G'.$a.$e];
                		}
                		else
                		{
                			echo'0';
                		}
                		
                		echo'" type="text" size=15 class="abrunden_15 input15 "/>
                		</div>';
                		 $zeile = $stmt->fetch_array();
                        }
                        $e=0;
                    echo'
					<div style="clear:both;"></div>
                    <div id="ZeileDetailauswahl_Berechnen">
                        <label id="Gesamt'.$a.'">';
                        if(isset($_SESSION['EP'.$a])){echo$_SESSION['EP'.$a];}
                        echo'</label><br>
                        <input type="hidden" value="';  if(isset($_SESSION['EP'.$a])){echo$_SESSION['EP'.$a];}echo'" name="GesamtH'.$a.'"/>
                    </div>

                    <div id="Zeile_Klein_Auswahl_Rechts" style="margin-top:60px;">
                      <button name="Plus'.$a.'" class="abrunden_6" style="background: url(plus-button_11.png) 100% 50% no-repeat #ffffff"></button>
                        <label style="margin-left:70px;" class="CH">weiteren Artikel hinzuf&uuml;gen</label>
                    </div>
					
                    <div id="Zeile_Klein_Auswahl_Links" style="margin-bottom:10px;">
                        <button name="Minus'.$a.'" class="abrunden_6" style="background: url(loeschen_button_11.png) 100% 50% no-repeat #ffffff"></button>
                        <label>Diese Auswahl entfernen</label>
                    </div>
                         <div style="clear:both;"></div>
                </div>
                      <div style="clear:both;"></div>';
                        $a++;
				}
				
				
				$test1=1;
				while($test1<=$_SESSION['AnzahlA'])
				{
					if(isset($_POST['Minus'.$test1]))
					{
						$_SESSION['EGP']=str_replace(',','.',$_POST['hiddenLabel'])-str_replace(',','.',$_POST['GesamtH'.$test1]);
						$testa=1;
						#Zwischenspeichern
						while($testa<=$_SESSION['AnzahlA'])
						{
							
							$ee=1;
							while($ee<=$_SESSION['GAnzahl'.$testa])
							{
								$_SESSION['G'.$testa.$ee]=$_POST['Groessen'.$testa.$ee];
								$ee++;
							}
							
							
							$_SESSION['F'.$testa]=$_POST['Farbe'.$testa];
							$_SESSION['M'.$testa]=$_POST['Menge'.$testa];
							$_SESSION['EP'.$testa]=$_POST['GesamtH'.$testa];
							$testa++;
						}

						$testa=1;
						while($testa<=$_SESSION['AnzahlB'])
						{
							$_SESSION['P'.$testa]=$_POST['Posi'.$testa];
							$_SESSION['V'.$testa]=$_POST['Ver'.$testa];
							$_SESSION['VP'.$testa]=$_POST['GesamtVH'.$testa];
							$_SESSION['D'.testa]=$_FILES['datei'.testa]['name'];
							$testa++;
						}
						if($_SESSION['AnzahlA']==1)
						{
							
						}
						else
						{
							#Produkt löschen
							$test0=$_SESSION['AnzahlA'];
							while($test1<$test0)
								#$test0=$test1;
								#while($test0<$_SESSION['AnzahlA'])
							{

								$ee=1;
								while($ee<=$_SESSION['GAnzahl'.$test1])
								{
									$_SESSION['G'.$test1.$ee]=$_SESSION['G'.($test1+1).$ee];
									$ee++;
								}
								
								$_SESSION['F'.$test1]=$_SESSION['F'.($test1+1)];
								$_SESSION['M'.$test1]=$_SESSION['M'.($test1+1)];
								$_SESSION['EP'.$test1]=$_SESSION['EP'.($test1+1)];
								$test0++;
							}
							if($test1==$_SESSION['AnzahlA'])
							{
								#$_SESSION['EGP']=str_replace(',','.',$_POST['hiddenLabel'])-str_replace(',','.',$_POST['GesamtH'.$test1]);
								
								$ee=1;
								while($ee<=$_SESSION['GAnzahl'.$test1])
								{
									unset($_SESSION['G'.$test1.$ee]);
									$ee++;
								}
								
								
								unset($_SESSION['F'.$test1]);
								unset($_SESSION['M'.$test1]);
								unset($_SESSION['EP'.$test1]);
								#$Weg=$test1;
							}
							while($test1<=$_SESSION['AnzahlA'])
							{
								if($test1==$_SESSION['AnzahlA'])
								{
									#$_SESSION['EGP']=str_replace(',','.',$_POST['hiddenLabel'])-str_replace(',','.',$_POST['GesamtH'.$test1]);
									
									$ee=1;
									while($ee<=$_SESSION['GAnzahl'.$test1])
									{
										unset($_SESSION['G'.$test1.$ee]);
										$ee++;
									}
									
									unset($_SESSION['F'.$test1]);
									unset($_SESSION['M'.$test1]);
									unset($_SESSION['EP'.$test1]);
									#$Weg=$test1;
								}
								else 
								{
								
									$ee=1;
									while($ee<=$_SESSION['GAnzahl'.$test1])
									{
										$_SESSION['G'.$test1.$ee]=$_SESSION['G'.($test1+1)];
										$ee++;
									}
									
								$_SESSION['F'.$test1]=$_SESSION['F'.($test1+1)];
								$_SESSION['M'.$test1]=$_SESSION['M'.($test1+1)];
								$_SESSION['EP'.$test1]=$_SESSION['EP'.($test1+1)];
								}
								$test1++;
							}
							
						}
						
						
						$_SESSION['AnzahlA']--;
						
							echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php?A=Pro1" />';
					}
					$test1++;
				}
				$aa=1;
				
				
				while($aa<=$_SESSION['AnzahlA'])
				{
					if(isset($_POST['Plus'.$aa]))
					{
						$aa=1;	
						#Zwischenspeichern
						while($aa<=$_SESSION['AnzahlA'])
						{
							
							$_SESSION['F'.$aa]=$_POST['Farbe'.$aa];
							$_SESSION['M'.$aa]=$_POST['Menge'.$aa];
							$_SESSION['EP'.$aa]=$_POST['GesamtH'.$aa];
							$ee=1;
							while($ee<=$_SESSION['GAnzahl'.$aa])
							{
								$_SESSION['G'.$aa.$ee]=$_POST['Groessen'.$aa.$ee];
								$ee++;
							}
							$aa++;
						}
						$aa=1;
						while($aa<=$_SESSION['AnzahlB'])
						{
							$_SESSION['VP'.$aa]=$_POST['GesamtVH'.$aa];
							$_SESSION['P'.$aa]=$_POST['Posi'.$aa];
							$_SESSION['V'.$aa]=$_POST['Ver'.$aa];
							$_SESSION['D'.$aa]=$_FILES['datei'.$aa]['name'];
								
							$aa++;
						}
						$_SESSION['EGP']=$_POST['hiddenLabel'];
						$_SESSION['AnzahlA']++;
						echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php?A=Pro'.$_SESSION['AnzahlA'].'" />';
					
					
					}
					$aa++;
				}
				
          		 ?>
                
                
                <div id="GesamtPreis">
                    <div id="GesamtPreis_label">
                        <label id="Einzigartig" class="TextSchein"><?php if(isset($_SESSION['EGP'])){echo str_replace('.',',',$_SESSION['EGP']).' &euro;';}else{echo$Price.' &euro;';}?></label><br />
                        <input type="hidden" value="<?php if(isset($_SESSION['EGP'])){echo$_SESSION['EGP'];}else{echo$Price;}?>" name="hiddenLabel"/>
                        <p>zzgl. Mwst</p>
                    </div>
                    
                    
                    
                </div>
                <div id="Korb_Anfrage">
                    <button name="WKLegen" class="button180_30_Korb abrunden_8 HintergrundGelbVerlauf">in den Warenkorb legen</button>
                    <div id="Korb_UnvAnfrage">
                        <img src="Fragen_15.jpg" /><br>
                        <button name="Anfrage" class="HintergrundGrauVerlauf abrunden_8">Unverbindliche Anfrage senden</button>
                    </div>
                    </div>
                </div>
                </form>
                </div>
    </div>
    
    
    
        
        <?php  include "zeile.php";?>
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
    
    
    
    
</body>
</html>
<?php $An=0;
if(isset($_POST['WKLegen']))
                {
                	
                	$aa=1;
                	#ZWischenspeichern
                	while($aa<=$_SESSION['AnzahlA'])
                	{
                		
                		$_SESSION['F'.$aa]=$_POST['Farbe'.$aa];
                		$_SESSION['M'.$aa]=$_POST['Menge'.$aa];
                		#$_SESSION['EP'.$aa]=$_POST['GesamtH'.$aa];
                		
                		$ee=1;
                		while($ee<=$_SESSION['GAnzahl'.$aa])
                		{
                			$_SESSION['G'.$aa.$ee]=$_POST['Groessen'.$aa.$ee];
                			$ee++;
                		}
                		 
                		$aa++;
                	}
                	$aa=1;
                	while($aa<=$_SESSION['AnzahlB'])
                	{
                		$_SESSION['VP'.$aa]=$_POST['GesamtVH'.$aa];
                		$_SESSION['P'.$aa]=$_POST['Posi'.$aa];
                		$_SESSION['V'.$aa]=$_POST['Ver'.$aa];
                		$_SESSION['D'.$aa]=$_FILES['datei'.$aa]['name'];
                		 
                		$aa++;
                	}
                	#$_SESSION['EGP']=$_POST['hiddenLabel'];
                	$Bi=1;
                	$Na=0;
                	$aa=1;
                	$An=0;
                	while($aa<=$_SESSION['AnzahlA'])
                	{
                		if($_SESSION['V'.$aa]=="KA")
                		{
                			$An=1;
                		}
                	$aa++;
                	}
                	#$An=0;
                	if($An==0)
                	{
                	$aa=1;
                	$bb=1;
                	while($aa<=$_SESSION['AnzahlA'])
                	{
                		$GesamtMenge=0;
                		$bb=1;
                		while($bb<=$_SESSION['GAnzahl'.$aa])
                		{
                			$GesamtMenge=$GesamtMenge+$_SESSION['G'.$aa.$bb];
                			$bb++;
                		}
                		if($GesamtMenge!=$_SESSION['M'.$aa])
                		{
                			$_SESSION['ErrorBP']="Mind. eine Teilmenge &uuml;berschreitet oder unterschreitet eine Gesamtmenge";
                			$Na=1;
                		}
                		#$_SESSION['ErrorBP']=$GesamtMenge;
                		$aa++;
                	}
                	
                	$bb=1;
                	$aa=1;
                	while($aa<=$_SESSION['AnzahlA'])
                	{
                		$x=1;
                		while($x<=$_SESSION['GAnzahl'.$aa])
                		{
                			if($_SESSION['G'.$aa.$x]!=0)
                			{
                		$stmt=$mysqli->query('Select count from Stocks where SKU_StyleID="'.$_SESSION['id'].'" and SKU_ColourID="'.$_SESSION['F'.$aa].'" and SKU_SizeID="'.$_SESSION['GSize'.$aa.$x].'"');
                		if($stmt === FALSE)
                		{
                			$Anzahl = $Anzahl+1;
                			echo"Fehler: ";
                			die(print_r( $mysqli->error ));
                		}
                		$zeile = $stmt->fetch_array();
                		
                		if($zeile==null)
                		{
                			$_SESSION['ErrorBP']="-----Kein Stockeintrag vorhanden!------";
                			$Na=1;
                		}
                		else 
                		{
                			if($zeile['count']<$_SESSION['M'.$aa])
                			{
                				$stmt1=$mysqli->query('Select StyleName2 from Styles_Description where SKU_StyleID="'.$_SESSION['id'].'"');
                				$zeile1 = $stmt1->fetch_array();
                				
                				$stmt2=$mysqli->query('Select Caption from Colour_ID_Text where SKU_ColourID="'.$_SESSION['F'.$aa].'"');
                				$zeile2 = $stmt2->fetch_array();
                				
                				$stmt3=$mysqli->query('Select Caption from Size_ID_Text where SKU_SizeID="'.$_SESSION['GSize'.$aa.$x].'"');
                				$zeile3 = $stmt3->fetch_array();
                				
                				
                				$_SESSION['ErrorBP']='Vom Produkt <b>'.$zeile1['StyleName2'].'</b> mit der Farbe '.$zeile2['Caption'].' und der Gr&ouml;&szlig;e '.$zeile3['Caption'].' sind nur mehr '.$zeile['count'].' St&uuml;ck auf Lager.';
                				$stmt1->close();
                				$stmt2->close();
                				$stmt3->close();
                				$Na=1;
                			}
                			else
                			{
                				
                			}
                		}
                			}
                		$x++;
                		}
                		$aa++;
                	}
                	
                	
                	
                	
                	
                	while($Bi<=$_SESSION['AnzahlB'])
                	{
                		if($_SESSION['P'.$Bi]!="Nix")
                		{
                		
                	if($_FILES['datei'.$Bi]['tmp_name']!="")
                	{
                		$dateityp = GetImageSize($_FILES['datei'.$Bi]['tmp_name']);
                		#Dateityp überprüfen
                		if($dateityp[2] != 0 or $dateityp[3] != 0)
                		{
                			#Bilder uploaden
                			//ändern
                			$Pfad="Upload/";
                			if(is_dir($Pfad.$_SESSION['Benutzer']))
                			{
                			move_uploaded_file($_FILES['datei'.$Bi]['tmp_name'], $Pfad.$_SESSION['Benutzer']."/".$_FILES['datei'.$Bi]['name']);
                			}
                			else
                			{
                				mkdir($Pfad.$_SESSION['Benutzer']);
                				move_uploaded_file($_FILES['datei'.$Bi]['tmp_name'], $Pfad.$_SESSION['Benutzer']."/".$_FILES['datei'.$Bi]['name']);
                			}
                		}
                		else
                		{
                			$_SESSION['ErrorBP']="Die ausgew&auml;hlte Datei, ist kein Bild im .jpg oder .png Format.";
                			$Na=1;
                		}
                		
                	
                	}
                	else
                	{
                		$_SESSION['ErrorBP']="Sie haben ein oder mehrere Bilder nicht ausgew&auml;hlt.";
                		$Na=1;
                	}
                	
                	}
                	$Bi++;
                	}
                	$Bi=1;
                	
                	
                	
                	$z=1;
                	if(isset($_SESSION['Benutzer']))
                	{
                		while($z<=$_SESSION['AnzahlA'])
                		{
                			if(!isset($_POST['Menge'.$z]) or $_POST['Menge'.$z]<1 or $_POST['GesamtH'.$z]<1)
                			{
                				#Mengen überprüfen
                				$_SESSION['ErrorBP']="Mindestens eine Menge wurde nicht oder nicht korrekt angegeben.";
                				$Na=1;
                				
                			}
                			$z++;
                		}
                		
                		$stmt=$mysqli->query('Select Benutzer_valid from Benutzer where Kundennummer="'.$_SESSION['Benutzer'].'"');
                		$zeile = $stmt->fetch_array();
                		
                		if($zeile['Benutzer_valid']!=1)
                		{
                			$_SESSION['ErrorBP']="Sie m&uuml;ssen Ihr Konto best&auml;tigen, um ein Produkt in den Warenkorb zu legen.";
                			$Na=1;
                		}
                		$stmt->close();
                		
                		if($Na!=1)
                		{
                			$z=1;
                	while($z<=$_SESSION['AnzahlA'])
                	{
                		
                		if($_SESSION['F'.$z]!="Nix")
                		{
                		$x=1;
                		while($x<=$_SESSION['GAnzahl'.$z])
                		{
                			
                			if($_SESSION['G'.$z.$x]!=0)
                			{
                			#Artikel_ID generieren
                			$stmt=$mysqli->query('Select Max(Bestellte_Artikel_ID) as MaxNummer from Bestellungen_Warenkorb');
                			$zeile = $stmt->fetch_array();
                			if($zeile==null)
                			{
                				$Nummer=0;
                			}
                			else
                			{
                				/*while($zeile!=null)
                				 {
                				$Nummer=$zeile['Bestellte_Artikel_ID'];
                				$zeile = $stmt->fetch_array();
                			
                				}*/
                				$Nummer=$zeile['MaxNummer'];
                				$Nummer++;
                			}
                			$stmt->close();
                			
                			#Artikel in den Warenkorb legen
                			
                			$stmt = $mysqli->prepare("INSERT INTO Bestellungen_Warenkorb (Bestellnummer, Kundennummer, SKU_StyleID, SKU_ColourID, SKU_SizeID, Stueck, Bestellte_Artikel_ID) Values (?,?,?,?,?,?,?)");
                			if($stmt === FALSE)
                			{
                				echo"Fehler: ";
                				die(print_r( $mysqli->error ));
                			}
                			$Bestell="Warenkorb";
                			$stmt->bind_param("sssssii",$Bestell, $_SESSION['Benutzer'],$_SESSION['id'],$_SESSION['F'.$z],$_SESSION['GSize'.$z.$x],$_SESSION['G'.$z.$x],$Nummer);
                			$stmt->execute();
                			$stmt->close();
                			
                			$y=1;
                			while($y<=$_SESSION['AnzahlB'])
                			{
                				if($_SESSION['V'.$y]!="Nix")
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
                			
                			
                					#Veredelungen der Produkte
                					$stmt = $mysqli->prepare("INSERT INTO Bestellungen_Warenkorb_has_Veredelungen (Bestellte_ArtikelID, VeredelungenID, PositionID, Hochgeladene_Datei, Versandkosten, Einzelverpackung, Veredelnummer) Values (?,?,?,?,?,?,?)");
                					if($stmt === FALSE)
                					{
                							echo"Fehler: ";
                							die(print_r( $mysqli->error ));
                					}
                						$VK=0;
                						$EV=false;
                						$stmt->bind_param("isssdsi",$Nummer,$_SESSION['V'.$y],$_SESSION['P'.$y],$_SESSION['D'.$y],$VK,$EV,$Nummer1);
                						$stmt->execute();
                						$stmt->close();
                				}
                				$y++;
                				}
                			}
                				$x++;
                		}
                		}
                		$z++;
                	}
                	
                	#Gesamtpreis des Warenkorbs aktualisieren
                	$_SESSION['WK1']=0;
                	$_SESSION['WK']=0;
                	$stmt = $mysqli->query('SELECT a.Price, c.Stueck, a.VolumeScale, b.SKU_StyleID, b.SKU_ColourID, b.SKU_SizeID from SKU_Price a, SKU b, Bestellungen_Warenkorb c where a.SKU_StyleID = b.SKU_StyleID and a.SKU_SizeID = b.SKU_SizeID and a.SKU_ColourID = b.SKU_ColourID and c.SKU_StyleID = b.SKU_StyleID and c.SKU_SizeID = b.SKU_SizeID and c.SKU_ColourID = b.SKU_ColourID and c.Bestellnummer="Warenkorb" and c.Kundennummer="'.$_SESSION['Benutzer'].'"');
                	$zeile = $stmt->fetch_array();
                	$GP=0;
                	 
                	if($zeile!= null)
                	{
                		while($zeile!=null)
                		{
                			$b=0;
                			$a=0;
                			 
                			while($a<4)
                			{
                				$lastVS=$zeile['VolumeScale'];
                				$lastPrice=$zeile['Price'];
                				$zeile = $stmt->fetch_array();
                				if($lastVS<=$zeile['Stueck'] and $zeile['Stueck']<$zeile['VolumeScale'])
                				{
                					$GP+=$zeile['Stueck']*$lastPrice;
                					$_SESSION[$zeile['SKU_StyleID'].$zeile['SKU_ColourID'].$zeile['SKU_SizeID']]=$zeile['Stueck']*$lastPrice;
                					$b=$a;
                					$a=5;
                				}
                				$a++;
                			}
                			if($zeile['Stueck']>1000)
                			{
                				$GP+=$zeile['Stueck']*$zeile['Price'];
                				#$_SESSION[$zeile['SKU_StyleID'].$zeile['SKU_ColourID'].$zeile['SKU_SizeID']]=$zeile['Stueck']*$zeile['Price'];
                			}
                			while($b<4)
                			{
                				$zeile = $stmt->fetch_array();
                				$b++;
                			}
                			 
                			$_SESSION['WK1']++;
                		}
                		$_SESSION['WK']=$P = str_replace('.', ',', $GP);
                		
                		
                		$stmt=$mysqli->query('SELECT a.Stueck, b.VeredelungenID from Bestellungen_Warenkorb a, Bestellungen_Warenkorb_has_Veredelungen b where a.Bestellnummer="Warenkorb" and a.Kundennummer="'.$_SESSION['Benutzer'].'" and a.Bestellte_Artikel_ID=b.Bestellte_ArtikelID');
                		$zeile=$stmt->fetch_array();
                		while($zeile!=null)
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
                				
                			$stmtP=$mysqli->query('SELECT Preis from VeredelungenStück where VeredelungenID="'.$zeile['VeredelungenID'].'" and Stückzahl='.$VerAn);
                			$zeileP=$stmtP->fetch_array();
                			$_SESSION['WK']=$_SESSION['WK']+round($zeileP['Preis']*$zeile['Stueck'],2);
                			$stmtP->close();
                				
                			$zeile=$stmt->fetch_array();
                		}
                		
                	}
                	else
                	{
                		$_SESSION['WK']="0,00";
                		$_SESSION['WK1']="0";
                	}
                	 
                	$stmt->close();
                	
                	echo'<meta http-equiv="refresh" content="0; url=Warenkorb.php" />';
                		}
                		else
                		{
                			
                			echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php?A=Fehler" />';
                		}
                	}
                	else 
                	{
                		$_SESSION['ErrorBP']="Sie m&uuml;ssen angemeldet sein, um ein Produkt in den Warenkorb zu legen.";
                		echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php?A=Fehler" />';
                	}
                	
                	
                	}
                }
                
                if(isset($_POST['Anfrage']) or $An==1)
                {
                	$aa=1;
                	#Zwischenspeichern
                	while($aa<=$_SESSION['AnzahlA'])
                	{
                		$_SESSION['F'.$aa]=$_POST['Farbe'.$aa];
                		$_SESSION['M'.$aa]=$_POST['Menge'.$aa];
                		$_SESSION['EP'.$aa]=$_POST['GesamtH'.$aa];
                		 
                		$ee=1;
                		while($ee<=$_SESSION['GAnzahl'.$aa])
                		{
                			$_SESSION['G'.$aa.$ee]=$_POST['Groessen'.$aa.$ee];
                			$ee++;
                		}
                		
                		$aa++;
                	}
                	$aa=1;
                	while($aa<=$_SESSION['AnzahlB'])
                	{
                		$_SESSION['VP'.$aa]=$_POST['GesamtVH'.$aa];
                		$_SESSION['P'.$aa]=$_POST['Posi'.$aa];
                		$_SESSION['V'.$aa]=$_POST['Ver'.$aa];
                		$_SESSION['D'.$aa]=$_FILES['datei'.$aa]['name'];
                		 
                		$aa++;
                	}
                	$_SESSION['EGP']=$_POST['hiddenLabel'];
                	
                	$Bi=1;
                	while($Bi<=$_SESSION['AnzahlB'])
                	{
                		if($_SESSION['P'.$Bi]!="Nix")
                		{
                			 
                			if($_FILES['datei'.$Bi]['tmp_name']!="")
                			{
                				$dateityp = GetImageSize($_FILES['datei'.$Bi]['tmp_name']);
                				#Dateityp überprüfen
                				if($dateityp[2] != 0 or $dateityp[3] != 0)
                				{
                				#Bilder uploaden
                						$Pfad="Upload/";
                						if(isset($_SESSION['Benutzer']))
                						{
                						if(is_dir($Pfad.$_SESSION['Benutzer']))
                						{
                						move_uploaded_file($_FILES['datei'.$Bi]['tmp_name'], $Pfad.$_SESSION['Benutzer']."/".$_FILES['datei'.$Bi]['name']);
                						}
                						else
                							{
                							mkdir($Pfad.$_SESSION['Benutzer']);
                							move_uploaded_file($_FILES['datei'.$Bi]['tmp_name'], $Pfad.$_SESSION['Benutzer']."/".$_FILES['datei'.$Bi]['name']);
                							}
                						}
                						else
                						{
                							if(is_dir($Pfad.'000_NichtRegistriert'))
                							{
                								move_uploaded_file($_FILES['datei'.$Bi]['tmp_name'], $Pfad.'000_NichtRegistriert'."/".$_FILES['datei'.$Bi]['name']);
                							}
                							else
                							{
                								mkdir($Pfad.'000_NichtRegistriert');
                								move_uploaded_file($_FILES['datei'.$Bi]['tmp_name'], $Pfad.'000_NichtRegistriert'."/".$_FILES['datei'.$Bi]['name']);
                							}
                						}
                				}
                				else
                				{
                					$_SESSION['ErrorBP']="Die ausgew&auml;hlte Datei, ist kein Bild im .jpg oder .png Format.";
                					echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php?A=Fehler" />';
                				}
                							 
                	
                			}
                			else
                				{
                					$_SESSION['ErrorBP']="Sie haben ein oder mehrere Bilder nicht ausgew&auml;hlt.";
                					echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php?A=Fehler" />';
                				}
                			 
                			}
                			$Bi++;
                		}
                	$Bi=1;
                	
                	
                	
                	 if(isset($_SESSION['Benutzer']))
                	 {

                	 	
                	 	$stmt=$mysqli->query('Select Benutzer_valid from Benutzer where Kundennummer="'.$_SESSION['Benutzer'].'"');
                	 	$zeile = $stmt->fetch_array();
                	 	
                	 	if($zeile['Benutzer_valid']!=1)
                	 	{
                	 		$_SESSION['ErrorBP']="Sie m&uuml;ssen Ihr Konto best&auml;tigen, um eine Anfrage zu senden.";
                	 		echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php?A=Fehler" />';
                	 		$stmt->close();
                	 	}
                	 	else 
                	 	{
                	 	
                	 	
                	 	
                	 	$stmt = $mysqli->query('SELECT Vorname, Nachname, Anrede, Email, Telefonnummer, Fax from Benutzer where Kundennummer="'.$_SESSION['Benutzer'].'"');
                	 	$zeile = $stmt->fetch_array();
                	 	
                	 	#Email
                	 	include'class.phpmailer.php';
                	 	$mail = new PHPMailer();
                	 	
                	 	#Sender
                	 	$mail->SetFrom($zeile['Email'], $zeile['Anrede'].' '.$zeile['Nachname']);
                	 	
                	 	#Empfänger
						include'Email_Adresse.php';
                	 	
                	 	#Betreff
                	 	$mail->Subject    = "Anfrage bezüglich Artikel";
                	 	
                	 	#Text zusammenschneiden
                	 	$body='<h1>Anfrage von Benutzer '.$zeile['Vorname'].' '.$zeile['Nachname'].'</h1><br><h2>Hauptprodukt: '.$BEN.'</h2><br><h3>Unterprodukte:</h3><br>';
                	 	$Pro=1;
                	 	$Nummerierung=1;
                	 	while($Pro<=$_SESSION['AnzahlA'])
                	 	{
                	 		if($_SESSION['F'.$Pro]!="Nix")
                	 		{
                	 		$Pra=1;
                	 		while($Pra<=$_SESSION['GAnzahl'.$Pro])
                	 		{
                	 			if($_SESSION['G'.$Pro.$Pra]!=0)
                	 			{
                	 				$stmt1 = $mysqli->query('SELECT Caption from Size_ID_Text where SKU_SizeID="'.$_SESSION['GSize'.$Pro.$Pra].'"');
                	 				$zeile1 = $stmt1->fetch_array();
                	 		 
                	 				$stmt2 = $mysqli->query('SELECT Caption from Colour_ID_Text where SKU_ColourID="'.$_SESSION['F'.$Pro].'"');
                	 				$zeile2 = $stmt2->fetch_array();
                	 		
                	 				$body=$body.'<b>'.$Nummerierung.'. Produkt</b><br>Größe: '.$zeile1['Caption'].'<br>Farbe: '.$zeile2['Caption'].'<br>Menge: '.$_SESSION['G'.$Pro.$Pra].'<br>Preis: '.$_SESSION['EP'.$Pro].'<br>';
                	 				$stmt1->close();
                	 				$stmt2->close();
                	 				$Nummerierung++;
                	 			}
                	 		$Pra++;
                	 		}
                	 		}
                	 		$Pro++;
                	 	}
                	 	
                	 	$Pro=1;
                	 	$body=$body.'<br><h3>Veredelungen:</h3><br>';
                	 	$Nummerierung1=1;
                	 	while($Pro<=$_SESSION['AnzahlB'])
                	 	{
                	 		if($_SESSION['V'.$Pro]!="Nix" and $_SESSION['P'.$Pro]!="Nix")
                	 		{
                	 			if($_SESSION['V'.$Pro]!="KA")
                	 			{
                	 			$stmt1 = $mysqli->query('SELECT Veredelungsart, Veredelungsfläche from Veredelungen where VeredelungenID="'.$_SESSION['V'.$Pro].'"');
                	 			$zeile1 = $stmt1->fetch_array();
                	 			
                	 			$stmt2 = $mysqli->query('SELECT Position from Positionen where PositionID="'.$_SESSION['P'.$Pro].'"');
                	 			$zeile2 = $stmt2->fetch_array();
                	 			
                	 			$body=$body.'<b>'.$Nummerierung1.'. Veredelung</b> <br>Art: '.$zeile1['Veredelungsart'].' '.$zeile1['Veredelungsfläche'].'<br>Position: '.$zeile2['Position'].'<br>Bild: '.$_SESSION['D'.$Pro].'<br>';
                	 			$stmt1->close();
                	 			$stmt2->close();
                	 			}
                	 			else
                	 			{
                	 				$body=$body.'<b>'.$Nummerierung1.'. Veredelung</b> <br>Art: Keine Ahnung<br>Position: Keine Ahnung<br>Bild: '.$_SESSION['D'.$Pro].'<br>';
                	 			}
                	 			$Nummerierung1++;
                	 		}
                	 		$Pro++;
                	 	}
                	 	$body=$body.'<br><h3>Gesamtpreis:</h3><br>';
                	 	$body=$body.$_SESSION['EGP'].' &euro;<br>';
                	 	$body=$body.'<br><h3>Sonstige Informationen:</h3><br>';
                	 	$body=$body.'Kundennummer: '.$_SESSION['Benutzer'].'<br>Datum: '.date("Y.m.d").' <br>Telefonnummer: '.$zeile['Telefonnummer'].'<br>Email: '.$zeile['Email'].'<br>Fax: '.$zeile['Fax'];
                	 	#echo$body;
                	 	$mail->MsgHTML($body);
                	 	$stmt->close();
                	 	if(!$mail->Send()) {
                	 		$_SESSION['ErrorBP']="Mailer Error: " . $mail->ErrorInfo;
                	 		echo'<meta http-equiv="refresh" content="0; url=Produktansicht.php?A=Fehler" />';
                	 	} else {
                	 		#$_SESSION['ErrorBP']="Ihre Anfrage wurde an uns gesendet.";
								echo'<meta http-equiv="refresh" content="0; url=Formular_ab.php" />';
                	 	}
                	 	}
                	 	
                	 }
                	 else 
                	 {
                	 	echo'<meta http-equiv="refresh" content="0; url=Formular.php" />';
                	 }
                }
                
                ?>