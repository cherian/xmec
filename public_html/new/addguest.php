<?php
$secure_page=0;
$this_page = "guestbookadd";
include 'header.php';
?>
<script Language="JavaScript" src="jslibxmec.js">
</script>
<script language="javascript">

function check()
{

  if (false == validate())
  {

   }
   else
   document.addpostit.submit();

 }
function validate()
{
	if (document.addpostit.realname.value == ""){
	alert("Please enter your Name");
	return false;
	}
	if (document.addpostit.comments.value == ""){
		alert("Please enter a Message ");
		return false;
	}

	if (document.addpostit.comments.value == ""){
	alert("Please enter a Message ");
	return false;
	}

		return true;
	}

</script>
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
		<TD width=6%><BR></TD>
		<TD width=90% height=40 class=head><B>Add a Post IT to XMEC</B></TD>
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
  	<TD valign=top width=445 class=body><P><B>Add a note to the guestbook also called the XMEC Post pad.</B></font></P>

<form name="addpostit" method=POST action="guestbook/guestbook.pl">
<table><tr>
<?php $user =& XMEC::getUser();

 if ($user->isLoggedIn()):  ?>
<td width="40%" class=name>Your Name</td><td><input type=text name=realname class=lbox></td></tr>
<tr><td class=name>Place</td><td> <input type=text name=state class=lbox> </td></tr>
<tr><td><input  type=hidden name=username class=lbox></td>
<td><input type=hidden type=text name=url class=lbox></td>
<td><input type=hidden type=text name=city class=lbox></td>
<td> <input type=hidden type=text name=country class=lbox></td></tr>
<tr><td class=name>Note</td><td><textarea name=comments class=tbox></textarea></td>
<? else: ?>
<td><input type=hidden name=realname value =" " class=lbox></td></tr>
<tr><td class=name>Name</td><td><input  name=username  class=lbox></td></tr>
<tr><td class=name>Email</td><td><input  type=text name=city class=lbox></td></tr>
<tr><td class=name>City</td><td> <input type=text name=state class=lbox> </td></tr>
<tr><td><input  type=hidden name=url class=lbox></td></tr>

<tr><td class=name>Country</td><td><input type=text name=country class=lbox></td></tr>
<tr><td class=name>Note</td><td><textarea name=comments class=tbox></textarea></td>
<? endif ?>
</tr>
<tr><td> <input type=reset name="Reset"></td><td><input type=submit value="Post"></td></tr>
</table>
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
