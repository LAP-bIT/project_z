<?php 
#----------------------------------------------------------------------------------------------------------------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------------------------------------#
#---------------------------------------------------#FUNKTIONEN SUCHE & SORTIEREN & FILTERN N.E.U#---------------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------------------------------------#
#Session starten
session_start();

#Error unseten
unset($_SESSION['Error']);
unset($_SESSION['ErrorBP']);
unset($_SESSION['ErrorR']);
unset($_SESSION['ErrorC']);
unset($_SESSION['ErrorPW']);

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

if(!isset($_SESSION['Seite']))
{
	$_SESSION['Seite']='0';
}
if(!isset($_SESSION['Count']))
{
	$_SESSION['Count']='0';
}

if(!isset($_SESSION['Select']))
{
	$_SESSION['Select']="Nix";
}

#Datenbankverbindung
include "DB_Verbindung.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Webshop f&uuml;r Textilwaren | Suche</title>
<link href="WebShopStyle.css" rel="stylesheet" type="text/css" />
<link href="AuswahlStyle.css" rel="stylesheet" type="text/css" />
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script type='text/javascript' src='menu_jquery.js'></script>

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
        <h2 style="margin-top:25px;margin-bottom:10px;font-style:oblique;text-decoration:underline;letter-spacing:2px;font-size:20px">KATEGORIEN</h2>
   <div id='cssmenu'>
      <ul>
      
      <?php
	  
	   if(isset($_POST['Produkt']))
				{
					$_SESSION['Suchtext']=$_POST['Produkt'];
					unset($_SESSION['Caption']);
					unset($_SESSION['Ref']);
					#unset($_SESSION['Sort']);
					#unset($_SESSION['Filt1']);
					#unset($_SESSION['Filt2']);
					#unset($_SESSION['Filt3']);
					#unset($_SESSION['Filt4']);
					#unset($_SESSION['Sortieren']);
				}
				if(isset($_GET['Caption']))
				{
					$_SESSION['Caption']=$_GET['Caption'];
					$_SESSION['Ref']=$_GET['Ref'];
					unset($_SESSION['Suchtext']);
					#unset($_SESSION['Sort']);
					#unset($_SESSION['Filt1']);
					#unset($_SESSION['Filt2']);
					#unset($_SESSION['Filt3']);
					#unset($_SESSION['Filt4']);
					#unset($_SESSION['Sortieren']);
				}
	  
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
   
     <h2 style="margin-top:25px;margin-bottom:10px;font-style:oblique;text-decoration:underline;letter-spacing:2px ;font-size:20px">SORTIEREN</h2>
   <div id="Auswahl">
            <div id='cssmenu'>
                <ul>
                     <li <?php 
					 if(isset($_SESSION['Sort']) or isset($_GET['Sort']))
				{
					if(isset($_GET['Sort']))
					{
						$_SESSION['Sort']=$_GET['Sort'];
					}
					
					if($_SESSION['Sort']=="Preisab")
					{
						echo" class='test' ";
					}
					else
					{
						
					}
				}
				else
				{
					
				}
					   ?>><a href='Suche.php?Sort=Preisab'><span>Preis ab.</span></a></li>
                     <li<?php 
					 if(isset($_SESSION['Sort']) or isset($_GET['Sort']))
				{
					if(isset($_GET['Sort']))
					{
						$_SESSION['Sort']=$_GET['Sort'];
					}
					
					if($_SESSION['Sort']=="Preisauf")
					{
						echo" class='test' ";
					}
					else
					{
						
					}
				}
				else
				{
					
				}
					   ?>><a href='Suche.php?Sort=Preisauf'><span>Preis auf.</span></a></li>
                     <li<?php 
					 if(isset($_SESSION['Sort']) or isset($_GET['Sort']))
				{
					if(isset($_GET['Sort']))
					{
						$_SESSION['Sort']=$_GET['Sort'];
					}
					
					if($_SESSION['Sort']=="Lager")
					{
						echo" class='test' ";
					}
					else
					{
						
					}
				}
				else
				{
					
				}
					   ?>><a href='Suche.php?Sort=Lager'><span>Lagerbestand</span></a></li>
                     <li<?php 
					 if(isset($_SESSION['Sort']) or isset($_GET['Sort']))
				{
					if(isset($_GET['Sort']))
					{
						$_SESSION['Sort']=$_GET['Sort'];
					}
					
					if($_SESSION['Sort']=="Alp")
					{
						echo" class='test' ";
					}
					else
					{
						
					}
				}
				else
				{
					
				}
					   ?>><a href='Suche.php?Sort=Alp'><span>Alphabet</span></a></li> 
                     <li<?php 
					 if(isset($_SESSION['Sort']) or isset($_GET['Sort']))
				{
					if(isset($_GET['Sort']))
					{
						$_SESSION['Sort']=$_GET['Sort'];
					}
					
					if($_SESSION['Sort']=="Nix")
					{
						echo" class='test' ";
					}
					else
					{
						
					}
				}
				else
				{
					
				}
					   ?>><a href='Suche.php?Sort=Nix'><span>Nichts</span></a></li> 
          </ul>
       </div>
       </div>
   
   
   
   <div style="clear:both;"></div>
   <h2 style="margin-top:25px;margin-bottom:10px;font-style:oblique;text-decoration:underline;letter-spacing:2px;font-size:20px">FILTERN</h2>
   <div id="Auswahl">
            <div id='cssmenu'>
                <ul>
                <?php
	  #Liefert alle Hauptkategorien
	  $stmt1 = $mysqli->query('SELECT DISTINCT Hauptkate from Test_Kate where Hauptkate!="Produkte" and Hauptkate!="Filter" and Hauptkate!="Stile"');
	  $zeile1 = $stmt1->fetch_array();
	  $nn=0;
	  while($zeile1!=null)
	  {
		  $nn++;
		  if(isset($_SESSION['Filt'.$nn]) or isset($_GET['Filt'.$nn]))
				{
					if(isset($_GET['Filt'.$nn]))
					{
						$_SESSION['Filt'.$nn]=$_GET['Filt'.$nn];
					}
					
					if($_SESSION['Filt'.$nn]!="Nix")
					{
						$xx=" test";
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
	  ?>
                   <li class='has-sub <?php echo $xx; ?>'><a href='#'><span><?php echo $zeile1['Hauptkate']; ?></span></a>
                     <ul>
                     
                     
                             <?php
					#Liefert alle Kategorien der Hauptkategorie
				 $stmt2 = $mysqli->query('SELECT DISTINCT Unterkate, Anzahl from Test_Kate where Hauptkate="'.$zeile1['Hauptkate'].'" order by Anzahl desc');
	  			 $zeile2 = $stmt2->fetch_array();
				 
				 if(isset($_SESSION['Filt'.$nn]) or isset($_GET['Filt'.$nn]))
				{
					if(isset($_GET['Filt'.$nn]))
					{
						$_SESSION['Filt'.$nn]=$_GET['Filt'.$nn];
					}
					
					if($_SESSION['Filt'.$nn]=="Nix")
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
				 
				 echo"<li ".$xx."><a href='Suche.php?Filt".$nn."=Nix'><span>Nichts</span></a></li>";
				 while($zeile2!=null)
				 {
					 if(isset($_SESSION['Filt'.$nn]) or isset($_GET['Filt'.$nn]))
				{
					if(isset($_GET['Filt'.$nn]))
					{
						$_SESSION['Filt'.$nn]=$_GET['Filt'.$nn];
					}
					
					if($_SESSION['Filt'.$nn]==$zeile2['Unterkate'])
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
					 
					 
						echo"<li ".$xx."><a href='Suche.php?Filt".$nn."=".urlencode($zeile2['Unterkate'])."'><span>".$zeile2['Unterkate']."</span></a></li>"; 
					 
					 
					 
					 $zeile2 = $stmt2->fetch_array();
				 }
				 
				?>     
                     </ul>
                 </li>
                 <?php
		$zeile1 = $stmt1->fetch_array();
	  }
	?>
    		 
          </ul>
       </div>
    </div> 
   </div>
   <img class="abrunden_15" src="hotline_11.jpg" />
  </div>
        
		<!-- #-----------------------------------------------------------------------------------------------------------------------------------------------# -->        
        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein">Suche <?php 
                #------------------------------------------------Suchtexte-für-die-----------------------------------------------------
				$Anzeige='';
				
				
				$na=false;
				if(!isset($_GET['Caption']) and !isset($_POST['Produkt']) and !isset($_SESSION['Caption']) and !isset($_SESSION['Suchtext']) and (isset($_GET['Sort']) or isset($_GET['Filt1']) or isset($_GET['Filt2']) or isset($_GET['Filt3']) or isset($_GET['Filt4'])))
				{
					$Anzeige=$Anzeige. ' - Bitte zuerst eine Kategorie ausw&auml;hlen!';
					$na=true;
				}
				else
				{
				#------------------------------------------------FREITEXTSUCHE------------------------------------------------------
                if(isset($_POST['Produkt']))
				{
				$Anzeige=$Anzeige.' nach '.$_POST['Produkt'];	
				}
				else
				{
				
				if(isset($_SESSION['Suchtext']))
				{
				$Anzeige=$Anzeige.' nach '.$_SESSION['Suchtext'];	
				}
				}
				#-------------------------------------------------KATEGORIENSUCHE---------------------------------------------------
				if(isset($_GET['Caption']))
				{
						if($_GET['Caption']==$_GET['Ref'])
						{
							$Anzeige=$Anzeige.' nach ('.$_GET['Caption'].')';
						}
						else
						{
							$Anzeige=$Anzeige.' nach ('.$_GET['Caption'].'/'.str_replace('/','-',$_GET['Ref']).')';
						}	
				}
				else
				{
				if(isset($_SESSION['Caption']))
				{
						if($_SESSION['Caption']==$_SESSION['Ref'])
						{
							$Anzeige=$Anzeige.' nach ('.$_SESSION['Caption'].')';
						}
						else
						{
							$Anzeige=$Anzeige.' nach ('.$_SESSION['Caption'].'/'.str_replace('/','-',$_SESSION['Ref']).')';
						}	
				}
				}
				#--------------------------------------------------SORTIERUNG--------------------------------------------------
				if(isset($_GET["Sort"]) or isset($_SESSION["Sort"]))
				{
					if(isset($_GET["Sort"]))
					{
						$_SESSION["Sort"]=$_GET["Sort"];
					}
					if($_SESSION["Sort"]=='Preisab')
					{
						$Anzeige=$Anzeige.' - (Preis ab.)';
					}
					if($_SESSION["Sort"]=='Preisauf')
					{
						$Anzeige=$Anzeige.' - (Preis auf.)';
					}
					if($_SESSION["Sort"]=='Lager')
					{
						$Anzeige=$Anzeige.' - (Lagerbestand)';
					}
					if($_SESSION["Sort"]=='Alp')
					{
						$Anzeige=$Anzeige.' - (Alphabet)';
					}
					if($_SESSION["Sort"]=='Nix')
					{
						$Anzeige=$Anzeige.'';
					}
				}
				#----------------------------------------------FILTERUNG----------------------------------------------
				$f=1;
				$nn++;
				$ftext='';
				$_SESSION['FiltA']=0;
				while($f<$nn)
				{
				if(isset($_GET["Filt".$f]) or isset($_SESSION["Filt".$f]))
				{
					if(isset($_GET["Filt".$f]))
					{
						$_SESSION["Filt".$f]=urldecode($_GET["Filt".$f]);
					}
					if($_SESSION["Filt".$f]!="Nix")
					{
						$_SESSION['FiltA']++;
						$ftext=$ftext.' - ('.$_SESSION["Filt".$f].')';
					}
					else
					{
						unset($_SESSION['Filt'.$f]);	
					}
				}
				$f++;
				}
				$Anzeige=$Anzeige.$ftext;
				}
				
				if(strlen($Anzeige)>55)
				{
					echo substr($Anzeige,0,53).'...';
				}
				else
				{
					echo $Anzeige;
				}
				
			?> 
			</label>
            </div>
          
    
            
                        <?php 
            
            if((isset($_POST["Produkt1"]) or isset($_POST["ProduktW"]) or isset($_POST["ProduktZ"]) or isset($_GET["Caption"]) or isset($_GET["Sort"]) or isset($_GET["Filt1"]) or isset($_GET["Filt2"]) or isset($_GET["Filt3"]) or isset($_GET["Filt4"])) and $na==false)
            {
				#----------------------------------------------------FILTERN-----------------------------------------------------
					$nein=false;
					#Siehe oben
				#----------------------------------------------------SORTIEREN---------------------------------------------------
				if(isset($_GET["Sort"]))
				{
					if($_GET["Sort"]=='Preisab')
					{
						$_SESSION['Sortieren']=' order by SKU_Price.Price desc';
					}
					if($_GET["Sort"]=='Preisauf')
					{
						$_SESSION['Sortieren']=' order by SKU_Price.Price asc';	
					}
					if($_GET["Sort"]=='Lager')
					{
						$_SESSION['Sortieren']=' order by Stocks.Count desc';	
					}
					if($_GET["Sort"]=='Alp')
					{
						$_SESSION['Sortieren']=' order by Styles_D.StyleName2';	
					}
					if($_GET["Sort"]=='Nix')
					{
						unset($_SESSION['Sortieren']);
					}
				}
				#---------------------------------------------------------------------------------------------------------------------------------------
				#--------------------FREITEXTSUCHE+SORTIEREN+FILTERN+WEITER/ZURÜCKBLÄTTERN--------------------------------------------------------------
				#---------------------------------------------------------------------------------------------------------------------------------------
				if(isset($_SESSION['Suchtext']) and (isset($_SESSION['Filt1']) or isset($_SESSION['Filt2']) or isset($_SESSION['Filt3']) or isset($_SESSION['Filt4'])))
				{
					#echo 'FREITEXTSUCHE+SORTIEREN+FILTERN+WEITER/ZURÜCKBLÄTTERN';
					$nein=true;
					if(!isset($_SESSION['Sortieren']))
					{
						$_SESSION['Sortieren']='';
					}
					
					$textS='';
					$f=1;
					while($f<$nn)
					{
						if(isset($_SESSION["Filt".$f]))
						{
						
						if($_SESSION["Filt".$f]!="Nix")
						{
								$textS=$textS.' and Styles_D.SKU_StyleID IN (SELECT DISTINCT Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION["Filt".$f].'")) ';
						}
						}
						$f++;
					}
					
					#$hilfe=strlen($textS);
					#$textS=substr($textS,0,($hilfe-2));
					
					
					
					$Select_Kat=$mysqli->query('SELECT DISTINCT Styles_D.StyleName2, Styles_D.StyleDescription, Styles_D.SKU_StyleID from Styles_Description Styles_D, SKU_Price, Stocks where LanguageISO="DE" '.$textS.' and Styles_D.SKU_StyleID=SKU_Price.SKU_StyleID and Styles_D.SKU_StyleID=Stocks.SKU_StyleID and Styles_D.StyleName2 LIKE "%'.$_SESSION['Suchtext'].'%"'.$_SESSION['Sortieren']);
												
						$zeile_Produkte=$Select_Kat->fetch_array();	
						
						if(!isset($_POST['ProduktW']) and !isset($_POST['ProduktZ']))
					{	
						$_SESSION['Seitenzahl']=ceil(($mysqli->affected_rows)/30);
						$_SESSION['Produktanzahl']=$mysqli->affected_rows;
						$_SESSION['Seite']=1;
					}
					if(isset($_POST['ProduktW']) and $_SESSION['Seite']<$_SESSION['Seitenzahl'])
					{
						$_SESSION['Seite']++;
					}
					if(isset($_POST['ProduktZ']))
					{
						$_SESSION['Seite']--;
					}
						$a=$_SESSION['Seite']*30-30;
						while($a>0)
						{
							$zeile_Produkte=$Select_Kat->fetch_array();
							$a--;
						}
				}
				#---------------------------------------------------------------------------------------------------------------------------------------
				#----------------------------------KATEGORIENSUCHE+SORTIEREN+FILTERN+WEITER/ZURÜCKBLÄTTERN----------------------------------------------
				#---------------------------------------------------------------------------------------------------------------------------------------
				if(isset($_SESSION['Caption']) and (isset($_SESSION['Filt1']) or isset($_SESSION['Filt2']) or isset($_SESSION['Filt3']) or isset($_SESSION['Filt4'])))
				{
					#echo'KATEGORIENSUCHE+SORTIEREN+FILTERN+WEITER/ZURÜCKBLÄTTERN';
					$nein=true;
					if(!isset($_SESSION['Sortieren']))
					{
						$_SESSION['Sortieren']='';
					}
					
					$textS='';
					$f=1;
					while($f<$nn)
					{
						if(isset($_SESSION["Filt".$f]))
						{
						
						if($_SESSION["Filt".$f]!="Nix")
						{
							$textS=$textS.' and Styles_D.SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION["Filt".$f].'")) ';
						}
						}
						$f++;
					}
					
					#$hilfe=strlen($textS);
					#$textS=substr($textS,0,($hilfe-3));
					
					#echo $_SESSION['FiltA'].'<br>';
					#echo $textS.'<br>';
					
					$Select_Kat=$mysqli->query('SELECT DISTINCT Styles_D.StyleName2, Styles_D.StyleDescription, Styles_D.SKU_StyleID from Styles_Description Styles_D, SKU_Price, Stocks where Styles_D.SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION['Caption'].'")) and Styles_D.SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION['Ref'].'"))'.$textS.' and LanguageISO="DE" and Styles_D.SKU_StyleID=SKU_Price.SKU_StyleID and Styles_D.SKU_StyleID=Stocks.SKU_StyleID'.$_SESSION['Sortieren']);
												
						$zeile_Produkte=$Select_Kat->fetch_array();	
						
					if(!isset($_POST['ProduktW']) and !isset($_POST['ProduktZ']))
					{	
						$_SESSION['Seitenzahl']=ceil(($mysqli->affected_rows)/30);
						$_SESSION['Produktanzahl']=$mysqli->affected_rows;
						$_SESSION['Seite']=1;
					}
					if(isset($_POST['ProduktW']) and $_SESSION['Seite']<$_SESSION['Seitenzahl'])
					{
						$_SESSION['Seite']++;
					}
					if(isset($_POST['ProduktZ']))
					{
						$_SESSION['Seite']--;
					}
						$a=$_SESSION['Seite']*30-30;
						while($a>0)
						{
							$zeile_Produkte=$Select_Kat->fetch_array();
							$a--;
						}
				}
				#---------------------------------------------------------------------------------------------------------------------------------------
				#-----------------------------------------------FREITEXTSUCHE+SORTIEREN-----------------------------------------------------------------
				#---------------------------------------------------------------------------------------------------------------------------------------
				if(isset($_SESSION['Sortieren']) and isset($_SESSION['Suchtext']) and $nein==false)
				{
					#echo'FREITEXTSUCHE+SORTIEREN';
					$Select_Kat= $mysqli->query('SELECT DISTINCT Styles.SKU_StyleID, Styles_D.StyleName2
												  from Styles_Description Styles_D, Styles, SKU, SKU_Price, Stocks
												  where Styles_D.LanguageISO="DE"
												  and Styles.SKU_StyleID=SKU.SKU_StyleID
												  and SKU.SKU_StyleID=SKU_Price.SKU_StyleID
												  and SKU.SKU_ColourID=SKU_Price.SKU_ColourID
												  and SKU.SKU_SizeID=SKU_Price.SKU_SizeID
												  and SKU.SKU_StyleID=Stocks.SKU_StyleID
												  and SKU.SKU_ColourID=Stocks.SKU_ColourID
												  and SKU.SKU_SizeID=Stocks.SKU_SizeID
												  and SKU_Price.VolumeScale=0
												  and Styles_D.SKU_StyleID=Styles.SKU_StyleID
												  and Styles_D.StyleName2 LIKE "%'.$_SESSION['Suchtext'].'%"'.$_SESSION['Sortieren']);
												  
						$zeile_Produkte=$Select_Kat->fetch_array();
						$_SESSION['Seitenzahl']=ceil(($mysqli->affected_rows)/30);
						$_SESSION['Produktanzahl']=$mysqli->affected_rows;
						$a=$_SESSION['Seite']*30-30;
						while($a>0)
						{
							$zeile_Produkte=$Select_Kat->fetch_array();
							$a--;
						}
				}
				#---------------------------------------------------------------------------------------------------------------------------------------
				#----------------------------------------------------------KATEGORIERENSUCHE+SORTIEREN--------------------------------------------------
				#---------------------------------------------------------------------------------------------------------------------------------------
				if(isset($_SESSION['Sortieren']) and isset($_SESSION['Caption']) and $nein==false)
				{
					#echo 'KATEGORIERENSUCHE+SORTIEREN';
				$Select_Kat=$mysqli->query('SELECT DISTINCT Styles_D.StyleName2, Styles_D.StyleDescription, Styles_D.SKU_StyleID from Styles_Description Styles_D, SKU_Price, Stocks where Styles_D.SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION['Caption'].'")) and Styles_D.SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION['Ref'].'")) and LanguageISO="DE" and Styles_D.SKU_StyleID=SKU_Price.SKU_StyleID and Styles_D.SKU_StyleID=Stocks.SKU_StyleID'.$_SESSION['Sortieren']);
												
						$zeile_Produkte=$Select_Kat->fetch_array();	
						$_SESSION['Seitenzahl']=ceil(($mysqli->affected_rows)/30);
						$_SESSION['Produktanzahl']=$mysqli->affected_rows;
						$a=$_SESSION['Seite']*30-30;
						while($a>0)
						{
							$zeile_Produkte=$Select_Kat->fetch_array();
							$a--;
						}
				}
				#---------------------------------------------------------------------------------------------------------------------------------------
				#--------------------------------------------------------------WEITER-BLÄTTERN----------------------------------------------------------
				#---------------------------------------------------------------------------------------------------------------------------------------
				if(isset($_POST["ProduktW"]) and $nein==false and $_SESSION['Seite']<$_SESSION['Seitenzahl'])
				{
					#echo'WEITER-BLÄTTERN';
					#echo $_SESSION['Seite'].' '.$_SESSION['Seitenzahl'];
					$_SESSION['Seite']++;
					
					if(!isset($_SESSION['Sortieren']))
					{
						$_SESSION['Sortieren']='';
					}
					
					if(isset($_SESSION['Suchtext']))
					{
						$Select_Kat= $mysqli->query('SELECT DISTINCT Styles.SKU_StyleID, Styles_D.StyleName2
												  from Styles_Description Styles_D, Styles, SKU, SKU_Price, Stocks
												  where Styles_D.LanguageISO="DE"
												  and Styles.SKU_StyleID=SKU.SKU_StyleID
												  and SKU.SKU_StyleID=SKU_Price.SKU_StyleID
												  and SKU.SKU_ColourID=SKU_Price.SKU_ColourID
												  and SKU.SKU_SizeID=SKU_Price.SKU_SizeID
												  and SKU.SKU_StyleID=Stocks.SKU_StyleID
												  and SKU.SKU_ColourID=Stocks.SKU_ColourID
												  and SKU.SKU_SizeID=Stocks.SKU_SizeID
												  and SKU_Price.VolumeScale=0
												  and Styles_D.SKU_StyleID=Styles.SKU_StyleID
												  and Styles_D.StyleName2 LIKE "%'.$_SESSION['Suchtext'].'%"'.$_SESSION['Sortieren']);
												  
						$zeile_Produkte=$Select_Kat->fetch_array();
					
						$a=$_SESSION['Seite']*30-30;
						while($a>0)
						{
							$zeile_Produkte=$Select_Kat->fetch_array();
							$a--;
						}
					}
					else
					{
						$Select_Kat=$mysqli->query('SELECT DISTINCT Styles_D.StyleName2, Styles_D.StyleDescription, Styles_D.SKU_StyleID from Styles_Description Styles_D, SKU_Price, Stocks where Styles_D.SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION['Caption'].'")) and Styles_D.SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION['Ref'].'")) and LanguageISO="DE" and Styles_D.SKU_StyleID=SKU_Price.SKU_StyleID and Styles_D.SKU_StyleID=Stocks.SKU_StyleID'.$_SESSION['Sortieren']);
												
						$zeile_Produkte=$Select_Kat->fetch_array();	
						
						$a=$_SESSION['Seite']*30-30;
						while($a>0)
						{
							$zeile_Produkte=$Select_Kat->fetch_array();
							$a--;
						}
					}	
				}
				#---------------------------------------------------------------------------------------------------------------------------------------
				#-----------------------------------------------------------ZURÜCK-BLÄTTERN-------------------------------------------------------------
				#---------------------------------------------------------------------------------------------------------------------------------------
				if(isset($_POST["ProduktZ"]) and $nein==false)
				{
					#echo'ZURÜCK-BLÄTTERN';
					$_SESSION['Seite']--;
					
					if(!isset($_SESSION['Sortieren']))
					{
						$_SESSION['Sortieren']='';
					}
					
					if(isset($_SESSION['Suchtext']))
					{
						$Select_Kat= $mysqli->query('SELECT DISTINCT Styles.SKU_StyleID, Styles_D.StyleName2
												  	from Styles_Description Styles_D, Styles, SKU, SKU_Price, Stocks
												  	where Styles_D.LanguageISO="DE"
													and Styles.SKU_StyleID=SKU.SKU_StyleID
												    and SKU.SKU_StyleID=SKU_Price.SKU_StyleID
												    and SKU.SKU_ColourID=SKU_Price.SKU_ColourID
												    and SKU.SKU_SizeID=SKU_Price.SKU_SizeID
												    and SKU.SKU_StyleID=Stocks.SKU_StyleID
												    and SKU.SKU_ColourID=Stocks.SKU_ColourID
												    and SKU.SKU_SizeID=Stocks.SKU_SizeID
												    and SKU_Price.VolumeScale=0
												 	and Styles_D.SKU_StyleID=Styles.SKU_StyleID
												  	and Styles_D.StyleName2 LIKE "%'.$_SESSION['Suchtext'].'%"'.$_SESSION['Sortieren']);
												  
						$zeile_Produkte=$Select_Kat->fetch_array();
					
						$a=$_SESSION['Seite']*30-30;
						while($a>0)
						{
							$zeile_Produkte=$Select_Kat->fetch_array();
							$a--;
						}
					}
					else
					{
						$Select_Kat=$mysqli->query('SELECT DISTINCT Styles_D.StyleName2, Styles_D.StyleDescription, Styles_D.SKU_StyleID from Styles_Description Styles_D, SKU_Price, Stocks where Styles_D.SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION['Caption'].'")) and Styles_D.SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION['Ref'].'")) and LanguageISO="DE" and Styles_D.SKU_StyleID=SKU_Price.SKU_StyleID and Styles_D.SKU_StyleID=Stocks.SKU_StyleID'.$_SESSION['Sortieren']);
												
						$zeile_Produkte=$Select_Kat->fetch_array();	
						
						$a=$_SESSION['Seite']*30-30;
						while($a>0)
						{
							$zeile_Produkte=$Select_Kat->fetch_array();
							$a--;
						}
					}
				}
				#---------------------------------------------------------------------------------------------------------------------------------------
            	#-----------------------------------------------------------FREITEXTSUCHE---------------------------------------------------------------
				#---------------------------------------------------------------------------------------------------------------------------------------
				if((isset($_POST['Produkt']) and $nein==false and !isset($_SESSION['Sortieren'])) or (isset($_SESSION['Suchtext']) and $nein==false and !isset($_SESSION['Sortieren'])))
				{
					#echo'FREITEXTSUCHE';
					unset($_SESSION['Caption']);
					unset($_SESSION['Ref']);
					
					if(isset($_POST['Produkt']))
					{
						unset($_SESSION['Sortieren']);
						unset($_SESSION['Filtern1']);
						unset($_SESSION['Filtern2']);
						unset($_SESSION['Filtern3']);
						unset($_SESSION['Filtern4']);
						
            			$_SESSION['Suchtext']=$_POST['Produkt'];
						
						
					}
					#Select
					$Select_Kat= $mysqli->query('SELECT Styles.SKU_StyleID, Styles_D.StyleName2
												  from Styles_Description Styles_D, Styles
												  where Styles_D.LanguageISO="DE"
												  and Styles_D.SKU_StyleID=Styles.SKU_StyleID
												  and Styles_D.StyleName2 LIKE "%'.$_SESSION['Suchtext'].'%"');
												  
					$zeile_Produkte=$Select_Kat->fetch_array();
					
					$_SESSION['Seitenzahl']=ceil(($mysqli->affected_rows)/30);
					$_SESSION['Produktanzahl']=$mysqli->affected_rows;
					$_SESSION['Seite']=1;
				}
				#---------------------------------------------------------------------------------------------------------------------------------------
				#--------------------------------------------------------KATEGORIENSUCHE----------------------------------------------------------------
				#---------------------------------------------------------------------------------------------------------------------------------------
            	if((isset($_GET["Caption"]) and $nein==false and !isset($_SESSION['Sortieren'])) or (isset($_SESSION["Caption"]) and $nein==false and !isset($_SESSION['Sortieren'])))
				{
					#echo'KATEGORIENSUCHE';
					unset($_SESSION['Suchtext']);
					
					if(isset($_GET['Caption']))
					{
						unset($_SESSION['Sortieren']);
						unset($_SESSION['Filtern1']);
						unset($_SESSION['Filtern2']);
						unset($_SESSION['Filtern3']);
						unset($_SESSION['Filtern4']);
					
						$_SESSION['Caption']=urldecode($_GET['Caption']);
						$_SESSION['Ref']=urldecode($_GET['Ref']);
					}	
					#Select
					$Select_Kat=$mysqli->query('SELECT StyleName2, StyleDescription, SKU_StyleID from Styles_Description where SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION['Caption'].'")) and SKU_StyleID IN (SELECT DISTINCT  Cat_Styles.SKU_StyleID from Categories_ID_Text_has_Styles Cat_Styles LEFT JOIN Categories_Description ON Cat_Styles.CategoriesID = Categories_Description.CategoriesID where Categories_Description.Caption IN ("'.$_SESSION['Ref'].'")) and LanguageISO="DE"');							
					$zeile_Produkte=$Select_Kat->fetch_array();	
					$_SESSION['Seitenzahl']=ceil(($mysqli->affected_rows)/30);
					$_SESSION['Produktanzahl']=$mysqli->affected_rows;
					$_SESSION['Seite']=1;							
				}
				#---------------------------------------------------------------------------------------------------------------------------------------
				#--------------------------------------------------------------ANZEIGE------------------------------------------------------------------
				#---------------------------------------------------------------------------------------------------------------------------------------
            	if($zeile_Produkte!=null)
            	{
					$a=0;
					$b=0;
            		echo'<div id="OverFunction">';
					while($a<6 and $zeile_Produkte!=null)
					{
            		echo'  <div id="AnzeigeZeile" class="abrunden_15">';
					while($b<5 and $zeile_Produkte!=null)
					{
						$Select_Info=$mysqli->query('SELECT SKU.SKU_StyleID, SKU_Price.Price, Stocks.Count
													 from SKU, SKU_Price, Stocks
													 where SKU.SKU_StyleID=SKU_Price.SKU_StyleID
													 and SKU.SKU_ColourID=SKU_Price.SKU_ColourID
													 and SKU.SKU_SizeID=SKU_Price.SKU_SizeID
													 and SKU.SKU_StyleID=Stocks.SKU_StyleID
													 and SKU.SKU_ColourID=Stocks.SKU_ColourID
													 and SKU.SKU_SizeID=Stocks.SKU_SizeID
													 and SKU_Price.VolumeScale=0
													 and SKU.SKU_StyleID="'.$zeile_Produkte['SKU_StyleID'].'"');			 
					  $Select_Bilder=$mysqli->query('SELECT DISTINCT PictureName
					  								 from Style_Pictures 
													 where SKU_StyleID="'.$zeile_Produkte['SKU_StyleID'].'"');						 		 
						$zeile_Info=$Select_Info->fetch_array();
						if($zeile_Info!=null)
						{
							$Lager=$zeile_Info['Count'];
							$Preis=str_replace('.',',',$zeile_Info['Price']);
						}
						else
						{
							$Lager='null';
							$Preis='null';
						}
						$zeile_Bilder=$Select_Bilder->fetch_array();
						if($zeile_Bilder!=null)
						{
							$Pfad1=str_replace('\\','/',$zeile_Bilder['PictureName']);
							if(file_exists('neue_Bilder/'.$Pfad1)==true)
							{
								$Pfad='neue_Bilder/'.$Pfad1;
							}
							else
							{
								$Pfad='Kein_Bild.jpg';
							}
						}
						else
						{
							$Pfad='Kein_Bild.jpg';
						}
					$SKU=$zeile_Produkte['SKU_StyleID'];
					$SName2=substr($zeile_Produkte['StyleName2'],0,30);
					if(strlen($zeile_Produkte['StyleName2'])>30)
					{
						$SName2=$SName2.'...';	
					}
                    echo' 
					<div class="abrunden_15">
					<img onmouseover="Tip(\'Preis: '.$Preis.' &euro;<br>Lagerbestand: '.$Lager.' St&uuml;ck\')" onmouseout="UnTip()" src="'.$Pfad.'">
				    <div id="AnzeigeZeileBeschriftung">
                    <a href="Produktansicht.php?id='.$SKU.'">'.$SName2.'</a>
					</div>
					</div>';
					
					if(isset($_SESSION['Suchtext']))
					{
						$zeile_Produkte=$Select_Kat->fetch_array();
					}
					else
					{
						$zeile_Produkte=$Select_Kat->fetch_array();
					}
					$b++;
					}
					$a++;
					$b=0;
					echo'</div>';
					}
            		#---------------------------------------------------------------------------------------------------------------------------------------
            		#--------------------------------------------------------Weiter-und-zur�ck-Buttons------------------------------------------------------
					#---------------------------------------------------------------------------------------------------------------------------------------
            		if($_SESSION['Seite']!=1)
            		{
            			echo'<form action="Suche.php" method="post">';
            		}
            		echo'<div id="SeiteWeiter"><label style="float:left;">Seite '.$_SESSION['Seite'].' / '.$_SESSION['Seitenzahl'].' </label><label style="float:right;"> ('.$_SESSION['Produktanzahl'].') Produkte</label><br>';
            		echo'<div style="clear:both;"></div>';
            		echo'<div style="float:left;"><button style="margin-left:0px;" name="ProduktZ">Zur&uuml;ck</button></div>';
            		if($_SESSION['Seite']!=1)
            		{
            			echo'</form>';
            		}
            		
            		if($_SESSION['Seite']<$_SESSION['Seitenzahl'])
            		{
            			echo'<form action="Suche.php" method="post">';
            		}
    				echo'<div style="float:right;"><button name="ProduktW">Weiter</button></div><br />';
    				echo'</div>';
    				if($_SESSION['Seite']<$_SESSION['Seitenzahl'])
    				{
    					echo'</form>';
    				}
    				echo'<div style="clear:both;"></div>';
    				echo'</div>';
            	}
				else
				{
					echo'<h3>Keine Artikel mit diesen Kriterien gefunden.</h3>';	
				}
            }
            else
            {
				#---------------------------------------------------------------------------------------------------------------------------------------
            	#------------------------------------------------------------------Anrede---------------------------------------------------------------
				#---------------------------------------------------------------------------------------------------------------------------------------
				$text='<br><h5>Version: 3.0 01.08.2014</h5>';
				if(isset($_GET['Aus']))
				{
					$Anrede= $mysqli->query('Select Anrede, Nachname from Benutzer where Kundennummer="'.$_GET['Aus'].'"');
					$Anrede1=$Anrede->fetch_array();
					echo'<h2>Auf Wiedersehen, '.$Anrede1['Anrede'].' '.$Anrede1['Nachname'].'.</h2>'.$text;
				}
				else
				{
				if(isset($_SESSION['Benutzer']))
				{
					$Anrede= $mysqli->query('Select Anrede, Nachname from Benutzer where Kundennummer="'.$_SESSION['Benutzer'].'"');
					$Anrede1=$Anrede->fetch_array();
					echo'<h2>Willkommen zur&uuml;ck, '.$Anrede1['Anrede'].' '.$Anrede1['Nachname'].'.</h2>'.$text;
				}
				else
				{
					echo'<h2>Herzlich Willkommen im Webshop f&uuml;r Textilwaren.</h2>'.$text;
				}
				}
            }
            ?>  
    </div>
    <?php  include "zeile.php";?>
</div>
</body>
</html>