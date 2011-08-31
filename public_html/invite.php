<?php
$secure_page=1;
$this_page="college";
include 'header.php';
?>
<!--center starts-->

<TABLE cellSpacing=0 cellPadding=1 width=100% border=0>
  <TR>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  	<TD width=477 height=40 class=head><B>Webmasters' Invitation</B></TD>
  	<TD width=25 rowspan=2><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD width=90% valign=top>
  	<P class=body>Hi XMECians</P>
<P class=body>Development of  www.xmec.net as a means of networking the alumni of Model Engineering College has been a fruitful and hard journey. The alumni can pat each other to congratulate each other on the efforts to build our network. It has truly been an XMECian affair. </P>
<P class=body>The development team has strived to further the cause of improving the accessibility and features in xmec.net. We believe that this has helped at least the Batch 10 and Batch 11 during their job run. </P>
<P class=body>However while looking forward, we feel that there is a lot more that can be achieved by a vibrant site. This calls for more support from the all of us. This also calls for more in terms of time and effort from a dedicated team.</P>

<P class=body>As part of a core team, we sense an urgency in expanding the team so that maintenance and sustenance of the site remains unhampered due to pressures mounted by our regular jobs. We would like to invite interested XMECians to join the team to help us with the job of maintenance and sustenance of the site.</P>
<P class=body>Mandatory Criteria<BR>
<UL>
		<LI>Enthusiasm</LI>
		<LI>Team Player</LI>
		<LI>Direct Internet Connection ( No Firewall)</LI>
		</UL></P>
<P class=body>Secondary Criteria<BR>
		<UL>
		<LI>HTML</LI>
		<LI>PHP</LI>
		<LI>MySQL</LI>
		<LI>Perl</LI>
		</UL></P>
<P class=body>Candidates who have been selected will enjoy the best pay package - the goodwill of the alumni and students of MEC <img src="images/smiley.jpg"> </P>
  	</TD>
  </TR>
  </table>
  <form name="emails" method="post" action="mail.php">
  <TABLE cellSpacing=0 cellPadding=1 width=100% border=0>
  <TR>
  <TD width=275><INPUT type=hidden NAME="name" value="<?php echo $user->first_name ?> <?php echo $user->last_name ?>" type=text class=lbox style="width:225px;">
  </TD></TR>
  <TR>
  <TD width=275><INPUT type=hidden NAME="sender" value="<?php echo $user->personal_email ?>" type=text class=lbox style="width:225px;">
  </TD></TR>
  <TR>
  <TD width=275><INPUT type=hidden NAME="subject" value="[xmec.net]Dev Team Invitation Accepted" type=text class=lbox style="width:225px">
  </TD></TR>
  <tr>
  <TD width=275 align=left><TD width=300><TEXTAREA cols=35 name=message rows=4 wrap=virtual class=tbox>I would like to join the Development team since I accept the conditions</TEXTAREA></TD>
  </TD></TR>
  <TR>
  <TD width=275><INPUT type=hidden NAME="recipient" value="Robi Thomas<robi_thomas@mindtree.com>" type=text class=lbox style="width:225px;"></TD>
  <TD width=275><INPUT type=hidden NAME="ccrecipient" value="webmasters@xmec.net" type=text class=lbox style="width:225px;"></TD>
  <TD width=275><INPUT type=hidden NAME="details" value="<?php echo $user->first_name ?> <?php echo $user->last_name ?> <?php echo $user->id ?>" type=text class=lbox style="width:225px;">
  </TD></TR>
    <TR>
    <TD width=25 rowspan=2><img src="images/space.gif"></TD>
    <TD>
     <INPUT TYPE="button" NAME="sendit" VALUE="I Accept the Invitation" onClick="javascript:submit()"></TD>
  <TD>
      <P><A href="index.php"><img src="images/home.gif" border=0></A></P>
  </TD></TR>


</TABLE>
</FORM>
<!--center ends-->
<?php
include 'footer.php';
?>

