<?php
	$secure_page=1;
	include 'header.php';
	include_once 'xmec.inc';
?>	
<center><img src="images/head_stat.gif"></center>
<center>
<!--Box Starts-->
<TABLE cellSpacing=0 cellPadding=0 border=0 width="90%">
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

<!--Content starts-->
<table cellspacing=0 cellpadding=0 border=0 width="100%">
	<tr>
		<td colspan=2 bgcolor="#e7f3fb">
		&nbsp;&nbsp;<b class=name>XMEC Site Statistics</b>
		</td>
	</tr>
	<tr><td colspan=2 bgcolor="#e7f3fb" height=1></td></tr>
	<tr>
  	<td class=body width=80%>&nbsp;&nbsp;Total Number of XMECian Profiles </td>
		<td class=body><?php echo (XMEC::get_user_count()-3); ?></td>
	</tr>
	<tr>
		<td class=body bgcolor=#E7F3FB width=80%>&nbsp;&nbsp;Total Number of Profiles Updated</td>
		<td class=body bgcolor=#E7F3FB><?php echo count(XMEC::get_update_list()); ?></td>
	</tr>
	<!--tr>
		<td class=body bgcolor=#FFFFFF>Hit Counter</td>
		<td class=body bgcolor=#FFFFFF><img src=/server-scripts/Count.cgi?df=xmec.dat></td>
	</tr-->
</table>
<!--Content Ends-->
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

<!--Box ends-->	
</center>
<BR>
<center>
<!--Box Starts-->
<TABLE cellSpacing=0 cellPadding=0 border=0 width="90%">
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

<!-- Content Starts -->
<table width="100%" border=0>
<tbody>
	<tr><td colspan=2 bgcolor="#e7f3fb" class=name><b>&nbsp;&nbsp;Batchwise Profile Updation</b></td></tr>
<?php
	$bgcolor[0]="#e7f3fb";
	$bgcolor[1]="#ffffff";
	for ($i=1;$i<12;$i++) {      #### For 11 Batches; Add 1 every year!!
		$year=$i+1988;
		echo '<tr><td bgcolor="'.$bgcolor[$i%2].'" class=body>&nbsp;<a href="search.php?year='.$year.'&.s=Search" class=link> Batch '.$i.' ('.$year.'-'.($year+4).') </a></td>';
	echo '<td bgcolor="'.$bgcolor[$i%2].'" class=body>'.count(XMEC::get_update_list($year)).'/'.XMEC::get_user_count($year).'</td><td bgcolor="'.$bgcolor[$i%2].'" class=body>'.((count((XMEC::get_update_list($year)))/(XMEC::get_user_count($year)))*100).'</td></tr>';
	}
?>
</tbody>
</table>
<!--Content Ends-->
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

<!--Box Ends-->
</center>
<BR>
<?php
include 'footer.php';
?>
