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
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
  <TD width=90% height=40 class=head align=left><B>XMEC Statistics >></B>XMECian Work Profile List</TD>
  </TR>
  <TR>
 		<TD valign=top width=90% class=body ALIGN=CENTER COLSPAN=2>
<TABLE align=center cellSpacing=0 cellPadding=0 border=0>
<TBODY>
        <TR>
                <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    </TR>
    <TR>
                <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
                <TD colSpan=2 rowSpan=2>

<!-- Content -->
<?
	$sqlbox = "SELECT work_type, COUNT(*) AS Entries FROM xmec_user GROUP BY work_type ORDER by Entries DESC LIMIT 1";
	$dbh =& XMEC::getDB();
	if (DB::isManip($sqlbox)) {
		echo "No manipulation queries please !";
	} else {
		$r = $dbh->query(XMEC_user::unQuote($sqlbox));
		if (DB::isError($r)) {
			echo "Query: $sql failed.";
		} else {
			echo "<table border=0>";
			echo "<tr bgcolor=#DDDDDD>";
			  echo "<tr>";
			  echo "<td class =body colspan=2><p>XMEC profile defines the Field of Work (Area of Expertise ) as a mandatory information while Designation is optional. The Field of Work information helps MEC students and other XMECians to locate experienced hands in the domain that they are interested in or need assistance in.</P><P class=name><b>However there are many profiles where the Field of Work is mistaken and misinformed as Designation. For eg. <i>Software Engineer</i> is a Designation and <i>Software Design</i> or <i>C, C++,Unix</i> is the Field of Work</b>.<BR><BR></P></td></tr><tr> ";
echo "<td colspan=2 align=left><P class=head><B>Profile Details for $me->first_name </B></P></td></tr><tr>";
echo "<td><P class=body>Field of Work</P></td><td><P><b> $me->work_type</B></P></td></tr><tr>";
echo "<td><P class=body>Designation (optional) </P></td><td><P><B> $me->msn </B><BR></P></td></tr><tr>";
echo "<td></td><td><P><b><A href=editprofile.php class=flink>Do you want to change your profile ?</A></B></P></td>";

			  echo "</tr>";
			echo "</table>";
		}
	}

?>

<!-- Content -->

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
<TABLE align=center cellSpacing=0 cellPadding=0 border=0>
<TBODY>
        <TR>
                <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    </TR>
    <TR>
                <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
                <TD colSpan=2 rowSpan=2>

<?
	$sqlbox = "SELECT work_type, COUNT(*) AS Entries FROM xmec_user WHERE work_type <> '' GROUP BY work_type ORDER by Entries DESC";
	$dbh =& XMEC::getDB();
	if (DB::isManip($sqlbox)) {
		echo "No manipulation queries please !";
	} else {
		$r = $dbh->query(XMEC_user::unQuote($sqlbox));
		if (DB::isError($r)) {
			echo "Query: $sql failed.";
		} else {
			echo "<table border=0>";
			echo "<tr bgcolor=#DDDDDD>";
			echo "<td><b class=title>Field of Work</b></td>";
			echo "<td><b class=title>XMECians</b></td>";
			echo "</tr>";
			while (is_array($x = $r->fetchRow())) {
			  echo "<tr>";
			  for ($i=0; $i<count($x); $i++) echo "<td bgcolor=#CFDDD1>$x[$i]</td>";
			  echo "</tr>";
			}
			echo "</table>";
		}
	}

?>

<!-- Content -->

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
</TD>
</TR>
</TABLE>


</BODY>
</HTML>


<?php
include 'footer.php';
?>