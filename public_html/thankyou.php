<?php
$secure_page=0;
include 'header.php';
$user = XMEC::getUser();
?>
<TABLE BGCOLOR="white" align=left border=0 cellPadding=0 cellSpacing=0 width="615" height="100%">
<TR>
<TD valign=center align=center width=615 class=head><img src="images/thanks.jpg"><P><B><?php echo $user->first_name ?> <?php echo $user->last_name ?></B><BR>
Your request has been sent. Please feel free to contact us in case you do not receive feedback within a weeks time from today.<BR><a href="mailto:webmasters@xmec.net" class=flink>Webmasters XMEC</A></P>

</TD>
<TR>
<TD align=center>
<A href="javascript:history.back();"><img src="images/back.gif" border=0></A>
</TD></TR>
</TR></TABLE>

<?php
include 'footer.php';
?>