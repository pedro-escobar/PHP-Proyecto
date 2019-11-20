<?php

/*
*
* Endeos, Working for You
* blog.endeos.com
*
*/

require_once('phpmailer/PHPMailerAutoload.php');


$mail = new PHPMailer;

//$mail->SMTPDebug    = 3;

$mail->IsSMTP();
$mail->Host = 'smtp.gmail.com';   /*Servidor SMTP*/																		
$mail->SMTPSecure = 'ssl';   /*Protocolo SSL o TLS*/
$mail->Port = 465;   /*Puerto de conexión al servidor SMTP*/
$mail->SMTPAuth = true;   /*Para habilitar o deshabilitar la autenticación*/
$mail->Username = 'bittussoftware@gmail.com';   /*Usuario, normalmente el correo electrónico*/
$mail->Password = 'bittus123456';   /*Tu contraseña*/
$mail->From = 'bittussoftware@gmail.com';   /*Correo electrónico que estamos autenticando*/
$mail->FromName = 'JaveCoin';   /*Puedes poner tu nombre, el de tu empresa, nombre de tu web, etc.*/
$mail->CharSet = 'UTF-8';   /*Codificación del mensaje*/

?>