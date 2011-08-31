<?php
	include 'xmec.inc';
	$auth = XMEC::authenticate_user();

	if ($id != "") {
	    $res = new XMEC_user($id);	
	    if ($res->fetchInfo())
	    {	
		$pres_addr = $res->getAddress('PRESENT');
		$comp_addr = $res->getAddress('COMPANY');
		$perm_addr = $res->getAddress('PERMANENT');
?>

<BODY bgcolor=#FFFFFF>
<LINK rel=stylesheet href="style.css" type="text/css">
<TABLE bgcolor=#FFFFFF  cellspacing=0 width=370 align=center ><TR><TD>
<TABLE bgcolor=#FFFFFF cellspacing=0 cellpadding=5 width=100% align=center border=1>
<TR><TD class=record bgcolor=#FFDFB0  width=370 align=left>
<strong>XMEC Record</strong></TD><TD class=record bgcolor=#FFDFB0   width=370 align=right>No. RQ00<?=htmlentities($res->get('id'))?>9K</TD></TR>
<TR>
<TD class=record bgcolor=#FFDFB0 width=370 align=left>Engineering Dept</TD>
<TD class=record bgcolor=#FFDFB0   width=370 align=right><?=htmlentities($res->get('branch'))?></TD>
</TR>
<TR>
<TD class=record bgcolor=#FFDFB0  width=370 align=left>Year of Joining</TD>
<TD class=record bgcolor=#FFDFB0 width=370 align=right><?=htmlentities($res->get('year'))?></TD>
</TR> 
<TR>
<TD class=record bgcolor=#FFDFB0   width=370 align=left><strong>Name</strong></TD>
<TD class=sbecord bgcolor=#FFDFB0  width=370 align=left><?=htmlentities($res->get('full_name'))?></TD>
</TR>
<TR><TD class=sbecord bgcolor=#FFFFCC  width=370 align=left><strong>Field of Work</strong></TD>
<TD class=becord bgcolor=#FFFFCC  width=370 align=left><?=htmlentities($res->get('work_type'))?></TD></TR> 
<TR>
<TD class=sbecord bgcolor=#FFFFCC  width=370 align=left><strong>Personal Email</strong></TD>
<TD class=becord bgcolor=#FFFFCC  width=370 align=left>
<?=XMEC::pref_print(htmlentities($res->get('personal_email')),
		    $res->getPref('personal_email'), $auth);
?>
</TD>
</TR>
<TR>
<TD class=sbecord bgcolor=#FFFFCC  width=370 align=left><strong>Official Email</strong></TD>
<TD class=becord bgcolor=#FFFFCC  width=370 align=left>
<?=XMEC::pref_print(htmlentities($res->get('official_email')),
		    $res->getPref('official_email'), $auth);
?>
</TD>
</TR>
<?
  if (($comp_addr->get('house_name') != "") &&
      ($comp_addr->get('visibility') == 'PUBLIC' || 
       ($comp_addr->get('visibility') == 'XMEC' && $auth))) {
?>

<TR>
<TD class=sbecord bgcolor=#FFFFCC  width=370 align=left valign=top><strong>Organisation</strong></TD>
<TD class=becord bgcolor=#FFFFCC  width=370 align=left>
<strong><?=htmlentities($comp_addr->get('house_name'))?></strong><br>
<? if ($comp_addr->get('street') != "") 
	echo htmlentities($comp_addr->get('street')), "<br>";
   if ($comp_addr->get('area') != "") 
	echo htmlentities($comp_addr->get('area')), "<br>"; 
   if ($comp_addr->get('city') != "") 
	echo htmlentities($comp_addr->get('city')), "<br>";
   if ($comp_addr->get('state') != "") 
	echo htmlentities($comp_addr->get('state')), "<br>";
   if ($comp_addr->get('country') != "") 
	echo htmlentities($comp_addr->get('country')), "<br>";
   if ($comp_addr->get('postal_code') != "") 
	echo htmlentities($comp_addr->get('postal_code')), "<br>";
   if ($comp_addr->get('telephone_no') != "") 
	echo "Ph: ", htmlentities($comp_addr->get('telephone_no')), "<br>";
  }
?>
</TD></TR>

<?
  if (($pres_addr->get('house_name') != "") &&
      ($pres_addr->get('visibility') == 'PUBLIC' || 
       ($pres_addr->get('visibility') == 'XMEC' && $auth))) {
?>

<TR><TD class=sbecord bgcolor=#FFFFCC  width=370 align=left valign=top><strong>Current Address</strong></TD>
<TD class=becord bgcolor=#FFFFCC  width=370 align=left><?=htmlentities($pres_addr->get('house_name'))?><br>

<? if ($pres_addr->get('street') != "") 
	echo htmlentities($pres_addr->get('street')), "<br>";
   if ($pres_addr->get('area') != "") 
	echo htmlentities($pres_addr->get('area')), "<br>"; 
   if ($pres_addr->get('city') != "") 
	echo htmlentities($pres_addr->get('city')), "<br>";
   if ($pres_addr->get('state') != "") 
	echo htmlentities($pres_addr->get('state')), "<br>";
   if ($pres_addr->get('country') != "") 
	echo htmlentities($pres_addr->get('country')), "<br>";
   if ($pres_addr->get('postal_code') != "") 
	echo htmlentities($pres_addr->get('postal_code')), "<br>";
   if ($pres_addr->get('telephone_no') != "") 
	echo "Ph: ", htmlentities($pres_addr->get('telephone_no')), "<br>";
  }
?>
</TD></TR>

<?
  if (($perm_addr->get('house_name') != "") &&
      ($perm_addr->get('visibility') == 'PUBLIC' || 
       ($perm_addr->get('visibility') == 'XMEC' && $auth))) {
?>

<TR><TD class=sbecord bgcolor=#FFFFCC  width=370 align=left valign=top><strong>Permanent Address</strong></TD>
<TD class=becord bgcolor=#FFFFCC  width=370 align=left><?=htmlentities($perm_addr->get('house_name'))?><br>

<? if ($perm_addr->get('street') != "")
        echo htmlentities($perm_addr->get('street')), "<br>";
   if ($perm_addr->get('area') != "") 
        echo htmlentities($perm_addr->get('area')), "<br>";
   if ($perm_addr->get('city') != "") 
        echo htmlentities($perm_addr->get('city')), "<br>";
   if ($perm_addr->get('state') != "") 
        echo htmlentities($perm_addr->get('state')), "<br>";
   if ($perm_addr->get('country') != "") 
        echo htmlentities($perm_addr->get('country')), "<br>";
   if ($perm_addr->get('postal_code') != "") 
        echo htmlentities($perm_addr->get('postal_code')), "<br>";
   if ($perm_addr->get('telephone_no') != "") 
        echo "Ph: ", htmlentities($perm_addr->get('telephone_no')), "<br>";
  }
?>                                                                      
</TD></TR>
<?php
if (!$auth)echo '<tr><td colspan=2 bgcolor=#FFDFB0  width=370 align=left class=record><i>You may need to log in to view the details restricted to XMECians.</td></tr>';
?>
</TABLE>
</TD></TR>
</TABLE>
</BODY>

<?	} else {
	    echo "Details of ", "<strong>",$id,"</strong>"," not found","<br>";
	}

    } else 
	echo "No more details !!\n";
	
?> 
