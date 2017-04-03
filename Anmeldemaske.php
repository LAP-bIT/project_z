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

#Variablen von Registrieren
unset($_SESSION['Anrede']);
unset($_SESSION['Email']);
unset($_SESSION['Firmenname']);
unset($_SESSION['Namenszusatz']);
unset($_SESSION['Vorname']);
unset($_SESSION['Nachname']);
unset($_SESSION['Strasse']);
unset($_SESSION['PLZ']);
unset($_SESSION['Ort']);
unset($_SESSION['Land']);
unset($_SESSION['Steuernummer']);
unset($_SESSION['Telefonnummer']);
unset($_SESSION['Faxnummer']);

#Andere Error Variabeln
unset($_SESSION['ErrorR']);
unset($_SESSION['ErrorC']);
unset($_SESSION['ErrorPW']);
unset($_SESSION['Error1']);

#Datenbankverbindung
include "DB_Verbindung.php";

#Unset die Variabeln aus der Produktansicht
if(isset($_SESSION['AnzahlA']))
{
	while($_SESSION['AnzahlA']>0)
	{
		$ee=1;
		while($ee<=$_SESSION['GAnzahl'.$_SESSION['AnzahlA']])
		{
			unset($_SESSION['G'.$_SESSION['AnzahlA'].$ee]);
			$ee++;
		}
			unset($_SESSION['GAnzahl'.$_SESSION['AnzahlA']]);
		unset($_SESSION['F'.$_SESSION['AnzahlA']]);
		unset($_SESSION['EP'.$_SESSION['AnzahlA']]);
		unset($_SESSION['M'.$_SESSION['AnzahlA']]);
		$_SESSION['AnzahlA']--;
	}
}
unset($_SESSION['EGP']);
unset($_SESSION['AnzahlA']);

if(isset($_SESSION['AnzahlB']))
{
	while($_SESSION['AnzahlB']>0)
	{
		unset($_SESSION['P'.$_SESSION['AnzahlB']]);
		unset($_SESSION['V'.$_SESSION['AnzahlB']]);
		$_SESSION['AnzahlB']--;
	}
}





unset($_SESSION['AnzahlB']);
unset($_SESSION['Select']);
unset($_SESSION['Anzahl']);
unset($_SESSION['Seite']);
unset($_SESSION['Count']);
unset($_SESSION['Sort']);
unset($_SESSION['Sort1']);
if(isset($_POST["Anmelde"]))
{
	$i =0;
	#Keine Eingabe
	if($_POST['Email']==null or $_POST['Passwort']==null)
	{
		$_SESSION['Error']='Bitte geben sie Ihre Email und Ihr Passwort ein.';
		echo'<meta http-equiv="refresh" content="0; url=Anmeldemaske.php" />';
	}
	else
	{
		#ï¿½berprï¿½ft ob Email registriert ist
		$stmt = $mysqli->query('SELECT Email from Benutzer order by Kundennummer');
		//$stmt->bind_param("s",$_POST['Email']);
		if($stmt === false)
		{
			die(print_r( $mysqli->error ));
		}
		$zeile = $stmt->fetch_array();
		while($zeile!= null)
		{
			if(strtolower($_POST['Email'])==strtolower($zeile['Email']))
			{
				$i=1;
			}
			$zeile = $stmt->fetch_array();
		}
		if($i==1)
		{
			
			
			
			#Prï¿½ft ob Passwort richtig
			$stmt = $mysqli->query('SELECT Passwort from Benutzer where Email ="'.$_POST['Email'].'"');
			$zeile = $stmt->fetch_array();
			$stmt->close();
			if (crypt($_POST['Passwort'], $zeile['Passwort']) == $zeile['Passwort']) 
			{
				
				
				
				
				#Sucht Kundennummer
				$stmt = $mysqli->query('SELECT Kundennummer from Benutzer where Email ="'.$_POST['Email'].'"');
				$zeile = $stmt->fetch_array();
				$_SESSION['Benutzer']=$zeile['Kundennummer'];
				$_SESSION['Email']=strtolower($_POST['Email']);
				$stmt->close();
				$stmt = $mysqli->query('SELECT a.Price, c.Stueck, a.VolumeScale, b.SKU_StyleID, b.SKU_ColourID, b.SKU_SizeID from SKU_Price a, SKU b, Bestellungen_Warenkorb c where a.SKU_StyleID = b.SKU_StyleID and a.SKU_SizeID = b.SKU_SizeID and a.SKU_ColourID = b.SKU_ColourID and c.SKU_StyleID = b.SKU_StyleID and c.SKU_SizeID = b.SKU_SizeID and c.SKU_ColourID = b.SKU_ColourID and c.Bestellnummer="Warenkorb" and c.Kundennummer="'.$_SESSION['Benutzer'].'"');
				$zeile = $stmt->fetch_array();
				$GP=0;
				
				#Berechnet die Stï¿½ck und den Preis der Artikel im Warenkorb
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
						if($zeile['Stueck']>=1000)
						{
							$GP+=$zeile['Stueck']*$zeile['Price'];
							//$_SESSION[$zeile['SKU_StyleID'].$zeile['SKU_ColourID'].$zeile['SKU_SizeID']]=$zeile['Stueck']*$zeile['Price'];
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
					
					if(strpos($_SESSION['WK'],',')!=false)
					{
						list ($vor, $nach) = split(',',$_SESSION['WK']);
						if(strlen($nach)==1)
						{
							$nach.='0';
							$_SESSION['WK']=$vor.','.$nach;
						}
						else
						{
							
						}
					}
					else
					{
						
					}
					
					
				}
				else 
				{
					$_SESSION['WK']="0,00";
					$_SESSION['WK1']="0";
				}
				
				$stmt->close();
				echo'<meta http-equiv="refresh" content="0; url=MeinKonto.php" />';
			}
			else 
			{
				$_SESSION['Error']='Ihr angegebenes Passwort ist nicht korrekt.';
				echo'<meta http-equiv="refresh" content="0; url=Anmeldemaske.php" />';
			}
		}
		else 
		{
			$_SESSION['Error']='Ihre angegebene Email ist nicht registriert.';
			echo'<meta http-equiv="refresh" content="0; url=Anmeldemaske.php" />';
		}
		
	}
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Webshop f&uuml;r Textilwaren | Anmelden</title>
    <link href="WebShopStyle.css" rel="stylesheet" type="text/css" />
    <link href="AuswahlStyle.css" rel="stylesheet" type="text/css" />
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script type='text/javascript' src='menu_jquery.js'></script>
	<link rel="shortcut icon" href="webshop.ignition.at/favicon.ico" type="image/x-icon" />
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

        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein">anmelden</label>
            </div>  
            <div id="OverFunction">
            <div id="DIV_min_height_150" class="abrunden_20">
            <form action="Anmeldemaske.php" method="post">
                <div>
                    <span class="span150">Benutzername / Email:</span>
                    <input name="Email" class="input25" size="30" type="text" /> <br />
                    <span class="span150">Passwort:</span>
                    <input name="Passwort" class="input25" size="30" type="password" /> <br />
                    <span class="span400ROT"><?php if (!isset($_SESSION['Error'])){$_SESSION['Error'] = "";}; echo$_SESSION['Error'];?></span> <br />
                    <button name="Anmelde" class="button_abbrunden15 button180_30_B HintergrundGelbVerlauf">Anmelden</button><br>
                   </div>
                    </form>
                      <form action="PWvergessen.php">
                     <div >
                    <button class="button_abbrunden15 button180_30_B HintergrundGelbVerlauf">Passwort vergessen</button>
                </div>
                </form>
                 </div>
                 <form action="Registrierungsmaske.php">
                <div id="DIV_min_height_110" class="abrunden_20">
                    <span class="span400">Sind Sie noch nicht Registriert?<br /> Dann klicken Sie auf den Button <b>Registrieren </b>darunter.</span> <br />
                    <button class="button_abbrunden15 button180_30_B HintergrundGelbVerlauf">Registrieren</button>
                </div>
                </form>
            </div>
        </div>
        
        
        <?php  include "zeile.php";?>
        
        
        
        </div>
    </body>
</html>