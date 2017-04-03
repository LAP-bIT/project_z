<?php 
#Session starten
if(!isset($_SESSION))
{
	session_start();	
}

#Datenbankverbindung
include "DB_Verbindung.php";

$b=1;
if(isset($_POST['test']))
{
	$b=$_POST['test'];
}

	
#Positionen der Veredelungen
$stmt = $mysqli->query('SELECT Position, PositionID from Positionen order by Position');
if($stmt === false)
{
	die(print_r( $mysqli->error ));
}
$zeile = $stmt->fetch_array();
echo'<a name="VerPosi'.$b.'"></a>
					<div id="DIV_min_height_180D" class="abrunden_15 bla '.$b.'" name="'.$b.'">
                    <div id="ZeileDetailauswahl">
                        <button onclick="return Pruef1()" onmouseover="Tip(\'W&auml;hlen Sie hier Ihre gew&uumlnschte Position f&uuml;r Ihr Logo auf dem Produkt.\')" onmouseout="UnTip()" class="abrunden_6" style="background: url(inf_button.png) 100% 50% no-repeat #ffffff;cursor:auto;"></button>
                        <span class="span90D">Druckposition:</span>
                        <div id="SelectDetail" class="abrunden_15">
                            <select onchange="Keine('.$b.')" name="Posi'.$b.'" id="Posi'.$b.'">';
	
if($zeile==null)
{
	echo'<option value="'.Nix.'">Keine Veredelungen verf&uuml;gbar</option>';
}
else
{
	echo'<option value="Nix">Keine Veredelung</option>';
	echo'<option value="KA">Keine Ahnung</option>';
}
while($zeile!=null)
{
	$Posi=$Pr = str_replace('ü', '&uuml;',$zeile['Position']);
	$Posi=$Pr = str_replace('Ü', '&uuml;',$Posi);
	$Posi=$Pr = str_replace('Ä', '&Auml;',$Posi);
	$Posi=$Pr = str_replace('ä', '&auml;',$Posi);
	$Posi=$Pr = str_replace('Ö', '&Ouml;',$Posi);
	$Posi=$Pr = str_replace('ö', '&ouml;',$Posi);
	$Posi=$Pr = str_replace('ß', '&szlig;',$Posi);
	$PosiID=$zeile['PositionID'];
	echo'<option ';
	if(isset($_SESSION['P'.$b]))
	{
		if($_SESSION['P'.$b]==$PosiID){echo'selected';}}
		echo' value="'.$PosiID.'">'.$Posi.'</option>';
		$zeile = $stmt->fetch_array();
}
$stmt->close();
	
$stmt = $mysqli->query('SELECT a.VeredelungenID, a.Veredelungsart, a.Veredelungsfläche, b.Veredelung_machbar from Veredelungen a, Styles_Description_bool b where a.VeredelungenID = b.VeredelungenID and b.SKU_StyleID = "'.$_SESSION['id'].'" order by a.VeredelungenID');
if($stmt === false)
{
	die(print_r( $mysqli->error ));
}
$zeile = $stmt->fetch_array();
echo'</select>
                        </div>
                        <div id="ZeileDetailauswahl">
                            <button onclick="return Pruef1()" onmouseover="Tip(\'W&auml;hlen Sie hier die Art der gew&uuml;nschten Veredelung aus.\')" onmouseout="UnTip()" class="abrunden_6" style="background: url(inf_button.png) 100% 50% no-repeat #ffffff;cursor:auto;"></button>
                            <span class="span90D">Veredelungsart:</span>
                            <div id="SelectDetail" class="abrunden_15">
                                <select name="Ver'.$b.'" onchange="Rechne(1,'.$b.',1,1,1);" id="Ver'.$b.'">';
if($zeile==null)
{
	echo'<option value="'.Nix.'">Keine Veredelungen verf&uuml;gbar</option>';
}
else
{
	echo'<option value="Nix">Keine Veredelung</option>';
	echo'<option value="KA">Keine Ahnung</option>';
}

while($zeile!=null)
{
#Art der Veredelungen
$Ver=$zeile['Veredelungsart'].' '.$zeile['Veredelungsfläche'].'';
	$Ver=str_replace('Ü', '&Uuml;',$Ver);
			$Ver=str_replace('ü', '&uuml;',$Ver);
					$Ver=str_replace('Ä', '&Auml;',$Ver);
					$Ver=str_replace('ä', '&auml;',$Ver);
					$Ver=str_replace('Ö', '&Ouml;',$Ver);
					$Ver=str_replace('ö', '&ouml;',$Ver);
					$Ver=str_replace('ß', '&szlig;',$Ver);
					$VerID=$zeile['VeredelungenID'];
					$Vermach=$zeile['Veredelung_machbar'];
					if($Vermach==1)
					{
					echo'<option ';
					if(isset($_SESSION['V'.$b]))
					{
					if( $_SESSION['V'.$b]==$VerID){echo'selected';}}
					echo' value="'.$VerID.'">'.$Ver.'</option>';
}
$zeile = $stmt->fetch_array();
}
$stmt->close();
	echo'</select>
	</div>
			</div>';

			 

			echo'<div id="ZeileDetailauswahl">
			<button onclick="return Pruef1()" onmouseover="Tip(\'W&auml;hlen Sie hier Ihr gew&uuml;nschtes Logo von Ihrem PC aus.\')" onmouseout="UnTip()" class="abrunden_6" style="background: url(inf_button.png) 100% 50% no-repeat #ffffff;cursor:auto;"></button>
			<span class="span90D">Logo-hochladen:</span>
			<div id="divLogohochladen">';
			echo'<input id="JSdatei'.$b.'" onchange="Neues_Bild('.$b.')" name="datei'.$b.'" type="file" class="warum">';
                               echo'<img id="Bild_'.$b.'" src="hacken_07_def.png" />';
			echo'</div>
			</div>

			<div id="ZeileDetailauswahl_Berechnen">
			<label id="GesamtV'.$b.'">';
                        if(isset($_SESSION['VP'.$b])){echo$_SESSION['VP'.$b];}
                        echo'</label><br>
                        <input type="hidden" id="GesamtVH'.$b.'" value="';if(isset($_SESSION['VP'.$b])){echo$_SESSION['VP'.$b];} echo'" name="GesamtVH'.$b.'"/>
                    </div>

                        <div id="Zeile_Klein_Auswahl_Links">
                            <button name="EinsWeg'.$b.'" class="EinsWeg a'.$b.'" id="abrunden_6" style="background: url(loeschen_button_11.png) 100% 50% no-repeat #ffffff"></button>
                            		<label>Diese Auswahl entfernen</label>
                            		</div>
                            				<div id="Zeile_Klein_Auswahl_Rechts">
                            <button  name="NochEins'.$b.'" class="NochEins" id="abrunden_6" style="background: url(plus-button_11.png) 100% 50% no-repeat #ffffff"></button>
                            				<label>weitere Druckposition hinzuf&uuml;gen</label>
                            				</div>
                    </div>
                            						</div>';

?>