<?php
$secure_page=1;
$this_page = "poll";
include_once 'header.php';
include_once 'xmec_poll.php';
reset($HTTP_POST_VARS);
$action=chop($HTTP_POST_VARS["action"]);
$poll_id=chop($HTTP_POST_VARS["pollID"]);
if ($REQUEST_METHOD == "GET") {
  $action=chop($HTTP_GET_VARS["action"]);
  $poll_id=chop($HTTP_GET_VARS["pollID"]);
}
if (!$action) {
  $action="view_open";
}

$user =& XMEC::getUser();

if (($action == "del_poll") || ($action == "create_poll") || ($action == "poll_admin")) {
	if (!$user->isAdmin()) {
		echo "<CENTER><H1>You are not authorised...!<BR></H1></CENTER>";
		include 'footer.php';
		exit;
	}
}

?>
<BR>
<CENTER><B class =head>XMEC Polls - Your Opinion Counts</B></CENTER><BR>
<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER WIDTH="85%">
<?php 
echo '<TR><TD><TABLE BORDER=0 WIDTH=100%><TR><TD WIDTH=5%>&nbsp;</TD>';
if ($action != "view_open") {
  echo '<TD ALIGN=CENTER><A class=flink HREF="polls.php?action=view_open">Active Polls</A></TD>';
}
if ($action != "view_results") {
  echo '<TD ALIGN=CENTER><A class=flink HREF="polls.php?action=view_results">Results</A></TD>';
}
if ($user->isAdmin()) {
  echo '<TD ALIGN=CENTER><A class=flink HREF="polls.php?action=poll_admin">Administer Polls</A></TD>';
}
echo '<TD WIDTH=5%>&nbsp;</TD></TR></TABLE></TD></TR>';
?>

<?php
if ($action == "view_open") {
  $polls =& getOpenPolls();
  for($i=0;$i<count($polls);$i++) {
    $userResponse = $polls[$i]->hasUserVoted($user);
    if ( ($polls[$i]->isAnonymous == 0) ||
        ($userResponse == 0) ) {
?>
  <TR><TD>
    <TABLE ALIGN=CENTER CELLSPACING=0 CELLPADDING=0 BORDER=0 WIDTH="100%">
      <TBODY>
        <TR><TD>
	<!-- Box start -->
<TABLE cellSpacing=0 cellPadding=0 border=0 width="100%">
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
        <!--Content Start -->
          <TABLE CELLPADDING=1 CELLSPACING=1 BORDER=0 WIDTH="100%"
              ALIGN=CENTER>
          <FORM METHOD=POST ACTION="polls.php">

<?php
          if ($userResponse == 0) {
?>
            <INPUT TYPE=hidden NAME=action VALUE=vote>
<?php
          } else {
?>
            <INPUT TYPE=HIDDEN NAME=action VALUE=revote>
<?php
          }
          echo '<INPUT TYPE=HIDDEN NAME=pollID VALUE="' . $polls[$i]->pollID . '">';
?>

            <TR ALIGN=CENTER>
              <TD BGCOLOR="#CFDDD1">
                <B class=head>
<?php
          echo $polls[$i]->title;
					if ($polls[$i]->isAnonymous) {
						echo "<SUP>*</SUP>";
					}
?>
                </B>
              </TD>
            </TR>
            <TR ALIGN=RIGHT>
              <TD BGCOLOR="#CFDDD1">
                <B class=body>
<?php
          echo "This Poll Closes ". $polls[$i]->endDatefmt;
?>
                </B>
              </TD>
            </TR>
            <TR>
              <TD BGCOLOR="#FFFFFF" class=name>
<?php
          echo $polls[$i]->pollQuestion;
?>
              </TD>
            </TR>
            <TR>
              <TD BGCOLOR="#FFFFFF" class=body>
<?php
          for ($j = 0; $j < count($polls[$i]->answers); $j++) {
            $ansSeq = $polls[$i]->answers[$j]->ansSeq;
            $ansDesc = $polls[$i]->answers[$j]->ansDesc;
            echo '<INPUT TYPE=radio NAME=answers VALUE=' . $ansSeq;
            if ($ansSeq == $userResponse) {
              echo " CHECKED";
            }
            echo '>' . $polls[$i]->answers[$j]->ansDesc . '</INPUT><BR>';
          }
?>
              </TD>
            </TR>
            <TR>
              <TD ALIGN=CENTER>
<?php
          if ($userResponse == 0) {
            echo '<INPUT TYPE=submit VALUE="Vote"></INPUT>';
          } else {
            echo '<INPUT TYPE=submit VALUE="Revote"></INPUT>';
          }
?>
              </TD>
            </TR>
<?php
          if ($polls[$i]->isAnonymous == 1) {
?>
            <TR>
              <TD CLASS=head>
                <CENTER><SUP>*</SUP>This is an anonymous poll. Vote once registered cannot be changed.</CENTER>
              </TD>
            </TR>
<?php
          }
?>
          </FORM>
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
	<!--Box ends -->
        </TD></TR>
      </TBODY>
    </TABLE><br>
  </TD></TR>
<?php
    } # if loop
  } # for loop
}
?>

<?php
if ($action == "view_results") {
  $titles = getTitles();
?>
    <TR><TD><BR></TD></TR>
		<?php if ($user->isAdmin()) {
		echo '<tr><td>For Admins all the polls will be listed. not just the closed ones</td></tr>';
		 } ?>
    <TR><TD colspan=2>
	<!-- Box starts -->
<TABLE cellSpacing=0 cellPadding=0 border=0 width="100%">
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

              <!--Content start-->
              <TABLE border=0 cellPadding=0 cellSpacing=3 WIDTH=100%>
                <TR bgcolor="#CFDDD1">
                  <TD WIDTH="75%"><B class=head>Poll Title</B></TD>
                  <TD WIDTH="25%"><B class=head>Closed On</B></TD>
                </TR>
<?php
  for($i=0;$i<count($titles); $i++) {
    $ttl = $titles[$i];
?>
                <TR>
                  <TD class=body>
<?php
      echo "<A class=link HREF=polls.php?action=view_poll&pollID=" . $ttl[0] . ">" . $ttl[1];
?>
                    </A>
                  </TD>
                  <TD class=body>
<?php
      /* list($date,)=split(' ',$ttl[2]); echo descDate($date); */
			echo $ttl[2];
?>
                  </TD>
                </TR>
<?php
  }
?>
              </TABLE>
           <!-- Content Ends --> 
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

					<!-- Box Ends-->
   </TD></TR>
<?php
}
?>

<?php
if ($action == "view_poll") {
?>
    <TR><TD><BR></TD></TR>
    <TR><TD>
<!--Box Starts -->
<TABLE cellSpacing=0 cellPadding=0 border=0 width="100%">
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

            <!--Content Start -->
<?php
  $poll = getPoll($poll_id);
  $total_votes = 0;
  for ($i=0;$i<count($poll->answers);$i++) {
    $total_votes += $poll->answers[$i]->votes;
  }
  if (!$total_votes) $total_votes++;
?>
              <TABLE border=0 cellPadding=0 cellSpacing=3 WIDTH=100%>
                <TR bgcolor="#CFDDD1">
                  <TD WIDTH="75%" COLSPAN=3>
                    <B class=head>
<?php
  echo $poll->title;
?>
</B>
                  </TD>
                </TR>
                <TR>
                  <TD class=name COLSPAN=3>
<?php
echo $poll->pollQuestion;
?>
                  </TD>
                </TR>
<?php
    for($i=0;$i<count($poll->answers);$i++) {
      $percent = ($poll->answers[$i]->votes*100)/$total_votes;
?>
                <TR>
                  <TD class=body WIDTH="60%">
<?php
echo $poll->answers[$i]->ansDesc;
?>
                  </TD>
                  <TD class=body WIDTH="5%">
<?php
echo $poll->answers[$i]->votes;
?>
                  </TD>
                  <TD class=body WIDTH="35%">
<?php
      echo '<IMG SRC="images/pollBar.gif" HEIGHT=12 WIDTH=' .$percent . '>';
      printf(" %.2f%s", $percent,"%") ;
?>
                  </TD>
                </TR>
<?php
    }
?>
              </TABLE>
            <!--Content End-->
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
			<CENTER>
<?php if ($user->isAdmin()) { ?>
			<FORM NAME=delme ACTION=polls.php METHOD=GET>
				<INPUT TYPE=HIDDEN NAME=pollID VALUE=<?php echo $poll_id; ?>>
				<INPUT TYPE=SUBMIT NAME=action VALUE=del_poll>
			</FORM>
			<FONT color=#FF0000><B>Please note that I am not going to prompt you again if you hit that button above.</B></FONT>
<?php } ?>
			</CENTER>
    </TD></TR>
<?php
}
?>

<?php
	if ($action == "del_poll") {
		$retval = deletePoll($poll_id);
		if ($retval == 0) {
			echo "<CENTER>Poll Sucessfully Deleted<BR></CENTER>";
		} else  {
			echo "<CENTER>There were some errors while deleting the poll<BR></CENTER>";
		}
	}
?>

<?php
if ($action == "revote") {
?>
    <TR><TD><BR></TD></TR>
    <TR><TD class=head style="color:#00FF00">
<?php
  $ansSeq=chop($HTTP_POST_VARS["answers"]);
	$poll_id = chop($HTTP_POST_VARS["pollID"]);
	$userID = $user->id;
  registerReVote($poll_id,$user, $ansSeq);
?>
      <CENTER><B>Thank you for for using XMEC Polls . Your Vote has been updated. The results will be displayed after the poll is closed.</B> </CENTER>
    </TD></TR>
<?php
}
?>



<?php
if ($action == "vote") {
?>
    <TR><TD><BR></TD></TR>
    <TR><TD>
<?php
  $ansSeq=chop($HTTP_POST_VARS["answers"]);
	$poll_id = chop($HTTP_POST_VARS["pollID"]);
	$userID = $user->id;
  registerVote($poll_id,$user, $ansSeq);
?>
      <CENTER>Thanks For Voting. Your Vote has been registered.</CENTER>
    </TD></TR>
<?php
}
?>

<?php
if ($action == "poll_admin") {
  if ($user->isAdmin()) {
?>
    <TR><TD>
      <TABLE WIDTH="80%" border=1>
      <FORM NAME=create_poll method=post action="polls.php">
        <INPUT TYPE=hidden NAME=action value=create_poll>
      <TR><TD COLSPAN=2 ALIGN=center>Create new poll</TD></TR>
      <TR>
        <TD>Title</TD>
        <TD><INPUT TYPE=text NAME=poll_title Value="Replace this line by the title of the poll" size=35 maxlength=200></INPUT>
        </TD>
      </TR>
      <TR>
        <TD>
          Poll Question
        </TD>
        <TD>
          <TEXTAREA NAME=poll_q maxlength=2048 cols=35 rows=5>Replace this line by the poll question.</TEXTAREA>
        </TD>
      </TR>
      <TR>
        <TD>
          Poll Answers
        </TD>
        <TD>
          <TEXTAREA NAME=poll_ans cols=35 rows=5>Replace this line by the options for the poll oneeach on a line.</TEXTAREA>
        </TD>
      </TR>
      <TR>
        <TD><INPUT TYPE=checkbox NAME=poll_anonymous>Anonymous</TD>
        <TD>Start Date
          <INPUT TYPE=text NAME=poll_start_date></INPUT>yyyy/mm/dd
          <BR>End Date
            <INPUT TYPE=text NAME=poll_end_date></INPUT>yyyy/mm/dd
          </TD>
        </TR>
        <TR>
          <TD COLSPAN=2 ALIGN=center>
            <INPUT TYPE=submit Value="Create Poll"></INPUT>
          </TD>
        </TR>
      </FORM>
      </TABLE>
    </TD></TR>
<?php
  } else {
    echo "You need to be admin to access this page<BR>";
  }
}
?>

<?php
if ($action == "create_poll") {
  if ($user->isAdmin()) {
    $poll_title = $HTTP_POST_VARS['poll_title'];
    $poll_q = $HTTP_POST_VARS['poll_q'];
    $poll_ans = $HTTP_POST_VARS['poll_ans'];
    $poll_st = $HTTP_POST_VARS['poll_start_date'];
    $poll_en = $HTTP_POST_VARS['poll_end_date'];
    $poll_anon = $HTTP_POST_VARS['poll_anonymous'];
    if ($poll_anon == 'on') {
        $poll_anon = 1;
    } else {
      $poll_anon = 0;
    }
    if (!$poll_title || !$poll_q || !$poll_ans || !$poll_st || !$poll_en) {
      echo "Enter all the values in the create FORM before creating\n";
    } else {
      $retval = createPoll($poll_title, $poll_q, $poll_ans, $poll_st, $poll_en, $poll_anon);
			if ($retval != 0) {
				echo "<CENTER>There were errors while creating the poll<BR></CENTER>";
			} else {
				echo "<CENTER>Sucessfully create the poll<BR></CENTER>";
			}
    }
  } else {
    echo "You need to be an Administrator to create a poll<br>";
  }
}
?>

</TABLE>

<?php
include 'footer.php';
?>
