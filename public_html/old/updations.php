<?php
	include 'common.php';
	$auth = XMEC::authenticate_user();
	$user =& XMEC::getUser();
	if(!$user->isAdmin()) {
		echo '<h2>Not Authorized !</h2>';
		exit ;
	}
?>	

<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft Visual Studio 6.0">
<TITLE></TITLE>
<LINK href="style.css" type="text/css" rel="Stylesheet">
</HEAD>
<BODY bgcolor="#ffffff">

<P>
<?php
	$wrk =& XMEC::get_update_list();
	echo "<b>Total entries: ". sizeof($wrk) . "</b><br>";
	for ($i = 0; $i < sizeof($wrk); $i++)
	echo $wrk[$i] . "<br>";
?>
</BODY>
</HTML>
