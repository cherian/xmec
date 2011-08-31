<?php
	include 'common.php';
	$auth = XMEC::authenticate_user();

	if ($_s != 1) {
		$name = trim($name);
		$worktype = trim($worktype);
		$company = trim($company);
		$year = trim($year);
		$branch = trim($branch);
		$location = trim($location);
	} else {
		$name = trim($_n);
		$worktype = trim($_w);
		$company = trim($_c);
		$year = trim($_y);
		$branch = trim($_b);
		$location = trim($_l);
	}

	$fil = array();
	if ($name != "" || $worktype != "" || $year != "" ||
		$branch != "" || $company != "" || $location != "") {
		$name != "" && $fil['name'] = $name;
		$worktype != "" && $fil['work_type'] = $worktype;
		$company != "" && $fil['company'] = $company;
		$year != "" && $fil['year'] = $year;
		$branch != "" && $fil['branch'] = $branch;
		$location != "" && $fil['location'] = $location;
	}

	$user =& XMEC::getUser();
?>	

<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft Visual Studio 6.0">
<TITLE></TITLE>
<LINK href="style.css" type="text/css" rel="Stylesheet">
</HEAD>
<BODY bgcolor="#ffffff">

<P>
<Form method=GET action=search.php>
<TABLE border=0 cellPadding=1 cellSpacing=1 width="615">
  
  <TR>
    <TD></TD>
    <TD colSpan=2 align=center><STRONG><FONT face=Verdana>ACCESS XMECians</FONT></STRONG> 
      </TD>
    <TD></TD></TR>
  
  <TR>
    <TD></TD>
    <TD colSpan=2></TD>
    <TD></TD></TR>
  <TR>
<?php 
	if($user->isAdmin()) 
    	echo "<TD><FONT face=Verdana size=2>Name/Roll no</FONT></TD>";
	else
    	echo "<TD><FONT face=Verdana size=2>Name</FONT></TD>";
?>
    <TD><FONT face=Verdana size=2><INPUT id=text1 name=name></FONT></TD>
    <TD nowrap><FONT face=Verdana size=2>Field of Work</FONT>  </TD>
    <TD><FONT face=Verdana size=2><select name=worktype>
	<option value="">--- Any ---</option>
<?php           
	$wrk = XMEC::get_work_types();
	for ($i = 0; $i < sizeof($wrk); $i++)
	echo "<option value=\"". htmlentities($wrk[$i]) . "\">".htmlentities($wrk[$i]). "</option>";
?>
	</SELECT>	
		
</FONT></TD></TR>
  <TR>
    <TD nowrap><FONT face=Verdana size=2>Year of Joining</FONT>  </TD>
    <TD><FONT face=Verdana size=2><select name=year>
	<option value="">--- Select ---</option>
<?php
	for ($y=1989; $y<=2001; $y++)
	echo "<option value=\"$y\">$y</option>";
?>
	</SELECT>	
	</FONT></TD>
    <TD><FONT face=Verdana size=2>Organisation</FONT></TD>
    <TD><FONT face=Verdana size=2><INPUT id=text2 name=company></FONT></TD></TR>
  <TR>
    <TD><FONT face=Verdana size=2>Branch</FONT></TD>
    <TD><FONT face=Verdana size=2><SELECT name=branch>
	<option value="">--- Select ---</option>
	<OPTION value=BE>Biomedical</OPTION>
	<OPTION value=CE>Computer</OPTION>
	<OPTION value=EE>Electronics</OPTION>
	</SELECT>
	</FONT></TD>
    <TD nowrap><FONT face=Verdana size=2>Org. Location</FONT> </TD>
    <TD><FONT face=Verdana size=2><INPUT id=text2 name=location></FONT></TD></TR>
  <TR>
    <TD></TD>
    <TD></TD>
    <TD></TD>
    <TD></TD></TR>
    <TR>
    <TD></TD>
    <TD align=center>
      <INPUT name=.s style="HEIGHT: 24px; WIDTH: 101px" type=submit value=Search></TD>
    <TD align=center><INPUT name=BCancel style="HEIGHT: 24px; WIDTH: 86px" type=reset value=Cancel></TD>
	<TD></TD> 
    </TR></TABLE></P><BR><FONT 
face=Verdana size=2>
<hr width=100% color=#DDDDDD>
</FONT>
<p></p>
<p></p>
<p></p>
</form>

<?php

	$search_fil = $fil;
	$do_search = TRUE;
	if ($_s == "Search") {
            $search_start = 0;
            $search_count = 20;
	} else if ($_s == 1) {
	    $search_start = $f;
	    $search_count = $c;
	} else {
		$do_search = FALSE;
	}

	if ($do_search) {
		if ($user->isAdmin()) {
			//$fil['rollno'] = $fil['name'];
			//$search_fil = $fil;
			include ('admin_search_results.php');
		} else 
			include ('search_results.php');
	}
?>

</BODY>
</HTML>
