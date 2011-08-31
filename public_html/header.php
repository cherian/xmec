<?php
  $_menu_number = 0;
  include_once 'xmec.inc';
    if (!XMEC::authenticate_user() && $secure_page) {
      global $PHP_SELF;
      $url = "login.php?xgetpage=$PHP_SELF";
      header("Location: $url");
      exit ;
    }

// Global variable holds the menu no. displayed.
if (!session_is_registered("_menu_number")) {
  session_register("_menu_number");
}
$current_sel = 0;
if (chop($HTTP_GET_VARS["mi"]) != "") {
  $current_sel += chop($HTTP_GET_VARS["mi"]);
  if ($current_sel && $current_sel != $_menu_number) {
    $_menu_number = $current_sel;
  }
}
$onload_str = "";
if ($_menu_number != 0) {
  $onload_str = "onload=javascript:show('".htmlentities($_menu_number)."')";
}

    function show_discussion() {
  echo '<TR>
    <TD align=center><A href="/phorum/index.php?mi=7"><img src="images/discussion.jpg"  border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}
function show_career() {
   echo '<TR>
    <TD align=center><A href="/post_job.php?mi=7"><img src="images/career.jpg" border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
  }
function show_gallery() {
   echo '<TR>
    <TD align=center><A href="/gallery.php?mi=6"><img src="images/gallery.jpg"
 border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
  }
function show_profile() {
  echo '<TR>
    <TD align=center><A href="/editprofile.php?mi=7"><img src="images/profile.jpg"  border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}
function show_password() {
  echo '<TR>
    <TD align=center><A href="/preferences.php?mi=7"><img src="images/password.jpg"  border=0></A></TD>
  </TR><TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}
function show_calendar() {
  echo '<TR>
    <TD align=center><A href="/calendar.php?mi=7"><img src="images/calendar.jpg"  border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}
function show_downloads() {
  echo '<TR>
    <TD align=center><A href="/downloads.php?mi=2"><img src="images/downloads.jpg"  border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}
function show_preferences() {
  echo '<TR>
    <TD align=center><A href="/preferences.php?mi=7"><img src="images/preferences.jpg"  border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}
function show_letters() {
  echo '<TR>
    <TD align=center><A href="/letters.php?mi=4"><img src="images/letters.jpg"  border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}
function show_polls() {
  echo '<TR>
    <TD align=center><A href="/polls.php?mi=7"><img src="images/polls.jpg"  border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}
 function show_groups() {
  echo '<TR>
    <TD align=center><A href="/groups.php?mi=3"><img src="images/groups.jpg"  border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}
function show_bday() {
  echo '<TR>
    <TD align=center><A href="/birthday.php?mi=7"><img src="images/bday.jpg"  border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}
function show_credits() {
  echo '<TR>
    <TD align=center><A href="/credits.php?mi=4"><img src="images/credits.jpg"  border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}
function show_charity() {
  echo '<TR>
    <TD align=center><A href="/charity.php?mi=5"><img src="images/charity.jpg"  border=0></A></TD>
  </TR>
  <TR>
    <TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>';
}





  $user = XMEC::getUser();
?>
<HTML>
<HEAD>
<META NAME="keywords" Content="XMEC,Alumni of Model Engineering College,Kochi,Cochin,Alumni,MEC,College,Kerala,Engineering Colleges in Kerala,MEC Alumni,electronics,computer engineering, information technology,biomedical,ihrd,">
<META NAME="Description" Content="XMEC is the Alumni of Model Engineering College, Kochi. www.xmec.net is the official site for the Alumni of Model Engineering College.">
<TITLE>XMEC - Alumni of Model Engineering College, Kochi</TITLE>
<style>
.linkh{FONT-SIZE: 10px;COLOR: #8EBBE6;LINE-HEIGHT: 130%;FONT-FAMILY: verdana,arial;TEXT-DECORATION: none;}
.linkh:hover{FONT-SIZE: 10px;COLOR: #FFFFFF;LINE-HEIGHT: 130%;FONT-FAMILY: verdana,arial;TEXT-DECORATION: none;}
</style>
<LINK href="style.css" type="text/css" rel="Stylesheet">
<?php if ($need_cal_js) {
echo '<SCRIPT language=JavaScript src="calendar.js" type=text/javascript></SCRIPT>';
} ?>
<script language="javascript">
function show(x)
{
  change();
  document["img"+x].src = "/images/"+x+"_on.gif";
  if (document.all)
    document.all["Layer"+x].style.visibility="visible";
  else if (document.layers) {
    document.layers["Layer"+x].visibility="visible";
  } else { // new w3c standard
    document.getElementById("Layer"+x).style.visibility = "visible";
  }
}
function change()
{
  if (document.all){
    for (var i = 1; i <=7; i++) { // IE 5
      document["img"+i].src = "/images/"+i+"_off.gif";
      document.all["Layer"+i].style.visibility="hidden";
    }
  } else if (document.layers){ // Netscape 4
    for (var i = 1; i <=7; i++) {
      document["img"+i].src = "/images/"+i+"_off.gif";
      document.layers["Layer"+i].visibility="hidden";
    }
  } else {
  // For w3c Complaint browsers do the following after detecting them.
  // To check you can use any Gaecko based browsers. mozilla, galeon,
  // Firebird for example.
  // Also the positioning has been changed.
    for (var i = 1; i <=7; i++) {
      document["img"+i].src = "/images/"+i+"_off.gif";
      document.getElementById("Layer"+i).style.visibility="hidden";
    }
  }
}
</script>

</HEAD>
<BODY <?=$onload_str?> topmargin=0 leftmargin=0 rightmargin=0 marginheight="0" marginwidth="0">
<TABLE cellSpacing=0 cellPadding=0 width=780 border=0 bgcolor="#FFFFFF">
  <TR>
<TD colspan=7 height=53 background="images/topback.jpg" valign=bottom><A name="top"><img src="images/logo.gif" width=520 height=53 usemap="#XMEC" border=0></A></TD>
  </TR>
  <TR>
    <TD colspan=7 height=1 bgcolor="#FFFFFF"><img src="images/space.gif"></TD>
  </TR>
<!--first menu starts-->
  <TR>
    <TD width=15 height=20 bgcolor="#8EBBE6"><img src="images/space.gif"></TD>
    <TD height=20 colspan=5 bgcolor="#8EBBE6" align=left valign=bottom>
<TABLE cellSpacing=0 cellPadding=0 bgcolor="#8EBBE6" align=left border=0>
  <TR>
    <TD><A href="javascript:show('1')" onClick="javascript:show('1')"><img src="images/1_off.gif" name=img1 border=0></A></TD>
    <TD><A href="javascript:show('3')" onClick="javascript:show('3')"><img src="images/3_off.gif" name=img3 border=0></A></TD>
    <TD><A href="javascript:show('4')" onClick="javascript:show('4')"><img src="images/4_off.gif" name=img4 border=0></A></TD>
    <TD><A href="javascript:show('5')" onClick="javascript:show('5')"><img src="images/5_off.gif" name=img5 border=0></A></TD>
    <TD><A href="javascript:show('6')" onClick="javascript:show('6')"><img src="images/6_off.gif" name=img6 border=0></A></TD>
    <TD><A href="javascript:show('7')" onClick="javascript:show('7')"><img src="images/7_off.gif" name=img7 border=0></A></TD>
		<TD><A href="/downloads.php?mi=2" onClick="javascript:show('2')"><img src="images/2_off.gif" name=img2 border=0></A></TD>
 </TR>
</TABLE>
    </TD>
    <TD width=15 height=20 bgcolor="#8EBBE6"><img src="images/space.gif"></TD>
  </TR>
<!--first menu ends-->
<!--second menu starts-->
  <TR>
    <TD colspan=7 height=18 bgcolor="#0958A3"><img src="images/space.gif"></TD>
  </TR>
<!--second menu ends-->
  <TR>
    <TD rowspan=3 width=15 bgcolor="#E6EBEF"><img src="images/space.gif" width=15 height=350></TD>
    <TD rowspan=3 width=1 bgcolor="#FF6666"><img src="images/space.gif"></TD>
    <TD colspan=3 height=26 width=748 align=right>
    <TABLE cellSpacing=0 cellPadding=0 width=740 height=26 border=0 bgcolor="#FFFFFF">
      <TR>
      <?php $user =& XMEC::getUser();
        if ($user->isLoggedIn()):  ?>
        <TD width=570 class=body>Welcome <b class=name>
      <?php echo $user->get('first_name')." ".$user->get('middle_name')." ".$user->get('last_name') ?>
        </b></TD>
        <TD align=right width=70><A href="/login.php?action=logout"><img src="images/logoff.gif" border=0 align=right></A></TD>
      <? else: ?>
        <TD width=570 class=body>Welcome</TD>
        <TD align=right width=70><A href="/login.php"><img src="images/login.gif" border=0 align=right></A></TD>
      <? endif ?>
        <TD align=right width=60 nowrap><A href="/index.php"><img src="images/home.gif" border=0 align=right></A></TD>
      </TR>
    </TABLE>
    </TD>
    <TD rowspan=3 width=1  bgcolor="#FF6666"><img src="images/space.gif"></TD>
    <TD rowspan=3 width=15 bgcolor="#E6EBEF"><img src="images/space.gif" width=15></TD>
  </TR>
  <TR>
    <TD colspan=3 height=1 width=748 bgcolor="#DBDBDB"><img src="images/space.gif"></TD>
  </TR>
  <TR>
<? if (!$no_left_side) { ?>
<!--left side starts-->
    <TD width=125 valign=top>
<TABLE cellSpacing=0 cellPadding=0 width=125 border=0 bgcolor="#FFFFFF">
  <?php
# Put the rows for showing the discussion
if (($this_page == 'xnews') || ($this_page == 'poll') || ($this_page == 'letters')) {
show_discussion();
} ?>
  <?php
# Put the rows for showing career
if (($this_page == 'xmec') || ($this_page == 'univ') || ($this_page == 'vision')|| ($this_page == 'mecnews')) {
show_career();
} ?>
  <?php
# Put the rows for showing gallery
if (($this_page == 'xmec') || ($this_page == 'chapters') || ($this_page == 'college') || ($this_page == 'login') || ($this_page == 'contact') ) {
show_gallery();
} ?>
  <?php
# Put the rows for showing Edit Profile
if (($this_page == 'xmec') || ($this_page == 'poll')) {
show_profile();
} ?>
 <?php
# Put the rows for showing Edit Password
if (($this_page == 'xmec') || ($this_page == 'profile') || ($this_page == 'letters')) {
show_password();
} ?>
 <?php
# Put the rows for showing Letters
if (($this_page == 'groups') || ($this_page == 'profile') || ($this_page == 'college') || ($this_page == 'login') || ($this_page == 'gallery') ) {
show_letters();
} ?>
 <?php
# Put the rows for showing Downloads
if (($this_page == 'xnews') || ($this_page == 'letters') || ($this_page == 'college') || ($this_page == 'contact')) {
show_downloads();
} ?>
 <?php
# Put the rows for showing Preferences
if (($this_page == 'profile') || ($this_page == 'calendar') || ($this_page == 'groups')) {
show_preferences();
} ?>
 <?php
# Put the rows for showing Calendar
if (($this_page == 'vision') || ($this_page == 'activity') || ($this_page == 'xnews')) {
show_calendar();
} ?>
 <?php
# Put the rows for showing Polls
if (($this_page == 'xnews') || ($this_page == 'chapters') || ($this_page == 'accounts') || ($this_page == 'gallery')) {
show_polls();
} ?>
<?php
# Put the rows for showing Birthdays
if (($this_page == 'preferences') || ($this_page == 'univ') || ($this_page == 'mecnews') || ($this_page == 'gallery')) {
show_bday();
} ?>
<?php
# Put the rows for showing Credits
if (($this_page == 'subscribe') || ($this_page == 'preferences') || ($this_page == 'mecnews') || ($this_page == 'bday')) {
show_credits();
} ?>
<?php
# Put the rows for showing Mailing Lists
if (($this_page == 'preferences') || ($this_page == 'contact') || ($this_page == 'accounts')) {
show_groups();
} ?>

  <TR>
    <TD align=center>
<?  if (!$no_search_menu) {   ?>
<!--XMECian search starts-->
<TABLE cellSpacing=2 cellPadding=0 border=0>
<FORM name=frmxsearch method=get action="/search.php">
  <TR>
    <TD colspan=2 align=center><img src="images/xsearch.jpg"></TD>
  </TR>
  <TR>
    <TD colspan=2 class=fname>Name</TD>
  </TR>
  <TR>
    <TD colspan=2><INPUT name=name type=text class=box size=10></TD>
  </TR>
  <TR>
    <TD colspan=2 class=fname>Place</TD>
  </TR>
  <TR>
    <TD><INPUT name=location type=text class=box size=10></TD>
    <TD><INPUT name=b type=image src="images/go.gif" border=0 width=15 height=15></TD>
  </TR>
  <TR>
    <TD colspan=2 align=center height=20><A href="/search.php" class=link><b>Advanced Search</b></A></TD>
  </TR>
  <INPUT TYPE=HIDDEN NAME=".s" VALUE="Search">
</FORM>
</TABLE>
<?  }  ?>
<!--XMECian search ends-->
     </TD>
  </TR>
</TABLE>
<!--left side ends-->
    </TD>
    <TD width=1 bgcolor="#FF6666"><img src="images/space.gif"></TD>
    <TD width=622 valign=top>
<? } else { ?>
    <TD width=740 valign=top>
<? } ?>
<div id="Layer1"  style="position:absolute; visibility: hidden; top:74px; left:30px;">
<TABLE width=285 cellSpacing=1 cellPadding=1 border=0>
  <TR>
    <TD><A href="/xmec.php?mi=1" class=linkh>Xmec</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/college.php?mi=1" class=linkh>College</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/university.php?mi=1" class=linkh>University</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/contact.php?mi=1" class=linkh>Contact Us</A></TD>
		<TD class=linkh>|</TD>
    <TD><A href="/vision.php?mi=1" class=linkh>Vision</A></TD>
  </TR>
</TABLE>
</div>
<div id="Layer2"  style="position:absolute; visibility: hidden; top:74px; left:74px;">
</div>
<div id="Layer3"  style="position:absolute; visibility: hidden; top:74px; left:98px;">
<TABLE width=110 cellSpacing=1 cellPadding=1 border=0>
  <TR>
    <TD><A href="/search.php?mi=3" class=linkh>Search</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/groups.php?mi=3" class=linkh>Groups</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/subscription.php?mi=3" class=linkh>Subscriptions</A></TD>
    <?php if ($user->isAdmin()) { ?>
    <TD class=linkh>|</TD>
    <TD><A href="/admin.php?mi=3" class=linkh>Administration</A></TD>
    <? } ?>
  </TR>
</TABLE>
<!-- /TABLE is this the probs Pash -->
</div>
<div id="Layer4"  style="position:absolute; visibility: hidden; top:74px; left:172px;">
<TABLE width=170 cellSpacing=1 cellPadding=1 border=0>
  <TR>
    <TD><A href="/xnews.php?mi=4" class=linkh>XMEC</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/mecnews.php?mi=4" class=linkh>College</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/letters.php?mi=4" class=linkh>Letters</A></TD>
  </TR>
</TABLE>
</div>
<div id="Layer5"  style="position:absolute; visibility: hidden; top:74px; left:223px;">
<TABLE width=170 cellSpacing=1 cellPadding=1 border=0>
  <TR>
    <TD><A href="/colact.php?mi=5" class=linkh>College</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/chapters.php?mi=5" class=linkh>Chapters</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/post_job.php?mi=5" class=linkh>Careers</A></TD>
  </TR>
</TABLE>
</div>
<div id="Layer6"  style="position:absolute; visibility: hidden; top:74px; left:293px;">
<TABLE width=95 cellSpacing=1 cellPadding=1 border=0>
  <TR>
    <TD><A href="/gallery.php?mi=6" class=linkh>Gallery</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/video.php?mi=6" class=linkh>Video</A></TD>
  </TR>
</TABLE>
</div>
<div id="Layer7"  style="position:absolute; visibility: hidden; top:74px; left:195px;">
<TABLE width=475 cellSpacing=1 cellPadding=1 border=0>
  <TR>
    <TD><A href="/calendar.php?mi=7" class=linkh>Calendar</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/post_job.php?action=post" class=linkh>Post a Job</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/phorum/index.php?mi=7" class=linkh>Discussions</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/polls.php?mi=7" class=linkh>Polls</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/accounts.php?mi=7" class=linkh>Accounts</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/editprofile.php?mi=7" class=linkh>My Profile</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/preferences.php?mi=7" class=linkh>My Preferences</A></TD>
  </TR>
</TABLE>
</div>
