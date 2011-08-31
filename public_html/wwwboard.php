<?php
$secure_page=1;
include 'header.php';
$user = XMEC::getUser();
?>
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
		<TD width=6%><BR></TD>
		<TD width=90% height=40 class=head><B>Add a Questionaire</B></TD>
  </TR>
<TR><TD colspan=2>
<!--Box Starts-->
<TABLE cellSpacing=0 cellPadding=0 border=0 width=90% align=center>
<TBODY>
<TR>
<TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
<TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
<TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
<TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>    </TR>
<TR>
<TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6
src="images/tb_left_topb.gif" width=3></TD>
<TD colSpan=2 rowSpan=2>
<!--center starts-->
<TABLE cellSpacing=0 cellPadding=1 width=527 border=0>
  <TR>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  	<TD width=477 height=40 class=head></TD>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD valign=top width=445 class=body><P><BR><BR><strong>Add a Questionaire to the XMEC Question Bank. This will be useful to all XMECians</strong><BR><BR></P>
<script Language="JavaScript" src="jslibxmec.js">
</script>
<script language="javascript">
 </script>
<form name="addpostit" method=POST action="wwwboard/wwwboard.pl">
<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">
<TR>
<TD>Name: </TD><TD><input class=lbox type=text name="name" size=50></TD>
</TR>
<TR>
<TD>
Subject:  </TD><TD><input class=lbox type=text name="subject" size=50>
</TD>
</TR>
<TR>
<TD>
Questions:</TD><TD><textarea class=tbox name="body" ></textarea>
</TD>
</TR>
<TR>
<TD>
Optional Link URL</TD><TD><input class=lbox type=text name="url" size=45>
</TD>
</TR>
<TR>
<TD>
Link Title</TD><TD><input class=lbox type=text name="url_title" size=50>
</TD>
</TR>
<TR>
<TD>
Optional Image URL</TD><TD><input class=lbox type=text name="img" size=45>
</TD>
</TR>
<TR>
<TD class=body >
<tr><td> <input type=reset name="Reset"></td><td><input type=submit value="Post"></td></tr>
</TABLE>
</form>
</TD>
  </TR>
</TABLE>
<!--center ends-->
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
</TD></TR>
</TABLE>

<?php
include 'footer.php';
?>

