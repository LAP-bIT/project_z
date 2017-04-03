<?php
#Session starten
session_start();

#Datenbankverbindung
include "DB_Verbindung.php";

?>



<?php 
if(isset($_POST['Anfrage']))
{

$_SESSION['AnzahlA']=$_POST['A'];
$_SESSION['AnzahlB']=$_POST['B'];
 
 
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
		$_SESSION['GSize'.$aa.$ee]=$_POST['GSize'.$aa.$ee];
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


}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Webshop f&uuml;r Textilwaren | Formular</title>
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
                    <label id="LabelP"><?php if(!isset($_SESSION['WK'])){ $_SESSION['WK']="0,00 ";}echo $_SESSION['WK']?> &euro;</label>
                  
               
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
        
        
		<form action="Formular.php" method="post">
        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein">anfrageformular</label>
            </div>
            <div id="OverFunction">
               <div id="DIV_min_height_150" class="abrunden_20">
                    <span class="span66">Anrede:</span>
                    <div id="SelectAnrede" class="abrunden_15">
                        <select name="Anrede">
                            <option <?php if($_SESSION['AnredeF']=="Herr"){echo'selected';}?> value="Herr">Herr</option>
                            <option <?php if($_SESSION['AnredeF']=="Frau"){echo'selected';}?> value="Frau">Frau</option>
                            <option <?php if($_SESSION['AnredeF']=="Firma"){echo'selected';}?> value="Firma">Firma</option>
                        </select>
                    </div>
                    <span class="span66">Email:</span>
                    <input name="Email" class="input25" size="25" value="<?php if(isset($_SESSION['EmailF'])){echo$_SESSION['EmailF'];}?>" type="text" /><br />
                    <span class="span66">Vorname:</span>
                    <input name="Vorname" class="input25" size="25" value="<?php if(isset($_SESSION['VornameF'])){echo$_SESSION['VornameF'];}?>" type="text" />
                    <span class="span66">Nachname:</span>
                    <input name="Nachname" class="input25" size="25" value="<?php if(isset($_SESSION['NachnameF'])){echo$_SESSION['NachnameF'];}?>" type="text" /><br />
                    <span class="span66">Telefonnr.:</span>
                    <input name="Telefon" class="input25" size="25" value="<?php if(isset($_SESSION['TelefonF'])){echo$_SESSION['TelefonF'];}?>" type="text" /><br />
                    <span class="span400ROT"><?php if (isset($_SESSION['ErrorBV1'])){echo$_SESSION['ErrorBV1'];} ?></span><br />
                    <button name="Fertig" class="button_abbrunden15 button180_30_B HintergrundGelbVerlauf">Abschicken</button><br>
                </div>
            </div>

        </div>
        </form>
        
        <div style="clear:both;"></div>
<?php  include "zeile.php";?>
    </div>

</body>
</html>

<?php 

if(isset($_POST['Fertig']))
{
	#Daten zwischenspeichern
	$_SESSION['AnredeF']=$_POST['Anrede'];
	$_SESSION['VornameF']=$_POST['Vorname'];
	$_SESSION['NachnameF']=$_POST['Nachname'];
	$_SESSION['EmailF']=$_POST['Email'];
	$_SESSION['TelefonF']=$_POST['Telefon'];
	
	
	#Eingabe prüfen
	if($_POST['Anrede']!=null and $_POST['Vorname']!=null and $_POST['Nachname']!=null and $_POST['Email']!= null and $_POST['Telefon']!=null)
	{

		#Email Klasse
		include'class.phpmailer.php';
		$mail = new PHPMailer();
			
		#Sender
		$mail->SetFrom($_POST['Email'], $_POST['Anrede'].' '.$_POST['Nachname']);

		#Empfänger
		include'Email_Adresse.php';

				#Betreff
				$mail->Subject    = "Anfrage bezüglich Artikel (Formular)";

				#Text zusammenbasteln
				$body='<h1>Anfrage von Benutzer '.$_POST['Vorname'].' '.$_POST['Nachname'].'</h1><br><h2>Hauptprodukt: '.$_SESSION['BEN'].'</h2><br><h3>Unterprodukte:</h3><br>';


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
                	 			$body=$body.'<a href="http://webshop.ignition.at/Download/Download.php?Datei='.$_POST['datei'.$Pro].'&Benutzer=000_NichtRegistriert">Bild-Download</a>';
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
				$body=$body.'Datum: '.date("Y.m.d").' <br>Telefonnummer: '.$_POST['Telefon'].'<br>Email: '.$_POST['Email'];
				#echo$body;

				#Email senden
				$mail->MsgHTML($body);
				#$stmt->close();
				if(!$mail->Send()) {
					$_SESSION['ErrorBV1']="Mailer Error: " . $mail->ErrorInfo;
					echo'<meta http-equiv="refresh" content="0; url=Formular.php" />';
				} else {
					unset($_SESSION['AnredeF']);
					unset($_SESSION['VornameF']);
					unset($_SESSION['NachnameF']);
					unset($_SESSION['EmailF']);
					unset($_SESSION['TelefonF']);
					unset($_SESSION['TextF']);
					echo'<meta http-equiv="refresh" content="0; url=Formular_ab.php" />';
				}

	}
	else
	{
		$_SESSION['ErrorBV1']="F&uuml;llen Sie bitte alle Felder aus.";
		echo'<meta http-equiv="refresh" content="0; url=Formular.php" />';
	}
}

?>
