<?php
	$no_search_menu = 1;
	$no_left_side = 1;
	include 'header.php';

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
<BR>
<!-- Box starts -->
<TABLE align=center cellSpacing=0 cellPadding=0 border=0>
<TBODY>
        <TR>
                <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    </TR>
    <TR>
                <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
                <TD colSpan=2 rowSpan=2>
                        <!--contents starts-->

<TABLE border=0 cellPadding=1 cellSpacing=1 width="85%" ALIGN=CENTER>
	<FORM name=frmsearch method=GET action=search.php>
  <TR bgcolor=#EEEEEE>
    <TD></TD>
    <TD colSpan=2 align=center class=head bgcolor=#EEEEEE><B>ACCESS XMECians</B></TD>
    <TD></TD>
	</TR>
  <TR>
    <TD></TD>
    <TD colSpan=2></TD>
    <TD></TD>
	</TR>
  <TR>
<?php if($user->isAdmin()) { ?>
		<TD class=body>Name/Roll no</TD>
<? } else { ?>
		<TD class=fbody >Name</TD>
<? } ?>
    <TD><INPUT class=lbox id=text1 name=name></TD>
    <TD nowrap class=fbody>Designation</TD>
    <TD>
			<INPUT class=lbox id=text1 name=workrole>
		</TD>
	</TR>
	<TR>
    <TD nowrap class=fbody>Year of Joining</TD>
    <TD>
      <SELECT class=cbox style="width:144px" name=year>
        <OPTION value="">--- Select ---</OPTION>
<?php
        for ($y=1989; $y<=2001; $y++)
        echo "<OPTION value=\"$y\">$y</OPTION>";
?>
      </SELECT>
    </TD>
    <TD class=fbody>Branch</TD>
    <TD>
      <SELECT class=cbox style="width:144px" name=branch>
        <OPTION value="">--- Select ---</option>
        <OPTION value=BE>Biomedical</OPTION>
        <OPTION value=CE>Computer</OPTION>
        <OPTION value=EE>Electronics</OPTION>
      </SELECT>
    </TD>
    </TR>
  <TR>
		<TD class=fbody>Organisation</TD>
    <TD><INPUT class=lbox id=text2 name=company></TD>

    <TD nowrap class=fbody>Org. Location</TD>
    <TD><INPUT id=text2 class=lbox name=location></TD>
	</TR>
  <TR>
    <TD nowrap class=fbody>Field of Work</TD>
    <TD>
      <SELECT class=cbox name=worktype>
        <OPTION value="">--- Any ---</OPTION>
<?php
        $wrk = XMEC::get_work_types();
        for ($i = 0; $i < sizeof($wrk); $i++)
        echo "<OPTION value=\"". htmlentities($wrk[$i]) . "\">".htmlentities($wrk[$i]). "</OPTION>";
?>
      </SELECT>
    </TD>


    </TR>

    <TR>
    <TD></TD>
    <TD align=center>
      <INPUT name=.s style="HEIGHT: 24px; WIDTH: 101px" type=submit value=Search></TD>
    <TD align=center><INPUT name=BCancel style="HEIGHT: 24px; WIDTH: 86px" type=reset value=Cancel></TD>
		<TD></TD> 
	</TR>
</TABLE>

</P>
</form>
 <!--contents ends-->
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
<BR>
<!-- Box ends -->
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
<?
include ('footer.php')
?>
