<?php
   global $PHP_SELF;
   $res =& XMEC::search($search_fil, $search_start, $search_count);
   $no_links = 5; // half the no. of navigation links (1 2 3...) 
?>
<BR>
<!-- Box starts -->
<TABLE width = 90% align=center cellSpacing=0 cellPadding=0 border=0>
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
                        <!--contents starts-->

<TABLE border=0 cellPadding=0 cellSpacing=3 width=100%>

<?php
$total = $res['total'];
if ($res['total'] > $search_count ) {
    $rem = (int)(($res['total'] + $search_count - 1)/ $search_count);
    $current = (int)(($search_start + $search_count - 1)/$search_count);

    echo "<TR>";
    echo "<TD align=left>";
    if ($search_start > 0) 
        echo "<A href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".(($current - 1)*$search_count)."&c=$search_count&.s=1 class=link><img src=images/back.gif border=0></A></TD>";
    else 
	echo "&nbsp;</TD>";

    echo "<TD align=center colspan=2>";

	if ($current - $no_links < 0)
		$xfrom = 0;
	else
		$xfrom = $current - $no_links;

	$xto = $xfrom + $no_links * 2;

	if ($xto > $rem) {
		$xto = $rem;
		$xfrom = $rem - $no_links * 2;
		if ($xfrom < 0) 
			$xfrom = 0;
	}

        for ($i = $xfrom; $i < $xto; $i++) {
		if ($i == $current) {
			echo "<b>";
		} 
        echo "<A class= link href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".($i*$search_count)."&c=$search_count&.s=1>".($i+1)."</A>&nbsp";
		if ($i == $current) {
			echo "</b>";
		} 
        }
    echo "</TD>";
    echo "<TD align=right>";
    if ($search_start + $search_count < $total) 
        echo "<A href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".(($current + 1)*$search_count)."&c=$search_count&.s=1 class=link><img src=images/next.gif border=0></A></TD>";
    else 
	echo "&nbsp;</TD>";
    echo "</TR>";
}       
?>
	<TR bgcolor="#E7F3CC">
		<TD><b class=head>Name</b></TD>
		<TD><b class=head>Organisation</b></TD>
		<TD><b class=head>Location</b></TD>
		<TD><b class=head>Batch</b></TD>
	</TR>

<?php
for ($i = 0; $i < $res['count']; $i++) {
	echo "<TR". (($i%2)?" bgcolor=\"#E7F3FB\">":">");
   	echo "<TD><A href='View Details' onClick=\"javascript:open('view_details.php?.s=1&id=",rawurlencode($res[$i]->id),"','','height=600,width=425,scroll=yes,scrollbars=yes');return false;\" class=link>", htmlentities($res[$i]->name), "</a></TD>\n";
	echo "<TD class=body>". ($res[$i]->company == ""?"&nbsp;":htmlentities($res[$i]->company)) . "</TD>";
	echo "<TD class=body>" . ($res[$i]->location == ""?"&nbsp;":htmlentities($res[$i]->location)). "</TD>";
	echo "<TD class=body>" . ($res[$i]->year == ""?"&nbsp;":htmlentities($res[$i]->year)). "</TD>";
	echo "</TR>\n";
}

$total = $res['total'];
if ($res['total'] > $search_count ) {
    $rem = (int)(($res['total'] + $search_count - 1)/ $search_count);
    $current = (int)(($search_start + $search_count - 1)/$search_count);

    echo "<TR>";
    echo "<TD align=left>";
    if ($search_start > 0) 
        echo "<A href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".(($current - 1)*$search_count)."&c=$search_count&.s=1 class=link><img src=images/back.gif border=0></A></TD>";
    else 
	echo "&nbsp;</TD>";

    echo "<TD align=center colspan=2>";

        for ($i = $xfrom; $i < $xto; $i++) {
		if ($i == $current) {
			echo "<b>";
		} 
        echo "<A class=link href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".($i*$search_count)."&c=$search_count&.s=1>".($i+1)."</A>&nbsp;";
		if ($i == $current) {
			echo "</b>";
		} 
        }
    echo "</TD>";
    echo "<TD align=right>";
    if ($search_start + $search_count < $total) 
        echo "<A href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".(($current + 1)*$search_count)."&c=$search_count&.s=1 class=link><img src=images/next.gif border=0></A></TD>";
    else 
	echo "&nbsp;</TD>";
    echo "</TR>";
}       
?>
	<TR>
		<TD colspan=4 bgcolor="#CFDDD1" height=2><img src="images/space.gif"></TD>
	</TR>
</TABLE>
<!--Contents Ends-->
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
<BR>
<!-- Box ends -->


