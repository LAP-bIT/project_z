<?php

include'class.phpmailer.php';
$mail = new PHPMailer();

$mail->SetFrom('testi@test.at', 'Sir Testi');

$address = "jukra@gmx.at";
$mail->AddAddress($address, "Julian Kraxner");

$mail->Subject    = "Test";
$body='Hallo, Test. Umlaute? Ä Ü ß? <br><b>Linki</b><br><a href="http://webshop.ignition.at/Emailtest.php" target="blank">Hier hin</a> ';
$mail->MsgHTML($body);

if(!$mail->Send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
} else {
	echo "Message sent!";
}
?>