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
		<TD width=90% height=40 class=head><B>XMEC Broadcast Mailer</B></TD>
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
  	<TD valign=top width=445 class=body><P><B>You can broadcast a mail to all XMECians that using XMEC Broadcast Mailer. You can define the Target Group to which you wish to send the mail using the query option. Please use the Broadcast to XMEC and Batches with care as XMECians are sensitive to SPAM. <font color=red><BR>When you press the Submit button no additional level confirmation or verification is done, mails will be sent instantaneously.</font>
  	</B></font></P>
<script Language="JavaScript" src="jslibxmec.js">
</script>
<script language="javascript">
function check()
{
  if (false == validate())
  {
	alert("Validate is False ");
   }
   else {
   	   	document.broadcast.action = "<?=$_SERVER['PHP_SELF']?>";
		document.broadcast.method = "post";
		document.broadcast.submit();
	}
	//return false;

 }
function validate()
{
			if (document.broadcast.to.value == ""){
			alert("Please select the Broadcast option that you wish to use");
			return false;
			}
		if ((document.broadcast.to.value == "aow") && (document.broadcast.data.value == "")){
				alert("Please enter a valid data to query ");
				return false;
			}
			if (document.broadcast.to_address.value == "" && document.broadcast.to_address.value == ""){
				alert("Please either the To or Cc Address to which mails to be sent ");
				return false;
			}
			if (document.broadcast.subject.value == ""){
		  alert("Please enter the Subject of the Mail to be posted");
		  return false;
		  	}
		  if (document.broadcast.message.value == ""){
		    alert("Please enter the Message to be posted");
		    return false;
		 	 }
			
			if (document.broadcast.to.value == "notall" && document.broadcast.batch.value == ""){
			alert("Please select the Batch to which you wish to send");
			return false;
			}
		return true;
}
</script>
<form name="broadcast">
<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">
<tr>
<td align="center">
</td>
</tr>
<tr>
<TD width=225 class=name><strong>Broadcast Option</strong></td>
<td>
<select name="to" class=cbox style="HEIGHT: 19px; WIDTH: 144px">
<option value="all">Entire XMEC</OPTION>
<option value="notall">By Batch</OPTION>
<option value="aow">Query</OPTION>
<option selected value="">None</OPTION>
</select>
</td>
</tr>
<tr>
<TD width=225 class=body>Batch:</td>
<td>
<select name="batch" class=cbox style="HEIGHT: 19px; WIDTH: 144px">
<OPTION selected value="">None</OPTION>
<OPTION value="1989">Batch 1 (1989~93)</OPTION>
<OPTION value="1990">Batch 2 (1990~94)</OPTION>
<OPTION value="1991">Batch 3 (1991~95)</OPTION>
<OPTION value="1992">Batch 4 (1992~96)</OPTION>
<OPTION value="1993">Batch 5 (1993~97)</OPTION>
<OPTION value="1994">Batch 6 (1994~98)</OPTION>
<OPTION value="1995">Batch 7 (1995~99)</OPTION>
<OPTION value="1996">Batch 8 (1996~2000)</OPTION>
<OPTION value="1997">Batch 9 (1997~2001)</OPTION>
<OPTION value="1998">Batch 10 (1998~2002)</OPTION>
<OPTION value="1999">Batch 11 (1999~2003)</OPTION>
<OPTION value="2000">Batch 12 (2000~2004)</OPTION>
</select>
</td>
</tr>
<TR>
<TD class=name width=225><STRONG>Query Condition</STRONG></TD>
<TD class=name><P><select name="condition" class=cbox>
<option selected value="id = ">Roll Number</OPTION>
<option value="work_type =">Work Type</OPTION>
<option value="company =">Company</OPTION>
</select> equals <INPUT name=data class=lbox style="HEIGHT: 19px; WIDTH: 70px"></P>
</TD>
</TR>
<tr>
<TD width=225 class=name>To:</td>
<td> <select name="to_address" class=cbox style="HEIGHT: 19px; WIDTH: 144px">
<option selected value="">None</OPTION>
<option value="pemail">Personal Email</OPTION>
</select>
</td>
</tr>
<tr>
<TD width=225 class=name>Cc:</td>
<td> <select name="cc_address" class=cbox style="HEIGHT: 19px; WIDTH: 144px">
<option selected value="">None</OPTION>
<option value="ofemail">Official Email</OPTION>
</select>
</td>
</tr>
<tr>
<TD width=225 class=name>Bcc:</td><td> <input name="bcc" class=lbox>
</td>
</tr>
<tr>
<TD width=225 class=name>Title or Subject:</td><td> <input name="subject" class=lbox>
</td>
</tr>
<tr>
<TD width=225 class=name>Message:</td>
<td>
<textarea wrap name="message" rows=10 cols=45 class=tbox></textarea>
</td>
</tr>
<tr>
<TD width=225></td>
<td class=name>
<input type=submit name="submit" value="SUBMIT" onClick="javascript:check()">
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

  if ("all" == $to) {
   $x = 1;
      $hold = 10; // quantity of emails sent before 3 sec delay
      $query = "SELECT id,personal_email,official_email,concat(first_name,' ',middle_name,' ',last_name) as name FROM xmec_user ";
      $aowmail = mysql_query("$query");
      while ($countmail = mysql_fetch_array($aowmail,MYSQL_ASSOC)) {
      $name = $countmail["name"];
      $roll = $countmail["id"];
      if ($to_address == "pemail") {
      $to_whom = $name." <".$countmail["personal_email"].">";
      }
      if ($cc_address == "ofemail") {
      $cc_id = $name." <".$countmail["official_email"].">";
      }
      $messagex = "Dear $name "."[Login ID : $roll ]\n\n"."$message\n\n"."This Message was sent from the XMEC Alumni site (www.xmec.net). Please contact webmasters@xmec.net if this mail has reached you in error or if you have any other concerns.";
	  echo "Mail sent to :[ $roll ] $name \n";
      //mail($to_whom , $subject ,$messagex , "From:XMEC Webmasters <webmasters@xmec.net>\r\n"."Cc:{$cc_id}\r\n"."Bcc:{$bcc}\r\n");
      $x++;
       if($x == $hold) { // When $x is equal to $hold, a 3 sec delay will occur avoiding php to timeout
       sleep(3);
       $x = 0;
    }
   } // end of while loop
  } else if ("aow" == $to){

   $x = 1;
   $hold = 10; // quantity of emails sent before 3 sec delay
   $value = " '".$data."' ;";
   $query = "SELECT id,personal_email,official_email,concat(first_name,' ',middle_name,' ',last_name) as name FROM xmec_user where ".$condition.$value;
   $aowmail = mysql_query("$query");
   while ($countmail = mysql_fetch_array($aowmail,MYSQL_ASSOC)) {
   $name = $countmail["name"];
   $roll = $countmail["id"];
   if ($to_address == "pemail") {
   $to_whom = $name." <".$countmail["personal_email"].">";
   }
   if ($cc_address == "ofemail") {
   $cc_id = $name." <".$countmail["official_email"].">";
   }
   $messagex = "Dear $name "."[Login ID : $roll ]\n\n"."$message\n\n"."This Message was sent from the XMEC Alumni site (www.xmec.net). Please contact webmasters@xmec.net if this mail has reached you in error or if you have any other concerns.";
   //mail($to_whom , $subject ,$messagex , "From:XMEC Webmasters <webmasters@xmec.net>\r\n"."Cc:{$cc_id}\r\n"."Bcc:{$bcc}\r\n");
	echo "Mail sent to :[ $roll ] $name \n";
   $x++;
    if($x == $hold) { // When $x is equal to $hold, a 3 sec delay will occur avoiding php to timeout
    sleep(3);
    $x = 0;
    }
   } // end of while loop
  } else if ("notall" == $to){

   $x = 1;
   $hold = 10; // quantity of emails sent before 3 sec delay
   $value = " '%".$batch."%' ;";
   $query = "SELECT id,personal_email,official_email,concat(first_name,' ',middle_name,' ',last_name) as name FROM xmec_user where id like ".$value;
   $aowmail = mysql_query("$query");
   while ($countmail = mysql_fetch_array($aowmail,MYSQL_ASSOC)) {
   $name = $countmail["name"];
   $roll = $countmail["id"];
   if ($to_address == "pemail") {
   $to_whom = $name." <".$countmail["personal_email"].">";
   }
   if ($cc_address == "ofemail") {
   $cc_id = $name." <".$countmail["official_email"].">";
   }
   $messagex = "Dear $name "."[Login ID : $roll ]\n\n"."$message\n\n"."This Message was sent from the XMEC Alumni site (www.xmec.net). Please contact webmasters@xmec.net if this mail has reached you in error or if you have any other concerns.";
   //mail($to_whom , $subject ,$messagex , "From:XMEC Webmasters <webmasters@xmec.net>\r\n"."Cc:{$cc_id}\r\n"."Bcc:{$bcc}\r\n");
	echo "Mail sent to :[ $roll ] $name \r\n";
   $x++;
    if($x == $hold) { // When $x is equal to $hold, a 3 sec delay will occur avoiding php to timeout
    sleep(3);
    $x = 0;
    }
   } // end of while loop
  }
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
