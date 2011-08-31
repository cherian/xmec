<?php
   $res =& XMEC::search($search_fil, $search_start, $search_count);
   $no_links = 5; // half the no. of navigation links (1 2 3...) 
?>

<TABLE border=0 cellPadding=0 cellSpacing=3 width=100%>

<?php
$total = $res['total'];
if ($res['total'] > $search_count ) {
    $rem = (int)(($res['total'] + $search_count - 1)/ $search_count);
    $current = (int)(($search_start + $search_count - 1)/$search_count);

    echo "<TR>";
    echo "<TD align=left>";
    if ($search_start > 0) 
        echo "<A href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".(($current - 1)*$search_count)."&c=$search_count&.s=1 class=xmec><img src=images/back.gif border=0></A></TD>";
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
        echo "<A class=xmec href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".($i*$search_count)."&c=$search_count&.s=1> &nbsp;".($i+1)."</A>";
		if ($i == $current) {
			echo "</b>";
		} 
        }
    echo "</TD>";
    echo "<TD align=right>";
    if ($search_start + $search_count < $total) 
        echo "<A href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".(($current + 1)*$search_count)."&c=$search_count&.s=1 class=xmec><img src=images/next.gif border=0></A></TD>";
    else 
	echo "&nbsp;</TD>";
    echo "</TR>";
}       
?>
	<TR bgcolor="#CFDDD1">
		<TD><b class=stitle>Name</b></TD>
		<TD><b class=stitle>Organisation</b></TD>
		<TD><b class=stitle>Location</b></TD>
		<TD><b class=stitle>Batch</b></TD>
	</TR>

<?php
for ($i = 0; $i < $res['count']; $i++) {
	echo "<TR". (($i%2)?" bgcolor=\"#CFDDD1\">":">");
   	echo "<TD><A href=not-a-real-link onClick=\"javascript:open('view_details.php?.s=1&id=",rawurlencode($res[$i]->id),"','','height=600,width=425,scroll=yes,scrollbars=yes');return false;\" class=slink>", htmlentities($res[$i]->name), "</a></TD>\n";
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
        echo "<A href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".(($current - 1)*$search_count)."&c=$search_count&.s=1 class=xmec><img src=images/back.gif border=0></A></TD>";
    else 
	echo "&nbsp;</TD>";

    echo "<TD align=center colspan=2>";

        for ($i = $xfrom; $i < $xto; $i++) {
		if ($i == $current) {
			echo "<b>";
		} 
        echo "<A class=xmec href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".($i*$search_count)."&c=$search_count&.s=1> &nbsp;".($i+1)."</A>";
		if ($i == $current) {
			echo "</b>";
		} 
        }
    echo "</TD>";
    echo "<TD align=right>";
    if ($search_start + $search_count < $total) 
        echo "<A href=$PHP_SELF?.n=".urlencode($search_fil['name'])."&.w=".urlencode($search_fil['work_type'])."&.c=".urlencode($search_fil['company'])."&.y=".urlencode($search_fil['year'])."&.b=".urlencode($search_fil['branch'])."&.l=".urlencode($search_fil['location'])."&f=".(($current + 1)*$search_count)."&c=$search_count&.s=1 class=xmec><img src=images/next.gif border=0></A></TD>";
    else 
	echo "&nbsp;</TD>";
    echo "</TR>";
}       
?>
	<TR>
		<TD colspan=4 bgcolor="#CFDDD1" height=2><img src="images/space.gif"></TD>
	</TR>
</TABLE>

