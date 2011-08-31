<?php
$secure_page=1;
include 'header.php';
$user = XMEC::getUser();
?>
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
		<TD width=6%><BR></TD>
		<TD width=90% height=40 class=head><B>XMEC Calendar >></B>Add a Calendar Event</TD>
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
  	<TD valign=top width=445 class=body><P><BR><BR><B>XMECians can add Events that need to be displayed on the <A href="calendar.php" class=flink>XMEC Calendar</A>. The Event will be added to the Calendar on approval of the XMEC Moderator and Webmasters. Marriage Invitations and other events posted in the XMEC Mailing List will be listed in the XMEC Calendar.<BR> <font color=red>XMEC Executive Committee and Chapters uses this Calendar to decide dates for XMEC Get togethers, Chapter Meetings etc.</B></font></P>
<script Language="JavaScript" src="jslibxmec.js">
</script>
<script language="javascript">

function check()
{

  if (false == validate())
  {

   }
   else
   document.addevent.submit();

 }
function validate()
{

	if (document.addevent.Rollno.value == ""){
	alert("Please record your College Roll Number ");
	return false;
	}
	if (document.addevent.name.value == ""){
		alert("Please record your College Roll Number ");
		return false;
	}
	if(!CheckEmailStr(document.addevent.email.value )){
//	alert("Please verify Personel Email");
	return false;
	}
	if (document.addevent.NewsCategory.value == ""){
  alert("Please select the nature of the Event to be posted");
  return false;
  }

	if((document.addevent.Doe.value == "" ) ||((false == CheckDate(document.addevent.Doe.value))) || ((IsDateGreaterToday(document.addevent.Doe.value)))){
				alert("Please Enter the correct Event Date. Use dd/mm/yyyy format");
				return false;
		}
	if (document.addevent.NewsDetail.value == ""){
	alert("Please record details of the Event you wish to add");
	return false;
	}

		return true;
	}

</script>
<form name="addevent" method="post"
action="/server-scripts/formmail/FormMail.pl">
<input type=hidden name="recipient" value="webmasters@xmec.addr.com">
<INPUT TYPE=hidden NAME="subject" VALUE="[xmec.net] Add Calendar Event">
<input type=hidden name="redirect" value="http://www.xmec.net/thankyou.php">
<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">

<INPUT type=hidden NAME="Rollno" value="<?php echo $user->id; ?>" class=box>
<TR>
<TD width=125 class=name><STRONG>Name</STRONG></TD>
<TD width=300><INPUT NAME="name"  value="<?php echo $user->first_name ?> <?php echo $user->last_name ?>" class=lbox>
</TD></TR>
<TR>
<TD width=125 class=name><STRONG>Email ID</STRONG></TD>
<TD width=300><INPUT NAME="email"  value="<?php echo $user->personal_email ?>" class=lbox>
</TD></TR>
<TR>
<TD width=125 class=name><B>Category</B></TD>
<TD width=300><SELECT NAME="NewsCategory" class=cbox style="width:144px" >
<OPTION value="" selected>Select One</OPTION>
<OPTION value="XMEC_event">XMEC Event</OPTION>
<OPTION value="Marriage_invite">Marriage Invitation</OPTION>
<OPTION value="College_activity">Actvity in College</OPTION>
<OPTION value="Holiday">Holiday Reminder</OPTION>
<OPTION value="Other Events">Other Event</OPTION>

</SELECT></TD>
</TR>

<TR>
<TD width=40% class=name><STRONG>Event Date</STRONG></TD>
<TD width=100><INPUT name=Doe size=30 class=lbox></TD>
<TD width=200 class=body><I>[dd/mm/yyyy]</I></TD>
</TR>

<TR>
<TD width=125 class=name><STRONG>Event Details</STRONG></TD>
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

