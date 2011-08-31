<?php

	include 'xmec.inc';
	if (! XMEC::authenticate_user()) {
		echo "<html><h1>Please login to access this page<html>";
		exit ;
	}

	$me =& XMEC::getUser();

	if (!$me->isAdmin()) {
		echo "<html><h1>Not authorized !!</html>";
		exit ;
	}

	reset($HTTP_POST_VARS);

	$action = chop($HTTP_POST_VARS["todo"]);
	if ($REQUEST_METHOD == "GET")
		$action = chop($HTTP_GET_VARS["todo"]);

	$sql = chop($HTTP_POST_VARS["sql"]);
	if ($REQUEST_METHOD == "GET")
		$sql = chop($HTTP_GET_VARS["sql"]);
?>


<HTML>
<HEAD>
<LINK rel=stylesheet href="style.css" type="text/css">
</HEAD>
<BODY topmargin=0 leftmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<Form name="Fcr" method=post action=<?=$PHP_SELF?>>
<input type=hidden name=todo value=run>
<p>
<textarea name=sql cols=60 rows=6></textarea>
<br><input type=submit value="Run Query">
</FORM>
<hr>
<?
if (isset($sql) && isset($action ) && $action =="run" ){
	$dbh =& XMEC::getDB();
	if (DB::isManip($sql)) {
		echo "No manipulation queries please !";
	} else {
		$r = $dbh->query(XMEC_user::unQuote($sql));
		if (DB::isError($r)) {
			echo "Query: $sql failed.";
		} else {
			echo "<table border=1>";
			while (is_array($x = $r->fetchRow())) {
			  echo "<tr>";
			  for ($i=0; $i<count($x); $i++) echo "<td>$x[$i]</td>";
			  echo "</tr>";
			}
			echo "</table>";
		}
	}
}
?>

</BODY>
</HTML>
