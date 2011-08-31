<?php
$secure_page=1;
$this_page="college";
include 'header.php';
?>
<?php
	if (! XMEC::authenticate_user()) {
		echo "<html><h1>Please login to access this page<html>";
		exit ;
	}
	$me =& XMEC::getUser();

	if (!$me->isAdmin()) {
		echo "<html><h1>Not authorized !!</html>";
		exit ;
	}
?>
<?php
$dbh =& XMEC::getDB();
   if (!isset($_POST['submit'])):{
      }
?>

<html>
<head>
</head>
<body>
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
		<TD width=6%><BR></TD>
		<TD width=90% height=40 class=head><B>XMEC Birthday Greetings</B></TD>
  </TR>
<TR><TD colspan=2>
<!--Box Starts-->
<TABLE cellSpacing=0 cellPadding=0 border=0 width=90% align=center>
<TBODY>
<TR>
<TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
<TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
<TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
<TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>    </TR>
<TR>
<TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6
src="images/tb_left_topb.gif" width=3></TD>
<TD colSpan=2 rowSpan=2>
<!--center starts-->
<!--center starts-->
<TABLE cellSpacing=0 cellPadding=1 width=527 border=0>
  <TR>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  	<TD width=477 height=40 class=head></TD>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD valign=top width=445 class=body><P><B>You can broadcast a mail to all XMECians that using XMEC Broadcast Mailer. <font color=red>Please do definite the target group to which you wish to send the mail using the query option. Please use with care as XMECians are sensitive to SPAM</font>
  	</B></font></P>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">
<tr>
<td align="center">
</td>
</tr>
<tr><Td>
<?php
 $day = date ("m-d");
?>
</td>
<TD width=225 class=name>Date</td><td> <input name="day" value=<?=$day?>  value class=lbox>
</td>
</tr>
<tr>
<TD width=225></td>
<td class=name>
<input type=submit name="submit" value="SUBMIT">
</td>
</tr>
</table>
</form>
</TD>
  </TR>
</TABLE>
<!--center ends-->
</TD>
<TD vAlign=top width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_topb.gif" width=3></TD>
</TR>
<TR>
<TD vAlign=bottom width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_bottomb.gif" width=3></TD>
<TD vAlign=bottom width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_bottomb.gif" width=3></TD>
</TR>
<TR>
<TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
<TD align=left background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_left_bottomt.gif" width=8></TD>
<TD align=right background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_right_bottomt.gif" width=8></TD>
<TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
</TR>
</TBODY>
</TABLE>
<!--Box Ends-->
</TD></TR>
</TABLE>
</body>
</html>

<?php else:

  $to = $_POST['to'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $country = $_POST['country'];

   $x = 1;
   $hold = 10; // quantity of emails sent before 3 sec delay
   $value = " '%".$day."%' ;";
   $query = "SELECT id,date_of_birth,personal_email,official_email,concat(first_name,' ',middle_name,' ',last_name) as name FROM xmec_user where date_of_birth like ".$value;
   $aowmail = mysql_query("$query");
   while ($countmail = mysql_fetch_array($aowmail,MYSQL_ASSOC)) {
   $name = $countmail["name"];
   $roll = $countmail["id"];
   $to_whom = $name." <".$countmail["personal_email"].">";
   $cc_id = $name." <".$countmail["official_email"].">";
   $subject = "Greetings from XMEC.net";
   $from = htmlentities($me->get('first_name'))." ".htmlentities($me->get('last_name'));
   $from_id = htmlentities($me->get('personal_email'));
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
<html>
<head>
</head>
<body>
</body>
</html>
<?php endif; ?>
<?php
include 'footer.php';
?>
