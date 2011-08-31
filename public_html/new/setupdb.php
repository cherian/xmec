<?
/* ©2002 Proverbs, LLC. All rights reserved. */ 

   require "db_mysql.inc";
   require "config.inc.php";
   require "layout.inc.php";

class dbaccess extends DB_Sql
{
    // - host & database info
    var $Host;
    var $Database;
    var $User;
    var $Password;
 
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

    function SetupDB()
    {
      $query = "CREATE TABLE calusers (userid varchar(25) NOT NULL default '', password varchar(25) NOT NULL default '', ";
      $query.= "rights tinyint(4) NOT NULL default '0', PRIMARY KEY  (userid), UNIQUE KEY userid (userid), ";
      $query.= "KEY userid_2 (userid)) TYPE=MyISAM";
      $this->query($query);
      
      $query = "INSERT INTO calusers VALUES ('admin', '', 2)";
      $this->query($query);
      
      $query = "CREATE TABLE recurring (id int(10) unsigned NOT NULL auto_increment, weekday tinyint(4) ";
      $query.= "NOT NULL default '0', eventtime time NOT NULL default '25:00:00', ";
      $query.= "schedule enum('weekly','monthly','yearly') NOT NULL default 'weekly', period tinyint(4) default NULL, ";
      $query.= "month tinyint(4) default NULL, shortevent varchar(50) NOT NULL default '', ";
      $query.= "longevent varchar(255) NOT NULL default '', userid varchar(25) NOT NULL default '', ";
      $query.= "PRIMARY KEY  (id), UNIQUE KEY id (id), KEY weekday (weekday), KEY eventtime (eventtime)) TYPE=MyISAM";
      $this->query($query);
      
      $query = "CREATE TABLE bydate (id int(10) unsigned NOT NULL auto_increment, ";
      $query.= "eventdate date NOT NULL default '0000-00-00', eventtime time NOT NULL default '25:00:00', ";
      $query.= "shortevent varchar(50) NOT NULL default '', longevent varchar(255) NOT NULL default '', ";
      $query.= "userid varchar(25) NOT NULL default '', PRIMARY KEY  (id), UNIQUE KEY id (id), ";
      $query.= "KEY eventdate (eventdate), KEY eventtime (eventtime)) TYPE=MyISAM";
      $this->query($query);
    }
    
    function CheckSetup()
    {
       $query = "SELECT rights FROM calusers WHERE userid='admin'";
       $this->query($query);
       
       if ($this->affected_rows() > 0)
       {
           $this->next_record();
           return $this->f('rights');
       }
       return 0;
    }
}

   // Create the database object.
   $db = new dbaccess;
   echo '<HTML>
<HEAD>
   <TITLE>'.$site_title.' Database Setup</TITLE>
   <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
</HEAD>
<BODY TOPMARGIN=0 LEFTMARGIN=0 MARGINHEIGHT=0 MARGINWIDTH=0>
<CENTER>';
   $db->SetupDB();

   $nr = $db->CheckSetup();

   if (isset($nr) && $nr >= 1)
   {
      echo 'The Calendar Database Has Been Created<br><br>
	Administrative Userid created for Calender(no password)<br>
	Userid: admin<br>
	Password: <br><br>
	The userid is case sensitive.<br>
	You may change the admin password within the Calender Administration tool<br>
	<br>
	You may remove this file (setupdb.php) from your website now.<br><br>';
   }
   else
   {
      echo 'Error creating the calendar database tables!<br><br>
        Ensure that the database: "'.$config_databasename.'" exists on the MySQL server,<br>
        correct permissions to the account: "'.$config_databaseuser.'" have been assigned<br>
        and then reload this webpage.<br><br>';
   }
echo '</CENTER>
</BODY>
</HTML>';
?>