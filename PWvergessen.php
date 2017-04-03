<?php 
#Session starten
session_start();

#Fehler unseten
unset($_SESSION['Error']);
unset($_SESSION['ErrorR']);
unset($_SESSION['ErrorC']);
unset($_SESSION['Error1']);?>
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
                <label class="TextSchein">Passwort vergessen</label>
            </div>
            <div id="OverFunction">
            <form action="PWvergessen.php" method="post">
                <div id="DIV_min_height_110" class="abrunden_20">
                    <span class="span150">Benutzername / Email:</span>
                    <input name="Email" class="input25" size="30" type="text" /> <br />
                    <span class="span400ROT"><?php if (!isset($_SESSION['ErrorPW'])){$_SESSION['ErrorPW'] = "";}; echo$_SESSION['ErrorPW'];?></span> <br />
                    <button name="Vergessen" class="button_abbrunden15 button180_30_B HintergrundGelbVerlauf">Zuschicken</button>
                </div>
                </form>
            </div>

        </div>
        <?php  include "zeile.php";?>
    </div>
</body>
</html>

<?php

#-------------------------PW generieren-------------------------
function GeneratePassword($length = 5) {
	$char_control  = "";
	$chars_for_pw  = "ABCDEFGHJKLMNOPQRSTUVWXYZ";
	$chars_for_pw .= "023456789";

	$chars_for_pw .= "abcdefghijklmnopqrstuvwxyz";
	srand((double) microtime() * 1000000);
	for($i=0;$i<$length;$i++) {
		$number = rand(0, strlen($chars_for_pw));
		$char_control .= $chars_for_pw[$number];
	}
	return $char_control;
}

#Datenbankverbindung
include "DB_Verbindung.php";

if(Isset($_POST['Vergessen']))
{
	#Eingabe �berpr�fen
	if($_POST['Email']==null)
	{
		$_SESSION['ErrorPW']='Bitte geben sie Ihre Email ein.';
		echo'<meta http-equiv="refresh" content="0; url=PWvergessen.php" />';
	}
	else 
	{
	#Select Command wegen Email
	$i=0;
	$DMail = strtolower($_POST['Email']);
	#Daten selecten
	$stmt = $mysqli->query('SELECT Email, Anrede, Nachname from Benutzer where Email="'.$_POST['Email'].'"');
	$zeile = $stmt->fetch_array();
	$Anrede=$zeile['Anrede'];
	$Nachname=$zeile['Nachname'];
	$stmt->close();
	if($zeile==null)
	{
		$_SESSION['ErrorPW']='Ihre angegebene Email ist nicht registriert.  <a href=Registrierungsmaske.php>Registrieren</a>';
		echo'<meta http-equiv="refresh" content="0; url=PWvergessen.php" />';
	}
	else
	{
		$NeuesPW=GeneratePassword();
		$Zeit = time()+28800;
		$NeuesPWV=crypt($NeuesPW);
		
		#---------Update-Statement----------
		$stmt = $mysqli->prepare("Update Benutzer SET Passwort=?, Passwort_valid=? where Email=?");
		if($stmt === FALSE)
		{
			echo"Fehler: ";
			die(print_r( $mysqli->error ));
		}
		$stmt->bind_param("sis",$NeuesPWV,$Zeit,$_POST['Email']);
		$stmt->execute();
		$stmt->close();
		
		#---------Email schreiben-----------
		#session_start();
		$_SESSION["Email"]=$_POST['Email'];
		#echo'Code: '.$NeuesPW;
		#echo'Geben Sie<a href="PWsetzen.php"> hier </a>Ihren Code ein.';
		
		#Email
		include'class.phpmailer.php';
		$mail = new PHPMailer();
			
		#Sender
		$mail->SetFrom('test@gmx.at', 'testi');
			
		#Emp�nger
		$address = $_POST['Email'];
		$mail->AddAddress($address, $Anrede." ".$Nachname);
			
		#Betreff
		$mail->Subject    = "Neues Passwort";
		#EmailText
		$body='Ihr Code: <b>'.$NeuesPW.'</b><br>Dieser Code ist nur 8 Stunden ab jetzt g�ltig! <br><a href="http://webshop.ignition.at/PWsetzen.php">Passwort setzen</a>';
		$mail->MsgHTML($body);
			
		if(!$mail->Send())
		{
			$_SESSION['ErrorPW']="Mailer Error: " . $mail->ErrorInfo;
		}
		else
		{
			$_SESSION['ErrorPW']='Ihre Email wurde erfolgreich gesendet.';
		}
		echo'<meta http-equiv="refresh" content="0; url=PWvergessen.php" />';
	}
	}
}
?>