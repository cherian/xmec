<?php
$secure_page=0;
$this_page="groups";
include 'header.php';
$user = XMEC::getUser();
?>
<!--center starts-->
<TABLE cellSpacing=0 cellPadding=4 width=90% align=center border=0>
  <TR>
		<TD width=6%><BR></TD>
		<TD width=90% height=40 class=head><B>XMEC Groups and Mailing Lists</B></TD>
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
  	<TD width=477 height=40><P class=body><BR><B>One can send a message to the Alumni, Chapter(s) or any Batch that has graduated from Model Engineering College, Kochi.<BR></B><i>Your message will be delivered to the groups only on approval of the moderator of the respective Group or Mailing List.<i></P></TD>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD width=90% valign=top>
<script language="javascript" src="jslibxmec.js">
</script>
<script language="javascript">
function check()
{

  if (false == validate())
  {
     return;
   }
   else
   document.emails.submit();

 }
function validate()
{
	if (document.emails.list.options[document.emails.list.selectedIndex].value == ""){
	alert("Please Select the Mailing List to send to");
	return false;
	}
	if (document.emails.sub.value == ""){
	alert("Please enter the Subject of your Message");
	return false;
	}
	if(!CheckEmailStr(document.emails.email.value )){
//	alert("Please Please verify Personel Email");
	return false;
	}
	if (document.emails.information.value == ""){
	alert("Please enter the Message");
	return false;
	}
		return true;
	}

function canceltext()
{
document.emails.information.value = "";
}

function displayinfo(){
        var who=document.emails.list.options[document.emails.list.selectedIndex].value;
//        var address=document.emails.address;
        var info=document.emails.information;

if (who==""){
                info.value="Please select the group you want to send the message.";}
if (who=="xmec"){
                info.value="This message will be conveyed to all XMECians on approval of the moderator.";
                document.emails.recipient.value = "moderator@xmec.addr.com";
                }
if (who=="xmec_e"){
                info.value="This message will be conveyed to all XMECians of US East Coast on approval of the moderator.";
                document.emails.recipient.value = "us_east@xmec.addr.com";
                }
if (who=="xmec_w"){
                info.value="This message will be conveyed to all XMECians of US West Coast on approval of the moderator.";
                document.emails.recipient.value = "us_west@xmec.addr.com";
                }
if (who=="xmec_h"){
                info.value="This message will be conveyed to all XMECians of US West Coast on approval of the moderator.";
                document.emails.recipient.value = "hyd@xmec.addr.com";
                }
if (who=="batch1"){
                info.value="This message will be conveyed to all XMECians of First Batch on approval of the moderator.";
                document.emails.recipient.value = "batch1@xmec.addr.com";
                }
if (who=="batch2"){
                info.value="This message will be conveyed to all XMECians of Second Batch on approval of the moderator.";
                document.emails.recipient.value = "batch2@xmec.addr.com";
                }
if (who=="batch3"){
                info.value="This message will be conveyed to all XMECians of Third Batch on approval of the moderator.";
                document.emails.recipient.value = "batch3@xmec.addr.com";
                }
if (who=="batch4"){
                info.value="This message will be conveyed to all XMECians of Fourth Batch on approval of the moderator.";
                document.emails.recipient.value = "batch4@xmec.addr.com";
                }
if (who=="batch5"){
                info.value="This message will be conveyed to all XMECians of Fifth Batch on approval of the moderator.";
                document.emails.recipient.value = "batch5@xmec.addr.com";
                }
if (who=="batch6"){
                info.value="This message will be conveyed to all XMECians of Sixth Batch on approval of the moderator.";
                document.emails.recipient.value = "batch6@xmec.addr.com";
                }
if (who=="batch7"){
                info.value="This message will be conveyed to all XMECians of Seventh Batch on approval of the moderator.";
                document.emails.recipient.value = "batch7@xmec.addr.com";
                }
if (who=="batch8"){
                info.value="This message will be conveyed to all XMECians of Eighth Batch on approval of the moderator.";
                document.emails.recipient.value = "batch8@xmec.addr.com";
                }
if (who=="batch9"){
                info.value="This message will be conveyed to all XMECians of Ninth Batch on approval of the moderator.";
                document.emails.recipient.value = "batch9@xmec.addr.com";
                }
if (who=="batch10"){
                info.value="This message will be conveyed to all XMECians of Tenth Batch on approval of the moderator.";
                document.emails.recipient.value = "batch10@xmec.addr.com";
                }
if (who=="batch11"){
                info.value="This message will be conveyed to all XMECians of Eleventh Batch on approval of the moderator.";
                document.emails.recipient.value = "batch11@xmec.addr.com";
                }

}


</script>
<form name="emails" method="post" action="/server-scripts/formmail/FormMail.pl">
<INPUT TYPE="hidden" NAME="recipient" value="">
<INPUT TYPE=hidden NAME="subject" VALUE="[xmec.net] Message to your Batch">
<input type=hidden name="redirect" value="http://www.xmec.net/new/thankyou.php">

<TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">
<TR><BR><BR>
<TD width=150 class=name><B>To Mailing List</B></TD>
<TD width=275><SELECT NAME="list" onChange="displayinfo()" class=cbox >
<OPTION value=""
              selected>Select One</OPTION>
<OPTION value="xmec">XMEC</OPTION>
<OPTION value="xmec_h">XMEC Hyderabad</OPTION>
<OPTION value="xmec_e">XMEC US East Coast</OPTION>
<OPTION value="xmec_w">XMEC US West Coast</OPTION>
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
<TD width=150 class=body><B>From</B></TD>
<TD width=275><INPUT NAME="name" value="<?php echo $user->first_name ?> <?php echo $user->last_name ?>" type=text class=lbox>
</TD></TR>
<TR>
<TD width=150 class=name><B>From Email ID</B></TD>
<TD width=275><INPUT NAME="email" value="<?php echo $user->personal_email ?>" type=text class=lbox style="width=225px;">
</TD></TR>
<TR>
<TD width=150 class=name><B>Subject</B></TD>
<TD width=275><INPUT NAME="sub" type=text class=lbox size=10>
</TD></TR>
<TR><TD width=150 class=name><B>Your Message</B></TD><TD colspan=2><TEXTAREA class=tbox cols=50 name=information rows=10 wrap=virtual onfocus="javascript:canceltext();">Please select the group you want to send the message</TEXTAREA>
</TD></TR>
<TR><TD align=middle colspan=2>
<INPUT TYPE="Button" NAME="sendit" VALUE="Send" onclick="javascript:check();">
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

