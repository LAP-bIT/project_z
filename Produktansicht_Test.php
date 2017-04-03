<?php 
#Session starten
session_start();

#Datenbankverbindung
include "DB_Verbindung.php";

if(isset($_POST['WKLegen']))
{
	$_SESSION['AnzahlA']=$_POST['A'];
	$_SESSION['AnzahlB']=$_POST['B'];
	 
	 
	$aa=1;
	#ZWischenspeichern
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
		#$_SESSION['ErrorBP']='hjgig'.$_FILES['datei'.$aa]['name'];
		$_SESSION['D'.$aa]=$_POST['datei'.$aa];
		 
		$aa++;
	}
	$_SESSION['EGP']=$_POST['hiddenLabel'];
	$Bi=1;
	$Na=0;
	$aa=1;
	$An=0;
	while($aa<=$_SESSION['AnzahlA'])
	{
	if($_SESSION['V'.$aa]=="KA")
	{
	$An=1;
}
$aa++;
}
#$An=0;
if($An==0)
	{
	$aa=1;
	$bb=1;
			while($aa<=$_SESSION['AnzahlA'])
	{
		$GesamtMenge=0;
				$bb=1;
				while($bb<=$_SESSION['GAnzahl'.$aa])
			{
			$GesamtMenge=$GesamtMenge+$_SESSION['G'.$aa.$bb];
			$bb++;
}
if($GesamtMenge!=$_SESSION['M'.$aa])
{
#$_SESSION['ErrorBP']="Mind. eine Teilmenge &uuml;berschreitet oder unterschreitet eine Gesamtmenge";
$Na=1;
}
#$_SESSION['ErrorBP']=$GesamtMenge;
$aa++;
}
	 
	$bb=1;
		$aa=1;
		while($aa<=$_SESSION['AnzahlA'])
		{
		$x=1;
		while($x<=$_SESSION['GAnzahl'.$aa])
		{
			if($_SESSION['G'.$aa.$x]!=0)
			{
			$stmt=$mysqli->query('Select count from Stocks where SKU_StyleID="'.$_SESSION['id'].'" and SKU_ColourID="'.$_SESSION['F'.$aa].'" and SKU_SizeID="'.$_SESSION['GSize'.$aa.$x].'"');
			if($stmt === FALSE)
                		{
                			$Anzahl = $Anzahl+1;
					echo"Fehler: ";
					die(print_r( $mysqli->error ));
}
$zeile = $stmt->fetch_array();

if($zeile==null)
{
echo 'Error1_A ---KEIN STOCKEINTRAG VORHANDEN--- Error1_E';
$Na=1;
}
else
{
if($zeile['count']<$_SESSION['M'.$aa])
{
$stmt1=$mysqli->query('Select StyleName2 from Styles_Description where SKU_StyleID="'.$_SESSION['id'].'"');
		$zeile1 = $stmt1->fetch_array();

	$stmt2=$mysqli->query('Select Caption from Colour_ID_Text where SKU_ColourID="'.$_SESSION['F'.$aa].'"');
                				$zeile2 = $stmt2->fetch_array();

                				$stmt3=$mysqli->query('Select Caption from Size_ID_Text where SKU_SizeID="'.$_SESSION['GSize'.$aa.$x].'"');
                				$zeile3 = $stmt3->fetch_array();


                				echo'Error1_A Vom Produkt <b>'.$zeile1['StyleName2'].'</b> mit der Farbe '.$zeile2['Caption'].' und der Gr&ouml;&szlig;e '.$zeile3['Caption'].' sind nur mehr '.$zeile['count'].' St&uuml;ck auf Lager. Error1_E';
                				#echo'<input type="hidden" id="hidden1" value="'.$_SESSION['ErrorBP'].'" name="may"/>';
                				$stmt1->close();
                				$stmt2->close();
                				$stmt3->close();
                						$Na=1;
                				}
                					else
                						{

                			}
                		}
                				}
                					$x++;
                				}
                				$aa++;
                				}
                				 
         
         
         
         
                				 		
$Bi=1;
 
 
 
$z=1;
if(isset($_SESSION['Benutzer']))
 {
  while($z<=$_SESSION['AnzahlA'])
   {
  //if(!isset($_POST['Menge'.$z])  or $_POST['GesamtH'.$z]<1)
  	//{
  #Mengen überprüfen
  //$_SESSION['ErrorBP']="Mindestens eine Menge wurde nicht oder inkorrekt angegeben.";
  //$Na=1;

  //}
  $z++;
  }

  $stmt=$mysqli->query('Select Benutzer_valid from Benutzer where Kundennummer="'.$_SESSION['Benutzer'].'"');
  $zeile = $stmt->fetch_array();

  if($zeile['Benutzer_valid']!=1)
  {
  echo"Error1_A Sie m&uuml;ssen Ihr Konto best&auml;tigen, um ein Produkt in den Warenkorb zu legen. Error1_E";
  $Na=1;
  }
  $stmt->close();

  if($Na!=1)
  {
  $z=1;
   
  while($z<=$_SESSION['AnzahlA'])
  {

  if($_SESSION['F'.$z]!="Nix")
  {
  $x=1;
  while($x<=$_SESSION['GAnzahl'.$z])
  {
   
  if($_SESSION['G'.$z.$x]!=0)
  {
  #Artikel_ID generieren
  $stmt=$mysqli->query('Select Max(Bestellte_Artikel_ID) as MaxNummer from Bestellungen_Warenkorb');
  $zeile = $stmt->fetch_array();
  if($zeile==null)
  {
  $Nummer=0;
  }
  else
  {
  /*while($zeile!=null)
  {
  $Nummer=$zeile['Bestellte_Artikel_ID'];
  $zeile = $stmt->fetch_array();
   
  }*/
  $Nummer=$zeile['MaxNummer'];
  $Nummer++;
  }
  $stmt->close();
   
  #Artikel in den Warenkorb legen
   
  $stmt = $mysqli->prepare("INSERT INTO Bestellungen_Warenkorb (Bestellnummer, Kundennummer, SKU_StyleID, SKU_ColourID, SKU_SizeID, Stueck, Bestellte_Artikel_ID) Values (?,?,?,?,?,?,?)");
  if($stmt === FALSE)
  {
  echo"Fehler: ";
  die(print_r( $mysqli->error ));
  }
  $Bestell="Warenkorb";
  $stmt->bind_param("sssssii",$Bestell, $_SESSION['Benutzer'],$_SESSION['id'],$_SESSION['F'.$z],$_SESSION['GSize'.$z.$x],$_SESSION['G'.$z.$x],$Nummer);
  $stmt->execute();
  $stmt->close();
  		 
  		$y=1;
  		while($y<=$_SESSION['AnzahlB'])
  			{
  			if($_SESSION['V'.$y]!="Nix")
  			{
  				$stmt=$mysqli->query('Select Max(Veredelnummer) as MaxNummer from Bestellungen_Warenkorb_has_Veredelungen');
  				$zeile = $stmt->fetch_array();
  				if($zeile==null)
  				{
  				$Nummer1=0;
  			}
  			else
  			{
  			$Nummer1=$zeile['MaxNummer'];
  			 
  			$Nummer1++;
  			}
  			$stmt->close();
  			 
  			 
  			#Veredelungen der Produkte
  				$stmt = $mysqli->prepare("INSERT INTO Bestellungen_Warenkorb_has_Veredelungen (Bestellte_ArtikelID, VeredelungenID, PositionID, Hochgeladene_Datei, Versandkosten, Einzelverpackung, Veredelnummer) Values (?,?,?,?,?,?,?)");
  				if($stmt === FALSE)
  				{
  				echo"Fehler: ";
  				die(print_r( $mysqli->error ));
  				}
                						$VK=0;
                						$EV=false;
  						$stmt->bind_param("isssdsi",$Nummer,$_SESSION['V'.$y],$_SESSION['P'.$y],$_SESSION['D'.$y],$VK,$EV,$Nummer1);
  				echo $_SESSION['V'.$y].' '.$_SESSION['P'.$y].
  				$stmt->execute();
  				$stmt->close();
  				}
  				$y++;
  				}
  				}
  						$x++;
  				}
  				}
  					$z++;
  				}
  					 
  					#Gesamtpreis des Warenkorbs aktualisieren
  					$_SESSION['WK1']=0;
  					$_SESSION['WK']=0;
  					$stmt = $mysqli->query('SELECT a.Price, c.Stueck, a.VolumeScale, b.SKU_StyleID, b.SKU_ColourID, b.SKU_SizeID from SKU_Price a, SKU b, Bestellungen_Warenkorb c where a.SKU_StyleID = b.SKU_StyleID and a.SKU_SizeID = b.SKU_SizeID and a.SKU_ColourID = b.SKU_ColourID and c.SKU_StyleID = b.SKU_StyleID and c.SKU_SizeID = b.SKU_SizeID and c.SKU_ColourID = b.SKU_ColourID and c.Bestellnummer="Warenkorb" and c.Kundennummer="'.$_SESSION['Benutzer'].'"');
  					$zeile = $stmt->fetch_array();
  					$GP=0;

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
                			if($zeile['Stueck']>1000)
                			{
                			$GP+=$zeile['Stueck']*$zeile['Price'];
                				#$_SESSION[$zeile['SKU_StyleID'].$zeile['SKU_ColourID'].$zeile['SKU_SizeID']]=$zeile['Stueck']*$zeile['Price'];
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
  					 
  					echo'<meta http-equiv="refresh" content="0; url=Warenkorb.php" />';
  				}
  				else
  				{
  				 
  				echo'<meta http-equiv="refresh" content="0; url=Produktansicht_AJAX.php?A=Fehler" />';
  				}
  				}
  				else
  				{
  				#$_SESSION['ErrorBP']="Sie m&uuml;ssen angemeldet sein, um ein Produkt in den Warenkorb zu legen.";
                		echo'<meta http-equiv="refresh" content="0; url=Produktansicht_AJAX.php?A=Fehler" />';
                	}
         
         
                	}
                }
                

#--------------------------------------------------------------------------------------------------------------------------------
#--------------------------------------------------------------------------------------------------------------------------------
#---------------------------------------------------------------ANFRAGE----------------------------------------------------------
#--------------------------------------------------------------------------------------------------------------------------------
#--------------------------------------------------------------------------------------------------------------------------------              
                
                
                
                if(isset($_POST['Anfrage']) or $An==1)
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
                	 
                	$Bi=1;
                	
                									
                										 
                										 
                										 
                										if(isset($_SESSION['Benutzer']))
                										{
                
                											 
                				$stmt=$mysqli->query('Select Benutzer_valid from Benutzer where Kundennummer="'.$_SESSION['Benutzer'].'"');
                				$zeile = $stmt->fetch_array();
                				 
                				if($zeile['Benutzer_valid']!=1)
                				{
                				echo"Error1_A Sie m&uuml;ssen Ihr Konto best&auml;tigen, um eine Anfrage zu senden. Error1_E";
                				#echo'<meta http-equiv="refresh" content="0; url=Produktansicht_AJAX.php?A=Fehler" />';
                					$stmt->close();
                				}
                	 	else
                	 	{
                							 
                                	 	 
                                	 	 
                	 	$stmt = $mysqli->query('SELECT Vorname, Nachname, Anrede, Email, Telefonnummer, Fax from Benutzer where Kundennummer="'.$_SESSION['Benutzer'].'"');
                										$zeile = $stmt->fetch_array();
                										 
                										#Email
                										include'class.phpmailer.php';
                										$mail = new PHPMailer();
                										 
                										#Sender
                											$mail->SetFrom($zeile['Email'], $zeile['Anrede'].' '.$zeile['Nachname']);
                													 
                													#Empfänger
                											include'Email_Adresse.php';
                											 
                											#Betreff
                											$mail->Subject    = "Anfrage bezüglich Artikel";
                											 
                											#Text zusammenschneiden
                	 	$body='<h1>Anfrage von Benutzer '.$zeile['Vorname'].' '.$zeile['Nachname'].'</h1><br><h2>Hauptprodukt: '.$BEN.'</h2><br><h3>Unterprodukte:</h3><br>';
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
                
                											$body=$body.'<b>'.$Nummerierung.'. Produkt</b><br>Größe: '.$zeile1['Caption'].'<br>Farbe: '.$zeile2['Caption'].'<br>Menge: '.$_SESSION['G'.$Pro.$Pra].'<br>Preis: '.$_SESSION['EP'.$Pro].' &euro;<br>';
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
                											 
                											$body=$body.'<b>'.$Nummerierung1.'. Veredelung</b> <br>Art: '.$zeile1['Veredelungsart'].' '.$zeile1['Veredelungsfläche'].'<br>Position: '.$zeile2['Position'].'<br>Bild: '.$_POST['datei'.$Pro].'<br>';
                											$body=$body.'<a href="http://webshop.ignition.at/Download/Download.php?Datei='.$_POST['datei'.$Pro].'&Benutzer='.$_SESSION['Benutzer'].'">Bild-Download</a>';
                											$stmt1->close();
                											$stmt2->close();
                                	 						}
                                	 						else
                                	 						{
                                	 						$body=$body.'<b>'.$Nummerierung1.'. Veredelung</b> <br>Art: Keine Ahnung<br>Position: Keine Ahnung<br>Bild: '.$_POST['datei'.$Pro].'<br>';
                                	 			}
                                	 			$Nummerierung1++;
                                	 			}
                                	 			$Pro++;
                                	 			}
                                	 			$body=$body.'<br><h3>Gesamtpreis:</h3><br>';
                                	 				$body=$body.$_SESSION['EGP'].' &euro;<br>';
                                	 				$body=$body.'<br><h3>Sonstige Informationen:</h3><br>';
                	 	$body=$body.'Kundennummer: '.$_SESSION['Benutzer'].'<br>Datum: '.date("Y.m.d").' <br>Telefonnummer: '.$zeile['Telefonnummer'].'<br>Email: '.$zeile['Email'].'<br>Fax: '.$zeile['Fax'];
                	 	#echo$body;
                                	 			$mail->MsgHTML($body);
                                	 				$stmt->close();
                                	 				if(!$mail->Send()) {
                                	 				echo "Error1_A Mailer Error: " . $mail->ErrorInfo.' Error1_E';
                                	 				#echo'<meta http-equiv="refresh" content="0; url=Produktansicht_AJAX.php?A=Fehler" />';
                                	 				} else {
                                	 				#$_SESSION['ErrorBP']="Ihre Anfrage wurde an uns gesendet.";
                                	 				#echo'<meta http-equiv="refresh" content="0; url=Formular_ab.php" />';
                                	 				}
                	 	}
          
                	 }
                                	 						else
                                	 						{
                                	 							#echo'<meta http-equiv="refresh" content="0; url=Formular.php" />';
                                	 			}
                                	 			}
?>