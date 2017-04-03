<?php
#Session starten
session_start();

$Abmelden=$_SESSION['Benutzer'];
#Löscht die gesamt Session mitsamt allen Variablen
session_destroy();

echo'<meta http-equiv="refresh" content="0; url=Suche.php?Aus='.$Abmelden.'" />';
?>