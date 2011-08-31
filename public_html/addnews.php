<?php
$secure_page=1;
include 'header.php';
$user = XMEC::getUser();
?>
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
		<TD width=6%><BR></TD>
		<TD width=90% height=40 class=head><B>Add News or Activity to Site</B></TD>
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
<TABLE cellSpacing=0 cellPadding=1 width=527 border=0>
  <TR>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  	<TD width=477 height=40 class=head></TD>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD valign=top width=445 class=body><P><BR><BR><strong>XMECians can post suitable News items or Activity in the site. The item will be added to the appropriate page on approval of the XMEC Moderator and Webmasters. MEC students and faculty can use the Placement cell access to use this facility.  </strong><BR><BR></P>
<script Language="JavaScript" src="jslibxmec.js">
</script>
<script language="javascript">

function check()
{

  if (false == validate())
  {

   }
   else
   document.addnews.submit();

 }
function validate()
{

	if (document.addnews.Rollno.value == ""){
	alert("You are not a valid XMEC Member ");
	return false;
	}
	if(!CheckEmailStr(document.addnews.send.value )){
//	alert("Please verify Personel Email");
	return false;
	}
	if (document.addnews.subject.value == ""){
  alert("Please select if the news item pertains to XMEC or MEC or if it is a new activity/announcement");
  return false;
  }

	if (document.addnews.news.value == ""){
  alert("Please compose the News / Activity Headline you wish to add");
  return false;
  }
	if (document.addnews.NewsDetail.value == ""){
	alert("Please record details of the News item/ Activity you wish to add");
	return false;
	}
	document.addnews.sender.value = document.addnews.details.value+"<"+document.addnews.send.value+">";

	document.addnews.message.value = document.addnews.news.value+"\n-------------------\n"+document.addnews.NewsDetail.value ;
	alert (document.addnews.message.value);
		return true;
	}

</script>
<form name="addnews" method="post" action="mail.php">
<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">

<INPUT type=hidden NAME="Rollno" value="<?php echo $user->id; ?>" class=box>
<TR>
<TD width=150 class=body><STRONG>Name</STRONG></TD>
<TD width=300 class=body><?php echo $user->first_name ?> <?php echo $user->last_name ?>
</TD></TR>
<TR>
<TD width=150 class=name><STRONG>Email ID</STRONG></TD>
<TD width=300><INPUT NAME="send"  value="<?php echo $user->personal_email ?>" class=lbox>
</TD></TR>
<TR>
<TD width=150 class=name><B>Category</B></TD>
<TD width=300><SELECT NAME="subject" class=cbox style="width:144px" >
<OPTION value="" selected>Select One</OPTION>
<OPTION value="[xmec.net] Add XMEC News">XMEC News </OPTION>
<OPTION value="[xmec.net] Add MEC News">College News</OPTION>
<OPTION value="[xmec.net] Add College Activity">Actvity in College</OPTION>
<OPTION value="[xmec.net] Add XMEC Activity">Actvity in XMEC</OPTION>

</SELECT></TD>
</TR>

<TR>
<TD width=300><INPUT type=hidden NAME="recipient" value="robi_thomas@mindtree.com" ></TD>
<TD width=300><INPUT type=hidden NAME="message" value="" ></TD>
<TD width=300><INPUT type=hidden NAME="sender" value="" ></TD>
<TD width=300><INPUT type=hidden NAME="details" value="<?php echo $user->first_name ?> <?php echo $user->last_name ?> <?php echo $user->id; ?>" >
</TD></TR>
<TR>
<TD width=150 class=name><B>Headline</B></TD>
<TD width=300><INPUT NAME="news"  class=lbox style=width:400px>
</TD></TR>
<TR>
<TD width=150 class=name><STRONG>Detailed Text</STRONG></TD>
<TD width=300><TEXTAREA cols=35 name=NewsDetail rows=10 wrap=virtual class=tbox style=width:400px></TEXTAREA></TD></TR>

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

