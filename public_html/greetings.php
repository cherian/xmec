<?php
include 'header.php';
$dbh =& XMEC::getDB();

   $x = 1;
   $hold = 10; // quantity of emails sent before 3 sec delay
   $day = "07-26";
   $value = " '%".$day."%' ;";
   $query = "SELECT id,date_of_birth,personal_email,official_email,concat(first_name,' ',middle_name,' ',last_name) as name FROM xmec_user where date_of_birth like ".$value;
   $aowmail = mysql_query("$query");
   while ($countmail = mysql_fetch_array($aowmail,MYSQL_ASSOC)) {
   $name = $countmail["name"];
   $roll = $countmail["id"];
   $to_whom = $name." <".$countmail["personal_email"].">";
   $cc_id = $name." <".$countmail["official_email"].">";
   $subject = "Greetings from XMEC.net";
   $from = "XMEC Webmasters";
   $from_id = "webmasters@xmec.net";
   $from_mail = $from."<".$from_id.">";
   $greeting = "Wishing you a very special Happy Birthday. Have a great day ahead! ";
   $messagex = "Dear $name\n\n"."$greeting\n\n"."$from\n\n"."This Message was sent from the XMEC Alumni site (www.xmec.net). Please contact webmasters@xmec.net if this mail has reached you in error or if you have any other concerns.";
   mail($to_whom , $subject ,$messagex , "From:{$from_mail}\r\n"."Cc:{$cc_id}\r\n"."Bcc:{$bcc}\r\n");
	echo "Mail sent to :[ $roll ] $name from $from_mail";
   $x++;
    if($x == $hold) { // When $x is equal to $hold, a 3 sec delay will occur avoiding php to timeout
    sleep(3);
    $x = 0;
    }
   } // end of while loop

?>

