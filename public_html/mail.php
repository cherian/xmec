<html><title>Email Sent to Webmaster</title>
<?php
$messagex = "$message\n\n"."$details\n\n"."This Message was sent from the XMEC Alumni site (www.xmec.net). Please contact webmasters@xmec.net if this mail has reached you in error or if you have any other concerns.";
mail($recipient, $subject, $messagex, "From:{$sender}\r\n"."Cc:{$ccrecipient}\r\n"."Bcc:{$bccrecipient}\r\n") ;
?>
<SCRIPT>document.location.href="thankyou.php";
</SCRIPT></html>
