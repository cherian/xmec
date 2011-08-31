<?php   
        include 'common.php';
        if (! XMEC::authenticate_user()) {
                echo "<html><h2>Please login to access this page<html>";
                exit ;
        }
	chdir('poll/polls');
?>
<HTML>
<HEAD>
<LINK rel=stylesheet href="style.css" type="text/css">
</HEAD>
<BODY bgcolor="#ffffff" topmargin=0 leftmargin=0 marginheight = "0" marginwidth = "0">
<TABLE class=body align=left border=0 cellPadding=0 cellSpacing=0 width="615" height="100%">
<TR>
<TD valign=top width=445><IMG src="/images/head_polls.gif"><BR>

<P><b>Poll - General</b></P>
<P>Model Engineering College is one of the few colleges in Kerala that can boast of a dedicated 256 kbps Leased Line Internet Connectivity. The college has been allotted a domain namely mec.ac.in. The college is in the process of establishing Mail servers for students and faculty alike.</P>

<?php
if (empty($view)) {
	require_once('phpPollConfig.php3');
	require_once('phpPollUI.php3');
	poll_generateUI(4, "/polls.php?view=1");
} 
?>

</TD>
<TD width=170 valign=top align=middle><BR><BR><BR><IMG src="/images/polls.jpg"><BR></TD>
</TR>

<?php if (!empty($view)): ?>
<TR>
<TD width=170 valign=top align=left>
<p><b>Poll Results...</b><br>
<? 
require_once('phpPollConfig.php3');
require_once('phpPollUI.php3');
poll_viewResults(3);
?>
</TD>
</TR>
<?php endif; ?>
<tr>
<td colspan=2>
<p>Previous poll results:</p>
<P><STRONG>Have you ever visited </STRONG><A href="http://www.mec.ac.in" class=xmec> www.mec.ac.in </A><STRONG>, the official site for Model Engineering College, Kochi ?</STRONG></P>
<? 
require_once('phpPollConfig.php3');
require_once('phpPollUI.php3');
poll_viewResults(3);
?>
</td>
</tr>
<TR>
<TD colspan=2>
      <TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="100%">
        
        <TR>
          <TD align=middle height=30 valign=top><A href="members.php"><font face=arial size=-1 color="#669999">Members</font></A> || <A href="disc.htm"><font face=arial size=-1 color="#669999">Disclaimer</font></A> || <A href="sitemap.htm"><font face=arial size=-1 color="#669999">Sitemap</font></A> || <A href="mailto:moderator@xmec.net"><font face=arial size=-1 color="#669999">Comments</font></A></TD>
        </TR>
        <TR>
			<TD align=middle height=30 valign=bottom><font face=arial size=-1 color="#999999">Site Powered by &nbsp;<A href="http://www.marlabs.com"><IMG align=absMiddle border=0 src="/images/marlabs.jpg"></A> &nbsp;© Copyright 2001</font></TD>
		</TR>
      </TABLE>
</TD></TR>
</TABLE> 
</form>
</BODY>
</HTML>
