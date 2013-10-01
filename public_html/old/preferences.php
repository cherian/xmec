<?php
        include 'xmec.inc';
        if (! XMEC::authenticate_user()) {
                echo "<html><h1>Please login to access this page<html>";
                exit ;
        }

	reset($HTTP_POST_VARS);
        $action = chop($HTTP_POST_VARS["todo"]);
        if ($REQUEST_METHOD == "GET")
                $action = chop($HTTP_GET_VARS["todo"]);

	$me =& XMEC::getUser();
	$user = $me;
	
	$admin = FALSE;	
	if ($me->isAdmin() && isset($id) && $id != "" && $_s == 1) {
		$admin = TRUE;		
		$user = new XMEC_user($id);
		if (!$user->fetchInfo()) {
        	echo "<html><h1>ID not found !</html>";
			exit;
		}
	}
		
	$pemail_pref = $user->getPref('personal_email');
	$oemail_pref = $user->getPref('official_email');
	$curr_visib = $user->getAddressVisibility('PRESENT');
	$comp_visib = $user->getAddressVisibility('COMPANY');
	$perm_visib = $user->getAddressVisibility('PERMANENT');

	$pass_st = "";
	$email_st = "";
	$addr_st = "";
			
	if ($action == "update") {

		// Password change..

		if (!empty($passwd1) || !empty($passwd2) || !empty($passwd3)) {
		if (!$admin && $passwd1 == "") {
			$pass_st = "Please enter the old password";
		} else 
		if (passwd2 != "" && $passwd3 != "") {
			if ($passwd2 != $passwd3) {
				$pass_st = "Passwords doesn't match";
			} else { 
				if ($admin) {
					if ($user->setPassword($passwd2, $passwd2, TRUE) == FALSE) 
						$pass_st = "Old password incorrect";
				} else {
					if ($user->setPassword($passwd1, $passwd2) == FALSE) 
						$pass_st = "Old password incorrect";
				}
			}
		} else
			$pass_st = "Please enter new password";
		}

		// Email prefs..
		if ($pemail != $pemail_pref) {
			if (! $user->setPref('personal_email', $pemail)) {
				$email_st = $user->getError();
			} else {
				$pemail_pref = $pemail;
			}
		}

		if ($oemail != $oemail_pref) {
			if (! $user->setPref('official_email', $oemail)) {
				$email_st .= $user->getError();
			} else {
				$oemail_pref = $oemail;
			}
		}

		// Address visibility..

		if ($curr != $curr_visib) {
			if (! $user->setAddressVisibility('PRESENT', $curr)) {
				$addr_st = $user->getError();
			} else {
				$curr_visib = $curr;
			}
		}

		if ($comp != $comp_visib) {
			if (! $user->setAddressVisibility('COMPANY', $comp)) {
				$addr_st .= $user->getError();
			} else {
				$comp_visib = $comp;
			}
		}

		if ($perm != $perm_visib) {
			if (! $user->setAddressVisibility('PERMANENT', $perm)) {
				$addr_st .= $user->getError();
			} else {
				$perm_visib = $perm;
			}
		}
	}
			
			
?>

<HTML>
<HEAD>

<script>
function validate()
{
<?php if (!$admin) { ?>
	if (document.f1.passwd1.value != "" || document.f1.passwd2.value != "" || document.f1.passwd3.value != "") {
		if (document.f1.passwd1.value == "" )
			alert("Please enter the old password");
		else if (document.f1.passwd2.value == "")
			alert("Please enter a new password");
		else if (document.f1.passwd3.value == "")
			alert("Please confirm the new password");
		else if (document.f1.passwd2.value != document.f1.passwd3.value)			alert("Passwords doesn't match");
		else {
			document.f1.action="<?=$PHP_SELF?>"
			document.f1.submit();
		}
	} else {
		document.f1.action="<?=$PHP_SELF?>"
		document.f1.submit();
	}
<?php } else { ?>
	document.f1.action="<?=$PHP_SELF?>"
	document.f1.submit();
<?php } ?>

}	
</script>

<LINK rel=stylesheet href="style.css" type="text/css">
</HEAD>
<BODY bgcolor="#ffffff" topmargin=0 leftmargin=0 marginheight = "0" marginwidth = "0">
<form name=f1 method=POST>
<TABLE align=left border=0 cellPadding=0 cellSpacing=0 width="615" height="100%">
<TR>
<TD valign=top width=445><IMG src="images/head_profile.gif">
<P><b>Changing preferences for <?=$user->get('full_name')?></b>
<?php 
	if ($pass_st != "" || $email_st != "" || $addr_st != "")
	echo "<br><FONT face=arial size=2 color=\"#FF0000\">Failed updating preferences: $pass_st  $email_st  $addr_st</font><br>";
	else if ($action == "update")
	echo "<br><FONT face=arial size=2 color=\"#00FF00\">Successfully updated preferences</font><br>";
?>
</P><BR>
<P><b>Change Password </b><BR>
You can change your password and the next time you login in, the system will accept the new password. Please use a distinctive word (more than 8 letters). </P>

<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="400">
<TR><TD width=150><P>Old password</P></TD><TD width=250><INPUT name=passwd1 type=password></TD></TR>
<TR><TD><P>New password</P></TD><TD><INPUT name=passwd2 type=password></TD></TR>
<TR><TD><P>Confirm New password</P></TD><TD><INPUT name=passwd3 type=password></TD></TR>
</TABLE><BR>

<BR>
<P><B>XMEC Yahoo Groups Subscription</B><BR>
You can add or change the Email ID that you want to receive all XMEC Yahoo Groups mails. <A href="yahoo_xmec.htm" class=xmec>Click here to access Yahoo Groups Add/Change Form</A> </P>
<BR>
<P><B>Profile Security </B><BR>
Your Profile is by default visible to all Internet users. You can however set your preferences with respect to visibility of certain information. </P>

<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="400">
<TR><TD width=150><P>Personal Email ID</P></TD>
	<TD width=250><SELECT name=pemail>
		<OPTION value="PUBLIC" <?if($pemail_pref=='PUBLIC')echo 'SELECTED';?> >Public</OPTION>
		<OPTION value="XMEC" <?if($pemail_pref=='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION>
		<OPTION value="PRIVATE" <?if($pemail_pref=='PRIVATE')echo 'SELECTED';?>>Restricted</OPTION></SELECT></TD></TR>
<TR><TD><P>Official Email ID</P></TD>
	<TD><SELECT name=oemail>
		<OPTION value="PUBLIC" <?if($oemail_pref=='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
		<OPTION value="XMEC" <?if($oemail_pref=='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION>
		<OPTION value="PRIVATE" <?if($oemail_pref=='PRIVATE')echo 'SELECTED';?>>Restricted</OPTION></SELECT></TD></TR>

<TR><TD><P>Current Address</P></TD>
	<TD><SELECT name=curr>
		<OPTION value="PUBLIC" <?if($curr_visib =='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
		<OPTION value="XMEC" <?if($curr_visib =='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION></SELECT></TD></TR>

<TR><TD><P>Company Address</P></TD>
	<TD><SELECT name=comp>
		<OPTION value="PUBLIC" <?if($comp_visib =='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
		<OPTION value="XMEC" <?if($comp_visib =='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION></SELECT></TD></TR>

<TR><TD><P>Permanent Address</P></TD>
	<TD><SELECT name=perm>
		<OPTION value="PUBLIC" <?if($perm_visib =='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
		<OPTION value="XMEC" <?if($perm_visib =='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION></SELECT></TD></TR>

</TABLE><BR><BR>



<?php if (0) { //Disabled... ?>

<P><B>XMEC Yahoo groups Subscription </B><BR>
Please specify the Email ID Mailbox that you would want to receive all your XMEC communication. </P>
<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="400">
<TR><TD width=150><P>Email ID</P></TD><TD width=250><SELECT name=select1> <OPTION 
              selected>Official Email ID</OPTION> <OPTION>Personal Email ID</OPTION> 
              </SELECT></TD></TR>
</TABLE><BR><BR>

<P><b>Reminders</b><BR>
Do you wish to receive any reminder on the forthcoming Birthdays of fellow XMECians? </P>
<TABLE align=center border=0 cellPadding=0 cellSpacing=0>
<TR><TD><INPUT name=checkbox1 type=checkbox></TD><TD><P>Yes</P></TD></TR>
<TR><TD><INPUT name=checkbox1 type=checkbox></TD><TD><P>No</P></TD></TR>
</TABLE><BR><BR>

<P>Do you wish to receive Newsletters regarding news and events regarding the Alumni? </P>
<TABLE align=center border=0 cellPadding=0 cellSpacing=0>
<TR><TD><INPUT name=checkbox2 type=checkbox></TD><TD><P>Yes</P></TD></TR>
<TR><TD><INPUT name=checkbox2 type=checkbox></TD><TD><P>No</P></TD></TR>
</TABLE><BR><BR>

<?php } //Disabled... ?>
 
<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width=200>
<TR><TD align=middle><INPUT name=submit1 type=button value=Submit onClick="javascript:validate();"></TD>
<TD align=middle><INPUT name=reset1 type=reset value=Reset></TD></TR>
</TABLE><BR><BR>


</TD>
<TD width=170 valign=top align=middle><BR><BR><BR><IMG src="images/preferences.jpg"><BR></TD>
</TR>
<TR>
<TD colspan=2>
      <TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="100%">
        
        <TR>
          <TD align=middle height=30 valign=top><A href="members.php"><font face=arial size=-1 color="#669999">Members</font></A> || <A href="disc.htm"><font face=arial size=-1 color="#669999">Disclaimer</font></A> || <A href="sitemap.htm"><font face=arial size=-1 color="#669999">Sitemap</font></A> || <A href="mailto:moderator@xmec.net"><font face=arial size=-1 color="#669999">Comments</font></A></TD>
        </TR>
        <TR>
			<TD align=middle height=30 valign=bottom><font face=arial size=-1 color="#999999">Site Powered by &nbsp;<A href="http://www.marlabs.com"><IMG align=absMiddle border=0 src="images/marlabs.jpg"></A> &nbsp;� Copyright 2001</font></TD>
		</TR>
      </TABLE>
</TD></TR>
</TABLE> 
<?php if ($admin) { ?>
<input type=hidden name=.s value=1>
<input type=hidden name=id value=<?=$id?>>
<?php } ?>
<input type=hidden name=todo value="update">
</form>
</BODY>
</HTML>
