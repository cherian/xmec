<?php
	include 'header.php';
	$auth = XMEC::authenticate_user();
	$user =& XMEC::getUser();
	if(!$user->isAdmin()) {
		echo '<BR><BR><H2><CENTER>You Are Not Authorized !</CENTER></H2>';
	include 'footer.php';
	exit ;
	}
?>	
<BR><BR>
<UL>
<LI><A HREF="/statistics.php" class=link>Site Statistics</A>
<LI><A HREF="/updations.php" class=link>Profile Updations</A>
<LI><A HREF="/polls.php?action=poll_admin" class=link>Poll Admin</A>
<LI><A HREF="/caladmin.php" class=link>Calendar Admin</A>
</UL>
<?php
include 'footer.php';
?>
