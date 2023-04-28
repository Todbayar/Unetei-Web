<?php
include "mysql_config.php";
include "info.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "./include/PHPMailer/src/Exception.php";
require "./include/PHPMailer/src/PHPMailer.php";
require "./include/PHPMailer/src/SMTP.php";

if(isset($_REQUEST["fromID"]) && isset($_REQUEST["toID"]) && isset($_REQUEST["type"]) && isset($_REQUEST["message"])){
	chat_send($_REQUEST["fromID"], $_REQUEST["toID"], $_REQUEST["type"], htmlspecialchars(addslashes($_REQUEST["message"])));
}

function chat_send($from, $to, $type, $message){
	global $conn, $smtp_host, $smtp_port, $smtp_username, $smtp_password;
	if($message != ""){
		if(!isChatExist($from, $to, $type, $message)){
			$query = "INSERT INTO chat (fromID, toID, type, message, isRead, datetime) VALUES (".$from.", ".$to.", ".$type.", '".$message."', 0, '".date("Y-m-d H:i:s")."')";
			if($conn->query($query)){
				echo "OK";
			}
			else {
				echo "Fail";
			}
		}
		else {
			$query = "UPDATE chat SET isRead=0, datetime='".date("Y-m-d H:i:s")."' WHERE fromID=".$from." AND toID=".$to." AND type=".$type." AND message='".$message."'";
			if($conn->query($query)){
				echo "OK";
			}
			else {
				echo "Fail";
			}
		}
	}
	
//	$mail = new PHPMailer(true);
//	try {
//		//Server settings
////		$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//		$mail->isSMTP();                                            //Send using SMTP
//		$mail->Host       = $smtp_host;                     		//Set the SMTP server to send through
//		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//		$mail->Username   = $smtp_username;                     	//SMTP username
//		$mail->Password   = $smtp_password;                         //SMTP password
//		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//		$mail->SMTPSecure = "ssl";
//		$mail->Port       = $smtp_port;                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
//
//		//Recipients
//		$mail->setFrom('atodko0513@gmail.com', 'Unetei.mn');
//		$mail->addAddress('misheelgamestudio@gmail.com', 'Todbayar');      //Add a recipient
////		$mail->addAddress('ellen@example.com');               		//Name is optional
////		$mail->addReplyTo('info@example.com', 'Information');
////		$mail->addCC('cc@example.com');
////		$mail->addBCC('bcc@example.com');
//
//		//Attachments
////		$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
////		$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
//
//		//Content
//		$mail->isHTML(true);                                  //Set email format to HTML
//		$mail->Subject = 'Here is the subject';
//		$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//
//		$mail->send();
//		echo 'Message has been sent';
//	} catch (Exception $e) {
//		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//	}
}

function isChatExist($from, $to, $type, $message){
	global $conn;
	$query = "SELECT * FROM chat WHERE fromID=".$from." AND toID=".$to." AND type=".$type." AND message='".$message."'";
	$result = $conn->query($query);
	if(mysqli_num_rows($result) > 0){
		return true;
	}
	else {
		return false;
	}
}
?>