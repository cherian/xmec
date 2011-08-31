<?php
	include 'common.php';
	$auth = XMEC::authenticate_user();

	$srch = FALSE;
	
	$name = trim($name);
	$worktype = trim($worktype);
	$company = trim($company);
	$year = trim($year);
	$branch = trim($branch);
	$location = trim($location);

	if ($name != "" || $worktype != "" || $year != "" ||
		$branch != "" || $company != "" || $location != "") {
		$srch = TRUE;
		$fil = array();
		$name != "" && $fil['name'] = $name;
		$worktype != "" && $fil['work_type'] = $worktype;
		$company != "" && $fil['company'] = $company;
		$year != "" && $fil['year'] = $year;
		$branch != "" && $fil['branch'] = $branch;
		$location != "" && $fil['location'] = $location;
		$res =& XMEC::search ($fil);
	}

?>	

<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft Visual Studio 6.0">
<TITLE></TITLE>
</HEAD>
<BODY bgcolor="#ffffff">

<P>
<Form method=GET action=xmec_search.php>
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
    <TD><FONT face=Verdana size=2>Name</FONT></TD>
    <TD><FONT face=Verdana size=2><INPUT id=text1 name=name value=<?=$name?>></FONT></TD>
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
      <INPUT name=Bsubmit style="HEIGHT: 24px; WIDTH: 101px" type=submit value=Search></TD>
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

<?php if ($srch == TRUE && count($res) > 0) : ?>

XMECian records matching Search criteria:
<TABLE border=1 cellPadding=1 cellSpacing=1 width="615">
  
  <TR>
    <TD>
      <P><FONT face=Verdana size=2>Name</FONT></P></TD>
    <TD><FONT face=Verdana size=2>Organisation</FONT> </TD>
    <TD><FONT face=Verdana size=2>Location</FONT></TD>
    <TD><FONT face=Verdana size=2>Batch</FONT></TD></TR>
<?php elseif ($srch == TRUE) : ?>
	<p>No matches found ! </p>
<?php endif; ?>
<?php
	if ($srch == TRUE && count($res) > 0) {
	for ($i = 0; $i < count($res); $i++) {
  		echo "<TR>\n";
   		echo "<TD><A href=asdf onClick=\"javascript:open('view_details.php?id=",rawurlencode($res[$i]->id),"','','height=600,width=425,scroll=yes,scrollbars=yes');return false;\">", htmlentities($res[$i]->name), "</a></TD>\n";
    	echo "<TD>", htmlentities($res[$i]->company), "</TD>";
   		echo "<TD>", htmlentities($res[$i]->location), "</TD>\n";
   		echo "<TD>" . htmlentities($res[$i]->year) . "</TD></TR>\n";
	}
	echo "</TABLE>";
	}
?>

</BODY>
</HTML>
