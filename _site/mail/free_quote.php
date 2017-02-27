<?php
if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
{
  echo "No arguments Provided!";
  return false;
}
$name = $_POST['name'];
$email_address = $_POST['email'];
$type = $_POST['type'];
//$phone = $_POST['phone'];
$msg = $_POST['message'];
$file = $path . "/" . $filename;
$filename = 'myfile';

$mailto = 'tradfacile@gmail.com';
$subject = 'Devis Tradfacile';
$message = 'Devis TradFacile de '. $name .'<br />';
$message .= 'mail : ' . $email_address .'<br />';
$message .= 'message : ' . $msg . '<br />';

$content = file_get_contents($file);
$content = chunk_split(base64_encode($content));

// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (RFC)
$eol = "\r\n";

// main header (multipart mandatory)
$headers = "From: name <test@test.com>" . $eol;
$headers .= "MIME-Version: 1.0" . $eol;
$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
$headers .= "This is a MIME encoded message." . $eol;

// message
$body = "--" . $separator . $eol;
$body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
$body .= "Content-Transfer-Encoding: 8bit" . $eol;
$body .= $message . $eol;

// attachment
$body .= "--" . $separator . $eol;
$body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
$body .= "Content-Transfer-Encoding: base64" . $eol;
$body .= "Content-Disposition: attachment" . $eol;
$body .= $content . $eol;
$body .= "--" . $separator . "--";

//SEND Mail
if (mail($mailto, $subject, $body, $headers)) {
  echo "mail send ... OK"; // or use booleans here
  return true;
} else {
  echo "mail send ... ERROR!";
  print_r( error_get_last() );
  return false;
}

