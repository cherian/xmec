<?php
$secure_page=0;
$no_search_menu=1;
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
   document.othererrors.submit();

 }
function validate()
{
	if (document.othererrors.Batch.value == ""){
	alert("Please Select your Batch");
	return false;
	}

	if (document.othererrors.Rollno.value == ""){
	alert("Please record your College Roll Number ");
	return false;
	}
	if(!CheckEmailStr(document.othererrors.email.value )){
//	alert("Please verify Personel Email");
	return false;
	}
	if (document.othererrors.Error.value == ""){
	alert("Please record Details of the Error encountered during Login");
	return false;
	}

		return true;
	}
</script>

<!--center starts-->
<BR>
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
  	<TD width=6%><BR></TD>
  	<TD width=90% height=40 class=head><B>Login Help >></B> Report other Login Issues</TD>
  </TR>
  <TR>
		<TD valign=top width=90% class=body ALIGN=CENTER COLSPAN=2>

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
<!--Content Starts-->

<TABLE width=100% cellpadding=4 border=0 cellspacing=0><TR><TD>
<BR><BR><strong>In case you encounter any other error, please describe the nature of Error so that the Webmasters can rectify the same. </strong>

<form name="othererrors" method="post"
action="/server-scripts/formmail/FormMail.pl">
<input type=hidden name="recipient" value="webmasters@xmec.addr.com">
<INPUT TYPE=hidden NAME="subject" VALUE="[xmec.net] Other Errors">
<input type=hidden name="redirect" value="http://www.xmec.net/thankyou.php">

<TABLE border=0 cellpadding=5 cellspacing=0 width=90%>

<TR>
<TD width=30% class=body><B>Batch</B></TD>
<TD width=70%><SELECT NAME="Batch" width="250"class=cbox>
<OPTION value="" selected>Select One</OPTION>
<OPTION value="batch1">1st Batch (89-93)</OPTION>
<OPTION value="batch2">2nd Batch (90-94)</OPTION>
<OPTION value="batch3">3rd Batch (91-95)</OPTION>
<OPTION value="batch4">4th Batch (92-96)</OPTION>
<OPTION value="batch5">5th Batch (93-97)</OPTION>
<OPTION value="batch6">6th Batch (94-98)</OPTION>
<OPTION value="batch7">7th Batch (95-99)</OPTION>
<OPTION value="batch8">8th Batch (96-00)</OPTION>
<OPTION value="batch9">9th Batch (97-01)</OPTION>
<OPTION value="batch10">10th Batch (98-02)</OPTION>
<OPTION value="batch11">11th Batch (99-03)</OPTION>
</SELECT></TD>
</TR>
<TR>
<TD width=30% class=body><B>Roll No</B></TD>
<TD width=70%><INPUT NAME="Rollno" class=lbox>
</TD></TR>
<TR>
<TD width=30% class=body><STRONG>Email ID</STRONG></TD>
<TD width=70%><INPUT NAME="email" class=lbox>
</TD></TR>
<TR>
<TD width=30% class=body><STRONG>Error Details</STRONG></TD>
<TD width=70%><TEXTAREA cols=35 name=Error rows=10 wrap=virtual class=tbox></TEXTAREA></TD></TR>
<TR>
<TD align=middle colspan=2>
<INPUT TYPE="button" NAME="sendit" VALUE="Send" onClick="javascript:check()">
</TD>
</TR>
</TABLE></FORM>
</TD></TR>
</TABLE>

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
</TD></TR></TABLE>
<!--center ends-->
<?php
include 'footer.php';
?>
