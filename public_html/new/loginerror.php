<?php
$secure_page=0;
$this_page="loginerror";
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
   document.loginerror.submit();
   
 }   
function validate()
{
	if (document.loginerror.Batch.value == ""){ 
	alert("Please Select your Batch");
	return false;
	}
		
	if (document.loginerror.Rollno.value == ""){ 
	alert("Please record your College Roll Number ");
	return false;
	}
	if(!CheckEmailStr(document.loginerror.email.value )){
//	alert("Please verify Personel Email");
	return false;
	}
	if((document.loginerror.Dob.value == "" ) ||((false == CheckDate(document.loginerror.Dob.value))) || ((IsDateGreaterToday(document.loginerror.Dob.value)))){
			alert("Please Enter the correct Date of Birth. Use dd/mm/yyyy format");
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
  	<TD width=90% height=40 class=head><B>Login Help >></B> Request Password Change</TD>
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

			<TABLE WIDTH=100% CELLPADDING=4 BORDER=0 CELLSPACING=0><TR><TD>
				<BR><BR>Please enter the required details. The XMEC Webmasters will send the changed password to your Personal E-mail address.</strong>
	
			<form name="loginerror" method="post"
				action="/server-scripts/formmail/FormMail.pl">
				<input type=hidden name="recipient" value="webmasters@xmec.addr.com">
				<INPUT TYPE=hidden NAME="subject" VALUE="[xmec.net] Password Reset">
				<input type=hidden name="redirect" value="http://www.xmec.net/new/thankyou.php">
				<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH=100%>
					<TR>
						<TD width=40% class=body><B>Batch</B></TD>
						<TD width=60% colspan=2>
							<SELECT NAME="Batch" class=cbox>
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
							</SELECT>
						</TD>
					</TR>
					<TR>
						<TD width=40% class=body><B>Roll No</B></TD>
						<TD width=60% colspan=2><INPUT NAME="Rollno" SIZE=30 class=lbox></TD>
					</TR>
					<TR>
						<TD width=40% class=body><STRONG>Email ID</STRONG></TD>
						<TD width=60% colspan=2><INPUT NAME="email" SIZE=30 class=lbox></TD>
					</TR>
					<TR>
						<TD width=40% class=body><STRONG>Date of Birth</STRONG></TD>
						<TD width=100><INPUT name=Dob size=30 class=lbox></TD>
						<TD width=200 class=body><I>[dd/mm/yyyy]</I></TD>
					</TR>
					<TR>
						<TD> </TD>
						<TD colspan=2>
							<INPUT TYPE="button" NAME="sendit" VALUE="Send" onClick="javascript:check()">
						</TD>
					</TR>
				</TABLE>
			</FORM>
		</TD></TR></TABLE>
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

		</TD>
	</TR>
</TABLE>
<BR>
<!--Content ends-->
<?php
include 'footer.php';
?>
