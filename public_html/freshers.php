<?php
	$secure_page=1;
	$this_page="bday";
	include 'header.php';

	echo '
<br><br>
<TABLE align=center cellSpacing=0 cellPadding=0 border=0 width="90%">
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

<table cellpadding=0 cellspacing=3 width="100%">
<tr bgcolor="#CFDDD1">
<td><b class=stitle>Name</b></td>
<td><b class=stitle>Branch</b></td>
<td><b class=stitle>Percentage</b></td>
</tr>';

	$dbh =& XMEC::getDB();
	$condition = " xmec_user.msn like '%FRESHER%' ";
	$query = "select concat(first_name, ' ', middle_name, ' ', last_name) as name, branch,msn,concat('\downloads\resume\',first_name,'_',last_name,'.rtf') as link from xmec_user where ".$condition;
	$queryHndl = $dbh->query(XMEC_user::unQuote($query));
	$colored=0;
	while (is_array($da = $queryHndl->fetchRow())) {
	if ($colored%2) echo '<tr bgcolor="#CFDDD1">'; else echo '<tr>';
	echo '<td>'.$da[0].'</td>';
	echo '<td>'.$da[1].'</td>';
	echo '<td>'.$da[2].'</td>';
	echo '<td>'.$da[3].'</td>';
	echo '</tr>';
	$colored++;
}
echo '</table>

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
';
?>
<CENTER><BR>XMECians who celebrated their <A class=flink href="belated.php">Birthdays Last Week</A><BR><BR></CENTER>
<?php
include 'footer.php';
?>
