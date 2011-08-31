<?php
$secure_page=1;
include 'header.php';
?>
<?php
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
<P></P>

<p>
<SELECT name=sqlbox class=cbox style="width:144px">

<OPTION value="">Enter Query in Box</OPTION>
    <OPTION value="SELECT company, COUNT(*) AS Entries FROM xmec_user GROUP BY company ORDER by Entries DESC;">Company List</OPTION>
    <OPTION value="SELECT work_type, COUNT(*) AS Entries FROM xmec_user GROUP BY work_type ORDER by Entries DESC;">Work Type List</OPTION></SELECT></p>
 <P>
<textarea name=sql cols=60 rows=6>select user_id, concat(first_name, ' ', middle_name, ' ', last_name) as name, date, description from xmec_logs, xmec_user where xmec_user.id = user_id and type = 'LOGIN' and date > '2003-11-01 00:00:00' order by date, name;</textarea>
<br><input type=submit value="Run Query">
</FORM>
<hr>
<?
if ($sqlbox == ""){
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
}
else
if (isset($sqlbox) && isset($action ) && $action =="run" ){
	$dbh =& XMEC::getDB();
	if (DB::isManip($sqlbox)) {
		echo "No manipulation queries please !";
	} else {
		$r = $dbh->query(XMEC_user::unQuote($sqlbox));
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


<?php
include 'footer.php';
?>