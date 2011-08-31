<html><title>Email Sent to Webmaster</title>
<?php
$messagex = "$message\n\n"."$details\n\n";
$sender = $sendername."<".$senderemail.">";
mail($recipient, $subject, $messagex, "From:{$sender}\r\n"."Cc:{$ccrecipient}\r\n"."Bcc:{$bccrecipient}\r\n") ;
?>
<SCRIPT>document.location.href="thankyou.php";
</SCRIPT></html>
