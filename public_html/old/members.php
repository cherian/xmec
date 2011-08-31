<?php
	include 'common.php';
	if (! XMEC::authenticate_user()) {
		echo "<html><h2>Please login to access this page<html>";
		exit ;
	}
?>

<HTML>
<HEAD>
<LINK rel=stylesheet href="style.css" type="text/css">
<SCRIPT LANGUAGE=javascript>
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',noresizable'
win = window.open(mypage,myname,settings)
if(win.window.focus){win.window.focus();}
}
</SCRIPT>
	
</HEAD>
<BODY bgcolor="#FFFFFF" topmargin=0 leftmargin=0 marginheight = "0" marginwidth = "0" >
<TABLE align=left border=0 cellPadding=0 cellSpacing=0 width="615" height=100%>
<TR>
<TD valign=top width=445 align=middle>
<TABLE border=0 cellPadding=0 cellSpacing=0 width="400" height="400">
<TR><TD align=center><A href="editprofile.php"><IMG alt="" src="images/profile6.jpg" border=0></A></TD>
	<TD align=center><A href="phorum/index.php"><IMG alt=Bulletin Boards" src="images/bulletin.jpg" border=0></A></TD>
</TR>
<TR><TD align=center><A href="statistics.html"><IMG alt="" src="images/stats.jpg" border=0></A></TD>
	<TD align=center><A href="preferences.php"><IMG alt="" src="images/preferences.jpg" border=0></A></TD>
</TR>
<TR><TD align=center><IMG alt="We are working on it..." src="images/career.jpg" border=0></TD>
	<TD align=center><IMG alt="We are working on it..." src="images/chat3.jpg" border=0></TD>
</TR>
<TR><TD align=center><A href="accounts.html"><IMG alt="XMEC Accounts" src="images/cash.jpg" border=0></A></TD>
	<TD align=center><A href="polls.php"><IMG alt="Polls" src="images/polls.jpg" border=0></A></TD>
</TR>
</TABLE><BR><BR>
<TD width=170 valign=top align=center><img src="images/logina.gif"><BR><BR>
<a href="xmecians.pdf" class=slink onclick="NewWindow(this.href,'reports','800','600','yes');return false">XMEC Presentation to NBA</A><BR><BR>
<a href="bylaw.html"><img src="images/bylaw.gif" border=0></A><BR>Alumni Bylaw<BR>
<a href="announce.html" onclick="NewWindow(this.href,'reports','600','500','yes');return false"><img src="images/announce.gif" border=0></A><BR><BR>
<a href="credits.html" onclick="NewWindow(this.href,'reports','600','500','yes');return false"><img src="images/credits.gif" border=0></A>
</TD>
</TR>
<TR>
<TD colspan=2>
      <TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TR>
          <TD align=center height=30 valign=top><A href="disc.htm"><font face=arial size=-1 color="#669999">Disclaimer</font></A> || <A href="sitemap.htm"><font face=arial size=-1 color="#669999">Sitemap</font></A> || <A href="mailto:moderator@xmec.net"><font face=arial size=-1 color="#669999">Comments</font></A></TD>
        </TR>
        <TR>
			<TD align=center height=30 valign=bottom><font face=arial size=-1 color="#669999">Copyright C 2001</font> </TD>
		</TR>
      </TABLE>
</TD></TR>
</TABLE> 

</BODY>
</HTML>
