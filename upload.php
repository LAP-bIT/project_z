<?php 
session_start();
$Bi=$_POST['foo'];
print_r($_FILES);
if($_FILES['file'.$Bi]['tmp_name']!="")
{
	$dateityp = GetImageSize($_FILES['file'.$Bi]['tmp_name']);
	#Dateityp überprüfen
	if($dateityp[2] != 0 or $dateityp[3] != 0)
	{
	#Bilder uploaden
		//ändern
			$Pfad="Upload/";
			if(is_dir($Pfad.$_SESSION['Benutzer']))
			{
			move_uploaded_file($_FILES['file'.$Bi]['tmp_name'], $Pfad.$_SESSION['Benutzer']."/".$_FILES['file'.$Bi]['name']);
			}
			else
			{
					mkdir($Pfad.$_SESSION['Benutzer']);
							move_uploaded_file($_FILES['file'.$Bi]['tmp_name'], $Pfad.$_SESSION['Benutzer']."/".$_FILES['file'.$Bi]['name']);
							echo'ja';
			}
							}
							else
							{
							#$_SESSION['ErrorBP']="Die ausgew&auml;hlte Datei, ist kein Bild im .jpg oder .png Format.";
							echo'Error';
							$Na=1;
							}

									 
							}
							else
							{
							#$_SESSION['ErrorBP']="Sie haben ein oder mehrere Bilder nicht ausgew&auml;hlt.";
							echo 'Error';
							$Na=1;
							
                	}




?>