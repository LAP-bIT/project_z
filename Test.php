<head>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script type='text/javascript' src='menu_jquery.js'></script>

</head>
<body>

<input type="file" id="bla" name="bla" />

<script>

$('body').on('change', '#bla', function() {
	// Post-Daten vorbereiten
	var data = new FormData();
	data.append('file', $('#bla')[0].files[0]);
	data.append('foo', 1);
	// Ajax-Call
	$.ajax({
	url: 'Test.php',
	data: data,
	type: 'POST',
	processData: false,
	contentType: false,
	success: function(evt) { // Bild anzeigen
		alert(evt);
		//window.location="Test.php";
	}
	});
	});



</script>

<?php 
print_r($_FILES);
echo'bla';
if(isset($_FILES['file']['tmp_name']))
{
	echo'bla1';
	$dateityp = GetImageSize($_FILES['file']['tmp_name']);
	#Dateityp überprüfen
	if($dateityp[2] != 0 or $dateityp[3] != 0)
	{
	#Bilder uploaden
		//ändern
			$Pfad="Upload/";
			
					move_uploaded_file($_FILES['file']['tmp_name'], $Pfad."/".$_FILES['file']['name']);
			echo'ja!';

					 
			}
}

?>
</body>