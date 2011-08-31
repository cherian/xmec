<?php
	$secure_page=1;
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
<td class=name><b class=stitle>Name</b></td>
<td class=name ><b class=stitle>Batch</b></td>
<td class=name><b class=stitle>Bday</b></td>
</tr>';

	$dbh =& XMEC::getDB();
	$query = 'select id, first_name, middle_name, last_name, DATE_FORMAT(date_of_birth,"%D %b")  
from xmec_user 
where ( (RIGHT(date_of_birth,5) >= RIGHT(CURRENT_DATE,5)) 
		and (RIGHT(date_of_birth,5) < RIGHT(DATE_ADD(CURRENT_DATE,INTERVAL 1 DAY),5) ) ) 
order by  RIGHT(date_of_birth,5)'; 
$queryHndl = $dbh->query($query);
$colored=0;
while (is_array($da = $queryHndl->fetchRow())) {
	if ($colored%2) echo '<tr bgcolor="#CFDDD1">'; else echo '<tr>';
	echo '<td class=fbody>'.$da[1].' '.$da[2].' '.$da[3].'</td>';
	list(,$batch) = split('/', $da[0]);
	echo '<td class=fbody>'.$batch.'</td>';
	echo '<td class=fbody>'.$da[4].'</td>';
	echo '</tr>';
	$colored++;
}

echo '
</table>

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
<?php
include 'footer.php';
?>

