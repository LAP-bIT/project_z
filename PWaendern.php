<?php 
#Session starten
session_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Webshop f&uuml;r Textilwaren | Passwort &auml;ndern</title>
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
                <label class="TextSchein">Neues Passwort</label>
            </div>
            <form action="PWaendern.php" method="post">
            <div id="OverFunction">
                <div id="DIV_min_height_150" class="abrunden_20">
                    <span class="span600"><b>Bitte geben Sie ihr altes Passwort ein, um ein neues speichern zu k&ouml;nnen</b></span> <br />
                    <span class="span150">aktuelles Passwort:</span>
                    <input name="PWalt" class="input25" size="30" type="password" /> <br />
                    <span class="span150">neues Passwort:</span>
                    <input name="PW1" class="input25" size="30" type="password" /> <br />
                    <span class="span150">Passwort Wiederholen:</span>
                    <input name="PW2" class="input25" size="30" type="password" /> <br />
                    <span class="span400ROT"><?php if (!isset($_SESSION['ErrorA'])){$_SESSION['ErrorA'] = "";}; echo$_SESSION['ErrorA'];?></span> <br />
                    <button name="Setzen1" class="button_abbrunden15 button180_30_B HintergrundGelbVerlauf">Speichern</button><br>
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

if(isset($_POST['Setzen1']))
{
	#Altes Password
	$stmt = $mysqli->query('Select Passwort from Benutzer where Email="'.$_SESSION['Email'].'"');
	if($stmt === FALSE)
	{
		echo"Fehler: ";
		die(print_r( $mysqli->error ));
	}
	#$stmt->bind_param("s",$_SESSION['Email']);
	#$stmt->bind_result($PW);
	$zeile=$stmt->fetch_array();

	#Eingabe �berpr�fen
	if($_POST['PWalt']== null or $_POST['PW1']== null or $_POST['PW2']== null)
	{
		$_SESSION['ErrorA']='Bitte geben Sie f�r alle Felder Daten an!</font>';
		echo'<meta http-equiv="refresh" content="0; url=PWaendern.php" />';
	}
	else
	{
		#Altes PW �berpr�fen
		if($_POST['PW1'] != $_POST['PW2'])
		{
			$_SESSION['ErrorA']='Bitte geben Sie ihr neues Passwort 2 mal korrekt an!';
			echo'<meta http-equiv="refresh" content="0; url=PWaendern.php" />';
		}

			else
			{
				if ( crypt($_POST['PWalt'],$zeile['Passwort'])== $zeile['Passwort'])
				{
					#Neues PW setzen
					#---------Update-Statement----------
					$stmt->close();
					$stmt = $mysqli->prepare("Update Benutzer SET Passwort=? where Email=?");
					if($stmt === FALSE)
						{
						echo"Fehler: ";
						die(print_r( $mysqli->error ));
				}
						$hu=crypt($_POST['PW1']);
						$stmt->bind_param("ss",$hu,$_SESSION['Email']);
						$stmt->execute();
						$stmt->close();
							
		$_SESSION['ErrorA']='Ihr Passwort wurde erfolgreich ge&auml;ndert!';
		echo'<meta http-equiv="refresh" content="0; url=PWaendern.php" />';
						}
						else
		{
			$_SESSION['ErrorA']='Ihr altes Passwort ist nicht korrekt!';
				echo'<meta http-equiv="refresh" content="0; url=PWaendern.php" />';
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