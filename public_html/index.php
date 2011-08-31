<?php
	include_once 'xmec.inc';
	include_once 'functions.php';

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
<META NAME="keywords" Content="XMEC,Alumni of Model Engineering College,Kochi,Cochin,Alumni,MEC,College,Kerala,Engineering Colleges in Kerala,MEC Alumni,electronics,computer engineering, information technology,biomedical,ihrd,">
<META NAME="Description" Content="XMEC is the Alumni of Model Engineering College, Kochi. www.xmec.net is the official site for the Alumni of Model Engineering College.">
<TITLE>XMEC - Alumni of Model Engineering College, Kochi</TITLE>
<LINK href="style.css" type="text/css" rel="Stylesheet">
<style>
.linkh{FONT-SIZE: 10px;COLOR: #8EBBE6;LINE-HEIGHT: 130%;FONT-FAMILY: verdana,arial;TEXT-DECORATION: none;}
.linkh:hover{FONT-SIZE: 10px;COLOR: #FFFFFF;LINE-HEIGHT: 130%;FONT-FAMILY: verdana,arial;TEXT-DECORATION: none;}
</style>

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
<BODY topmargin=0 leftmargin=0 rightmargin=0 marginheight="0" marginwidth="0">
<TABLE cellSpacing=0 cellPadding=0 width=780 border=0 bgcolor="#FFFFFF">
  <TR>
    <TD colspan=9 height=53 background="images/topback.jpg" valign=bottom><img src="images/logo.gif" width=520 height=53 usemap="#XMEC" border=0></TD>
  </TR>
  <TR>
    <TD colspan=9 height=1 bgcolor="#FFFFFF"><img src="images/space.gif"></TD>
  </TR>
  <TR>
    <TD width=15 height=20 bgcolor="#8EBBE6"><img src="images/space.gif"></TD>
    <TD height=20 colspan=7 bgcolor="#8EBBE6" align=left valign=bottom>
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
    <TD width=15 colspan=9 height=18 bgcolor="#0958A3"><img src="images/space.gif"></TD>
  </TR>
  <TR>
    <TD rowspan=3 width=15 bgcolor="#E6EBEF"><img src="images/space.gif"></TD>
    <TD rowspan=3 width=1 bgcolor="#FF6666"><img src="images/space.gif"></TD>
    <TD colspan=5 height=26 width=748>
		<TABLE cellSpacing=0 cellPadding=0 width=740 height=26 border=0 bgcolor="#FFFFFF">
		  <TR>
			<?php $user =& XMEC::getUser();
				if ($user->isLoggedIn()):  ?>
				<TD class=body>&nbsp;&nbsp;&nbsp;&nbsp;Welcome <b class=name>
			<?php echo $user->get('first_name')." ".$user->get('middle_name')
						." ".$user->get('last_name') ?>
				</b></TD>
				<TD align=right><A href="/login.php?action=logout"><img src="images/logoff.gif" border=0></A></TD>
			<? endif ?>
		  </TR>
	</TABLE>
    </TD>
    <TD rowspan=3 width=1  bgcolor="#FF6666"><img src="images/space.gif"></TD>
    <TD rowspan=3 width=15 bgcolor="#E6EBEF"><img src="images/space.gif"></TD>
  </TR>
  <TR>
    <TD colspan=5 height=1 width=748 bgcolor="#DBDBDB"><img src="images/space.gif"></TD>
  </TR>
  <TR>
    <TD width=125 valign=top>
<!--left side starts-->
<TABLE cellSpacing=0 cellPadding=0 width=125 border=0 bgcolor="#FFFFFF">
  <TR>
  	<TD align=center height=100><A href="/phorum/index.php"><img src="images/discussion.jpg" border=0></A></TD>
  </TR>
  <TR>
  	<TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD align=center>
<!--XMECian search starts-->
<TABLE cellSpacing=2 cellPadding=0 border=0>
<form name=frmxsearch action="/search.php" method="GET">
<input type=hidden name=.s value=Search>
  <TR>
  	<TD colspan=2 align=center height=20><img src="images/xsearch.jpg" ></TD>
  </TR>
  <TR>
  	<TD colspan=2 class=fname>Name</TD>
  </TR>
	<TR>
    <TD colspan=2 ><INPUT name=name type=text class=box size=10></TD>
  </TR>

  <TR>
  	<TD colspan=2 class=fname>Place</TD>
  </TR>
	<TR>
    <TD ><INPUT name=location type=text class=box size=10></TD>
    <TD align=center><INPUT name=bttnxsearch type=image src="images/go.gif" border=0 width=15 height=15></TD>
  </TR>
  <TR>
  	<TD colspan=2 align=center height=20><A class=link href="/search.php"><B>Advanced Search</B></A></TD>
  </TR>
</form>
</TABLE>
<!--XMECian search ends-->
   	</TD>
  </TR>
  <TR>
  	<TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD align=center><A href="/letters.php"><img src="images/letters.jpg" border=0></A></TD>
  </TR>
</TABLE>
<!--left side ends-->
   </TD>
    <TD width=1 bgcolor="#FF6666"><img src="images/space.gif"></TD>
    <TD width=496 bgcolor="#F5F5F5" valign=top>
<!--center starts-->
<TABLE cellSpacing=0 cellPadding=0 width=496 height=196 border=0>
  <TR>
  <?php $user =& XMEC::getUser();

   if ($user->isLoggedIn()):  ?>
  	<TD width=225 valign=top bgcolor="#DDF5FF">
	<P><font color=#E00A55><b>Top XMEC Employers</b></font></P>
	<?php
	$dbh =& XMEC::getDB();
	$sql = "SELECT company, COUNT(*) AS Entries FROM xmec_user GROUP BY company ORDER by Entries DESC LIMIT 1,5;";
		if (DB::isManip($sql)) {
			echo "No manipulation queries please !";
		} else {
			$r = $dbh->query(XMEC_user::unQuote($sql));
			if (DB::isError($r)) {
				echo "Query: $sql failed.";
			} else {
				echo "<table border=0>";
				while (is_array($x = $r->fetchRow())) {
				  echo "<tr>";
				  for ($i=0; $i<count($x); $i++) echo "<td class=body>$x[$i]</td>";
				  echo "</tr>";
				  }
				echo "<tr><td colspan=2 align=right><P><A href=companies.php class=link>...more</A></P></td><tr>";
				echo "</table>";
			}
			echo "</td>";
	}
	?>
	</td>
	 <TD width=5 height=100><img src="images/space.gif"></TD>
		<TD width=225 valign=top bgcolor="#F9FFDF">
		<P ><font color=#456B52><b>Top XMEC Jobs</B></font></P>
		<?php
		$dbh =& XMEC::getDB();
		$sqle = "SELECT work_type, COUNT(*) AS Entries FROM xmec_user GROUP BY work_type ORDER by Entries DESC LIMIT 1,5;";
			if (DB::isManip($sqle)) {
				echo "No manipulation queries please !";
			} else {
				$r = $dbh->query(XMEC_user::unQuote($sqle));
				if (DB::isError($r)) {
					echo "Query: $sqle failed.";
				} else {
					echo "<table border=0>";
					while (is_array($x = $r->fetchRow())) {
					  echo "<tr>";
					  for ($i=0; $i<count($x); $i++) echo "<td class=body>$x[$i]</td>";
					  echo "</tr>";
					}
					echo "<tr><td colspan=2 align=right><P><A href=aow.php class=link>...more</A></P></td><tr>";
					echo "</table>";
					echo "</td>";
				}

		}
	?>
	</td>
	</TR>
	<TR>
	  	<TD width=225 valign=top bgcolor="#CEE3C1">
	<P BORDER=1><font color=#DE650C ><b>Current XMEC Poll</b></font></P>
<?php
		$dbh =& XMEC::getDB();
		$sql = "SELECT title FROM poll_questions WHERE (".
    	"(start_date <= NOW()) AND ".
    	"(end_date >= NOW()) )";
			if (DB::isManip($sql)) {
				echo "No manipulation queries please !";
			} else {
				$r = $dbh->query(XMEC_user::unQuote($sql));
				if (DB::isError($r)) {
					echo "Query: $sql failed.";
				} else {

					while (is_array($x = $r->fetchRow())) {
					  for ($i=0; $i<count($x); $i++) echo "<P><a href=polls.php class=flink>$x[$i]</a><BR></P>";
						}
						}
						echo "</td>";
		}
		?>
	</td>

	<TD width=5 ><img src="images/space.gif"></TD>
		<TD width=225 valign=top class=name bgcolor="#FBB3AA">
		<P ><font color=#574844><B>Webmasters' Note</B></font></P>
		<P><a href=invite.php class=flink>Wish to join the XMEC.net development?</A></P>
	</td>
	</TR>

	<TR>
	<? else: ?>
  	<TD width=10><img src="images/space.gif"></TD>
  	<TD valign=top><BR>
  	<P class=body><font color=grey><b>XMEC is the abbreviation for exMECians, the Alumni Association of Model Engineering College, Thrikkakara, Kochi. XMEC is an autonomous body representing thousand three hundred and more engineers who have earned their degrees in
  	Model Engineering College. It binds together MECians who are spread out in institutions and industries around the globe. The backbone of XMEC is the relentless support and cooperation of all exMECians who live in India and abroad and
  	who are proud to announce "MEC made me what I'm today". </b></font></P></TD>
  	<TD width=10><img src="images/space.gif"></TD>
  </TR>
  <TR><td></td><td>New&nbsp;&nbsp;<a href="XMEC-News-Jul.php">Newletter</a></td></tr>
  <TR>
  	<TD height=15 colspan=4 align=right><A href="/xmec.php" class=news>more >></A></TD>
  </TR>
  <? endif ?>
  <TR>
  	<TD height=15 colspan=4 bgcolor="#DBDBDB"></TD>

  </TR>
</TABLE><BR><BR>
<TABLE cellSpacing=0 cellPadding=0 width=490 height=100 border=0>
  <TR>
  	<TD align=center><A href="/colact.php"><img src="images/activities.jpg" border=0></A></TD>
  	<TD align=center><A href="/polls.php"><img src="images/polls.jpg" border=0></A></TD>
  	<TD align=center><A href="/gallery.php"><img src="images/gallery.jpg" border=0></A></TD>
  </TR>
</TABLE>
<!--center ends-->
    </TD>
    <TD width=1 bgcolor="#FF6666"><img src="images/space.gif"></TD>
    <TD width=125 valign=top>
<!--rightt side starts-->
<TABLE cellSpacing=0 cellPadding=0 width=125 border=0 bgcolor="#FFFFFF">
  <TR>
  	<TD align=center>
<!--members login starts-->
<? renderLoginBox() ?>
<!--members login ends-->
  	</TD>
  </TR>
  <TR>
  			<?php $user =& XMEC::getUser();

  				if ($user->isLoggedIn()):  ?>
  				<TD height=29><A href="/editprofile.php"class=flink><img src="images/dot.gif" border=0>My Profile</A></TD>
  			</TR>
			<TR>
  				<TD height=29><A href="/preferences.php"class=flink><img src="images/dot.gif" border=0>My Preferences</A></TD>
  			</TR>
  			<TR>
  				<TD height=29><A href="/statistics.php"class=flink><img src="images/dot.gif" border=0>XMEC Statistics</A></TD>
  			</TR>
			<TR>
  				<TD height=29><A href="/subscription.php"class=flink><img src="images/dot.gif" border=0>Subscribe to XMEC</A></TD>
  			<? endif ?>
  </TR>
  <TR>
  	<TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD height=100><A href="/post_job.php"><img src="images/career.jpg" width=125 height=100 border=0></A></TD>
  </TR>
  <TR>
  	<TD align=center height=3 background="images/hdot.gif"><img src="images/space.gif"></TD>
  </TR>
  <TR>
  	<TD align=center valign=center><A href="/calendar.php"><img src="images/calendar.jpg" border=0></A></TD>
  </TR>
</TABLE>
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
<div id="Layer2"  style="position:absolute; visibility: hidden; top:74px; left:40px;">
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
    <TD><A href="/calendar.php?mi=7" class=linkh>Calender</A></TD>
    <TD class=linkh>|</TD>
    <TD><A href="/post_job.php?action=post?mi=7" class=linkh>Post a Job</A></TD>
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
<!--right side ends-->
<?php
include 'footer.php';
?>
