<?php
#Session starten
session_start();

#Datenbankverbindung
include "DB_Verbindung.php";

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
		
		<form action="Kontakt.php" method="post">
        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein">Kontaktformular</label>
            </div>  
            <div id="OverFunction">
            
            <div id="DIV_min_height_150" class="abrunden_20">
                    <span class="span66">Anrede:</span>
                    <div id="SelectAnrede" class="abrunden_15">
                        <select name="Anrede">
                            <option <?php if($_SESSION['AnredeK']=="Herr"){echo'selected';}?> value="Herr">Herr</option>
                            <option <?php if($_SESSION['AnredeK']=="Frau"){echo'selected';}?> value="Frau">Frau</option>
                            <option <?php if($_SESSION['AnredeK']=="Firma"){echo'selected';}?> value="Firma">Firma</option>
                        </select>
                    </div>
                    <span class="span66">Email:</span>
                    <input name="Email" class="input25" size="25" value="<?php if(isset($_SESSION['EmailK'])){echo$_SESSION['EmailK'];}?>" type="text" /><br />
                    <span class="span66">Vorname:</span>
                    <input name="Vorname" class="input25" size="25" value="<?php if(isset($_SESSION['VornameK'])){echo$_SESSION['VornameK'];}?>" type="text" />
                    <span class="span66">Nachname:</span>
                    <input name="Nachname" class="input25" size="25" value="<?php if(isset($_SESSION['NachnameK'])){echo$_SESSION['NachnameK'];}?>" type="text" /><br />
                    <span class="span66">Telefonnr.:</span>
                    <input name="Telefon" class="input25" size="25" value="<?php if(isset($_SESSION['TelefonK'])){echo$_SESSION['TelefonK'];}?>" type="text" /><br />
                    <span class="span66" style="float:left;margin-top:55px;">Text:</span>
                    <textarea name="Text" class="input25a"><?php if(isset($_SESSION['TextK'])){echo$_SESSION['TextK'];}?></textarea>
                    <span class="span400ROT"><?php if (isset($_SESSION['ErrorK'])){echo$_SESSION['ErrorK'];} ?></span><br />
                    <button name="Fertig" class="button_abbrunden15 button180_30_B HintergrundGelbVerlauf">Abschicken</button><br>
                </div>
            
             
            </div>
            </div>
            </form>
             <?php  include "zeile.php";?>
             
             </div>
    </body>
</html>

<?php 

if(isset($_POST['Fertig']))
{
	#Daten zwischenspeichern
	$_SESSION['AnredeK']=$_POST['Anrede'];
	$_SESSION['VornameK']=$_POST['Vorname'];
	$_SESSION['NachnameK']=$_POST['Nachname'];
	$_SESSION['EmailK']=$_POST['Email'];
	$_SESSION['TelefonK']=$_POST['Telefon'];
	$_SESSION['TextK']=$_POST['Text'];
	
	#Eingabe prüfen
	if($_POST['Anrede']!=null and $_POST['Vorname']!=null and $_POST['Nachname']!=null and $_POST['Email']!= null and $_POST['Telefon']!=null and $_POST['Text']!=null)
	{
		
		#Email Klasse
		include'class.phpmailer.php';
		$mail = new PHPMailer();
			
		#Sender
		$mail->SetFrom($_POST['Email'], $_POST['Anrede'].' '.$_POST['Nachname']);
		
		#Empfänger
		include'Email_Adresse.php';
		
		#Betreff
		$mail->Subject    = "Kontaktanfrage";
		
		$body='<b>Nachname:</b> '.$_POST['Nachname'].'<br>';
		$body=$body.'<b>Vorname:</b> '.$_POST['Vorname'].'<br><br>';
		$body=$body.'<b>Email:</b> '.$_POST['Email'].'<br>';
		$body=$body.'<b>Telefonnummer:</b> '.$_POST['Telefon'].'<br><br>';
		$body=$body.'<b>Text:</b><br>';
		$body=$body.$_POST['Text'];
		
		#Email senden
		$mail->MsgHTML($body);
		#$stmt->close();
		if(!$mail->Send()) {
			$_SESSION['ErrorK']="Mailer Error: " . $mail->ErrorInfo;
			echo'<meta http-equiv="refresh" content="0; url=Kontakt.php" />';
		} else {
			$_SESSION['ErrorK']="Ihre Anfrage wurde erfolgreich abgeschickt.";
			unset($_SESSION['AnredeK']);
			unset($_SESSION['VornameK']);
			unset($_SESSION['NachnameK']);
			unset($_SESSION['EmailK']);
			unset($_SESSION['TelefonK']);
			unset($_SESSION['TextK']);
			echo'<meta http-equiv="refresh" content="0; url=Kontakt.php" />';
		}
		
	}
	else
	{
		$_SESSION['ErrorK']="F&uuml;llen Sie bitte alle Felder aus.";
		echo'<meta http-equiv="refresh" content="0; url=Kontakt.php" />';
	}
	
}

?>