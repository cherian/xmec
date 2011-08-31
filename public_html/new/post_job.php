<?php
	$secure_page=1;
	$this_page="job";
	$no_left_side = 1;
	include 'header.php';
	include_once 'xmec.inc';
	include_once 'xmec_jobs.php';

$category = array(
"Software",
"Hardware",
"Biomedical",
"Marketing",
"Management"
);
?>	

<?php 
function showJobPost($action, $post_id=NULL) { 
	if ($action == "view_details") {
		$job = getJobPostDetails($post_id);
	}
?>
<!--Box Starts-->
<BR>
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

<TABLE width=100% cellspacing=0 cellpadding=0 border=0><TBODY>
<?php if ($action == "post") { ?>
<FORM NAME=post_job ACTION=post_job.php?action=do_post METHOD=post>
<INPUT TYPE=hidden NAME=action VALUE="do_post">
<?php } ?>
<TR><TD colspan=4 align=center><b class=head>Post a Job</b><BR><BR></td></tr>
<TR>
	<TD width="15%">Company</TD>
	<TD width="35%" height=20px>
<?php
		if ($action == "view_details") {
			echo $job[1];
		} else {
			echo "<INPUT CLASS=lbox NAME=company VALUE=>";
		}
?>
	</TD>
	<TD width="15%">Exp.</TD>
	<TD width="35%">
<?php
		if ($action == "view_details") {
			echo $job[2] . " To " . $job[3];
		} else {
		echo "
		<SELECT CLASS=cbox NAME=lyof>
			<OPTION VALUE=0>Fresher</OPTION>
			<OPTION VALUE=1>1</OPTION>
			<OPTION VALUE=2>2</OPTION>
			<OPTION VALUE=3>3</OPTION>
			<OPTION VALUE=4>4</OPTION>
			<OPTION VALUE=5>-</OPTION>
		</SELECT> To 
		<SELECT CLASS=cbox NAME=uyof>
			<OPTION VALUE=0>Fresher</OPTION>
			<OPTION VALUE=1>1</OPTION>
			<OPTION VALUE=2>2</OPTION>
			<OPTION VALUE=3>3</OPTION>
			<OPTION VALUE=4>4</OPTION>
			<OPTION VALUE=5>>5</OPTION>
		</SELECT>";
		}
?>
	</TD>
</TR>
<TR>
	<TD>Contact Name</TD>
	<TD height=20px>
<?php
		if ($action == "view_details") {
			echo $job[4];
		} else {	
			echo "<INPUT CLASS=lbox NAME=referer VALUE=>";
		}
?>
	</TD>
	<TD>Contact Email</TD>
	<TD>
<?php
		if ($action == "view_details") {
			echo $job[5];
		} else {
			echo "<INPUT CLASS=lbox NAME=refemail VALUE=>";
		}
?>
	</TD>
</TR>
<TR>
	<TD>Category</TD>
	<TD height=20px>
<?php
/* WORKAROUND */
$category = array(
"Software",
"Hardware",
"Biomedical",
"Marketing",
"Management"
);
/* WORKAROUND */
		if ($action == "view_details") {
			echo $category[$job[6]];
		} else {
		echo "
		<SELECT CLASS=cbox NAME=fow>
			<OPTION VALUE=0>".$category[0]."</OPTION>
			<OPTION VALUE=1>".$category[1]."</OPTION>
			<OPTION VALUE=2>".$category[2]."</OPTION>
			<OPTION VALUE=3>".$category[3]."</OPTION>
			<OPTION VALUE=4>".$category[4]."</OPTION>
		</SELECT>";
		}
?>	
	</TD>
	<TD>Keywords</TD>
	<TD>
<?php
		if ($action == "view_details") {
			echo $job[7];
		} else {
			echo "<INPUT CLASS=lbox NAME=keywords VALUE=>";
		}
?>
	</TD>
</TR>
<TR>
	<TD COLSPAN=1>Details<sup>*</sup></TD>
	<TD COLSPAN=3>
<?php
		if ($action == "view_details") {
			echo '<pre>'.$job[8].'</pre>';
		} else {
			echo "<TEXTAREA CLASS=tbox NAME=details MAXLENGTH=80></TEXTAREA>";
		}
?>
<BR>
<P class=name><sup>*</sup> Paste the contents of the requirement mail in this section</P><BR>
	</TD>
</TR>
<?php if ($action == "post") { ?>
<TR ALIGN=CENTER>
	<TD COLSPAN=4><INPUT TYPE=submit VALUE="Post"></TD>
</TR>
</FORM>
<?php } ?>
</TBODY></TABLE>
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
<BR>
<!--Box Ends-->
<?php 
} 
?>
<?php 
$action = chop($HTTP_GET_VARS["action"]);
if ($action == "") {
	$action = "view";
}
?>

<?php 
	if ($action=="post") {
		showJobPost($action);
	}
?>

<?php 
	if ($action=="do_post") {
		$tmp_comp = chop($HTTP_POST_VARS["company"]);
		$tmp_lyof = chop($HTTP_POST_VARS["lyof"]);
		$tmp_uyof = chop($HTTP_POST_VARS["uyof"]);
		$tmp_ref = chop($HTTP_POST_VARS["referer"]);
		$tmp_email = chop($HTTP_POST_VARS["refemail"]);
		$tmp_fow = chop($HTTP_POST_VARS["fow"]);
		$tmp_keyw = chop($HTTP_POST_VARS["keywords"]);
		$tmp_det = chop($HTTP_POST_VARS["details"]);
		doJobPost($tmp_comp, $tmp_lyof, $tmp_uyof, $tmp_ref,
							$tmp_email, $tmp_fow, $tmp_keyw, $tmp_det);
		echo "Thank you for submitting this posting to XMEC. All XMECians will also get a mail from xmec-jobs@yahoogroups.com <br>";
	}
?>

<?php 
	if ($action=="view_details") {
	$post_id=chop($HTTP_GET_VARS["post_id"]);
		showJobPost($action,$post_id);
	}
?>

<?php 
	if ($action=="view") {
?>
<!--Box Starts-->
<BR>
	<CENTER><A class=link HREF="/post_job.php?action=post">Post a Job</A></CENTER>
<BR>
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
<TABLE WIDTH="100%">
<THEAD class=head bgcolor=#EEEEEE>
	<TD><B>Company</B></TD>
	<TD><B>Category</B></TD>
	<TD><B>Experience (Yrs)</B></TD>
	<TD><B>Keywords</B></TD>
	<TD><B>Post Date</B></TD>
</THEAD>
<TBODY>
<?php

		$posts = getJobPosts();	
		for($i=0;$i<count($posts);$i++) {
			if ($i%2) 
			$colored = " BGCOLOR=#CFDDD1 ";
			else 
			$colored = " BGCOLOR=#CFDDD1 ";
			$post = $posts[$i];
			echo "
<TR". $colored .">
	<TD><A class=link HREF=\"/post_job.php?action=view_details&post_id=".$post[0]."\">".$post[1]."</A></TD>
	<TD align=center>".$category[$post[6]]."</TD>
	<TD align=center>".$post[2]."-".$post[3]."</TD>
	<TD>".$post[7]."</TD>
	<TD>".$post[10]."</TD>
</TR>
";
			/* echo $post[1]." ".$post[2]."-".$post[5].
			" ".$post[6]." ".$post[9]."<br>"; */
		}
?>
</TBODY>
</TABLE>
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
<BR>
<!--Box Ends-->
<?php
	}
?>


<?php
include 'footer.php';
?>
