<?
/* ©2002 Proverbs, LLC. All rights reserved. */ 

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
   if (!isset($day) || $day == "")
   {
      $day = date("d");
   }
   
   if (!checkdate($month, $day, $year))
   {
      $month = date("m");
      $year = date("Y");
      $day = date("d");
   }
   $dayofweek = date("w", mktime(0, 0, 0, $month, $day, $year));

   function AddFullLine($text)
   {
		if (!$text) { $text = 'No Events on this day'; }
      echo '	<tr>
	<!--td class="onetime" align="left" valign="middle" width=50 height=40>
		<b>All Day</b>
	</td-->
	<td class="topline" align="left" valign="top" width=400 height=200>
		'.$text.'
	</td>
	</tr>
';
   }
   
   function AddLine($text, $eventtime, $count)
   {
       if ($count == 1)
       {
          echo '	<td class="onetime" align="left" valign="middle" width=50 height=40>
		<b>'.$eventtime.'</b>
	</td>
	<td class="one" align="left" valign="top" width=210 height=40>
';
       }
       else
       {
          echo '	<td class="twotime" align="left" valign="middle" width=50 height=40>
		<b>'.$eventtime.'</b>
	</td>
	<td class="two" align="left" valign="top" width=210 height=40>
';
       }
       echo '		'.$text.'
       	</TD>
';   
   }
      echo '<HTML>
<HEAD>
   <TITLE>'.$site_title.' Schedule - '.$month.'/'.$day.'/'.$year.'</TITLE>
   <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">';
   echo '<STYLE TYPE="text/css">
	<!--
		BODY {background-color: #'.$background_color.'; border-style: none; border-width: 0px; color: #'.$plain_text_color.'; 
			font-family: Arial; font-size: 12px; font-style: normal; margin: 0px; padding: 0px;
			text-align: left; text-decoration: none; text-indent: 0px}
		TABLE {border-style: none; margin: 0px; padding: 0px; border-width: none; font-size: 12px; text-indent: 0px;
			font-weight: normal; width: 500px; height: 200px; background-color: #'.$calendar_bg_color.'; 
			color: #'.$plain_text_color.'}
		TR {border-style: none; border-width: 0px; margin: 0px; padding: 0px}
		TD {border-style: none; border-width: none; margin: 0px; text-align:left; padding: 0px; font-weight: normal 
			height: 40px; width: 200px; font-size: 12px}
		TD.one {background-color: #'.$calendar_bg_color.'}
		TD.two {background-color: #'.$current_day_color.'}
		TD.onetime {width: 200px; background-color: #'.$calendar_bg_color.'}
		TD.twotime {width: 50px; background-color: #'.$current_day_color.'}
		TD.topline {width: 470px; background-color: #'.$calendar_bg_color.'}
	-->
	</STYLE>
</HEAD>
';
echo '<BODY TOPMARGIN=10 LEFTMARGIN=10 MARGINHEIGHT=10 MARGINWIDTH=10 bgcolor=#FFFFFF>
	<TABLE cellspacing=0 cellpadding=0 width=500 border=1 WIDTH=80%>
';
   $textlist = array();
   for ($k=0;$k<25;$k++)
   {
      $textlist[$k] = '';
   }
   $nr = $db->GetFullByDate($month, $day, $year);
   for ($k=0;$k<$nr;$k++)
   {
      $db->next_record();
      if ($db->f('eventtime') == '25:00:00')
      {
          $textlist[24].=$db->f('longevent').'<br>';
      }
      else
      {
          for ($x=0;$x<24;$x++)
          {
             $timestamp = date("H:i:s", mktime($x, 0, 0, 1, 1, 2001));
             $paststamp = date("H:i:s", mktime($x, 59, 0, 1, 1, 2001));
             if (isset($time_format) && $time_format == '12')
             {
                $recordstamp = date("h:iA", strtotime($db->f('eventtime')));
             }
             else
             {
                $recordstamp = date("H:i", strtotime($db->f('eventtime')));
             }
             if ($db->f('eventtime') >= $timestamp && $db->f('eventtime') <= $paststamp)
             {
                $textlist[$x].=$recordstamp.' - '.$db->f('longevent').'<br>';
             }
          }
      }
   }
   $nr = $db->GetFullYearly($month, $day);
   for ($k=0;$k<$nr;$k++)
   {
      $db->next_record();
      if ($db->f('eventtime') == '25:00:00')
      {
          $textlist[24].=$db->f('longevent').'<br>';
      }
      else
      {
          for ($x=0;$x<24;$x++)
          {
             $timestamp = date("H:i:s", mktime($x, 0, 0, 1, 1, 2001));
             $paststamp = date("H:i:s", mktime($x, 59, 0, 1, 1, 2001));
             if (isset($time_format) && $time_format == '12')
             {
                $recordstamp = date("h:iA", strtotime($db->f('eventtime')));
             }
             else
             {
                $recordstamp = date("H:i", strtotime($db->f('eventtime')));
             }
             if ($db->f('eventtime') >= $timestamp && $db->f('eventtime') <= $paststamp)
             {
                $textlist[$x].=$recordstamp.' - '.$db->f('longevent').'<br>';
             }
          }
      }
   }
   $nr = $db->GetFullYearlyRecurring($month, $dayofweek);
   for ($k=0;$k<$nr;$k++)
   {
       $db->next_record();
       $test = $day / 7;
       $periodlow = $db->f('period') - 1;
       if ($test <= $db->f('period') && $test > $periodlow)
       {
          if ($db->f('eventtime') == '25:00:00')
          {
             $textlist[24].=$db->f('longevent').'<br>';
          }
          else
          {
             for ($x=0;$x<24;$x++)
             {
                $timestamp = date("H:i:s", mktime($x, 0, 0, 1, 1, 2001));
                $paststamp = date("H:i:s", mktime($x, 59, 0, 1, 1, 2001));
                if (isset($time_format) && $time_format == '12')
                {
                   $recordstamp = date("h:iA", strtotime($db->f('eventtime')));
                }
                else
                {
                   $recordstamp = date("H:i", strtotime($db->f('eventtime')));
                }
                if ($db->f('eventtime') >= $timestamp && $db->f('eventtime') <= $paststamp)
                {
                   $textlist[$x].=$recordstamp.' - '.$db->f('longevent').'<br>';
                }
             }
          }
       }
   }
   $nr = $db->GetFullMonthly($day);
   for ($k=0;$k<$nr;$k++)
   {
      $db->next_record();
      if ($db->f('eventtime') == '25:00:00')
      {
          $textlist[24].=$db->f('longevent').'<br>';
      }
      else
      {
          for ($x=0;$x<24;$x++)
          {
             $timestamp = date("H:i:s", mktime($x, 0, 0, 1, 1, 2001));
             $paststamp = date("H:i:s", mktime($x, 59, 0, 1, 1, 2001));
             if (isset($time_format) && $time_format == '12')
             {
                $recordstamp = date("h:iA", strtotime($db->f('eventtime')));
             }
             else
             {
                $recordstamp = date("H:i", strtotime($db->f('eventtime')));
             }
             if ($db->f('eventtime') >= $timestamp && $db->f('eventtime') <= $paststamp)
             {
                $textlist[$x].=$recordstamp.' - '.$db->f('longevent').'<br>';
             }
          }
      }
   }
   $nr = $db->GetFullMonthlyRecurring($dayofweek);
   for ($k=0;$k<$nr;$k++)
   {
       $db->next_record();
       $test = $day / 7;
       $periodlow = $db->f('period') - 1;
       if ($test <= $db->f('period') && $test > $periodlow)
       {
          if ($db->f('eventtime') == '25:00:00')
          {
             $textlist[24].=$db->f('longevent').'<br>';
          }
          else
          {
             for ($x=0;$x<24;$x++)
             {
                $timestamp = date("H:i:s", mktime($x, 0, 0, 1, 1, 2001));
                $paststamp = date("H:i:s", mktime($x, 59, 0, 1, 1, 2001));
                if (isset($time_format) && $time_format == '12')
                {
                   $recordstamp = date("h:iA", strtotime($db->f('eventtime')));
                }
                else
                {
                   $recordstamp = date("H:i", strtotime($db->f('eventtime')));
                }
                if ($db->f('eventtime') >= $timestamp && $db->f('eventtime') <= $paststamp)
                {
                   $textlist[$x].=$recordstamp.' - '.$db->f('longevent').'<br>';
                }
             }
          }
       }
   }
   $nr = $db->GetFullWeekly($dayofweek);
   for ($k=0;$k<$nr;$k++)
   {
      $db->next_record();
      if ($db->f('eventtime') == '25:00:00')
      {
          $textlist[24].=$db->f('longevent').'<br>';
      }
      else
      {
          for ($x=0;$x<24;$x++)
          {
             $timestamp = date("H:i:s", mktime($x, 0, 0, 1, 1, 2001));
             $paststamp = date("H:i:s", mktime($x, 59, 0, 1, 1, 2001));
             if (isset($time_format) && $time_format == '12')
             {
                $recordstamp = date("h:iA", strtotime($db->f('eventtime')));
             }
             else
             {
                $recordstamp = date("H:i", strtotime($db->f('eventtime')));
             }
             if ($db->f('eventtime') >= $timestamp && $db->f('eventtime') <= $paststamp)
             {
                $textlist[$x].=$recordstamp.' - '.$db->f('longevent').'<br>';
             }
          }
      }
   }
   AddFullLine($textlist[24]);
   $linecount = 2;
   for ($k=0;$k<12;$k++)
   {
      echo '	<!--tr-->
';
      $j = $k + 12;
      if ($time_zone == 'auto')
      {
         if (isset($time_format) && $time_format == '12')
         {
            $timestamp = date("h:iAT", mktime($k, 0, 0, $month, $day, $year));
         }
         else
         {
            $timestamp = date("H:iT", mktime($k, 0, 0, $month, $day, $year));
         }
      }
      else
      {
         if (isset($time_format) && $time_format == '12')
         {
            $timestamp = date("h:iA", mktime($k, 0, 0, $month, $day, $year)).$time_zone;
         }
         else
         {
            $timestamp = date("H:i", mktime($k, 0, 0, $month, $day, $year)).$time_zone;
         }
      }
      #AddLine($textlist[$k], $timestamp, $linecount);
      if ($time_zone == 'auto')
      {
         if (isset($time_format) && $time_format == '12')
         {
            $timestamp = date("h:iAT", mktime($j, 0, 0, $month, $day, $year));
         }
         else
         {
            $timestamp = date("H:iT", mktime($j, 0, 0, $month, $day, $year));
         }
      }
      else
      {
         if (isset($time_format) && $time_format == '12')
         {
            $timestamp = date("h:iA", mktime($j, 0, 0, $month, $day, $year)).$time_zone;
         }
         else
         {
            $timestamp = date("H:i", mktime($j, 0, 0, $month, $day, $year)).$time_zone;
         }
      }
      #AddLine($textlist[$j], $timestamp, $linecount);
      if ($linecount > 1)
      {
         $linecount = 1;
      }
      else
      {
         $linecount = 2;
      }
      echo '	<!--/tr-->
';
   }
echo '	</TABLE>
</BODY>
</HTML>';
