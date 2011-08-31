<?
/* ©2002 Proverbs, LLC. All rights reserved. */ 

   require "layout.inc.php";
   require ".dbaccess.inc";

/* Prakash 
   if (isset($submit) && $submit == "Login")
   {
      if (isset($userid) && isset($password))
      {
         if ($db->LoginUser($userid, $password) != 0)
         {
            setcookie("usercookie", $userid, time()+(3600*24), "", "", 0);
         }
         else
         {
            setcookie("usercookie", "", time() - 3600, "", "", 0);
            $userid='';
            $rights = 0;
         }
      }
   }
   else
   {
      if (isset($submit) && $submit == "Logout")
      {
         setcookie("usercookie", "", time() - 3600, "", "", 0);
         $userid='';
         $rights = 0;
      }
      else
      {
         if (!isset($usercookie))
         {
            $userid = ''; 
         }
         else
         {
            $userid=$usercookie;
         }
      }
   }
*/
	
	$secure_page = 1;
	include 'header.php';

	$user =& XMEC::getUser();
	if ($user->isAdmin()) {
		$userid = 'admin';
	} else {
	  $userid = '';
	}
	
   
   $rights = $db->CheckRights($userid);

   if (isset($eventtime))
   {
      $eventtime = str_replace("24:", "00:", $eventtime);
   }

   if (isset($update) && $update == 'Update' && isset($select) && $select != '')
   {
      if (isset($shortevent))
      {
         $eventhour = date("H", strtotime($eventtime));
         $eventmin = date("i", strtotime($eventtime));

         if (isset($time_format) && $time_format == '12')
         {
            if (isset($amtopm) && $amtopm == 1 && $eventtime != '')
            {
               if ($eventhour < 12)
               {
                  $newhour = $eventhour + 12;
               }
               else
               {
                  $newhour = $eventhour;
               }
               $eventtime = $newhour.':'.$eventmin;
            }
            else
            {
               if (isset($amtopm) && $amtopm == 0 && $eventhour == 12)
               {
                  $eventtime = '00:'.$eventmin;
               }
            }
         }
  
         if (!isset($longevent) || $longevent == '')
         {
            $longevent == $shortevent;
         }
         if (!strstr($select, "rec"))
         {
            $db->UpdateByDate($select, $shortevent, $longevent, $eventtime, $userid);
         }
         else
         {
            $select = str_replace("rec", "", $select);
            $db->UpdateRecurring($select, $shortevent, $longevent, $eventtime, $userid);
         }
      }
   }

   if (isset($remove) && $remove == 'Delete' && isset($select) && $select != '')
   {
      if (!strstr($select, "rec"))
      {
         $db->RemoveByDate($select);
      }
      else
      {
         $select = str_replace("rec", "", $select);
         $db->RemoveRecurring($select);
      }
   }

   if (isset($userstuff) && $rights== 2)
   {
      if ($userstuff == "Add" && isset($userright) && isset($newid) && $newid != "")
      {
         $db->AddUser($newid, $userpass, $userright);
      }
      if ($userstuff == "Update" && isset($changeid) && $changeid != "" && isset($changeright))
      {
         $db->UpdateRights($changeid, $changeright);
      }
      if ($userstuff == "Delete" && isset($changeid) && $changeid != "")
      {
         $db->RemoveUser($changeid);
      }
   }

   if (isset($submit) && $submit=="Change" && isset($password))
   {
      $db->SetUserPassword($userid, $password);
   }

   if (isset($bydate))
   {
      if (!isset($longevent) || $longevent == '')
      {
         $longevent == $shortevent;
      }
      if ($bydate == "Add")
      {
         $eventhour = date("H", strtotime($eventtime));
         $eventmin = date("i", strtotime($eventtime));

         if (isset($time_format) && $time_format == '12')
         {
            if (isset($amtopm) && $amtopm == 1 && $eventtime != '')
            {
               if ($eventhour < 12)
               {
                  $newhour = $eventhour + 12;
               }
               else
               {
                  $newhour = $eventhour;
               }
               $eventtime = $newhour.':'.$eventmin;
            }
            else
            {
               if (isset($amtopm) && $amtopm == 0 && $eventhour == 12)
               {
                  $eventtime = '00:'.$eventmin;
               }
            }
         }

         if ($month == 0)
         {
            $eventdate = date("1900-00-d", mktime(0, 0, 0, 0, $day, 0));
         }
         else
         {
            if ($year == 0)
            {
              $eventdate = date("1900-m-d", mktime(0, 0, 0, $month, $day, 0));
            }
            else
            {
               if (!isset($day) || $day > 31 || $day < 1)
               {
                  $day = date("j");
               }
               $eventdate = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
            }
         }
         
         $db->AddByDate($userid, $shortevent, $longevent, $eventtime, $eventdate);
         $eventadded = 'yes';
      }
   
   }
   if (isset($recurring))
   {
      if (!isset($longevent) || $longevent == '')
      {
         $longevent == $shortevent;
      }
      if ($recurring == "Add")
      {
         $eventhour = date("H", strtotime($eventtime));
         $eventmin = date("i", strtotime($eventtime));

         if (isset($time_format) && $time_format == '12')
            {
            if (isset($amtopm) && $amtopm == 1 && $eventtime != '')
            {
               if ($eventhour < 12)
               {
                  $newhour = $eventhour + 12;
               }
               else
               {
                  $newhour = $eventhour;
               }
               $eventtime = $newhour.':'.$eventmin;
            }
            else
            {
               if (isset($amtopm) && $amtopm == 0 && $eventhour == 12)
               {
                  $eventtime = '00:'.$eventmin;
               }
            }
         }

         $db->AddRecurring($userid, $shortevent, $longevent, $eventtime, $weekday, $period, $schedule, $rmonth);
      
         $eventadded = 'yes';
      }
   }


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

   function newline()
   {
      echo '	</tr>
	<tr>
';
   }

   function td($content)
   {
      echo '	<td align="left" valign="middle">
      		'.$content.'
	</td>
';   
   }

   function tdright($content)
   {
      echo '	<td class="right" align="right" valign="middle">
      		'.$content.'
	</td>
';   
   }

   function tdlogin($content)
   {
      echo '	<td class="login" align="center" valign="middle">
      		'.$content.'
	</td>
';   
   } 
 
   function tdlogintwo($content)
   {
      echo '	<td class="login" align="center" valign="middle" colspan=2>
      		'.$content.'
	</td>
';   
   }
      /* echo '<HTML>
<HEAD>
   <TITLE>Calendar Administration</TITLE>
   <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">';
   echo '<STYLE TYPE="text/css">
	<!--
		BODY {background-color: #'.$background_color.'; border-style: none; border-width: 0px; color: #'.$plain_text_color.'; 
			font-family: Arial; font-size: 12px; font-style: normal; margin: 0px; padding: 2px;
			text-align: left; text-decoration: none; text-indent: 0px}
		TABLE {border-style: none; margin: 0px; padding: 0px; border-width: none; font-size: 12px; text-indent: 0px;
			font-weight: normal; width: 398px; height: 422px; background-color: #'.$calendar_bg_color.'; 
			color: #'.$plain_text_color.'}
		TR {border-style: none; border-width: 0px; margin: 0px; padding: 0px}
		TD {border-style: solid; border-width: thin; margin: 0px; padding: 2px; font-weight: normal; text-align: left; 
			border-color: #'.$calendar_border_color.'; font-size: 12px; background-color: #'.$calendar_bg_color.'; height: 20px}
	        TD.login {text-align: center}
	        TD.right {text-align: right}
	-->
	</STYLE>
	<SCRIPT LANGUAGE="JavaScript">
	<!-- 
		function clickselect(shortstuff, longstuff, timestuff, istwelve)
		{
		   document.forms[0].shortevent.value = shortstuff;
		   document.forms[0].longevent.value = longstuff;
		   if (istwelve == \'12\')
		   {
		      var newtime;
		      if (timestuff.substr(0,2) >= \'12\')
		      {
		         document.forms[0].amtopm.value = 1;
		         var test = timestuff.substr(0,2);
		         if (test == \'25\')
		         {
		            newtime = \'\';
		         }
		         else
		         {
		            if (test > \'12\')
		            {
		               test = test - \'12\';
		            }
		            if (test < \'10\')
		            {
		               newtime = \'0\' + test + timestuff.substr(2,5);
		            }
		            else
		            {
		               newtime = test + timestuff.substr(2,5);
		            }
		         }
		         timestuff = newtime;
		      }
		      else
		      {
		         if (timestuff.substr(0,2) == \'00\')
		         {
		            newtime = \'12\'+ timestuff.substr(2,5);
		            timestuff = newtime;
		         }
		         document.forms[0].amtopm.value = 0;
		      }
		   }
		   document.forms[0].eventtime.value = timestuff;			
		}
	//-->
	</SCRIPT>
</HEAD>
';

echo '<BODY TOPMARGIN=0 LEFTMARGIN=0 MARGINHEIGHT=0 MARGINWIDTH=0> */
	echo '<FORM METHOD="post" ACTION="caladmin.php">
	<TABLE cellspacing=0 cellpadding=0 width=398 height=422 border=1>
	<TR>
';
   if (!isset($userid) || $userid == '' || $rights == 0)
   {
      $content = '<b>Authorization Required</b><br>
		<b>Please Login</b><br><br>
		<b>Username:</b> <input type="text" name="userid" size="25" maxlength="25"><br>
		<b>Password:</b> <input type="password" name="password" size="25" maxlength="25"><br>
		<input type="submit" name="submit" value="Login">';
      tdlogin($content);
   }
   else
   {
      if ($rights == 2 && isset($submit) && $submit == "User Admin")
      {
         $content = '<b>Calendar User Administration</b>';
         $content.= '<input type="hidden" name="submit" value="User Admin">';
         tdlogintwo($content);
         newline();
         tdlogintwo('Create New User');
         newline();
         tdright('Userid:');
         td('<input type="text" name="newid" size="25" maxlength="25">');
         newline();
         tdright('Password:');
         td('<input type="password" name="userpass" size="25" maxlength="25">');
         newline();
         tdright('Access Level:');
         $content = '<select name="userright"><option value=0>None<option value=1>Modify Own<option value=2>Full</select>';
         $content.= '&nbsp;&nbsp;&nbsp;<input type="submit" name="userstuff" value="Add">';
         td($content);
         newline();
         $nr = $db->GetUsers();
         if ($nr > 1)
         {
            tdlogintwo('Edit Existing User');
            newline();
            $content = 'Userid: <select name="changeid">';
            for ($i=0;$i<$nr;$i++)
            {
               $db->next_record();
               if ($db->f('userid') != $userid)
               {
                  $content.='<option value="'.$db->f('userid').'"';
                  if (isset($changeid) && $changeid == $db->f('userid'))
                  {
                     $content.=' SELECTED';
                  }
                  $content.='>'.$db->f('userid');
               }
            }
            $content.='</select><br>';
            $content.='Access Level: <select name="changeright">';
            $content.='<option value=0>None<option value=1>Modify Own<option value=2>Full</select><br><br>';
            $content.='<input type="submit" name="userstuff" value="Update"> &nbsp;&nbsp;&nbsp;';
            $content.='<input type="submit" name="userstuff" value="Delete">';
            tdlogintwo($content);
            newline();
         }
         tdlogintwo('<input type="submit" name="submit" value="Admin Page">');
         newline();
      }  
      else
      {
         if (isset($edit) && $edit == "Edit Existing") 
         {
            $content = '<b>Edit Calender</b>';
            tdlogintwo($content);
            newline();
            $content = 'Date to Edit:';
            tdright($content);
            $content = 'Month: <select name="month">';
            for ($j=1;$j<=12;$j++)
            {
               $content.='<option value='.$j;
               if ($month == $j)
               {
                  $content.=' selected';
               }
               $content.='>'.date("M", mktime(0, 0, 0, $j, 1, 0));
            }
            $content.='</select>';
            $content.='<input type="hidden" name="edit" value="Edit Existing">';
            $content.='&nbsp;Day: <input type="text" name="day" size="2" maxlength="2" value="'.$day.'">';
            $content.='&nbsp;Year: <select name="year">';
            for ($j=2000;$j<=2036;$j++)
            {
               $content.='<option value='.$j;
               if ($year == $j)
               {
                  $content.= ' selected';
               }
               $content.= '>'.$j;
            }
            $content.='</select><br>';
            $content.='Edit Recurring: <input type="checkbox" name="editrecur"';
            if (isset($editrecur) && $editrecur == "on")
            {
               $content.=' CHECKED';
            }
            $content.='> &nbsp;&nbsp;&nbsp;<input type="submit" name="refresh" value="Refresh">';
            td($content);
            newline();
            $listpresent = 0;
            if (isset($editrecur) && $editrecur == 'on')
            {
               $nr = $db->GetRecurList($rights, $userid);
               $listpresent = $listpresent + $nr;
               for ($i=0;$i<$nr;$i++)
               {
                  $content='';
                  $db->next_record();
                  $tmstmp = str_replace(":00-", "", $db->f('eventtime').'-');
                  $shtvnt = str_replace('"', '', str_replace("'", "", $db->f('shortevent')));
                  $lngvnt = str_replace('"', '', str_replace("'", "", $db->f('longevent')));
                  tdright('<input type="radio" name="select" value="'.$db->f('id').'rec" onClick="clickselect(\''.$shtvnt.'\', \''.$lngvnt.'\', \''.$tmstmp.'\', \''.$time_format.'\')">');
                  if ($db->f('eventtime') == '25:00:00')
                  {
                     #$content.= 'All Day - ';
                  }
                  else
                  {
                     if (isset($time_format) && $time_format == '12')
                     {
                        $recordstamp = date("h:iA", strtotime($db->f('eventtime')));
                     }
                     else
                     {
                        $recordstamp = date("H:i", strtotime($db->f('eventtime')));
                     }                     
                     $timestamp = $recordstamp.' - ';
                     $content.=str_replace(":00 - ", " - ", $timestamp);
                  }
                  if ($db->f('schedule') == 'weekly')
                  {
                     $content.= 'Every ';
                  }
                  else
                  {
                     if ($db->f('schedule') == 'monthly')
                     {
                        $content.= 'Every ';
                     }
                     switch ($db->f('period'))
                     {
                        case (1):
                           $content.='1st ';
                           break;
                        case (2):
                           $content.='2nd ';
                           break;
                        case (3):
                           $content.='3rd ';
                           break;
                        case (4):
                           $content.='4th ';
                           break;
                     }
                  }

                  if ($db->f('weekday')== 0)
                  {
                        $content.='Sun ';
                  }
                  if ($db->f('weekday')== 1)
                  {
                        $content.='Mon ';
                  }
                  if ($db->f('weekday')== 2)
                  {
                        $content.='Tue ';
                  }
                  if ($db->f('weekday')== 3)
                  {
                        $content.='Wed ';
                  }
                  if ($db->f('weekday')== 4)
                  {
                        $content.='Thu ';
                  }
                  if ($db->f('weekday')== 5)
                  {
                        $content.='Fri ';
                  }
                  if ($db->f('weekday')== 6)
                  {
                        $content.='Sat ';
                  }
                  if ($db->f('schedule') == 'yearly')
                  {
                     $content.=' of '.date("M", mktime(0, 0, 0, $db->f('month'), 1, 2001));
                  }
                  $content.=' - ';
                  $content.=$db->f('shortevent');
                  if ($rights == 2)
                  {
                     $content.=' - '.$db->f('userid');
                  }
                  td($content);
                  newline();
               }
               $nr = $db->GetRepeatList($rights, $userid);
               $listpresent = $listpresent + $nr;
               for ($i=0;$i<$nr;$i++)
               {
                  $content='';
                  $db->next_record();
                  $tmstmp = str_replace(":00-", "", $db->f('eventtime').'-');
                  $shtvnt = str_replace('"', '', str_replace("'", "", $db->f('shortevent')));
                  $lngvnt = str_replace('"', '', str_replace("'", "", $db->f('longevent')));
                  tdright('<input type="radio" name="select" value="'.$db->f('id').'" onClick="clickselect(\''.$shtvnt.'\', \''.$lngvnt.'\', \''.$tmstmp.'\', \''.$time_format.'\')">');
                  if ($db->f('eventtime') == '25:00:00')
                  {
                     #$content.= 'All Day - ';
                  }
                  else
                  {
                     $timestamp = $db->f('eventtime').' - ';
                     $content.=str_replace(":00 - ", " - ", $timestamp);
                  }
                  $ripdate = array();
                  $ripdate = explode("-", $db->f('eventdate'));
                  $content.= $ripdate[2].' day of ';
                  if ($ripdate[1] == 0)
                  {
                     $content.='the month';
                  }
                  else
                  {
                     $content.=date("M", mktime(0, 0, 0, $ripdate[1], 1, 2001));
                  }
                  $content.=' - ';
                  $content.=$db->f('shortevent');
                  if ($rights == 2)
                  {
                     $content.=' - '.$db->f('userid');
                  }
                  td($content);
                  newline();
               }
            }
            else
            {
               $nr = $db->GetEditList($rights, $userid, $month, $day, $month, $year);
               $listpresent = $listpresent + $nr;
               for ($i=0;$i<$nr;$i++)
               {
                  $content='';
                  $db->next_record();
                  $tmstmp = str_replace(":00-", "", $db->f('eventtime').'-');
                  $shtvnt = str_replace('"', '', str_replace("'", "", $db->f('shortevent')));
                  $lngvnt = str_replace('"', '', str_replace("'", "", $db->f('longevent')));
                  tdright('<input type="radio" name="select" value="'.$db->f('id').'" onClick="clickselect(\''.$shtvnt.'\', \''.$lngvnt.'\', \''.$tmstmp.'\', \''.$time_format.'\')">');
                  if ($db->f('eventtime') == '25:00:00')
                  {
                     #$content.= 'All Day - ';
                  }
                  else
                  {
                     if (isset($time_format) && $time_format == '12')
                     {
                        $recordstamp = date("h:iA", strtotime($db->f('eventtime')));
                     }
                     else
                     {
                        $recordstamp = date("H:i", strtotime($db->f('eventtime')));
                     }                     
                     $timestamp = $recordstamp.' - ';
                     $content.=str_replace(":00 - ", " - ", $timestamp);
                  }
                  $content.=$db->f('shortevent');
                  if ($rights == 2)
                  {
                     $content.=' - '.$db->f('userid');
                  }
                  td($content);
                  newline();
               }
            }
            if ($listpresent > 0)
            {
               tdlogintwo('New Event Information<br><font size=1>Select the event from above and input the new event information below</font>');
               newline();
               tdright('Title:');
               td('<input type="text" name="shortevent" size="30" maxlength="50">');
               newline();
               tdright('Description:');
               td('<input type="text" name="longevent" size="40" maxlength="255">');
               newline();
               #tdright('Time:');
               $contleft = '<input type="text" name="eventtime" size="6" maxlength="5">';
               if (isset($time_format) && $time_format == '12')
               {
                  $contleft .= ' <select name="amtopm"><option value=0>AM<option value=1>PM</select>';
               }
               else
               {
                  $contleft .= '<input type="hidden" name="amtopm" value=0>';
               }              
               #td($contleft);
               #newline();
            }
            $content='<input type="submit" name="edit" value="Admin Page">';
            if ($listpresent > 0)
            {
               $content.=' &nbsp;&nbsp;<input type="submit" name="update" value="Update">';
               $content.=' &nbsp;&nbsp;<input type="submit" name="remove" value="Delete">';
            }
            tdlogintwo($content);
            newline();
         }
         else
         {
            $content = '<b>'.$site_title.' Calendar Administration</b>';
            tdlogintwo($content);
            /* newline();
            $content = 'User: '.$userid.'&nbsp;&nbsp;<input type="submit" name="submit" value="Logout">';
            if ($rights == 2)
            {
               $content.= ' &nbsp;&nbsp;<input type="submit" name="submit" value="User Admin">';
            }
            tdlogintwo($content);
            newline();
            $content = 'New Password: <input type="password" name="password" size="15" maxlength="25"> &nbsp; 
		<input type="submit" name="submit" value="Change">';
            tdlogintwo($content); */
            newline();
            $content = '<b>Events</b>';
            if (isset($eventadded) && $eventadded == 'yes')
            {
               $content.= '<br>Event Added Successfully';
            }
            tdlogintwo($content);
            newline();
            tdright('Event Title:');
            td('<input type="text" ID="shortevent" name="shortevent" size="30" maxlength="50">');
            newline();
            tdright('Event Description:');
            td('<input type="text" ID="longevent" name="longevent" size="40" maxlength="255">');
            #newline();
            #$contleft = '<input type="text" ID="eventtime" name="eventtime" size="6" maxlength="5">';
            if (isset($time_format) && $time_format == '12')
            {
               #$contright = 'Event Time(12:00):<br><font size=1>Leave blank for all day</font>';
               #$contleft .= ' <select name="amtopm"><option value=0>AM<option value=1>PM</select>';
            }
            else
            {
               #$contright = 'Event Time(24:00):<br><font size=1>Leave blank for all day</font>';
               #$contleft .= '<input type="hidden" name="amtopm" value=0>';
            }
            #tdright($contright);
            #td($contleft);
            newline();
            tdlogintwo('Add By Date');
            newline();
            tdright('Event Date:');
            $content = 'Month: <select name="month">';
            $content.='<option value=0>All';
            for ($j=1;$j<=12;$j++)
            {
               $content.='<option value='.$j;
               if ($month == $j)
               {
                  $content.=' selected';
               }
               $content.='>'.date("M", mktime(0, 0, 0, $j, 1, 0));
            }
            $content.='</select>';
            $content.='&nbsp;Day: <input type="text" name="day" size="2" maxlength="2">';
            $content.='&nbsp;Year: <select name="year">';
            $content.='<option value=0>All';
            for ($j=2000;$j<=2036;$j++)
            {
               $content.='<option value='.$j;
               if ($year == $j)
               {
                  $content.= ' selected';
               }
               $content.= '>'.$j;
            }
            $content.='</select><br><center><input type="submit" name="bydate" value="Add"></center>';
            td($content);
            newline();
            tdlogintwo('Add by Weekday');
            newline();
            tdright('Event Day:');
            $content = '<select name="period">';
            $content.= '<option value=0>All(weekly)';
            $content.= '<option value=1>1st';
            $content.= '<option value=2>2nd';
            $content.= '<option value=3>3rd';
            $content.= '<option value=4>4th';
            $content.= '</select>';
            $content.= '<select name="weekday">';
            $content.= '<option value=0>Sun';
            $content.= '<option value=1>Mon';
            $content.= '<option value=2>Tue';
            $content.= '<option value=3>Wed';
            $content.= '<option value=4>Thu';
            $content.= '<option value=5>Fri';
            $content.= '<option value=6>Sat';
            $content.= '</select>';
            $content.= '\'s&nbsp;of <select name="schedule">';
            $content.= '<option value="weekly">the Week';
            $content.= '<option value="monthly">all Months';
            $content.= '<option value="yearly">the Month ';
            $content.= '</select><br>';
            $content.= ' of <select name="rmonth">';
            $content.= '<option value=0 selected>All(monthly)';
            for ($j=1;$j<=12;$j++)
            {
               $content.='<option value='.$j.'>'.date("M", mktime(0, 0, 0, $j, 1, 0));
            }
            $content.='</select><br><center><input type="submit" name="recurring" value="Add"></center>';
            td($content);
            newline();
            tdlogintwo('<input type="Submit" name="edit" value="Edit Existing">');
         }
      }
   }
echo '	</TR>
	</TABLE>
	</FORM>';
/* </BODY>
</HTML>'; */

include 'footer.php';
