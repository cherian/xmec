<?php
  $secure_page=1;
  $this_page="preferences";
  include 'header.php';
        //include 'xmec.inc';
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
  $webpage = $user->get('webpage');
  $forwarding_addr = $user->get('forwarding_addr');
  $alias = $user->get('forwarding_addr');


  $pass_st = "";
  $email_st = "";
  $addr_st = "";

  if ($action == "update") {
	$need_update = FALSE; 

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
    //Fwding Email
	if ($forwarding_email != $fwd_addr) {
		$user->set("forwarding_email", $fwd_addr); 
		$need_update = TRUE;
	}

    //Fwding URL
	if ($webpage != $web_addr) {
		$user->set("webpage", $web_addr);
		$need_update = TRUE;
    }

	if ($alias != $lalias) {
		$user->set("alias", $lalias);
		$need_update = TRUE;
	}
	if ($need_update = TRUE) {
		if (!$user->Update()) {
			$st_email .= $user->getError();
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
    else if (document.f1.passwd2.value != document.f1.passwd3.value)      alert("Passwords doesn't match");
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

<form name=f1 method=POST>
<TABLE align=left border=0 cellPadding=4 cellSpacing=0 width=100% height="100%">
<TR>
<TD valign=middle height=40 width=100%>
<P class=head align=center>My Preferences

<?php
  if ($pass_st != "" || $email_st != "" || $addr_st != "" || $fwd_email_st != "")
  echo "<br><FONT face=arial size=2 color=\"#FF0000\">Failed updating preferences: $pass_st  $email_st  $addr_st $fwd_email_st</font><br>";
  else if ($action == "update")
  echo "<br><FONT face=arial size=2 color=\"#00FF00\">Successfully updated preferences</font><br>";
?>
</P>

</TD></TR>
<TR><TD>

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
<TABLE cellSpacing=0 cellPadding=4 border=0><TR><TD>
<P class=head><b>Change Password </b></P>
<P class=fbody>
You can change your password and the next time you login in, the system will accept the new password. Please use a distinctive word (more than 8 letters). </P>

<TABLE align=center border=0 cellPadding=2 cellSpacing=0 width=90%>
<TR>
  <TD class=fbody width=64%>Old password</TD>
  <TD><INPUT class=lbox name=passwd1 type=password></TD>
</TR>

<TR>
  <TD class=fbody width=64%>New password</TD>
  <TD><INPUT class=lbox name=passwd2 type=password></TD>
</TR>

<TR>
  <TD class=fbody width=64%>Confirm New password</TD>
  <TD><INPUT class=lbox name=passwd3 type=password></TD>
</TR>
</TABLE><BR>

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

</TR></TD>
<TR><TD>

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
<TABLE cellSpacing=0 cellPadding=4 border=0>
<TR><TD>
<?php
$login_alias_defined = ( ($user->get('id') != $user->get('alias')) &&
                          (trim($user->get('alias')) != "")  );
$login_alias = "";
if ($login_alias_defined) {
  $login_alias = htmlentities($user->get('alias'));
}
?>
<P class=body><b>Login Alias</b><BR>
You can choose to create an additional Login Alias to log on to the site. Your default login ID of <strong> <?=$user->get('id')?></strong> will continue to be enabled. Your choice of Login Alias will be accepted only if it is unique and not taken by any other XMECian already. You can choose an alias like <i><?=htmlentities($user->get('first_name'))?>_<?=htmlentities($user->get('last_name'))?></i> or <i><?=htmlentities($user->get('first_name'))?>123 </i><br>
A forwarding email address of the form <i>your_alias</i>@xmec.net and a URL of the form http://www.xmec.net/<i>your_alias</i> will be made available to you if you choose to create a login alias.
</P>
<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width=90%>
<TR>
  <TD class=fbody width=64%>Login Alias</TD>
  <TD align=right><INPUT class=lbox name=lalias value=<?=$login_alias?>></TD>
</TR>
</TABLE><BR>
<P class=body><b>XMEC Forwarding ID </b><BR>
<?php
  if (!$login_alias_defined) {
?>
An Email alias of the form <i>your_alias</i>@xmec.net is created when you create a Login Alias. You can choose to forward mails sent to this ID to an email mailbox of your choice.</P>
<?php
  } else {
?>
An Email alias <i><?=$login_alias?>@xmec.net</i> is defined for you. You can choose to forward mails sent to this ID to an email mailbox of your choice.</P>
<?php
  }
?>
<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width=90%>
<TR>
  <TD class=fbody width=64%>Forward <strong><?=$login_alias?>@xmec.net</strong> mails to</TD>
  <TD align=right><INPUT class=lbox name=fwd_addr value="<?=htmlentities($user->get('forwarding_email'))?>"></TD>
</TR>
</TABLE><BR>
<?php
  if (!$login_alias_defined) {
    $login_alias = "<i>your_alias</i>";
  }
?>

<P class=body><b>XMEC URL Link </b><BR>You can redirect http://www.xmec.net/<?=$login_alias?> to your existing homepage or an URL of your choice.</P>
<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width=90%>
<TR>
  <TD class=fbody width=64%>Redirect <strong>http://www.xmec.net/<?=$login_alias?></strong> to</TD>
  <TD align=right><INPUT class=lbox name=web_addr value="<?=htmlentities($user->get('webpage'))?>"></TD>
</TR>
</TABLE><BR>

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

</TR></TD>
<TR><TD>

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
<TABLE cellSpacing=0 cellPadding=4 border=0><TR><TD>

<P class=fbody><B>XMEC Yahoo! Groups Subscription</B>
<BR>
You can add or change the Email ID that you want to receive all XMEC and XMEC-Jobs Yahoo!Groups mails. Please allow two days for processing the request.</A></P>

<TABLE align=center border=0 cellPadding=2 cellSpacing=0 width=90%>
<TR>
  <TD class=fbody width=64%>Unsubscribe this ID from <B>xmec</B> groups</TD>
  <TD><INPUT class=lbox name=TBXMECEAddrold></TD>
</TR>
<TR>
  <TD class=fbody>Subsribe this ID to <B>xmec</B> groups</TD>
  <TD><INPUT class=lbox name=TBXMECEAddrNew></TD>
</TR>
<TR>
  <TD colspan=2 ><BR><BR></TD>
</TR>

<TR>
  <TD class=fbody>Unsubscribe this ID from <B>xmec-jobs</B> groups</TD>
  <TD><INPUT class=lbox name=TBXMECJobsEAddrold></TD>
</TR>
<TR><TD class=fbody>Subscribe this ID to <B>xmec-jobs</B> groups</TD>
  <TD><INPUT class=lbox name=TBXMECJobsEAddrNew></TD>

</TR>
</TABLE>
<BR>

</TR></TD></TABLE>
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

</TR></TD>
<TR><TD>

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
<TABLE cellSpacing=0 cellPadding=4 border=0><TR><TD>
<P class=fbody><B>Profile Security </B><BR>
Some of your profile information can be viewed. You can however set your preferences with respect to visibility of certain information. </P>

<TABLE align=center border=0 cellPadding=2 cellSpacing=0 width=90%>
<TR><TD width=64% class=fbody>Personal Email ID</TD>
  <TD ><SELECT name=pemail class=cbox style="width:144px">
    <OPTION value="PUBLIC" <?if($pemail_pref=='PUBLIC')echo 'SELECTED';?> >Public</OPTION>
    <OPTION value="XMEC" <?if($pemail_pref=='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION>
    <OPTION value="PRIVATE" <?if($pemail_pref=='PRIVATE')echo 'SELECTED';?>>Restricted</OPTION></SELECT></TD></TR>
<TR><TD class=fbody>Official Email ID</TD>
  <TD><SELECT name=oemail class=cbox style="width:144px">
    <OPTION value="PUBLIC" <?if($oemail_pref=='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
    <OPTION value="XMEC" <?if($oemail_pref=='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION>
    <OPTION value="PRIVATE" <?if($oemail_pref=='PRIVATE')echo 'SELECTED';?>>Restricted</OPTION></SELECT></TD></TR>

<TR>
  <TD class=fbody>Current Address</TD>
  <TD>
    <SELECT name=curr class=cbox style="width:144px">
    <OPTION value="PUBLIC" <?if($curr_visib =='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
    <OPTION value="XMEC" <?if($curr_visib =='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION>
    </SELECT>
  </TD>
</TR>

<TR>
  <TD class=fbody>Company Address</TD>
  <TD>
    <SELECT name=comp class=cbox style="width:144px">
    <OPTION value="PUBLIC" <?if($comp_visib =='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
    <OPTION value="XMEC" <?if($comp_visib =='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION>
    </SELECT>
  </TD>
</TR>

<TR>
  <TD class=fbody>Permanent Address</TD>
  <TD>
    <SELECT name=perm class=cbox style="width:144px">
    <OPTION value="PUBLIC" <?if($perm_visib =='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
    <OPTION value="XMEC" <?if($perm_visib =='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION>
    </SELECT>
  </TD>
</TR>
</TABLE><BR><BR>

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

</TR></TD>
<TR><TD>

<?php if (!0) { //Disabled... ?>

<!--Box Starts-->
<TABLE cellSpacing=0 cellPadding=0 border=0 width=90% align=center>
<TBODY>
<TR>
<TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
<TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
<TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
<TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
</TR>
<TR>
<TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6
src="images/tb_left_topb.gif" width=3></TD>
<TD colSpan=2 rowSpan=2>
<!--Content Starts-->
<TABLE cellSpacing=0 cellPadding=4 border=0><TR><TD>

<P><b>Reminders</b><BR>
Do you wish to receive any reminder on the forthcoming Birthdays of fellow XMECians? </P>
<TABLE align=center border=0 width=25% cellPadding=0 cellSpacing=0>
<TR><TD><INPUT name=checkbox1 type=radio></TD><TD><P>Yes</P></TD>
<TD><INPUT name=checkbox1 type=radio checked></TD><TD><P>No</P></TD></TR>
</TABLE><BR><BR>

</TR></TD></TABLE>
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

<?php } //Disabled... ?>

<BR>

<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width=200>
<TR><TD align=middle><INPUT name=submit1 type=button value=Submit onClick="javascript:validate();"></TD>
<TD align=middle><INPUT name=reset1 type=reset value=Reset></TD></TR>
</TABLE><BR><BR>


</TD>
</TR>
</TABLE>
<?php if ($admin) { ?>
<input type=hidden name=.s value=1>
<input type=hidden name=id value=<?=$id?>>
<?php } ?>
<input type=hidden name=todo value="update">
</form>
<?php
include 'footer.php';
?>
