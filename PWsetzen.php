<?php 
#Session starten
session_start();

#Error unseten
unset($_SESSION['ErrorPW']);
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

        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein">Neues Passwort</label>
            </div>
            <div id="OverFunction">
            <form action="PWsetzen.php" method="post">
                <div id="DIV_min_height_150" class="abrunden_20">
                    <span class="span600"><b>Bitte geben Sie unterhalb den Code ein den Sie per Email bekommen haben</b></span> <br />
                    <span class="span150">Email Code:</span>
                    <input name="Code" class="input25" size="30" type="text" /> <br />
                    <span class="span150">neues Passwort:</span>
                    <input name="PW1" class="input25" size="30" type="password" /> <br />
                    <span class="span150">Passwort Wiederholen:</span>
                    <input name="PW2" class="input25" size="30" type="password" /> <br />
                    <span class="span400ROT"><?php if (!isset($_SESSION['Error1'])){$_SESSION['Error1'] = "";}; echo$_SESSION['Error1'];?></span> <br />
                    <button name="Setzen" class="button_abbrunden15 button180_30 HintergrundGelbVerlauf">Speichern</button><br>
                </div>
                </form>
            </div>

        </div>
    </div>
</body>
</html>

<?php
include "DB_Verbindung.php";

if(isset($_POST['Setzen']))
{
	session_start();
	#PW selecten
	$stmt = $mysqli->query('Select Passwort, Passwort_valid from Benutzer where Email="'.$_SESSION['Email'].'"');
	if($stmt === FALSE)
	{
		echo"Fehler: ";
		die(print_r( $mysqli->error ));
	}
	#$stmt->bind_param("s",$_SESSION['Email']);
	#$stmt->bind_result($PW);
	$zeile=$stmt->fetch_array();
	$stmt->close();
	#Eingabe überpüfen
	if($_POST['Code']== null or $_POST['PW1']== null or $_POST['PW2']== null)
	{
		$_SESSION['Error1']='Bitte geben Sie für alle Felder Daten an!</font>';
		echo'<meta http-equiv="refresh" content="0; url=PWsetzen.php" />';
	}
	else 
	{
		#PW Eingabe überprüfen
		if($_POST['PW1'] != $_POST['PW2'])
		{
			$_SESSION['Error1']='Bitte geben Sie ihr neues Passwort 2 mal korrekt an!';
			echo'<meta http-equiv="refresh" content="0; url=PWsetzen.php" />';
		}
		else
		{
			#Gültigkeit des Codes überprüfen
			if($zeile['Passwort_valid']<time())
			{
				$_SESSION['Error1']='Ihr Code ist abgelaufen. <a href=PWvergessen.php>Neuen Code anfordern.</a>';
				echo'<meta http-equiv="refresh" content="0; url=PWsetzen.php" />';
			}
			else 
			{
				#Code überprüfen
		if ( crypt($_POST['Code'],$zeile['Passwort'])== $zeile['Passwort'])
		{
			#Neues PW setzen
			#---------Update-Statement----------
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
			
		$_SESSION['Error1']='Ihr Passwort wurde erfolgreich ge&auml;ndert!';
		echo'<meta http-equiv="refresh" content="0; url=PWsetzen.php" />';
		}
		else
		{
			$_SESSION['Error1']='Ihr angegebener Code ist nicht korrekt.<br>  <a href=PWvergessen.php>Passwort vergessen?</a>';
			echo'<meta http-equiv="refresh" content="0; url=PWsetzen.php" />';
		}
			}
		}
	}
}
?>