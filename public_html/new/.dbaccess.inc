<?
/* ©2002 Proverbs, LLC. All rights reserved. */ 

   require "db_mysql.inc";
   require "config.inc.php";

class dbaccess extends DB_Sql
{
    // - host & database info
    var $Host;
    var $Database;
    var $User;
    var $Password;
 
    // - table names
    var $tbl_bydate = "bydate";
    var $tbl_recurring = "recurring";
    var $tbl_users = "calusers";

    // Constructor
    function dbaccess()
    {
      global $config_databasehost,$config_databasename,$config_databaseuser,$config_databasepassword;

      $this->Host          = $config_databasehost;
      $this->Database      = $config_databasename;
      $this->User          = $config_databaseuser;
      $this->Password      = $config_databasepassword;
    }

    function TableName($var)
    {
      return $this->$var;
    }

    function GetByDate($month, $day, $year)
    {
      $a     = $this->TableName("tbl_bydate");
      $chkdate = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
      $query = "SELECT shortevent FROM $a WHERE eventdate='$chkdate' ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    }
    
    function GetYearly($month, $day)
    {
      $a     = $this->TableName("tbl_bydate");
      $chkdate = date("1900-m-d", mktime(0, 0, 0, $month, $day, 0));
      $query = "SELECT shortevent FROM $a WHERE eventdate='$chkdate' ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    }
    
    function GetMonthly($day)
    {
      $a     = $this->TableName("tbl_bydate");
      $chkdate = date("1900-00-d", mktime(0, 0, 0, 0, $day, 0));
      $query = "SELECT shortevent FROM $a WHERE eventdate='$chkdate' ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    }

    function GetWeekly($weekday)
    {
      $a     = $this->TableName("tbl_recurring");
      $query = "SELECT shortevent FROM $a WHERE weekday=$weekday AND schedule='weekly' ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    }
    
    function GetYearlyRecurring($month, $weekday)
    {
      $a     = $this->TableName("tbl_recurring");
      $query = "SELECT shortevent, period FROM $a WHERE weekday=$weekday AND schedule='yearly' AND month=$month ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    }
    
    function GetMonthlyRecurring($weekday)
    {
      $a     = $this->TableName("tbl_recurring");
      $query = "SELECT shortevent, period FROM $a WHERE weekday=$weekday AND schedule='monthly' ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    }

    function GetFullByDate($month, $day, $year)
    {
      $a     = $this->TableName("tbl_bydate");
      $chkdate = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
      $query = "SELECT longevent, eventtime FROM $a WHERE eventdate='$chkdate' ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    }
    
    function GetFullYearly($month, $day)
    {
      $a     = $this->TableName("tbl_bydate");
      $chkdate = date("1900-m-d", mktime(0, 0, 0, $month, $day, 0));
      $query = "SELECT longevent, eventtime FROM $a WHERE eventdate='$chkdate' ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    }
    
    function GetFullMonthly($day)
    {
      $a     = $this->TableName("tbl_bydate");
      $chkdate = date("1900-00-d", mktime(0, 0, 0, 0, $day, 0));
      $query = "SELECT longevent, eventtime FROM $a WHERE eventdate='$chkdate' ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    }

    function GetFullWeekly($weekday)
    {
      $a     = $this->TableName("tbl_recurring");
      $query = "SELECT longevent, eventtime FROM $a WHERE weekday=$weekday AND schedule='weekly' ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    }
    
    function GetFullYearlyRecurring($month, $weekday)
    {
      $a     = $this->TableName("tbl_recurring");
      $query = "SELECT longevent, eventtime, period FROM $a WHERE weekday=$weekday AND schedule='yearly' AND month=$month ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    }
    
    function GetFullMonthlyRecurring($weekday)
    {
      $a     = $this->TableName("tbl_recurring");
      $query = "SELECT longevent, eventtime, period FROM $a WHERE weekday=$weekday AND schedule='monthly' ORDER BY eventtime";
      $this->query($query);
      return $this->affected_rows();
    } 

    function CheckRights($userid)
    {
       $a    = $this->TableName("tbl_users");
       $query = "SELECT rights FROM $a WHERE userid='$userid'";
       $this->query($query);
       
       if ($this->affected_rows() > 0)
       {
           $this->next_record();
           return $this->f('rights');
       }
       return 0;
    }
    
    function SetUserPassword($userid, $password)
    {
       $a    = $this->TableName("tbl_users");
       $query = "UPDATE $a SET password=PASSWORD('$password') WHERE userid='$userid'";
       $this->query($query);
    }
    
    function LoginUser($userid, $password)
    {
       $a    = $this->TableName("tbl_users");
       $query = "SELECT userid FROM $a WHERE userid='$userid' AND password=PASSWORD('$password')";
       $this->query($query);
       return $this->affected_rows();
    }
    
    function UpdateRights($userid, $rights)
    {
       $a    = $this->TableName("tbl_users");
       $query = "UPDATE $a SET rights='$rights' WHERE userid='$userid'";
       $this->query($query);
    }
 
    function AddUser($userid, $password, $rights)
    {
       $a    = $this->TableName("tbl_users");
       $query = "INSERT INTO $a (userid, password, rights) VALUES ('$userid', PASSWORD('$password'), '$rights')";
       $this->query($query);
    }

    function RemoveUser($userid)
    {
       $a    = $this->TableName("tbl_users");
       $query = "DELETE from $a WHERE userid='$userid'";
       $this->query($query);
    }

    function GetUsers()
    {
       $a    = $this->TableName("tbl_users");
       $query = "SELECT userid FROM $a";
       $this->query($query);
       return $this->affected_rows();
    }

    function AddByDate($userid, $shortevent, $longevent, $eventtime, $eventdate)
    {
       $a    = $this->TableName("tbl_bydate");
       $shortevent = strip_tags($shortevent, '<b><font><i><u>');
       $longevent = strip_tags($longevent, '<b><font><i><u>');
       if ($longevent == "")
       {
          if ($shortevent == "")
          {
             return;
          }
          else
          {
             $longevent = $shortevent;
          }
       }
       if ($eventtime == '')
       {
          $eventtime = '25:00:00';
       }
       else
       {
         $eventtime.= ':00';
       }
       
       $query = "INSERT INTO $a (userid, shortevent, longevent, eventtime, eventdate) VALUES ('$userid', '$shortevent', '$longevent', '$eventtime', '$eventdate')";
       $this->query($query);
    }
    
    function AddRecurring($userid, $shortevent, $longevent, $eventtime, $weekday, $period, $schedule, $month)
    {
       $a    = $this->TableName("tbl_recurring");
       $shortevent = strip_tags($shortevent, '<b><font><i><u>');
       $longevent = strip_tags($longevent, '<b><font><i><u>');
       if ($longevent == "")
       {
          if ($shortevent == "")
          {
             return;
          }
          else
          {
             $longevent = $shortevent;
          }
       }
       if ($eventtime == '')
       {
          $eventtime = '25:00:00';
       }
       else
       {
         $eventtime.= ':00';
       }
       
       if ($period == 0 && $schedule == 'monthly' && $month == 0)
       {
          $schedule = 'weekly';
       }
       $query = "INSERT INTO $a (userid, shortevent, longevent, eventtime, weekday, period, schedule, month) VALUES ('$userid', '$shortevent', '$longevent', '$eventtime', $weekday, $period, '$schedule', $month)";
       $this->query($query);
    }
    
    function GetRecurList($rights, $userid)
    {
       $a    = $this->TableName("tbl_recurring");
       
       if ($rights == 2)
       {
          $query = "SELECT * FROM $a ORDER BY eventtime";
       }
       else
       { 
          $query = "SELECT * FROM $a WHERE userid='$userid' ORDER BY eventtime";
       }
       $this->query($query);
       return $this->affected_rows();
    }

    function GetRepeatList($rights, $userid)
    {
       $a    = $this->TableName("tbl_bydate");
       $chkdate = "1901-12-31";
       
       if ($rights == 2)
       {
          $query = "SELECT * FROM $a WHERE eventdate<'$chkdate' ORDER BY eventtime";
       }
       else
       { 
          $query = "SELECT * FROM $a WHERE eventdate<'$chkdate' AND userid='$userid' ORDER BY eventtime";
       }
       $this->query($query);
       return $this->affected_rows();
    }

    function GetEditList($rights, $userid, $month, $day, $month, $year)
    {
       $a    = $this->TableName("tbl_bydate");
       $chkdate = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
       
       if ($rights == 2)
       {
          $query = "SELECT * FROM $a WHERE eventdate='$chkdate' ORDER BY eventtime";
       }
       else
       { 
          $query = "SELECT * FROM $a WHERE eventdate='$chkdate' AND userid='$userid' ORDER BY eventtime";
       }
       $this->query($query);
       return $this->affected_rows();
    } 
    
    function RemoveRecurring($id)
    {
       $a    = $this->TableName("tbl_recurring");
       $query = "DELETE from $a WHERE id=$id";
       $this->query($query);
    }
    
    function RemoveByDate($id)
    {
       $a    = $this->TableName("tbl_bydate");
       $query = "DELETE from $a WHERE id=$id";
       $this->query($query);
    }
    
    function UpdateRecurring($id, $shortevent, $longevent, $eventtime, $userid)
    {
       $a    = $this->TableName("tbl_recurring");
       $shortevent = strip_tags($shortevent, '<b><font><i><u>');
       $longevent = strip_tags($longevent, '<b><font><i><u>');
       if ($longevent == "")
       {
          if ($shortevent == "")
          {
             return;
          }
          else
          {
             $longevent = $shortevent;
          }
       }
       if ($eventtime == '')
       {
          $eventtime = '25:00:00';
       }
       else
       {
         $eventtime.= ':00';
       }
       
       $query = "UPDATE $a SET shortevent='$shortevent', longevent='$longevent', eventtime='$eventtime', ";
       $query.= "userid='$userid' WHERE id=$id";
       $this->query($query);
    }
    
    function UpdateByDate($id, $shortevent, $longevent, $eventtime, $userid)
    {
       $a    = $this->TableName("tbl_bydate");
       $shortevent = strip_tags($shortevent, '<b><font><i><u>');
       $longevent = strip_tags($longevent, '<b><font><i><u>');
       if ($longevent == "")
       {
          if ($shortevent == "")
          {
             return;
          }
          else
          {
             $longevent = $shortevent;
          }
       }
       if ($eventtime == '')
       {
          $eventtime = '25:00:00';
       }
       else
       {
         $eventtime.= ':00';
       }

       $query = "UPDATE $a SET shortevent='$shortevent', longevent='$longevent', eventtime='$eventtime', ";
       $query.= "userid='$userid' WHERE id=$id";
       $this->query($query);
    }
       
}

  // Create the database object.
  $db = new dbaccess;
?>
