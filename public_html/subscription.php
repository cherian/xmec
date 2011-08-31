<?php
$secure_page=1;
$this_page="subscribe";
include 'header.php';
$user = XMEC::getUser();

?>
<!--center starts-->
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
		<TD width=6%><BR></TD>
		<TD width=90% height=40 class=head><B>XMEC Mailing List Subscription</B></TD>
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
<TABLE cellSpacing=0 cellPadding=1 width=100% border=0>
  <TR>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  	<TD width=477 height=40><P class=body><BR><B>You can choose to subscribe or unsubscribe your preferred email ID to any one of the XMEC Yahoogroups Mailing Lists. Please note that request goes directly to Yahoogroups and moderated by the XMEC Moderator. You will receive the confirmation mails from Yahoogroups directly.</B></P></TD>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD width=90% valign=top>
<script language="javascript" src="jslibxmec.js">
</script>
<script language="javascript">
function check1()
{

  if (false == validate1())
  {

   }
   else
   document.subscription.submit();

 }
function validate1()
{

	if(!CheckEmailStr(document.subscription.sendcat.value )){
		alert("Please record your Email ID ");
		return false;
	}
	if(document.subscription.list.value == ""){
		alert("Please verify Alumni Mailing List");
	return false;
	}
		if (document.subscription.subject1.value == ""){
  alert("Please select to Subcribe or Unsubscribe");
  return false;
  }
  if (document.subscription.subject1.value == "-subscribe@yahoogroups.com"){
  		document.subscription.message.value = "Please Subscribe this ID to the Mailing List";
	}
if (document.subscription.subject1.value == "-unsubscribe@yahoogroups.com"){
  		document.subscription.message.value = "Please Unsubscribe this ID from the Mailing List";
	}

	if (document.subscription.recipient.value == ""){
	  		document.subscription.recipient.value = document.subscription.list.value + document.subscription.subject1.value;
	}
	if (document.subscription.ccrecipient.value == ""){
		  		document.subscription.ccrecipient.value = document.subscription.list.value + "-owner@yahoogroups.com";
	}
	if (document.subscription.sendcat.value != ""){
	  document.subscription.sender.value = document.subscription.details.value +"<"+ document.subscription.sendcat.value +">";
	  }
	if (document.subscription.subject1.value != ""){
		  document.subscription.subject.value = document.subscription.message.value;
	  }
	 return true;
	}

function check2()
{

  if (false == validate2())
  {

   }
   else
   document.subscribelist.submit();

 }
function validate2()
{

	if(!CheckEmailStr(document.subscribelist.sendcat2.value )){
		alert("Please record your Email ID ");
		return false;
	}
	if(document.subscribelist.list2.value == ""){
		alert("Please verify Batch Mailing List");
	return false;
	}
		if (document.subscribelist.subject2.value == ""){
  alert("Please select to Subcribe or Unsubscribe");
  return false;
  }
  if (document.subscribelist.subject2.value == "Subscribe"){
  		document.subscribelist.message.value = "Please Subscribe this ID to the Mailing List ";
	}
if (document.subscribelist.subject2.value == "Unsubscribe"){
  		document.subscribelist.message.value = "Please Unsubscribe this ID from the Mailing List" ;
	}

	if (document.subscribelist.recipient.value == ""){
	  		document.subscribelist.recipient.value = document.subscribelist.list2.value;
	}
	if (document.subscribelist.bccrecipient.value == ""){
		  		document.subscribelist.bccrecipient.value = "robi_thomas@mindtree.com";
	}
	if (document.subscribelist.sendcat2.value != ""){
	  document.subscribelist.sender.value = document.subscribelist.details.value+"<"+document.subscribelist.sendcat2.value+">";
	  }
	  if (document.subscribelist.subject2.value != ""){
	  	  document.subscribelist.subject.value = document.subscribelist.subject2.value;
	  	  	  }
	return true;
	}

</script>
<form name="subscription" method="post" action="mail.php">


<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">
<TR><BR><BR>
<TD><SELECT NAME="subject1" class=cbox>
<OPTION value=""
              selected>Do Not Change</OPTION>
<OPTION value="-subscribe@yahoogroups.com">Subscribe</OPTION>
<OPTION value="-unsubscribe@yahoogroups.com">Unsubscribe</OPTION>
</SELECT></TD>
<TD><INPUT NAME="sendcat" value="<?php echo $user->personal_email ?>" type=text class=lbox></TD>
<TD><SELECT NAME="list" class=cbox >
<OPTION value=""
              selected>Alumni Lists</OPTION>
<OPTION value="xmec">XMEC</OPTION>
<OPTION value="xmec-jobs">XMEC Jobs</OPTION>
<OPTION value="xmec-placement-assist">Placement Assistance</OPTION>
<OPTION value="hash_define_mec">XMEC Programmers</OPTION>
<OPTION value="xmec-mgt">XMEC Management</OPTION>
<OPTION value="xmec-bangalore">XMEC Bangalore</OPTION>
<OPTION value="xmec-chennai">XMEC Chennai</OPTION>
<OPTION value="xmec-tvm">XMEC Trivandrum</OPTION>
<OPTION value="xmec-asiapac">XMEC AsiaPac</OPTION>
<OPTION value="xmec-Europe">XMEC Europe</OPTION>
<OPTION value="xmec-MiddleEast">XMEC Middle East</OPTION>
<OPTION value="xmec_west">XMEC US West</OPTION>
<OPTION value="xmec_east">XMEC US East</OPTION>
</SELECT></TD>
</TR>
<TR>
<TD><INPUT type=hidden NAME="message" value="" type=text></TD>
<TD><INPUT type=hidden NAME="recipient" value="" type=text></TD>
<TD><INPUT type=hidden NAME="ccrecipient" value="" type=text></TD>
<TD><INPUT type=hidden NAME="sender" value="" type=text></TD>
<TD><INPUT type=hidden NAME="subject" value="" type=text></TD>
<TD><INPUT type=hidden NAME="details" value="<?php echo $user->first_name ?> <?php echo $user->last_name ?> <?php echo $user->id ?>" type=text></TD>
</TR>
<TR><TD align=middle colspan=2>
<INPUT TYPE="button" NAME="sendit" VALUE="Send" onClick="javascript:check1()">
</TD>
</TR>
</TABLE> </FORM>

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
<BR>
<!--center starts-->
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
		<TD width=6%><BR></TD>
		<TD width=90% height=40 class=head><B>Batch Mailing List Subscription</B></TD>
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
<TABLE cellSpacing=0 cellPadding=1 width=100% border=0>
  <TR>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  	<TD width=477 height=40><P class=body><BR><B>You can choose to subscribe or unsubscribe your preferred email ID for your Batch Mailing List. Please note that you can use this facility to update your Email preference for <i>your Batch Mailing List</i> only.</B></P></TD>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD width=90% valign=top>
<form name="subscribelist" method="post" action="mail.php">


<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">
<TR><BR><BR>
<TD><SELECT NAME="subject2" class=cbox>
<OPTION value=""
              selected>Do Not Change</OPTION>
<OPTION value="Subscribe">Subscribe</OPTION>
<OPTION value="Unsubscribe">Unsubscribe</OPTION>
</SELECT></TD>
<TD><INPUT NAME="sendcat2" value="<?php echo $user->personal_email ?>" type=text class=lbox></TD>
<TD><SELECT NAME="list2" class=cbox >
<OPTION value=""
              selected>Batch List</OPTION>
<OPTION value="batch1@xmec.net">1st Batch (89-93)</OPTION>
<OPTION value="batch2@xmec.net">2nd Batch (90-94)</OPTION>
<OPTION value="batch3@xmec.net">3rd Batch (91-95)</OPTION>
<OPTION value="batch4@xmec.net">4th Batch (92-96)</OPTION>
<OPTION value="batch5@xmec.net">5th Batch (93-97)</OPTION>
<OPTION value="batch6@xmec.net">6th Batch (94-98)</OPTION>
<OPTION value="batch7@xmec.net">7th Batch (95-99)</OPTION>
<OPTION value="batch8@xmec.net">8th Batch (96-00)</OPTION>
<OPTION value="batch9@xmec.net">9th Batch (97-01)</OPTION>
<OPTION value="batch10@xmec.net">10th Batch (98-02)</OPTION>
<OPTION value="batch11@xmec.net">11th Batch (99-03)</OPTION>
<OPTION value="batch12@xmec.net">12th Batch (00-04)</OPTION>
</SELECT></TD>
</TR>
<TR>
<TD><INPUT type=hidden NAME="message" value="" type=text></TD>
<TD><INPUT type=hidden NAME="recipient" value="" type=text></TD>
<TD><INPUT type=hidden NAME="sender" value="" type=text></TD>
<TD><INPUT type=hidden NAME="subject" value="" type=text></TD>
<TD><INPUT type=hidden NAME="bccrecipient" value="" type=text></TD>
<TD><INPUT type=hidden NAME="details" value="<?php echo $user->first_name ?> <?php echo $user->last_name ?> <?php echo $user->id ?>" type=text></TD>
</TR>
<TR><TD align=middle colspan=2>
<INPUT TYPE="button" NAME="sendit" VALUE="Send" onClick="javascript:check2()">
</TD>
</TR>
</TABLE> </FORM>

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
<BR>
<?php
include 'footer.php';
?>

