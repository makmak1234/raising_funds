<?php

  // ini_set('display_errors', 1);

// include_once $_SERVER['DOCUMENT_ROOT'].'/classes/phpmailer/class.phpmailer.php';
// include_once $_SERVER['DOCUMENT_ROOT'].'/classes/phpmailer/class.smtp.php';

include_once 'classes/phpmailer/PHPMailerAutoload.php'; // $_SERVER['DOCUMENT_ROOT'].

//send_email('rage_x@mail.ru', '23', '23423');

 
function send_email($to_mail, $subject, $text, $from_email='info@div.holding.bz', $from_name='dividenty')
{
	$text = htmlspecialchars_decode($text);

	$body             = $text;
	$body             = eregi_replace("[\]",'',$body);

	$mail             = new PHPMailer();
	
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "bazabd.xyz";//"139841.simplecloud.club";//"http://89.223.25.228/webmail/";//ssl://mail.easywork24.com"; // SMTP server
	$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
	$mail->SMTPAuth   = "true";//"Normal password";//true;                  // enable SMTP authentication
	$mail->SMTPSecure = "STARTTLS";                // sets the prefix to the servier
	// $mail->Host       = "mail.easywork24.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 587;//25;                   // set the SMTP port for the GMAIL server
	$mail->Username   = 'money@bazabd.xyz';//'info@easywork24.com'; // "olegnsd6@gmail.com";  // GMAIL username
	$mail->Password   = 'BzOaii5sId';//'c71f6fdb177958e81f6a075653bd9e2c'; //"xyz151617";            // GMAIL password
	
	// $mail->SetFrom($from_email, $from_name);
	$mail->From = $from_email;
	$mail->FromName = $from_name;
	
	$mail->CharSet = 'utf-8';//'windows-1251';
	$mail->ContentType = 'text/html';
	 
	$mail->Subject  = $subject;
	$mail->Body    = $body;
	
	// $mail->MsgHTML($text);
	$mail->FromName = $from_name;
	
	$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
	$mail->AddAddress($to_mail);

	if(!$mail->Send()) 
	{
		 //echo $error = $mail->ErrorInfo;
		//echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";	
		return '-2';
		 
	}
	else 
	{ 
		return 1;
	}
}

// echo send_email('qwertyfamiliya@gmail.com', 'subject_test', 'text_test', 'money@bazabd.xyz', 'from_name');
// echo send_email('qwertyfamiliya@gmail.com', 'subject_test', 'text_test', 'money@bazabd.xyz', 'Милитарихолдинг');

?>