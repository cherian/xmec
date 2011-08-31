<?php
$secure_page=1;
$need_cal_js=1;
$this_page="calendar";
include 'header.php';
?>
<?
/*
 *  ©2002 Proverbs, LLC. All rights reserved.
 *
 *  This program is free software; you can redistribute it and/or modify it with the following stipulations:
 *  Changes or modifications must retain all Copyright statements, including, but not limited to the Copyright statement
 *  and Proverbs, LLC homepage link provided at the bottom of this page.
 */

   require "layout.inc.php";
   require ".dbaccess.inc";

   if (!isset($month) || $month == "" || $month > 12 || $month < 1)
   {
      $month = date("m");
   }
   if (!isset($year) || $year == "" || $year < 1972 || $year > 2036)
   {
      $year = date("Y");
   }

   $timestamp = mktime(0, 0, 0, $month, 1, $year);

   $current = date("F Y", $timestamp);

   if ($month < 2)
   {
      $prevmonth = 12;
      $prevyear = $year - 1;
   }
   else
   {
      $prevmonth = $month - 1;
      $prevyear = $year;
   }

   if ($month > 11)
   {
      $nextmonth = 1;
      $nextyear = $year + 1;
   }
   else
   {
      $nextmonth = $month + 1;
      $nextyear = $year;
   }

   $backward = date("F Y", mktime(0, 0, 0, $prevmonth, 1, $prevyear));
   $forward = date("F Y", mktime(0, 0, 0, $nextmonth, 1, $nextyear));

   $first = date("w", mktime(0, 0, 0, $month, 1, $year));

   $lastday = 28;

   for ($i=$lastday;$i<32;$i++)
   {
      if (checkdate($month, $i, $year))
      {
         $lastday = $i;
      }
   }

   function AddDay($fday, $fmonth, $fyear, $fvar)
   {
      if (!isset($fday) || $fday == "")
      {
         echo '	<TD class="calendar" align="left" valign="top" width="14.2%" height=70>
		&nbsp;
';
      }
      else
      {
         $schurl = 'schedule.php?day='.$fday.'&month='.$fmonth.'&year='.$fyear;
         if (date("m") == $fmonth && date("Y") == $fyear && date("j") == $fday)
         {
            echo '	<TD ID="day'.$fday.'" class="curday" style="cursor: hand" align="left" valign="top" width="14.2%" height=70
		onMouseOver="tdmouseover(\'day'.$fday.'\')"; onMouseOut="tdcurmouseout(\'day'.$fday.'\')";
		onClick="window.open(\''.$schurl.'\', \'schedule\', \'width=520,height=220,scrollbars=yes,resizable=yes\')">
';
         }
         else
         {
            echo '	<TD ID="day'.$fday.'" class="calendar" style="cursor: hand" align="left" valign="top" width="14.2%" height=70
		onMouseOver="tdmouseover(\'day'.$fday.'\')"; onMouseOut="tdmouseout(\'day'.$fday.'\')";
		onClick="window.open(\''.$schurl.'\', \'schedule\', \'width=500,height=200,scrollbars=yes,resizable=yes\')">
';
         }
         echo '		<b>'.$fday.'</b><br>
';
         if (isset($fvar) && $fvar != "")
         {
            echo '		<A class=\'calendar\' style="cursor: hand" onClick="javascript:window.open(\''.$schurl.'\',
		\'schedule\', \'width=500,height=200,scrollbars=yes,resizable=yes\')">
';
            echo '		'.$fvar.'
		</A>';
         }
      }
      echo '	</TD>
';
   }

   function FillDay($caldb, $dayofweek, $dayofmonth, $thismonth, $thisyear)
   {
      $textbody = '';
      $nr = $caldb->GetByDate($thismonth, $dayofmonth, $thisyear);
      for ($k=0;$k<$nr;$k++)
      {
         $caldb->next_record();
         $textbody.= $caldb->f('shortevent').'<br>';
      }
      $nr = $caldb->GetYearly($thismonth, $dayofmonth);
      for ($k=0;$k<$nr;$k++)
      {
          $caldb->next_record();
          $textbody.= $caldb->f('shortevent').'<br>';
      }
      $nr = $caldb->GetYearlyRecurring($thismonth, $dayofweek);
      for ($k=0;$k<$nr;$k++)
      {
          $caldb->next_record();
          $test = $dayofmonth / 7;
          $periodlow = $caldb->f('period') - 1;
          if ($test <= $caldb->f('period') && $test > $periodlow)
          {
             $textbody.= $caldb->f('shortevent').'<br>';
          }
      }
      $nr = $caldb->GetMonthly($dayofmonth);
      for ($k=0;$k<$nr;$k++)
      {
          $caldb->next_record();
          $textbody.= $caldb->f('shortevent').'<br>';
      }
      $nr = $caldb->GetMonthlyRecurring($dayofweek);
      for ($k=0;$k<$nr;$k++)
      {
          $caldb->next_record();
          $test = $dayofmonth / 7;
          $periodlow = $caldb->f('period') - 1;
          if ($test <= $caldb->f('period') && $test > $periodlow)
          {
             $textbody.= $caldb->f('shortevent').'<br>';
          }
      }
      $nr = $caldb->GetWeekly($dayofweek);
      for ($k=0;$k<$nr;$k++)
      {
         $caldb->next_record();
         $textbody.= $caldb->f('shortevent').'<br>';
      }
      return $textbody;
   }

	echo '	<CENTER><BR>
	<TABLE cellspacing=0 cellpadding=0 width="90%" border=1>
<!-- asdf-->
	<TR>
	<TD align="center" valign="middle" height=60 COLSPAN=7>
		<TABLE class="top" cellspacing=0 cellpadding=0 width="90%" border=0>
		<TR>
		<TD class="ends" nowrap align="center" valign="bottom">
			<A class=flink HREF="calendar.php?month='.$prevmonth.'&year='.$prevyear.'"><img src=images/back.gif border=0> '.$backward.'</a>
		</TD>
		<TD class="name" nowrap align="center" valign="middle" width="50%">
';
   if (isset($calender_title_image) && $calender_title_image != '')
   {
      echo '			<img src="'.$calender_title_image.'">';
   }
   else
   {
      echo '			'.$calender_title;
   }
   echo '<br>'.$current.'
		</TD>
		<TD class="ends" nowrap align="center" valign="bottom">
			<A class=flink HREF="calendar.php?month='.$nextmonth.'&year='.$nextyear.'">'.$forward.' <img src=images/next.gif border=0></a>
		</TD>
		</TR>
		</TABLE>
	</TD>
	</TR>

<!-- asdf-->
	<TR>
	<TD class="form" align="center" valign="bottom" width="90%" COLSPAN=7>
		<FORM METHOD="post" ACTION="calendar.php">
		<TABLE class="form" cellspacing=0 cellpadding=0 width="90%" border=0>
		<TR><TD COLSPAN=2>&nbsp;</TD></TR><TR>
		<TD class=head align="left" valign="bottom">
			'.date("F j, Y").'
		</TD>
		<TD class="fbody" align="left" valign="bottom">
			<b>Month:</b> <select class=cbox name="month">
';
			for ($j=1;$j<=12;$j++)
			{
			   echo'<option value='.$j;
			   if ($month == $j)
			   {
			      echo ' selected';
			   }
			   echo '>'.date("F", mktime(0, 0, 0, $j, 1, 0)).'
			   ';
			}
			echo '			</select>
		         &nbsp;&nbsp;<b>Year:</b> <select  class=cbox name="year">
';
			for ($j=1972;$j<=2036;$j++)
			{
			   echo'<option value='.$j;
			   if ($year == $j)
			   {
			      echo ' selected';
			   }
			   echo '>'.$j.'
			   ';
			}
			echo '			</select>
			 &nbsp;&nbsp;<input type="submit" value="Submit">
		</TD>
		</TR>';
		$user =& XMEC::getUser();
		if ($user->isAdmin()) {
		/* echo '<TR>
		<TD class="form" align="right" valign="bottom" colspan=2>
			<A style="cursor: hand" onClick="javascript:window.open(\'caladmin.php\', \'caladmin\',
				\'width=414,height=422,scrollbars=yes,resizable=yes\')"
				onMouseOver="window.status=\'\'">Administration</A>
		</TD>
		</TR>'; */
		echo '<TR>
		<TD class="form" align="right" valign="bottom" colspan=2>
			<A href="caladmin.php">Administration</A>
		</TD>
		</TR>';
		}
		echo '</TABLE>
		</FORM>
	</TD>
	</TR>
	<TR>';
   if (isset($start_day) && $start_day <= 6 && $start_day >= 0)
   {
      $n = $start_day;
   }
   else
   {
      $n = 0;
   }
   for ($i=0;$i<7;$i++)
   {
      if ($n > 6)
      {
         $n = 0;
      }
      if ($n == 0)
      {
         echo '	<TD class="name" nowrap align="center" valign="middle" width="14.2%" height=40>
		Sunday
	</TD>';
      }
      if ($n == 1)
      {
         echo '	<TD class="fbody" nowrap align="center" valign="middle" width="14.2%" height=40>
		Monday
	</TD>';
      }
      if ($n == 2)
      {
         echo '	<TD class="fbody" nowrap align="center" valign="middle" width="14.2%" height=40>
		Tuesday
	</TD>';
      }
      if ($n == 3)
      {
         echo '	<TD class="fbody" nowrap align="center" valign="middle" width="14.2%" height=40>
		Wednesday
	</TD>';
      }
      if ($n == 4)
      {
         echo '	<TD class="fbody" nowrap align="center" valign="middle" width="14.2%" height=40>
		Thursday
	</TD>';
      }
      if ($n == 5)
      {
         echo '	<TD class="fbody" nowrap align="center" valign="middle" width="14.2%" height=40>
		Friday
	</TD>';
      }
      if ($n == 6)
      {
         echo '	<TD class="name" nowrap align="center" valign="middle" width="14.2%" height=40>
		Saturday
	</TD>';
      }
      $n++;
   }
   echo'	</TR>
';
   $calday = 1;
   while ($calday <= $lastday)
   {
/* Alternate beginning day of the week for calendar view was created by Marion Heider of clixworx.net. */
      echo '<TR>';
      for ($j=0;$j<7;$j++)
      {
         if ($j == 0)
         {
            $n = $start_day;
         }
         else
         {
            if ($n < 6)
            {
               $n = $n + 1;
            }
            else
            {
               $n = 0;
            }
         }
         if ($calday == 1)
         {
            if ($first == $n)
            {
               $info = FillDay($db, $n, $calday, $month, $year);
               AddDay($calday, $month, $year, $info);
               $calday++;
            }
            else
            {
               AddDay('', '', '', '');
            }
         }
         else
         {
            if ($calday > $lastday)
            {
               AddDay('', '', '', '');
            }
            else
            {
               $info = FillDay($db, $n, $calday, $month, $year);
               AddDay($calday, $month, $year, $info);
               $calday++;
            }
         }
      }
      echo '</TR>';
   }
   echo '</TABLE>
	</CENTER>
	<P class=body ><center><A class=flink HREF="birthday.php">XMECian Birthdays this week</A> || <A class=flink HREF="addevent.php">Post Marriage Invitations or other XMEC Event</A>.<center></P><BR>';
	/* <P>©2002 <a class="bottom" href="http://www.proverbs.biz">Proverbs</a>, LLC. All rights reserved.</P> '; */
?>
<?php
include 'footer.php';
?>
