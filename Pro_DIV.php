<?php 

#Session starten
if(!isset($_SESSION))
{
	session_start();	
}


#Datenbankverbindung
include "DB_Verbindung.php";

$a=1;
if(isset($_POST['test']))
{
	$a=$_POST['test'];
}


$stmt = $mysqli->query('SELECT DISTINCT a.Caption, a.SKU_ColourID from Colour_ID_Text a, SKU b where b.SKU_StyleID="'.$_SESSION['id'].'" and a.SKU_ColourID = b.SKU_ColourID order by a.Caption');
					if($stmt === false)
					{
						die(print_r( $mysqli->error ));
					}
					$zeile = $stmt->fetch_array();
                echo'<a name="Pro'.$a.'"></a>
					<div id="DIV_min_height_210D" class="abrunden_15 bla1 x'.$a.'">
                    <div id="ZeileDetailauswahl">
                        <button onclick="return Pruef1()" onmouseover="Tip(\'W&auml;hlen Sie hier die gew&uuml;nschte Farbe des Produktes aus.\')" onmouseout="UnTip()" class="abrunden_6" style="background: url(inf_button.png) 100% 50% no-repeat #ffffff;cursor:auto;"></button>
                        <span class="span90D">Farbe:</span>
                        <div id="SelectDetail" class="abrunden_15">
                            <select onchange="Rechne(1,'.$a.',1,1,1)" name="Farbe'.$a.'" id="Farbe'.$a.'">';
                if($zeile==null)
                {
                	echo'<option value="'.Nix.'">Keine Farbe verf&uuml;gbar</option>';
                }
                while($zeile!=null)
                {
                	#Farben des Produktes
                	$ColourCap=$zeile['Caption'];
                	
                	$ColourID=$zeile['SKU_ColourID'];
                	$_SESSION['ColourID'.$a]=$ColourID;
                	$zeile = $stmt->fetch_array();
                	echo'<option ';
                	if(isset($_SESSION['F'.$a]))
                	{
                	if($_SESSION['F'.$a]==$ColourID){echo'selected';}}
                	echo' value="'.$ColourID.'">'.$ColourCap.'</option>';
                }
                $stmt->close();
                            echo'</select>
                        </div>
                    </div>';
			
			
                            
                            
                            
                            $stmt = $mysqli->query('SELECT DISTINCT a.Caption, a.SKU_SizeID from Size_ID_Text a, SKU b where b.SKU_StyleID="'.$_SESSION['id'].'" and a.SKU_SizeID = b.SKU_SizeID order by a.SKU_SizeID');
                            if($stmt === false)
                            {
                            	die(print_r( $mysqli->error ));
                            }
                            $zeile = $stmt->fetch_array();
                            $_SESSION['GAnzahl'.$a]=$mysqli->affected_rows;
                            
                            
                    echo'<div id="ZeileDetailauswahl">	
                        <span class="span90D">Gesamtmenge:</span>
                        <input onkeypress="return Pruef(event)" value="';
                        if(isset($_SESSION['M'.$a])){echo$_SESSION['M'.$a];}else{echo'0';}
                        echo'" onchange="Rechne(this.value,'.$a.',1,1,1);Teil(1,'.$_SESSION['GAnzahl'.$a].','.$a.')" name="Menge'.$a.'"';
                        echo' type="text" size="15" class="abrunden_15 input26 Menge M'.$a.'" id="Menge'.$a.'" />
                        <label>St&uuml;ck</label>
                            </div>';
                        
                        
                        $e=0;
                        while($zeile!=null)
                        {
                        	$e++;
                        	$_SESSION['GSize'.$a.$e]=$zeile['SKU_SizeID'];
                		echo'<div id="ZeileDetailauswahl">';
                		 echo'<span class="span90DU">Gr&ouml;&szlig;e: '.$zeile['Caption'].'</span>
                		<input name="'.$_SESSION['GSize'.$a.$e].'" onchange="Teil('.$e.','.$_SESSION['GAnzahl'.$a].','.$a.')" value="';
                		
                		if(isset($_SESSION['G'.$a.$e]))
                		{
                			echo$_SESSION['G'.$a.$e];
                		}
                		else
                		{
                			echo'0';
                		}
                		
                		echo'" type="text" size=15 class="abrunden_15 input15 value_'.$a.'_'.$e.'" id="Groessen'.$a.$e.'"/>
                		</div>';
                		 $zeile = $stmt->fetch_array();
                        }
                        $e=0;
                    echo'
					<div style="clear:both;"></div>
                    <div id="ZeileDetailauswahl_Berechnen">
                        <label id="Gesamt'.$a.'">';
                        if(isset($_SESSION['EP'.$a])){echo$_SESSION['EP'.$a];}
                        echo'</label><br>
                        <input type="hidden" value="';  if(isset($_SESSION['EP'.$a])){echo$_SESSION['EP'.$a];}echo'" name="GesamtH'.$a.'"/>
                    </div>

                    <div id="Zeile_Klein_Auswahl_Rechts" style="margin-top:60px;">
                      <button name="Plus'.$a.'" class="Plus" id="abrunden_6" style="background: url(plus-button_11.png) 100% 50% no-repeat #ffffff"></button>
                        <label style="margin-left:70px;" class="CH">weiteren Artikel hinzuf&uuml;gen</label>
                    </div>
					
                    <div id="Zeile_Klein_Auswahl_Links" style="margin-bottom:10px;">
                        <button name="Minus'.$a.'" class="Minus a'.$a.'" id="abrunden_6" style="background: url(loeschen_button_11.png) 100% 50% no-repeat #ffffff"></button>
                        <label>Diese Auswahl entfernen</label>
                    </div>
                         <div style="clear:both;"></div>
                </div>
                      <div style="clear:both;"></div>';
                        
                        ?>