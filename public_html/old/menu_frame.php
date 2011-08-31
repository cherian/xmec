<?php

	include 'xmec.inc';

	reset($HTTP_POST_VARS);
	$action = chop($HTTP_POST_VARS["action"]);
	if ($REQUEST_METHOD == "GET")
		$action = chop($HTTP_GET_VARS["action"]);
	$login_success = FALSE;

	if ($target == "")
		$target = "members.php";
	
	if ($action == "login") {
		$userid = chop($HTTP_POST_VARS["rollno"]);
		$pass = chop($HTTP_POST_VARS["passwd"]);
		$target = chop($HTTP_POST_VARS["target"]);

		if (XMEC::authenticate_user()) {
			XMEC::user_logout();
		}

		if (XMEC::user_login($userid, $pass)) {
			$login_success = TRUE;
			$url = "$PHP_SELF?action=null&target=";
			$url .= rawurlencode($target);
			header("Location: $url");
			exit ;
		}
	} else if ($action == "logout") {
		XMEC::user_logout();
	} else 
		XMEC::authenticate_user();

	$user =& XMEC::getUser();
	if (!$user->isLoggedIn()) {
		$user->set('first_name', "Guest");
		$user->set('last_name', "");
	} else {
		$login_success = TRUE;
	}

?>

<HTML>
<HEAD>
<?php if ($login_success): ?>
<script>parent.targetframe.location.href="<?=$target?>";</script>
<?php elseif ($action == "logout"): ?>
<script>parent.targetframe.location.href="logout.html";</script>
<?php endif; ?>
<LINK rel=stylesheet href="style.css" type="text/css">
</HEAD>
<BODY bgcolor="#FFFFFF" topmargin=0 leftmargin=0 marginheight = "0" marginwidth = "0" background="images/leftbanner.jpg">

<script Language="JavaScript">

var x;
var y;

<?php 
if ($login_success) {
 if ($user->isAdmin()) 
    echo "var no = 8;";
 else 
    echo "var no = 7;";
} else {
  echo "var no = 6;";
}
?>

var str = "";

function change(){

if (document.all){
for (var i = 1; i <= no; i++) {
document.all("Menu"+i).style.visibility="hidden"}
}
if (document.layers){
for (var i = 1; i <= no; i++) {
document.layers["Menu"+i].visibility="hidden"}
}
}

function show(x){
change();

if (document.all){
document.all("Menu"+x).style.visibility="visible"}

if (document.layers){
document.layers["Menu"+x].visibility="visible"}
}

function wait(x){
setTimeout(change, 8000)
}

</script>
<div id='Layer1' z-index=3 class='title' style='top:20px;'><img src='images/anim.gif' border=0><A class=menu href='#' OnMouseover="JavaScript:show('1')" OnMouseout="JavaScript:wait('7')" >About Us</a></div>
<div id='Menu1' z-index=2 class='submenu' style='top:20px'>
<TABLE border=0 cellpadding=0 cellspacing=0 height=80 width=140 background='images/sub4.gif'>
<TR><TD>
<TABLE border=0 cellpadding=0 cellspacing=0 height=80 width=140 background=''>
<TR><TD width=75 align=right>&nbsp;</TD>
<TD width=65 align=center><A class=menu href='aboutus.html' target='targetframe'>Xmec</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='college.html'>College</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='university.html'>University</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='contact.html'>Contacts</A></TD></TR>
</TABLE></TD></TR>
</TABLE>
</div>


<div id='Layer2' z-index=3 class='title'  style='top:45px;'><img src='images/anim.gif' border=0><A class=menu href='#' OnMouseover="JavaScript:show('2')" OnMouseout="JavaScript:wait('12')" >Vision</a></div>
<div id='Menu2' z-index=2 class='submenu' style='top:45px'>
<TABLE border=0 cellpadding=0 cellspacing=0 height=22 width=140 background='images/sub1.gif'>
<TR><TD>
<TABLE border=0 cellpadding=0 cellspacing=0 height=22 width=140 background=''>
<TR><TD width=75 align=left>&nbsp;</TD>
<TD width=65 align=center><A class=menu target='targetframe' href='vision.html'>Vision</A></TD></TR>
</TABLE></TD></TR>
</TABLE>
</div>


<div id='Layer3' z-index=3 class='title'  style='top:70px;'><img src='images/anim.gif' border=0><A class=menu href='#' OnMouseover="JavaScript:show('3')" OnMouseout="JavaScript:wait('11')" >XMECian</a></div>
<div id='Menu3' z-index=2 class='submenu' style='top:70px;'>
<TABLE border=0 cellpadding=0 cellspacing=0 height=40 width=140 background='images/sub2.gif'>
<TR><TD>
<TABLE border=0 cellpadding=0 cellspacing=0 height=40 width=140 background=''>
<TR><TD width=75 align=left>&nbsp;</TD>
<TD width=65 align=center><A class=menu target='targetframe' href='search.php'>Search</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='group.html'>Groups</A></TD></TR>
</TABLE></TD></TR>
</TABLE>
</div>

<div id='Layer4' z-index=3 class='title'  style='top:95px;'><img src='images/anim.gif' border=0><A class=menu href='#' OnMouseover="JavaScript:show('4')" OnMouseout="JavaScript:wait('8')" >News</a></div>
<div id='Menu4' z-index=2 class='submenu' style='top:95px'>
<TABLE border=0 cellpadding=0 cellspacing=0 height=60 width=140 background='images/sub3.gif'>
<TR><TD>
<TABLE border=0 cellpadding=0 cellspacing=0 height=60 width=140 background=''>
<TR><TD width=75 align=left>&nbsp;</TD>
<TD width=65 align=center><A class=menu target='targetframe' href='xnews.html'>XMEC</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='mecnews.html'>College</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='letters.html'>Letters</A></TD></TR>
</TABLE></TD></TR>
</TABLE>
</div>

<div id='Layer5' z-index=3 class='title'  style='top:120px;'><img src='images/anim.gif' border=0><A class=menu href='#' OnMouseover="JavaScript:show('5')" OnMouseout="JavaScript:wait('9')" >Activities</a></div>
<div id='Menu5' z-index=2 class='submenu' style='top:120px'>
<TABLE border=0 cellpadding=0 cellspacing=0 height=60 width=140 background='images/sub3.gif'>
<TR><TD>
<TABLE border=0 cellpadding=0 cellspacing=0 height=60 width=140	 background=''>
<TR><TD width=75 align=left>&nbsp;</TD>
<TD width=65 align=center><A class=menu target='targetframe' href='colact.html'>College</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='chapters.html'>Chapters</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='careers.html'>Career</A></TD></TR>
</TABLE></TD></TR>
</TABLE>
</div>

<div id='Layer6' z-index=3 class='title'  style='top:145px;'><img src='images/anim.gif' border=0><A class=menu href='#' OnMouseover="JavaScript:show('6')" OnMouseout="JavaScript:wait('10')" >Galleria</a></div>
<div id='Menu6' z-index=2 class='submenu' style='top:145px'>
<TABLE border=0 cellpadding=0 cellspacing=0 height=40 width=140 background='images/sub2.gif'>
<TR><TD>
<TABLE border=0 cellpadding=0 cellspacing=0 height=40 width=140 background=''>
<TR><TD width=75 align=left>&nbsp;</TD>
<TD width=65 align=center><A class=menu target='targetframe' href='gallery.html'>Gallery</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='video.html'>Video</A></TD></TR>
</TABLE></TD></TR>
</TABLE>
</div>

<?php if ($login_success): ?>

<div id='Layer7' z-index=3 class='title'  style='top:170px;'><img src='images/anim.gif' border=0><A class=menu href='#' OnMouseover="JavaScript:show('7')" OnMouseout="JavaScript:wait('12')" >Members</a></div>
<div id='Menu7' z-index=2 class='submenu' style='top:170px'>
<TABLE border=0 cellpadding=0 cellspacing=0 height=140 width=140 background='images/sub5.gif'>
<TR><TD>
<TABLE border=0 cellpadding=0 cellspacing=0 height=140 width=140 background=''>
<TR><TD align=left width=75>&nbsp;</TD>
<TD width=65 align=center><A class=menu target='targetframe' href='construct.html'>Chat</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='construct.html'>Post a Job</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='phorum/index.php'>Bulletin</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='polls.php'>Polls</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='accounts.html'>Accounts</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='editprofile.php'>Profile</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='preferences.php'>Options</A></TD></TR>
</TABLE></TD></TR>
</TABLE>
</div>

<?php if ($user->isAdmin()): ?>
<div id='Layer8' z-index=3 class='title'  style='top:195px;'><img src='images/anim.gif' border=0><A class=menu href='#' OnMouseover="JavaScript:show('8')" OnMouseout="JavaScript:wait('11')" >Admins</a></div>
<div id='Menu8' z-index=2 class='submenu' style='top:195px;'>
<TABLE border=0 cellpadding=0 cellspacing=0 height=60 width=140 background='images/sub3.gif'>
<TR><TD>
<TABLE border=0 cellpadding=0 cellspacing=0 height=40 width=140 background=''>
<TR><TD width=75 align=left>&nbsp;</TD>
<TD width=65 align=center><A class=menu target='targetframe' href='phorum/nimida/index.php'>Phorum</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='sql_query.php'>Run Query</A></TD></TR>
<TR><TD>&nbsp;</TD><TD align=center><A class=menu target='targetframe' href='poll/polls/phpPollAdmin.php3'>Polls</A></TD></TR>
</TABLE></TD></TR>
</TABLE>
</div>
<?php endif; ?>

<div id='Layer9' z-index=5 class='title'  style='top:<?=$user->isAdmin()?"220":"195"?>px;'>
<TABLE width=75 cellpadding=0 cellspacing=0 border=0>
<TR><TD align=left><img src='images/anim.gif' border=0><A class=menu href="<?=$PHP_SELF?>?action=logout">Logout</A></TD></TR></TABLE>
</div>
<div id='Layer10' z-index=5 class='title'  style='top:315px;'>
<TABLE width=140 cellpadding=0 cellspacing=0 border=0> 
<TR><TD align=center valign=bottom><font face="arial narrow","arial" size=3 color="#FFFF00"><b>Welcome<br> <?echo $user->get('first_name'). " ".$user->get('last_name');?></b></font></TD></TR></TABLE>
</div>

<?php else: ?>

<div id='Layer7' z-index=4 class='title' style='top:170px;'>
<form name=frmlogin method=POST action=<?=$PHP_SELF?>>
<?php 
    if ($HTTP_GET_VARS["target"]!= "")
      echo "<INPUT type=hidden name=target value=".$HTTP_GET_VARS["target"].">";
?>
<TABLE width=140 cellpadding=0 cellspacing=0 border=0>
<TR><TD align=left colspan=2><img src='images/anim.gif' border=0><font face=arial size=2 color="#FFFFFF"><b>Login</B></TD></TR>
<TR><TD rowspan=4 width=17>&nbsp;</TD><TD align=left><INPUT name=rollno type=text class=back size=12 height=18></TD></TR>
<TR><TD align=left><font face=arial size=2 color="#FFFFFF"><b>Password</b></TD></TR>
<TR><TD align=left><INPUT name=passwd type=password class=back size=12 height=18></TD></TR>
<TR><TD align=center valign=bottom><A href=problem.html target=targetframe><img src="images/help.gif" alt="Help" align=right border=0></A>
<input type="image" src="images/go.gif" alt="Go" border=0 target=targetframe></A>
</TD></TR>

<?php if ($action ==  "login" && $login_success == FALSE): ?>
<TR><TD align=center colspan=2><font face=arial color="#FF0000" size=2><b>Authorization Failed <b></font></TD></TR>

<?php endif; ?>
<TR><TD align=center colspan=2>&nbsp;</TD></TR>
<TR><TD align=center colspan=2 valign=bottom><font face="arial narrow","arial" size=3 color="#FFFF00"><b>Welcome <?echo $user->get('first_name'). " ".$user->get('last_name');?></b></font></TD></TR>
</TABLE>
<INPUT type=hidden name=action value="login">
</form>
</div>

<?php endif; ?>

</BODY>
</HTML>
