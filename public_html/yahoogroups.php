<?php
$secure_page=1;
$this_page="yahoo";
$no_search_menu = 1;
include 'header.php';
?>
<HTML>
<HEAD>
<LINK rel=stylesheet href="style.css" type="text/css">
</HEAD>
<BODY topmargin=0 leftmargin=0 marginheight = "0" marginwidth = "0" bgcolor="#ffffff">

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
<!--Content Starts-->
<TABLE BGCOLOR="white" align=left border=0 cellPadding=0 cellSpacing=0 width="625" height="100%">
<TR>
<TD valign=top width=620><BR><BR>
<font face=arial size=2 color="#FF0000"><P><strong>XMEC Yahoo Groups Subscription</strong></P><P>You can modify your preferences with regard to the Email Account in which you wish to receive mails from the Alumni YahooGroups <a href="mailto:xmec@yahoogroups.com" class=xmec>xmec@yahoogroups.com</a>. Please ignore this section if you do not wish to modify your existing preference</P></font>
<script Language="JavaScript" src="jslibxmec.js">
</script>
<script language="javascript">

function check()
{

  if (false == validate())
  {

   }
   else{
   if(document.yahoo.email_new.value != ""){
   document.yahoo.submit();
   }
   }

 }
function validate()
{
	if(document.yahoo.email_old.value != ""){
	if(!CheckEmailStr(document.yahoo.email_old.value )){
	alert("Please verify Email to unsubscribe from XMEC Yahoo Groups");
	return false;
	}
	}
	if((document.yahoo.email_new.value != "")	|| (document.yahoo.email_old.value != "")){
		if(!CheckEmailStr(document.yahoo.email_new.value )){
	alert("Please verify Email to subscribe to XMEC Yahoo Groups");
	return false;
	}
	}
			return true;
	}

</script>
<form name="yahoo" method="post"
action="/server-scripts/formmail/FormMail.pl">
<input type=hidden name="recipient" value="moderator@xmec.addr.com">
<INPUT TYPE=hidden NAME="subject" VALUE="[xmec.net] Yahoogroups Subscription">
<INPUT TYPE=hidden NAME="email" VALUE="email_new">
<INPUT TYPE="hidden" NAME="redirect" VALUE="http://www.xmec.net/thankyou.php">
<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="619">
<TR>
<TD width=331 class=body><B>Please unsubscribe my current Email ID</B></TD>
<TD width=64><INPUT NAME="email_old" class=lbox>
</TD></TR>
<TR>
<TD width=331 class=body><B>Please send all further XMEC YahooGroups Mails to</B></TD>
<TD width=64><INPUT NAME="email_new" class=lbox> </FONT>
</TD></TR>
<TR>
<TD align=left width="331">
<A href="javascript:history.back();"><img src="images/back.gif" border=0></A>
</TD>
<TD align=middle width="264">
<INPUT TYPE="button" NAME="sendit" VALUE="Send" onClick="javascript:check()">
</TD>
</TR>
</TABLE> </FORM>
</TD>
<TD width=2 valign=top align=middle><BR><BR><BR><BR></TD>
<TR>
<TD colspan=2 width="623">
      <TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TR>
          <TD align=middle height=30 valign=top></TD>
        </TR>

      </TABLE>
</TD></TR>
</TABLE>
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
</BODY>
</HTML>
<?php
include 'footer.php';
?>

