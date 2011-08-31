<?php
$secure_page=1;
include 'header.php';
$user = XMEC::getUser();
?>
<!--center starts-->
<TABLE cellSpacing=0 cellPadding=1 width=527 border=0>
  <TR>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  	<TD width=477 height=40 class=head><B>Add a News Item >></B> </TD>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD valign=top width=445 class=body><BR><BR><strong>XMECians can post suitable News items or Activity in the site. The item will be added to the appropriate page on approval of the XMEC Moderator and Webmasters. MEC students and faculty can use the Placement cell access to use this facility.  </strong>
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
	alert("Please record your College Roll Number ");
	return false;
	}
	if(!CheckEmailStr(document.addnews.email.value )){
//	alert("Please verify Personel Email");
	return false;
	}
	if (document.addnews.NewsCategory.value == ""){
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
	
		return true;
	}

</script>
<form name="addnews" method="post"
action="/server-scripts/formmail/FormMail.pl">
<input type=hidden name="recipient" value="webmasters@xmec.addr.com">
<INPUT TYPE=hidden NAME="subject" VALUE="[xmec.net] Add News Item or Activity">
<input type=hidden name="redirect" value="http://www.xmec.net/thankyou.php">
<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">
      
<INPUT type=hidden NAME="Rollno" value="<?php echo $user->id; ?>" class=box>
<TR>
<TD width=125 class=body><STRONG>Email ID</STRONG></TD>
<TD width=300><INPUT NAME="email"  value="<?php echo $user->personal_email ?>" class=lbox>
</TD></TR>
<TR>
<TD width=125 class=body><B>Category</B></TD>
<TD width=300><SELECT NAME="NewsCategory" class=cbox style="width:144px" >
<OPTION value="" selected>Select One</OPTION>
<OPTION value="xmec_news">XMEC News </OPTION>
<OPTION value="mec_news">College News</OPTION>
<OPTION value="college_activity">Actvity in College</OPTION>
<OPTION value="xmec_activity">Actvity in XMEC</OPTION>

</SELECT></TD>
</TR>

<TR>
<TD width=125 class=body><STRONG>Headline</STRONG></TD>
<TD width=300><INPUT NAME="news"  class=lbox style=width:400px>
</TD></TR>

<TR>
<TD width=125 class=body><STRONG>Detailed Text</STRONG></TD>
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
<?php
include 'footer.php';
?>

