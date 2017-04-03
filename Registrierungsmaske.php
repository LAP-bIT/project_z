<?php 

#Session starten
session_start();

#Fehler unseten
unset($_SESSION['Error']);
unset($_SESSION['ErrorPW']);
unset($_SESSION['Error1']);
if(isset($_SESSION['ErrorR']))
{
unset($_SESSION['ErrorC']);
}
if(isset($_SESSION['ErrorC']))
{
unset($_SESSION['ErrorR']);
}

if(!isset($_SESSION['Anrede']))
{
	$_SESSION['Anrede']="Herr";
}

if(!isset($_SESSION['Land']))
{
	$_SESSION['Land']="AT";
}

if(isset($_GET['A']))
{
	echo'<meta http-equiv="refresh" content="0; url=Registrierungsmaske.php#'.$_GET['A'].'" />';
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Webshop f&uuml;r Textilwaren | Registrieren</title>
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

        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein">registrieren</label>
            </div>
              <form action="Registrierungsmaske.php" method="post">
            <div id="OverFunction">
                <div id="DIV_min_height_150" class="abrunden_20">
                    <span class="span400" style="margin-bottom:0px">(*) &rarr; sind erforlderiche Felder</span><br />
                    <span class="span66">Anrede:</span>
                    <div  id="SelectAnrede" class="abrunden_15">
                        <select name="Anrede">
                            <option <?php if($_SESSION['Anrede']=="Herr"){echo'selected';}?> value="Herr">Herr</option>
                            <option <?php if($_SESSION['Anrede']=="Frau"){echo'selected';}?> value="Frau">Frau</option>
                            <option <?php if($_SESSION['Anrede']=="Firma"){echo'selected';}?> value="Firma">Firma</option>
                        </select>
                        </div>
                    <span class="span66">Email*:</span>
                    <input name="Email" class="input25" size="25" value="<?php if(isset($_SESSION['Email'])){echo$_SESSION['Email'];}?>" type="text" /><br />
                    <span class="span66">Firmennamen:</span>
                    <input name="FName" class="input25" size="25" value="<?php if(isset($_SESSION['Firmenname'])){echo$_SESSION['Firmenname'];}?>" type="text" />
                    <span class="span66">Namenszusatz:</span>
                    <input name="NameZusatz" class="input25" size="25" value="<?php if(isset($_SESSION['Namenszusatz'])){echo$_SESSION['Namenszusatz'];}?>" type="text" /><br />

                    <span class="span66">Vorname*:</span>
                    <input name="Vorname" class="input25" size="25" value="<?php if(isset($_SESSION['Vorname'])){echo$_SESSION['Vorname'];}?>" type="text" />
                    <span class="span66">Nachname*:</span>
                    <input name="Nachname" class="input25" size="25" value="<?php if(isset($_SESSION['Nachname'])){echo$_SESSION['Nachname'];}?>" type="text" /><br />
                             
                    <span class="span66">Stra&szlig;e*</span>
                    <input name="Strasse" class="input25" size="25" value="<?php if(isset($_SESSION['Strasse'])){echo$_SESSION['Strasse'];}?>" type="text" /><br />     
                             
                    <span class="span66">Postleitzahl*:</span>
                    <input name="PLZ" class="input25" size="10" value="<?php if(isset($_SESSION['PLZ'])){echo$_SESSION['PLZ'];}?>" type="text" /><br />
                    <span class="span66">Ort*:</span>
                    <input name="Ort" class="input25" size="25" value="<?php if(isset($_SESSION['Ort'])){echo$_SESSION['Ort'];}?>" type="text" /><br />   

                    <span class="span66">Land*:</span>
                    <div  id="SelectLand" class="abrunden_15">
                        <select name="Land">
                            <option <?php if($_SESSION['Land']=="AT"){echo'selected';}?> value="AT">&Ouml;sterreich</option>
                            <option <?php if($_SESSION['Land']=="DE"){echo'selected';}?> value="DE">Deutschland</option>
                            <option <?php if($_SESSION['Land']=="CH"){echo'selected';}?> value="CH">Schweiz</option>
                        </select>
                    </div>

                    <span class="span66">Steuernummer:</span>
                    <input name="SNummer" class="input25" size="25" value="<?php if(isset($_SESSION['Steuernummer'])){echo$_SESSION['Steuernummer'];}?>" type="text" /><br />
                    <span class="span66">Telefonnr.*:</span>
                    <input name="TNummer" class="input25" size="25" value="<?php if(isset($_SESSION['Telefonnummer'])){echo$_SESSION['Telefonnummer'];}?>" type="text" />
                    <span class="span66">Faxnumer:</span>
                    <input name="FNummer" class="input25" size="25" value="<?php if(isset($_SESSION['Faxnummer'])){echo$_SESSION['Faxnummer'];}?>" type="text" /><br />
                    <span class="span66">Passwort*:</span>
                    <input name="PW" class="input25" size="25" type="password" />
                    <span class="span66">Pwt.Wdh.*:</span>
                    <input name="PW1" class="input25" size="25" type="password" /><br />
					<?php echo'<a name="Fehler"></a>';?>
                    <span class="span400ROT"><?php if (isset($_SESSION['ErrorR'])){echo$_SESSION['ErrorR'];} ?></span> <br />

                    <span class="span400">Bitte geben sie den Sicherheitscode darunter ein</span>
                    <div id="DivIMG">
                        <img class="Captureimg" src="captcha.php" />
                        <a href="Registrierungsmaske.php?A=Fehler"><img class="reload" src="reload-icon.png" /></a>
                    </div>
                    <span class="span66">Sicherheitscode*</span>
                    <input name="Cap" class="input25" size="25" type="text" /><br />
                    <span class="span400ROT"><?php if (isset($_SESSION['ErrorC'])){echo$_SESSION['ErrorC'];} ?></span><br />
                    <button name="Register" class="button_abbrunden15 button180_30_B HintergrundGelbVerlauf">Speichern</button><br>
                </div>
            </div>
            </form>

        </div>
<?php  include "zeile.php";?>
    </div>
</body>
</html>
<?php

#Datenbankverbindung
include "DB_Verbindung.php";


if(isset($_POST["Register"]))
{
	#Daten zwischenspeichern
	$_SESSION['Anrede']=$_POST['Anrede'];
	$_SESSION['Email']=$_POST['Email'];
	$_SESSION['Firmenname']=$_POST['FName'];
	$_SESSION['Namenszusatz']=$_POST['NameZusatz'];
	$_SESSION['Vorname']=$_POST['Vorname'];
	$_SESSION['Nachname']=$_POST['Nachname'];
	$_SESSION['Strasse']=$_POST['Strasse'];
	$_SESSION['PLZ']=$_POST['PLZ'];
	$_SESSION['Ort']=$_POST['Ort'];
	$_SESSION['Land']=$_POST['Land'];
	$_SESSION['Steuernummer']=$_POST['SNummer'];
	$_SESSION['Telefonnummer']=$_POST['TNummer'];
	$_SESSION['Faxnummer']=$_POST['FNummer'];
	#session_start();
	#Captcha überprüfen
	if($_SESSION['captchacode'] != $_POST['Cap'])
	{
		$_SESSION['ErrorC'] ='Bitte geben sie den Captcha Code richtig an.';
		unset($_SESSION['ErrorR']);
		echo'<meta http-equiv="refresh" content="0; url=Registrierungsmaske.php?A=Fehler" />';
	}
	else
	{
		#Eingabe überprüfen
	if($_POST['Vorname']==null or $_POST['Nachname']==null or $_POST['Strasse']==null or $_POST['PLZ']==null or $_POST['Ort']==null or $_POST['TNummer']==null or $_POST['Email']==null or $_POST['PW']==null or $_POST['PW1']==null)
	{
		$_SESSION['ErrorR'] ='F&uuml;r mind. 1 erforderliches Feld wurden keine Daten eingegeben.';
		unset($_SESSION['ErrorC']);
		echo'<meta http-equiv="refresh" content="0; url=Registrierungsmaske.php?A=Fehler" />';
	}
	else
	{
		#Eingabelänge überprüfen
		if(strlen($_POST['PW'])>20 or strlen($_POST['Anrede'])>20 or strlen($_POST['Vorname'])>50 or strlen($_POST['Nachname'])>50 or strlen($_POST['Strasse'])>200 or strlen($_POST['PLZ'])>20 or strlen($_POST['Ort'])>100 or strlen($_POST['TNummer'])>20 or strlen($_POST['Email'])>50 or strlen($_POST['SNummer'])>50 or strlen($_POST['FName'])>50 or strlen($_POST['NameZusatz'])>50 or strlen($_POST['FNummer'])>20)
		{
			$_SESSION['ErrorR']='Mind. 1 Feld &uuml;berschreitet die maximale L&auml;nge.';
			unset($_SESSION['ErrorC']);
			echo'<meta http-equiv="refresh" content="0; url=Registrierungsmaske.php?A=Fehler" />';
		}
		else 
		{
			#PW überprüfen
			if($_POST['PW']!= $_POST['PW1'])
			{
				$_SESSION['ErrorR']='Passwort wurde nicht 2 mal gleich angegeben!';
				unset($_SESSION['ErrorC']);
				echo'<meta http-equiv="refresh" content="0; url=Registrierungsmaske.php?A=Fehler" />';
			}
			else
			{
			#Select Command wegen Email
			$i=0;
			$DMail = strtolower($_POST['Email']);
		$stmt = $mysqli->query("SELECT Email from Benutzer");
		$zeile = $stmt->fetch_array();
		#Email überprüfen
					while($zeile != null)
					{
					$email = strtolower($zeile['Email']);
			if($email == $DMail)
						{
						$_SESSION['ErrorR']='Ihre angegebene Email wird bereits für einen anderen Account verwendet.';
						unset($_SESSION['ErrorC']);
						echo'<meta http-equiv="refresh" content="0; url=Registrierungsmaske.php?A=Fehler" />';
				$i=1;
			}
			$zeile = $stmt->fetch_array();
			}
			
			if($i == 0)
			{
				#Kundennummer generieren
			#Select Command wegen Kundennummer
				$stmt = $mysqli->query("SELECT Kundennummer from Benutzer order by Kundennummer desc");
				$zeile = $stmt->fetch_array();
				$Nummer=$zeile['Kundennummer'];
				$Nummeralt = substr($Nummer,1,20);
				$Nummerneu = $Nummeralt+1;
				$Anzahl = strlen($Nummerneu)+1;
				$KDN='K';
				while($Anzahl<20)
				{
				$KDN = $KDN.'0';
				$Anzahl++;
				}
			$KDN = $KDN.$Nummerneu;
						
					#Insert Statement
					$stmt = $mysqli->prepare("INSERT INTO Benutzer (Anrede, Kundennummer, Firmenname, Namenszusatz, Vorname, Nachname, Strasse, Postleitzahl, Ort, Land, Steuernummer, Telefonnummer, Fax, Email, Passwort, Benutzer_valid) Values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			if($stmt === FALSE)
			{
				echo"Fehler: ";
				die(print_r( $mysqli->error ));
			}
			$VPW = crypt($_POST['PW']); 
			$valid=0;
			$stmt->bind_param("sssssssssssssssi",$_POST['Anrede'],$KDN,$_POST['FName'],$_POST['NameZusatz'],$_POST['Vorname'],$_POST['Nachname'],$_POST['Strasse'],$_POST['PLZ'],$_POST['Ort'],$_POST['Land'],$_POST['SNummer'],$_POST['TNummer'],$_POST['FNummer'],strtolower($_POST['Email']),$VPW,$valid);
			$stmt->execute();
			$stmt->close();
			
			#Warenkorb erstellen
			$stmt = $mysqli->prepare("INSERT INTO Bestellungen (Bestellnummer, Bestelldatum, Kundennummer, Infotext, Bruttopreis, Nettopreis) Values (?,?,?,?,?,?)");
			if($stmt === FALSE)
			{
				echo"Fehler: ";
				die(print_r( $mysqli->error ));
			}
			$Bestell="Warenkorb";
			$BeDatum=date("Y.m.d");
			$BeText=".";
			$BePreis=0.00;
			$stmt->bind_param("ssssdd",$Bestell, $BeDatum, $KDN, $BeText, $BePreis,$BePreis);
			$stmt->execute();
			$stmt->close();
			
			#------------------------------EMAIL schreiben mit Link---------------------
			
			#Emailklasse
			include'class.phpmailer.php';
			$mail = new PHPMailer();
			
			#Sender
			//Ändern
			$mail->SetFrom('Test@irg.at', 'Sir Testi');
			
			#Empfänger
			$address = $_POST['Email'];
			$mail->AddAddress($address, $_POST['Anrede']." ".$_POST['Nachname']);
			
			#Betreff
			$mail->Subject    = "Registrierung abschließen";
			
			#Emailtext
			$body='Mit einem Klick auf den unteren Link bestätigen Sie Ihr Konto und schließen Ihre Registrierung ab.<br><a href="http://webshop.ignition.at/Benutzer_valid.php?id='.$_POST['Email'].'">Email bestätigen</a>';
			$mail->MsgHTML($body);
			
			if(!$mail->Send()) 
			{
				$_SESSION['ErrorR']="Mailer Error: " . $mail->ErrorInfo;
			} 
			else 
			{
				$_SESSION['ErrorR']='Ihnen wurde eine Email mit einem Best&auml;tigungslink geschickt.';
			}
			unset($_SESSION['ErrorC']);
			echo'<meta http-equiv="refresh" content="0; url=Registrierungsmaske.php?A=Fehler" />';
			#'Schließen Sie ihre <a href="Benutzer_valid.php?site=detail&id='.$_POST['Email'].'">Registrierung ab.</a>';
			}
			}
		}
		}
	}
}
?>