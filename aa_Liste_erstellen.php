<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="WebShopStyle.css" rel="stylesheet" type="text/css" />
<link href="AuswahlStyle.css" rel="stylesheet" type="text/css" />
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script type='text/javascript' src='menu_jquery.js'></script>

</head>
<body>


<?php
include "DB_Verbindung.php";
?>

<div id="Auswahl">
   <div id='cssmenu'>
      <ul>
      
      <?php
	  #Liefert alle Hauptkategorien
	  $stmt1 = $mysqli->query('SELECT DISTINCT Hauptkate from Test_Kate where Hauptkate!="Produkte"');
	  $zeile1 = $stmt1->fetch_array();
	  while($zeile1!=null)
	  {
		  if($zeile1['Hauptkate']=="Stile")
		  {
			  $yy="test";
		  }
		  else
		  {
			  $yy="";
		  }
		  
	  ?>
      
  <li class='has-sub <?php echo $yy;  ?>'>
     <a href='#'><span><?php echo $zeile1['Hauptkate']; ?></span></a>
         <ul>
         		<?php
					#Liefert alle Kategorien der Hauptkategorie
				 $stmt2 = $mysqli->query('SELECT DISTINCT Unterkate, Anzahl from Test_Kate where Hauptkate="'.$zeile1['Hauptkate'].'" order by Anzahl desc');
	  			 $zeile2 = $stmt2->fetch_array();
				 while($zeile2!=null)
				 {
					 #Schreibt die Liste
					 echo"<li><a href='#'><span>".$zeile2['Unterkate']."</span></a></li>";
					 
					 $zeile2 = $stmt2->fetch_array();
				 }
				?>                                              
         </ul>
    </li>
    <?php
		$zeile1 = $stmt1->fetch_array();
	  }
	?>
    </ul>
   </div>
  </div>
  </body>