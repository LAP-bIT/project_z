<?php
#-------------------Datenbankverbindung------------------

include "DB_Verbindung.php";
#$ID='042410';
echo'<h1>Veredelungstool</h1><br>';
#echo'042410';
echo"Geben Sie hier die Stylenummer der SKU ein, um Veredelungen von bestimmten Produkten zu streichen.";
echo '<form action="Veredelungstool.php" method="post">
<input type="text" size="17" name="Produkt">
<input type="submit" value="OK">
</form>';
if(isset($_POST["Produkt"]))
{
	$Produkt = $_POST["Produkt"];
	$ID=$Produkt;
	$stmt = $mysqli->query('SELECT a.SKU_StyleID, a.VeredelungenID, a.Veredelung_machbar, b.Veredelungsart from Styles_Description_bool a, Veredelungen b where  a.VeredelungenID = b.VeredelungenID and a.SKU_StyleID = "'.$Produkt.'" Order by VeredelungenID');
	if($stmt === false)
	{
		die(print_r( $mysqli->error ));
	}
	$i=1;
	//$stmt->bind_param("s",$Produkt);
	//$zeile = $stmt->fetch_array();
	//echo'Produkt: '.$zeile['StyleName2'].'<br>';
	//echo'SKUID: '.$zeile['Styles_SKU_StyleID'].'<br>';
	echo '<form action="Veredelungstool.php" method="post">';
	while($i<18)
	{
	$zeile = $stmt->fetch_array();
	if($i==1)
	{
		echo'StyleID: '.$zeile['SKU_StyleID'].'<br>';
	}
		
		echo$zeile['Veredelungsart'].'<br>';
		if($zeile['Veredelung_machbar']==1)
		{
			echo'<select name="Produkt'.$zeile['VeredelungenID'].'" size="1">
			<option value="'.$zeile['Veredelung_machbar'].'">Machbar</option>
			<option value="0">Nicht Machbar</option>
			</select><br>';
		}
		else
		{
			echo'<select name="Produkt'.$zeile['VeredelungenID'].'" size="1">
			<option value="'.$zeile['Veredelung_machbar'].'">Nicht Machbar</option>
			<option value="1">Machbar</option>
			</select><br>';
		}
		
	$i++;
	}
	echo'<input type="submit" name="UpdateE" value="Updaten"/>';
	echo'</form><br>';
	echo '<form action="Veredelungstool.php" method="post">';
	echo'Alle Veredelungen<br>';
	echo'<select name="Produkt100" size="1">
	<option value="null">Option Auswählen</option>
	<option value="1">Machbar</option>
	<option value="0">Nicht Machbar</option>
	</select><br>';
	echo'<input type="submit" name="UpdateA" value="Updaten"/>';
	echo'</form><br>';
}
if(isset($_POST['UpdateE']))
{
	$i=1;
	while($i<19)
	{
		$a = (string)$i;
		//$help='Update Styles_Description_bool SET Veredelung_machbar='.$_POST['Produkt'.$i].' where Styles_SKU_StyleID="'.$ID.'" and VeredelungenID = "'.$a.'"';
		$help='Update Styles_Description_bool SET Veredelung_machbar=? where SKU_StyleID=? and VeredelungenID = ?';
		$stmt = $mysqli->prepare($help);
		if($stmt === false)
		{
			die(print_r( $mysqli->error ));
		}
		$stmt->bind_param("iss",$_POST['Produkt'.$i], $ID, $a);
		$stmt->execute();
		$stmt->close();
		$i++;
	}
}
if(isset($_POST['UpdateA']))
{
	$i=1;
	if($_POST['Produkt100'] =="null")
	{
		echo'<font color="#FF0000">Bitte wählen sie eine Option aus.</font>';
	}
	else
	{
	while($i<19)
	{
		$a = (string)$i;
		$stmt = $mysqli->prepare('Update Styles_Description_bool SET Veredelung_machbar=? where SKU_StyleID=? and VeredelungenID =?');
		if($stmt === false)
		{
			die(print_r( $mysqli->error ));
		}
		$stmt->bind_param("iss",$_POST['Produkt100'], $ID, $a);
		$stmt->execute();
		$stmt->close();
		$i++;
	}
	}
}

?>