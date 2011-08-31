<?php
$secure_page=1;
include 'header.php';
$user = XMEC::getUser();
?>
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
		<TD width=6%><BR></TD>
		<TD width=90% height=40 class=head><B>XMEC Mail</B></TD>
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
  	<TD valign=top width=445 class=body><P><B>You can send a mail to an XMECian using XMECMail. <font color=red>Please do not send offensive or unsolicited mail. The XMEC Moderator will take appropriate action in such unfornuate circumstances</font>
  	</B></font></P>
<script Language="JavaScript" src="jslibxmec.js">
</script>
<script language="javascript">

function check()
{

  if (false == validate())
  {

   }
   else
   document.comments.submit();

 }
function validate()
{

	if (document.XMECMail.subject.value == ""){
		alert("Please record the subject of Mail");
		return false;
	}
	if(!CheckEmailStr(document.XMECMail.recipient.value )){
//	alert("Please verify Email to send to ");
	return false;
	}

	if (document.XMECMail.message.value == ""){
	alert("Please compose mail you wish to send");
	return false;
	}

		return true;
	}

</script>
<form name="XMECMail" method="post"action="mail.php">
<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">

<INPUT type=hidden NAME="Rollno" value="<?php echo $user->id; ?>" class=box>

<TR>
<TD width=125 class=name>From</TD>
<TD width=300><?php echo $user->first_name ?> <?php echo $user->last_name ?> <INPUT type=hidden NAME="sender"  value="<?php echo $user->personal_email ?>" class=lbox>
</TD></TR>
<TR>
<TD width=125 class=name>To</TD>
<TD width=300><INPUT NAME="recipient" class=lbox>
</TD></TR>
<TR>
<TR>
<TD width=125 class=name>Subject</TD>
<TD width=300><INPUT NAME="subject" class=lbox>
</TD></TR>
<TR>
<TD width=125 class=name><STRONG>Message</STRONG></TD>
<TD width=300><TEXTAREA cols=35 name=message rows=10 wrap=virtual class=tbox></TEXTAREA></TD></TR>
<TR>
<TD align=left>
<A href="javascript:history.back();"><img src="images/back.gif" border=0></A>
</TD>
<TD align=middle>
<input type="submit" name="Submit" value="Submit">
</TD>
</TR>
</TABLE> </FORM>
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
<?php
include 'footer.php';
?>

