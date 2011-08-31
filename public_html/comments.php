<?php
$secure_page=0;
include 'header.php';
$user = XMEC::getUser();
?>
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
		<TD width=6%><BR></TD>
		<TD width=90% height=40 class=head><B>Mail to XMEC Webmasters</B></TD>
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
  	<TD valign=top width=445 class=body><P><B>Send us your comments, suggestions and any problems you may have encountered. The XMEC Webmasters will to look into the same and will get back to you the earliest. Please allow three to four days for the respective person (team) to respond to your mail.You may also choose to send a personal mail to <A href="mailto:moderator@xmec.net?subject=[xmec.net] Comments" class=flink>XMEC Moderator</A>.</B></font></P>
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

	if (document.comments.Yname.value == ""){
		alert("Please record your Name ");
		return false;
	}
	if(!CheckEmailStr(document.comments.email.value )){
//	alert("Please verify Personel Email");
	return false;
	}
	if (document.comments.Category.value == ""){
  alert("Please select the nature of the Mail to be posted");
  return false;
  }

	if (document.comments.NewsDetail.value == ""){
	alert("Please compose mail you wish to send");
	return false;
	}

		return true;
	}

</script>
<form name="comments" method="post"
action="/server-scripts/formmail/FormMail.pl">
<input type=hidden name="recipient" value="webmasters@xmec.addr.com">
<INPUT TYPE=hidden NAME="subject" VALUE="[xmec.net] Comments">
<input type=hidden name="redirect" value="http://www.xmec.net/thankyou.php">
<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">

<INPUT type=hidden NAME="Rollno" value="<?php echo $user->id; ?>" class=box>
<TR>
<TD width=125 class=name><STRONG>Name</STRONG></TD>
<TD width=300><INPUT NAME="Yname"  value="<?php echo $user->first_name ?> <?php echo $user->last_name ?>" class=lbox>
</TD></TR>
<TR>
<TD width=125 class=name><STRONG>Email ID</STRONG></TD>
<TD width=300><INPUT NAME="email"  value="<?php echo $user->personal_email ?>" class=lbox>
</TD></TR>
<TR>
<TD width=125 class=name><B>Category</B></TD>
<TD width=300><SELECT NAME="Category" class=cbox style="width:144px" >
<OPTION value="" selected>Select One</OPTION>
<OPTION value="Comment">Comment</OPTION>
<OPTION value="Suggestion">Suggestion</OPTION>
<OPTION value="Problems">Site Problems</OPTION>
<OPTION value="Others">Others</OPTION>

</SELECT></TD>
</TR>

<TR>
<TD width=125 class=name><STRONG>Message</STRONG></TD>
<TD width=300><TEXTAREA cols=35 name=NewsDetail rows=10 wrap=virtual class=tbox></TEXTAREA></TD></TR>
<TR>
<TD align=left>
<A href="javascript:history.back();"><img src="images/back.gif" border=0></A>
</TD>
<TD align=middle>
<INPUT TYPE="button" NAME="sendit" VALUE="Send" onClick="javascript:check()">
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

