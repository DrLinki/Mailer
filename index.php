<?php
$to = 'sender@mail.fr';

$subject = 'MAIL SUBJECT';

$boundary = md5(uniqid(microtime(), true));

$headers = 'From: John PAUL <john.paul@mail.fr>'."\r\n";
$headers.= 'Cc: Eric DAVID <eric.david@mail.fr>'."\r\n";
$headers.= 'Mime-Version: 1.0'."\r\n";
$headers.= 'Content-Type: multipart/mixed;boundary='.$boundary."\r\n";
$headers.= "\r\n";

// Message
$msg = 'Texte affiché par des clients mail ne supportant pas le type MIME.'."\r\n\r\n";
 
// Message HTML
$msg.= '--'.$boundary."\r\n";
$msg.= 'Content-type: text/html; charset=utf-8'."\r\n\r\n";
$msg.= '
	MAIL CONTENT
'."\r\n";

// Pièce jointe 1
$file_name = 'file1.txt';
$file_folder = 'src/';
if(file_exists($file_folder.$file_name)){
	$file_type = filetype($file_folder.$file_name);
	$file_size = filesize($file_folder.$file_name);
	
	var_dump($file_type);
	var_dump($file_size);
 
	$handle = fopen($file_folder.$file_name, 'r') or die('File '.$file_name.'can t be open');
	$content = fread($handle, $file_size);
	$content = chunk_split(base64_encode($content));
	$f = fclose($handle);
 
	$msg.= '--'.$boundary."\r\n";
	$msg.= 'Content-type:'.$file_type.';name='.$file_name."\r\n";
	$msg.= 'Content-transfer-encoding:base64'."\r\n\r\n";
	$msg.= $content."\r\n";
}
/*
// PJ2
$file_name = 'file2.txt';
$file_folder = 'src/';
if(file_exists($file_folder.$file_name)){
	$file_type = filetype($file_folder.$file_name);
	$file_size = filesize($file_folder.$file_name);
 
	$handle = fopen($file_folder.$file_name, 'r') or die('File '.$file_name.'can t be open');
	$content = fread($handle, $file_size);
	$content = chunk_split(base64_encode($content));
	$f = fclose($handle);
 
	$msg.= '--'.$boundary."\r\n";
	$msg.= 'Content-type:'.$file_type.';name='.$file_name."\r\n";
	$msg.= 'Content-transfer-encoding:base64'."\r\n\r\n";
	$msg.= $content."\r\n";
}

/*
// Logo de signature
$file_name = 'signature.jpg';
$file_folder = 'img/';
if(file_exists($file_folder.$file_name)){
	$file_type = filetype($file_folder.$file_name);
	$file_size = filesize($file_folder.$file_name);
 
	$handle = fopen($file_folder.$file_name, 'r') or die('File '.$file_name.'can t be open');
	$content = fread($handle, $file_size);
	$content = chunk_split(base64_encode($content));
	$f = fclose($handle);
 
	$msg.= '--'.$boundary."\r\n";
	$msg.= 'Content-type:'.$file_type.';name='.$file_name."\r\n";
	$msg.= 'Content-transfer-encoding:base64'."\r\n\r\n";
	$msg.= $content."\r\n";
}
//*/
$success = mail($to, $subject, $msg, $headers);

?>