<?php 
#Session starten
session_start();

#Verschiedene Errors unseten
if(isset($_SESSION['ErrorC1']))
{
	unset($_SESSION['ErrorC2']);
}
if(isset($_SESSION['ErrorC2']))
{
	unset($_SESSION['ErrorC1']);
}

#Datenbankverbindung
include "DB_Verbindung.php";

#Kundennummer
$Nummer = $_SESSION['Benutzer'];

#Daten des Kunden selecten
$stmt = $mysqli->query('SELECT Anrede, Firmenname, Namenszusatz, Vorname, Nachname, Strasse, Postleitzahl, Ort, Land, Steuernummer, Telefonnummer, Fax, Email from Benutzer where Kundennummer ="'.$Nummer.'"');
$zeile = $stmt->fetch_array();

#Daten zwischenspeichern
$_SESSION['1Anrede']=$zeile['Anrede'];
$_SESSION['1Email']=$zeile['Email'];
$_SESSION['1Firmenname']=$zeile['Firmenname'];
$_SESSION['1Namenszusatz']=$zeile['Namenszusatz'];
$_SESSION['1Vorname']=$zeile['Vorname'];
$_SESSION['1Nachname']=$zeile['Nachname'];
$_SESSION['1Strasse']=$zeile['Strasse'];
$_SESSION['1PLZ']=$zeile['Postleitzahl'];
$_SESSION['1Ort']=$zeile['Ort'];
$_SESSION['1Land']=$zeile['Land'];
$_SESSION['1Steuernummer']=$zeile['Steuernummer'];
$_SESSION['1Telefonnummer']=$zeile['Telefonnummer'];
$_SESSION['1Faxnummer']=$zeile['Fax'];
$stmt->close();

if(isset($_GET['A']))
{
	echo'<meta http-equiv="refresh" content="0; url=Daten_aendern.php#'.$_GET['A'].'" />';
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Webshop f&uuml;r Textilwaren | Meine Daten</title>
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
        <form action="Daten_aendern.php" method="post">
        <div id="Auswahl">
            <button name="Suche" class="ButtonKontoKlein abrunden_15 HintergrundGrauVerlauf">Zur&uuml;ck<br />zur Suche</button>
            <button name="Bestell" class="ButtonKontoKlein abrunden_15 HintergrundGelbVerlauf">Meine<br />Bestellungen</button>
            <button name="PWandern" class="ButtonKontoKlein abrunden_15 HintergrundGelbVerlauf">Passwort<br />&auml;ndern</button>
            <button name="Kontoandern" class="ButtonKontoKlein abrunden_15 HintergrundGelbVerlauf">Kontodaten<br />&auml;ndern</button>
            
        </div>
        </form>

        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein">Kontodaten bearbeiten</label>
            </div>
            <form action="Daten_aendern.php" method="post">
            <div id="OverFunction">
                <div id="DIV_min_height_150" class="abrunden_20">
                    <span class="span400" style="margin-bottom:0px">(*) &rarr; sind erforlderiche Felder</span><br />
                    <span class="span66">Anrede:</span>
                    <div id="SelectAnrede" class="abrunden_15">
                        <select name="Anrede">
                            <option  <?php if($_SESSION['1Anrede']=="Herr"){echo'selected';};?> value="Herr">Herr</option>
                            <option <?php if($_SESSION['1Anrede']=="Frau"){echo'selected';};?> value="Frau">Frau</option>
                            <option <?php if($_SESSION['1Anrede']=="Firma"){echo'selected';};?> value="Firma">Firma</option>
                        </select>
                    </div>
                    <span class="span66">Email*:</span>
                    <input value="<?php echo$_SESSION['1Email'];?>" name="Email" class="input25" size="25" type="text" /><br />
                    <span class="span66">Firmennamen:</span>
                    <input value="<?php echo$_SESSION['1Firmenname'];?>" name="FName" class="input25" size="25" type="text" />
                    <span class="span66">Namenszusatz:</span>
                    <input value="<?php echo$_SESSION['1Namenszusatz'];?>" name="NameZusatz" class="input25" size="25" type="text" /><br />

                    <span class="span66">Vorname*:</span>
                    <input value="<?php echo$_SESSION['1Vorname'];?>" name="Vorname" class="input25" size="25" type="text" />
                    <span class="span66">Nachname*:</span>
                    <input value="<?php echo$_SESSION['1Nachname'];?>" name="Nachname" class="input25" size="25" type="text" /><br />

                    <span class="span66">Stra&szlig;e*:</span>
                    <input value="<?php echo$_SESSION['1Strasse'];?>" name="Strasse" class="input25" size="25" type="text" /><br />
                    <span class="span66">Postleitzahl*:</span>
                    <input value="<?php echo$_SESSION['1PLZ'];?>" name="PLZ" class="input25" size="10" type="text" /><br />
                    <span class="span66">Ort*:</span>
                    <input value="<?php echo$_SESSION['1Ort'];?>" name="Ort" class="input25" size="25" type="text" /><br />

                    <span class="span66">Land*:</span>
                    <div id="SelectLand" class="abrunden_15">
                        <select name="Land">
                            <option <?php if($_SESSION['1Land']=="AT"){echo'selected';};?> value="AT">&Ouml;sterreich</option>
                            <option <?php if($_SESSION['1Land']=="DE"){echo'selected';};?> value="DE">Deutschland</option>
                            <option <?php if($_SESSION['1Land']=="CH"){echo'selected';};?> value="CH">Schweiz</option>
                        </select>
                    </div>

                    <span class="span66">Steuernummer:</span>
                    <input value="<?php echo$_SESSION['1Steuernummer'];?>" name="SNummer" class="input25" size="25" type="text" /><br />
                    <span class="span66">Telefonnummer*:</span>
                    <input value="<?php echo$_SESSION['1Telefonnummer'];?>" name="TNummer" class="input25" size="25" type="text" />
                    <span class="span66">Faxnummer:</span>
                    <input value="<?php echo$_SESSION['1Faxnummer'];?>" name="FNummer" class="input25" size="25" type="text" /><br />
						<?php echo'<a name="Fehler"></a>';?>
                    <span class="span400ROT"><?php if (isset($_SESSION['ErrorC2'])){echo$_SESSION['ErrorC2'];} ?></span> <br />

                    <span class="span400">Bitte geben sie den Sicherheitscode darunter ein</span>
                    <div id="DivIMG">
                        <img class="Captureimg" src="captcha.php" />
                        <a href=""><img class="reload" src="reload-icon.png" /></a>
                    </div>
                    <span class="span66">Sicherheitscode*</span>
                    <input name="Cap1" class="input25" size="25" type="password" /><br />
                    <span class="span400ROT"><?php if (isset($_SESSION['ErrorC1'])){echo$_SESSION['ErrorC1'];} ?></span><br />
                    <button name="Update" class="button_abbrunden15 button180_30_B HintergrundGelbVerlauf">Speichern</button><br>
                </div>
            </div>
            </form>

        </div>
        <?php  include "zeile.php";?>
    </div>
</body>
</html>
<?php


if(isset($_POST['Update']))
{
	#Daten zwischenspeichern
	$_SESSION['1Anrede']=$_POST['Anrede'];
	$_SESSION['1Email']=$_POST['Email'];
	$_SESSION['1Firmenname']=$_POST['FName'];
	$_SESSION['1Namenszusatz']=$_POST['NameZusatz'];
	$_SESSION['1Vorname']=$_POST['Vorname'];
	$_SESSION['1Nachname']=$_POST['Nachname'];
	$_SESSION['1Strasse']=$_POST['Strasse'];
	$_SESSION['1PLZ']=$_POST['PLZ'];
	$_SESSION['1Ort']=$_POST['Ort'];
	$_SESSION['1Land']=$_POST['Land'];
	$_SESSION['1Steuernummer']=$_POST['SNummer'];
	$_SESSION['1Telefonnummer']=$_POST['TNummer'];
	$_SESSION['1Faxnummer']=$_POST['FNummer'];
	
	#Captchacode �berpr�fen
	if($_SESSION['captchacode'] != $_POST['Cap1'])
	{
		$_SESSION['ErrorC1'] ='Bitte geben sie den Captcha Code richtig an.';
		echo'<meta http-equiv="refresh" content="0; url=Daten_aendern.php?A=Fehler" />';
		unset($_SESSION['ErrorC2']);
	}
	else
	{
		#Eingabe �berpr�fen
if($_POST['Vorname']==null or $_POST['Nachname']==null or $_POST['Strasse']==null or $_POST['PLZ']==null or $_POST['Ort']==null or $_POST['TNummer']==null or $_POST['Email']==null)
	{
		$_SESSION['ErrorC2'] ='F�r mind. 1 erforderliches Feld wurden keine Daten eingegeben.';
		unset($_SESSION['ErrorC1']);
		echo'<meta http-equiv="refresh" content="0; url=Daten_aendern.php?A=Fehler" />';
	}
	else
	{
		#L�nge der Eingabe �berpr�fen
		if( strlen($_POST['Vorname'])>50 or strlen($_POST['Anrede'])>20 or strlen($_POST['Nachname'])>50 or strlen($_POST['Strasse'])>200 or strlen($_POST['PLZ'])>20 or strlen($_POST['Ort'])>100 or strlen($_POST['TNummer'])>20 or strlen($_POST['Email'])>50 or strlen($_POST['SNummer'])>50 or strlen($_POST['FName'])>50 or strlen($_POST['NameZusatz'])>50 or strlen($_POST['FNummer'])>20)
		{
			$_SESSION['ErrorC2'] ='Mind. 1 Feld �berschreitet die maximale L&auml;nge.';
			unset($_SESSION['ErrorC1']);
			echo'<meta http-equiv="refresh" content="0; url=Daten_aendern.php?A=Fehler" />';
		}
		else
		{
			#Daten in der DB �ndern
			$stmt = $mysqli->prepare('Update Benutzer SET Anrede=?, Firmenname =?, Namenszusatz =?, Vorname =?, Nachname =?, Strasse =?, Postleitzahl =?, Ort = ?, Land =?, Steuernummer =?, Telefonnummer =?, Fax =?, Email =? where Kundennummer =?');
			if($stmt === FALSE)
			{
				echo"Fehler: ";
				die(print_r( $mysqli->error ));
			}
			$stmt->bind_param("ssssssssssssss",$_POST['Anrede'], $_POST['FName'],$_POST['NameZusatz'],$_POST['Vorname'],$_POST['Nachname'],$_POST['Strasse'],$_POST['PLZ'],$_POST['Ort'],$_POST['Land'],$_POST['SNummer'],$_POST['TNummer'],$_POST['FNummer'],$_POST['Email'],$Nummer);
			$stmt->execute();
			$stmt->close();
			
			$_SESSION['ErrorC2'] ='Ihre Daten wurden erfolgreich ge&auml;ndert.';
			unset($_SESSION['ErrorC1']);
			echo'<meta http-equiv="refresh" content="0; url=Daten_aendern.php?A=Fehler" />';
		}
	}
}
}
?>
<?php 

#Weiterleitungen
if(isset($_POST['Bestell']))
{
	echo'<meta http-equiv="refresh" content="0; url=Bestellungen_ansehen.php" />';
}

if(isset($_POST['PWandern']))
{
	echo'<meta http-equiv="refresh" content="0; url=PWaendern.php" />';
}

if(isset($_POST['Kontoandern']))
{
	echo'<meta http-equiv="refresh" content="0; url=Daten_aendern.php" />';
}

if(isset($_POST['Suche']))
{
	echo'<meta http-equiv="refresh" content="0; url=Suche.php" />';
}

?>