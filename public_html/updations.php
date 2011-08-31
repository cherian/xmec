<?php
	$secure_page=1;
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
<CENTER>
<TABLE cellSpacing=0 cellPadding=0 border=0 width="80%">
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

<?php
	$wrk =& XMEC::get_update_list();
	#echo "<b>Total entries: ". sizeof($wrk) . "</b><br>";
	echo '
<table border=0>
	<tbody>
	<tr><td colspan=3><br></td></tr>
		<tr>
			<td COLSPAN =2 class=name><B>&nbsp;Total Entries</B></td>
			<td class=name><B>' . sizeof($wrk) . '</B></td>
		</tr>
	<tr><td colspan=3><br></td></tr>';
	
	for ($i = 0; $i < sizeof($wrk); $i++) {
		$res = explode(',',$wrk[$i]);
		$batch = explode('/',$res[0]);
		echo '<tr>
						<td>&nbsp;<A HREF="View '.$res[1].'\'s profile ('.$batch[1].' batch)" onClick="javascript:open(\'/profile_admin.php?.s=1&id='.rawurlencode($res[0]).'\',\'\',\'scroll=yes,scrollbars=yes\');return false;" class=link>' . $res[1] . 
'</A></td>
						<TD CLASS=LINKH>'.$res[3].' '.$batch[1].'&nbsp;</TD>
						<td class=fbody>'.$res[2].'</td>
				</tr>'; 
	}
echo '</table>';
?>

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
</CENTER>
<BR><BR>
<?php
include 'footer.php';
?>
