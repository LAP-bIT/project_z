<?php
#Session starten
session_start();

#Datenbankverbindung
include "DB_Verbindung.php";

#Error unseten
unset($_SESSION['ErrorBV1']);

#Variabeln unseten
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
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Webshop f&uuml;r Textilwaren | Anfrage gesendet</title>
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

        <div id="UeberDiv">
            <div id="ProduktAnzeige" class="abrunden_20 HintergrundGelbVerlauf">
                <label class="TextSchein">Anfrage zugesandt</label>
            </div>
            <div id="OverFunction">
               <span class="span600">Die Unverbindliche Anfrage wurde übermittelt und ein Service Mitarbeiter wird sich persöhnlich bei Ihnen melden.</span>

                <div style="clear:both;"></div>
            </div>
        </div>



    </div>

</body>
</html>
