<?
ini_set ("include_path", ini_get("include_path") . 
	":/usr/addr/php/lib/php:/usr163/home/x/m/xmec/settings");
require_once 'DB.php';
require_once ('xmec_defines.inc');

// Preferences
define ('VISIBLE_PUBLIC', 0);
define ('VISIBLE_XMEC', 1);
define ('VISIBLE_NONE', 2);
define ('PERSONAL_EMAIL_MASK', 0xf);
define ('OFFICIAL_EMAIL_MASK', 0xf0);

//
// Globals
//

$__xmec_db = NULL;
$__xmec_user = NULL;
$__xmec_shutdown_registered = FALSE;

//
// Set error reporting level
//

if (!isset($__xmec_debug) || !$__xmec_debug)
        error_reporting(E_ERROR|E_PARSE|E_CORE_ERROR|E_CORE_WARNING);

function safeShutdown()
{
    global $__xmec_db; 
    if (isset($__xmec_db) && is_subclass_of($__xmec_db, "db_common")) {
        $__xmec_db->disconnect();
    }
}

/////////////////////////////////////////////////////////////
//
// class XMEC
//
/////////////////////////////////////////////////////////////

class XMEC
{
    function &getDB()
    {
        global $__xmec_db; 
        global $__xmec_dsn; // in xmec_defines.php
        global $__xmec_shutdown_registered;

        if (!isset($__xmec_db) || 
                !is_subclass_of($__xmec_db, "db_common")) {
            $__xmec_db = DB::connect($__xmec_dsn, false);
            if (DB::isError($__xmec_db)) {
                XMEC::error_exit($__xmec_db->getMessage());
            }
        //    if (!$__xmec_shutdown_registered) {
        //        register_shutdown_function(safeShutdown);
        //        $__xmec_shutdown_registered = TRUE;
        //    }
        }

        return $__xmec_db;
    }


    function &getUser()
    {
        global $__xmec_user;

        if (!isset($__xmec_user) ||
                get_class($__xmec_user) != "xmec_user") {
            $__xmec_user = new XMEC_user();
        }

        return $__xmec_user;
    }

    function authenticate_user()
    {
	session_cache_limiter('nocache');
        session_start();
        if (session_is_registered("__xmec_user")) {
            $user =& XMEC::getUser();
            return $user->isLoggedIn();
        }
				
        return FALSE;
    }

    function user_login($username, $passwd)
    {
	global $REMOTE_ADDR;
	global $REMOTE_HOST;

        $user =& XMEC::getUser();

        $user->setID($username);
        if (! $user->validateUser($passwd)) {
            return FALSE;
        }

        if (! $user->fetchInfo()) {
            return FALSE;
        }

	session_cache_limiter('nocache');
        session_start();
        session_register("__xmec_user");

	$msg = 'Login from ' . $REMOTE_HOST . ' ('. $REMOTE_ADDR . ')';
	XMEC::log('LOGIN', $user->get('id'), $msg);

        return TRUE;
    }

    function user_logout()
    {
	session_cache_limiter('nocache');
        session_start();
        session_destroy();

        $user =& XMEC::getUser();
        if ($user->isLoggedIn()) {
	    XMEC::log('LOGOUT', $user->get('id'));
            $user = new XMEC_user();
	}
    }
        
    function get_work_types()
    {
        $dbh =& XMEC::getDB();

        $query = "select distinct work_type from xmec_user ";
        $query .= "where work_type <> ''";
        $res =& $dbh->getCol($query);

        if (DB::isError($res)) {
            // return null array..
            $res = array();
         }

         return $res;
    }
	
		function get_user_count($join_batch = null)
		{
        $res = array();
        $dbh =& XMEC::getDB();

        $q = "select count(id) from xmec_user where id like '%".$join_batch."%'";

        $r = $dbh->query($q);
        if (DB::isError($r)) {
            return $res;
        }

        $i = 0;
        $res = $r->fetchRow();

	return ($res[0]);
    }

    function &get_update_list($join_batch = null)
    {
        $res = array();
        $dbh =& XMEC::getDB();

        $q = "select id, concat_ws(' ',first_name,";
	$q .= "middle_name, last_name) as name, DATE_FORMAT(last_update,'%d %b %Y %H:%m')";
	$q .= ", branch";
	$q .= " from xmec_user where (last_update <> '0000-00-00 00:00:00')";
	$q .=" and (id like '%" .$join_batch."%') ";
	$q .= " order by last_update desc";

        $r = $dbh->query($q);
        if (DB::isError($r)) {
            return $res;
        }

        $i = 0;
        while (is_array($x = $r->fetchRow()))
            $res[$i++] = $x[0]. ',' . $x[1] . ','. $x[2] . ','. $x[3];

	return ($res);
    }

    function &search($fil, $start=0, $count=10)
    {
        $res = array();

        $dbh =& XMEC::getDB();

        // Temporary table with:
        // id, name, work_type, company, branch, city, street, area, state, year
       
        $q = "create temporary table search_tmp select a.id as id, ";
        $q .= "concat_ws(' ',a.first_name, a.middle_name, a.last_name) as ";
        $q .= "name, a.work_type as work_type, a.company as company, ";
        $q .= "a.branch as branch, b.city as city, b.street as street, ";
        $q .= "b.area as area, b.state as state, right(a.id, 4) as year ";
        $q .= "from xmec_user a left join xmec_address b on a.id = b.user_id ";
        $q .= "where (b.type = 'COMPANY' or b.type is NULL) ";

        if (isset($fil['work_type'])) { 
            $q .= " and a.work_type = '". $fil['work_type'] ."' ";
        }

        if (isset($fil['company'])) {
            $q .= " and UPPER(a.company) like UPPER('%". $fil['company'] ."%')";
        }

        if (isset($fil['branch'])) {
            $q .= " and a.branch = '". $fil['branch'] ."' ";
        }

        if (isset($fil['rollno'])) {
            $q .= " and UPPER(a.id) like UPPER('%". $fil['rollno'] ."%')";
        }

        $r = $dbh->query($q);
        if (DB::isError($r)) {
            $dbh->query("drop table search_tmp");
            return $res;
        }

        $q1 = "select id, name, company, city from search_tmp where 1=1";
		$query = "";

        if (isset($fil['name'])) {
            $query .= " and UPPER(name) like UPPER('%". $fil['name'] . "%') ";
        }

        if (isset($fil['year'])) {
            $query .= " and year = '". $fil['year'] . "' ";
        }

        if (isset($fil['location'])) {
            $query .= " and (UPPER(city) like UPPER('%". $fil['location'];
            $query .= "%') or UPPER(street) like UPPER('%". $fil['location'];
            $query .= "%') or UPPER(area) like UPPER('%". $fil['location'];
            $query .= "%') or UPPER(state) like UPPER('%". $fil['location'];
            $query .= "%') ) ";
        }

        $q3 = " order by name limit $start, $count";
	$q2 = "select count(*) from search_tmp where 1=1";

        $r = $dbh->query($q1 . $query. $q3);
        if (DB::isError($r)) {
            $dbh->query("drop table search_tmp");
            return $res;
        }

        $i = 0;
        while (is_array($x = $r->fetchRow()))
            $res[$i++] = new XMEC_search_result($x);

	$total = $dbh->getOne($q2 . $query);
        $dbh->query("drop table search_tmp");

	$res['count'] = $i;
	$res['total'] = $total;
        return ($res);
    }

    function pref_print($str, $p, $auth, $msg = "Restricted")
    {
        if ($p == 'PUBLIC')
            echo $str;
        else if ($p == 'XMEC')
	    if ($auth)
            	echo $str;
	    else
		echo $msg . " to XMECians";
        else echo $msg;
    }

    function dbg_print($str = "")
    {
        global $__xmec_debug;

        if ($__xmec_debug) echo $str . "<br>";
    }

    function log($type, $user = 'UNKNOWN', $desc = "")
    {
        $dbh =& XMEC::getDB();

	$q = "insert into xmec_logs (type, date, user_id, description) ";
	$q .= "values ('$type', NOW(), '$user', '$desc')";

        $dbh->query($q);
    }

    function &get_logs($type, $from = "", $no = 1)
    {
        $dbh =& XMEC::getDB();

        if ($from == "") 
            $from = "NOW()";
        elseif (is_int($from + 0) && $from < 0)
            $from = "NOW() + INTERVAL $from DAY";
        else 
            $from = "'$from'";

        $q = "select user_id, concat_ws(' ',first_name,  ";
	$q .= "middle_name, last_name) as name, date, ";
	$q .= "description from xmec_logs a, xmec_user b where ";
	$q .= "a.user_id = b.id and a.type = '$type' and ";
        $q .= "TO_DAYS(a.date) >= TO_DAYS($from) and TO_DAYS(a.date) ";
        $q .= "< TO_DAYS($from) +1";

        $res = array();
        $r = $dbh->query($q);
        if (DB::isError($r)) {
            // return null array
            return $res;
        }

        $i = 0;
        while (is_array($x = $r->fetchRow()))
            $res[$i++] = $x;

        return ($res);
    }

    function error_exit($str = "")
    {
        // for the time being..
        echo $str . "\n";
        exit ;
    }
}


/////////////////////////////////////////////////////////////
//
// class XMEC_user
//
/////////////////////////////////////////////////////////////

class XMEC_user
{

    // Personal info

    var $id = NULL;
    var $alias = NULL;
    var $first_name = NULL;
    var $middle_name = NULL;
    var $last_name = NULL;
    var $nick_name = NULL;
    var $full_name = NULL;
    var $sex = NULL;
    var $marital_status = NULL;
    var $date_of_birth = NULL;
    var $branch = NULL;
    var $company = NULL;
    var $official_email = NULL;
    var $personal_email = NULL;
    var $forwarding_email = NULL;
    var $chapter_id = NULL;
    var $mobile_no = NULL;
    var $work_type = NULL;
    var $webpage = NULL;
    var $icq = NULL;
    var $aol = NULL;
    var $yahoo = NULL;
    var $msn = NULL;
    var $jabber = NULL;
    var $preferences = 0; 
    var $year = NULL;
    var $last_update = NULL;

    var $user_type = NULL;
    var $logged_in = FALSE;

    var $error = "";

    function XMEC_user($id = NULL)
    {
        if (isset($id))
            $this->setID($id);
    }

    function setID($id)
    {
        if (preg_match("/^([0-9]+)\/([0-9]+)$/", $id, $matches)) {

            // id is roll number
            $reg_no = $matches[1] . "/"; 

            // convert it into NN/YYYY form. BUG: after 2080 ??
            if ($matches[2] < 100) 
                $reg_no .= ($matches[2] > 80) ? "19" : "20";

            $reg_no .= $matches[2];

            // set id
            $this->id = $reg_no;
        } else {
            // id is alias..
            $this->alias = $id;
        }
    }
            
    function fetchInfo()
    {
        $dbh =& XMEC::getDB();

        if (!(is_object($dbh) && 
              is_subclass_of($dbh, "db_common"))) {
            $this->error = "Invalid database object";
            return FALSE;
        }

        if (isset($this->id)) {
            $field = "id";
            $id = $this->id;
        } else if (isset($this->alias)) {
            $field = "alias";
            $id = $this->alias;
        } else {
            $this->error = "ID/alias not set.";
            return FALSE;
        }

        $query = "select * from xmec_user where " . $field . " = " ;
        $query .= "'$id'";
        $res = $dbh->getRow($query, DB_FETCHMODE_ASSOC);
        if (DB::isError($res)) {
            $this->error = $res->getMessage();
            return FALSE;
        }

        if (count($res) <= 1) {
                $this->error = "No info found";
                return FALSE;
        }

        // fill all the info

        $this->id = $this->unQuote($res["id"]);
        $this->alias = $this->unQuote($res["alias"]);
        $this->first_name = $this->unQuote($res["first_name"]);
        $this->middle_name = $this->unQuote($res["middle_name"]);
        $this->last_name = $this->unQuote($res["last_name"]);
        $this->nick_name = $this->unQuote($res["nick_name"]);
        $this->sex = $this->unQuote($res["sex"]);
        $this->marital_status = $this->unQuote($res["marital_status"]);
        $this->date_of_birth = $this->unQuote($res["date_of_birth"]);
        $this->branch = $this->unQuote($res["branch"]);
        $this->company = $this->unQuote($res["company"]);
        $this->official_email = $this->unQuote($res["official_email"]);
        $this->personal_email = $this->unQuote($res["personal_email"]);
        $this->forwarding_email = $this->unQuote($res["forwarding_email"]);
        $this->chapter_id = $this->unQuote($res["chapter_id"]);
        $this->mobile_no = $this->unQuote($res["mobile_no"]);
        $this->work_type = $this->unQuote($res["work_type"]);
        $this->webpage = $this->unQuote($res["webpage"]);
        $this->icq = $this->unQuote($res["icq"]);
        $this->aol = $this->unQuote($res["aol"]);
        $this->yahoo = $this->unQuote($res["yahoo"]);
        $this->msn = $this->unQuote($res["msn"]);
        $this->jabber = $this->unQuote($res["jabber"]);
        $this->preferences = $this->unQuote($res["preferences"]);
        $this->last_update = $this->unQuote($res["last_update"]);

        // convert date to dd/mm/yyyy format

        list($yy, $mm, $dd) = split('[/-]', $this->date_of_birth);
        $this->date_of_birth = "$dd/$mm/$yy";

        // set full name
        $this->full_name = $this->first_name;
        $this->middle_name != "" && $this->full_name .= " ". $this->middle_name;
        $this->last_name != "" && $this->full_name .= " ". $this->last_name;

        // set joining year
        list($tmp,$this->year) = split('/', $this->id);

        return TRUE;
    }


    function validateUser($pass, $test = false)
    {
        
        if (!$test && $this->isLoggedIn())
            return TRUE;

        $dbh =& XMEC::getDB();

        if (!(is_object($dbh) && 
              is_subclass_of($dbh, "db_common"))) {
            $this->error = "Invalid database object";
            return FALSE;
        }

        $query = "select type from xmec_auth ";

        if (!isset($this->id)) {
            if (!isset($this->alias)) {
                $this->error = "ID/alias not set.";
                return FALSE;
            }
            // id not set, but alias set.
            $query .= "a, xmec_user b where a.user_id = b.id ";
            $query .= " and b.alias = '$this->alias' and ";
            $query .= " a.password = ";
            $q2 = "PASSWORD('$pass')";
        } else {
            $query .= " where user_id = '$this->id' and password = ";
            $q2 = "PASSWORD('$pass') ";
        }

		$qry = $query . $q2;
        $res = $dbh->getOne($qry);
        if (DB::isError($res)) {
            $this->error = $res->getMessage();
            return FALSE;
        }

        if (!isset($res)) {
	    // Try crypt.. to support migrated stuff..
	    $q2 = "ENCRYPT('$pass', 'xm') ";
	    $qry = $query . $q2;
	    $res = $dbh->getOne($qry);
            if (DB::isError($res)) {
                $this->error = $res->getMessage();
                return FALSE;
            }
            if (!isset($res)) {
                //try plain text also..
	        $q2 = "'$pass' ";
	        $qry = $query . $q2;
	        $res = $dbh->getOne($qry);
                if (DB::isError($res)) {
                    $this->error = $res->getMessage();
                    return FALSE;
                }
                if (!isset($res)) {
                    $this->error =  "Invalid credentials/User doesn't exist";
                    return FALSE;
                }
            }

            // change it to PASSWORD..
            $tmp = "update xmec_auth set password = PASSWORD('$pass') ";
            $tmp .= "where user_id = '$this->id' ";
            $dbh->query($tmp);
        }
        if ($test) return TRUE;

        $this->user_type = $res;
        $this->logged_in = TRUE;
        return TRUE;
    }


    function Update()
    {
        $dbh =& XMEC::getDB();

        if (!(is_object($dbh) && 
              is_subclass_of($dbh, "db_common"))) {
            $this->error = "Invalid database object ";
            return FALSE;
        }
        
        if (!isset($this->id)) {
            $this->error = "ID not set";
            return FALSE;
        }

        // convert date to yyyy-mm-dd format
        list($dd, $mm, $yy) = split('[/-]', $this->date_of_birth);

        $q = "update xmec_user set alias = ?, first_name = ?, middle_name = ?,";
        $q .= "last_name = ?, nick_name = ?, sex = ?, marital_status = ?, ";
        $q .= "date_of_birth = ?, branch = ?, company = ?, official_email= ?,";
        $q .= "personal_email = ?, forwarding_email = ?, chapter_id = ?, ";
        $q .= "mobile_no = ?, work_type = ?, webpage = ?, icq = ?, aol = ?,";
        $q .= "yahoo = ?, msn = ?, jabber = ?, preferences = ?, last_update =";
	$q .= "NOW() where id = ?";

        $key = $dbh->prepare($q);
        $data = array ( $this->unQuote($this->alias),
                         $this->unQuote($this->first_name),
                         $this->unQuote($this->middle_name),
                         $this->unQuote($this->last_name),
                         $this->unQuote($this->nick_name),
                         $this->unQuote($this->sex),
                         $this->unQuote($this->marital_status),
                         "$yy-$mm-$dd",
                         $this->unQuote($this->branch),
                         $this->unQuote($this->company),
                         $this->unQuote($this->official_email),
                         $this->unQuote($this->personal_email),
                         $this->unQuote($this->forwarding_email),
                         $this->unQuote($this->chapter_id),
                         $this->unQuote($this->mobile_no),
                         $this->unQuote($this->work_type),
                         $this->unQuote($this->webpage),
                         $this->unQuote($this->icq),
                         $this->unQuote($this->aol),
                         $this->unQuote($this->yahoo),
                         $this->unQuote($this->msn),
                         $this->unQuote($this->jabber),
                         $this->preferences,
                         $this->unQuote($this->id) );

        $res = $dbh->execute($key, $data);
        if ($res !== DB_OK) {
            if (DB::isError($res))
                $this->error = $res->getMessage();
            else
                $this->error = "Unknown error";

            return FALSE;
        }

        return TRUE;
    }

    function setAddress($addr, $type = 'PRESENT')
    {
        $dbh =& XMEC::getDB();

        if (!is_object($addr) ||
              !is_subclass_of($dbh, "db_common")) {
            $this->error = "Invalid address object";
            return FALSE;
        }

        if (!isset($this->id)) {
            $this->error = "ID not set";
            return FALSE;
        }

        if(!$addr->Update($this->id, $dbh, $type)) {
            $this->error = $addr->getError();
            return FALSE;
        }

        $q = 'update xmec_user set last_update = NOW() where id ';
	$q .= "'". $this->id . "'";

        $dbh->query($q);

        return TRUE;
    }

    function getAddress($type = 'PRESENT')
    {
        $dbh =& XMEC::getDB();

        if (!is_subclass_of($dbh, "db_common")) {
            $this->error = "Invalid address object";
            return FALSE;
        }

        $addr = new XMEC_address();
        if (!$addr->fetch($this->id, $dbh, $type)) {
            $this->error = $addr->getError();
        }
        
        return $addr;
    }

    function getPref($str)
    {
        $p = $this->preferences;
        switch ($str) {
            case 'official_email':
                $p &= OFFICIAL_EMAIL_MASK;
                $p >>= 4;

            case 'personal_email':
                $p &= PERSONAL_EMAIL_MASK;
                switch($p) {
                    case VISIBLE_PUBLIC: return 'PUBLIC';
                    case VISIBLE_XMEC: return 'XMEC';
                    default: return 'PRIVATE';
                }
                break;

            default:
                return FALSE;
        }
    }

    function setPref($str, $pref)
    {   
        $dbh =& XMEC::getDB();
        $p =& $this->preferences;
        $val = 0;
        $count = 0;
        switch ($str) {
            case 'official_email':
                $count = 4;
                $p &= ~OFFICIAL_EMAIL_MASK;
            case 'personal_email':
                if (!$count) $p &= ~PERSONAL_EMAIL_MASK;
                switch($pref) {
                    case 'PUBLIC': 
                        $val |= VISIBLE_PUBLIC;
                        break;
                    case 'XMEC': 
                        $val |= VISIBLE_XMEC;
                        break;
                    case 'PRIVATE': 
                    case 'NONE': 
                        $val |= VISIBLE_NONE;
                }
                $val <<= $count;
                $p |= $val;
                break;
            
            default:
                return FALSE;
        }

        $q = "update xmec_user set preferences = '$p' where id = '$this->id'";
        if (isset($this->id))
            return ($dbh->query($q) == DB_OK);
        
        return TRUE;
    }

    function setAddressVisibility($type, $v)
    {
        $dbh =& XMEC::getDB();

        if ($type != 'PERMANENT' && $type != 'PRESENT' && $type != 'COMPANY') {
            $this->error = "Invalid type of address: $type";
            return FALSE;
        }

        if ($v != 'PUBLIC' && $v != 'XMEC' && $v != 'PRIVATE') {
            $this->error = "Invalid type, $v for visibility";
            return FALSE;
        }

        $q = "update xmec_address set visibility = '$v' where ";
        $q .= "user_id = '$this->id' and type = '$type' ";

        if (isset($this->id))
            return ($dbh->query($q) == DB_OK);
        
        $this->error = "ID not set";
        return FALSE;
    }

    function getAddressVisibility($type)
    {
        $dbh =& XMEC::getDB();
        
        $q = "select visibility from xmec_address where user_id = '$this->id' ";
        $q .= "and type = '$type' ";

        $res = $dbh->getOne($q);
        if (DB::isError($res)) {
            $this->error = $res->getMessage();
            return 'PUBLIC';
        }

        if ($res == "") return 'PUBLIC';

        return ($res);
    }


    function setPassword($old, $n, $admin = FALSE)
    {
        $dbh =& XMEC::getDB();

        $q = "update xmec_auth set password = PASSWORD('$n') where user_id = ";
        $q .= "'$this->id'";

		if (!$admin) 
			$q .= " and password = PASSWORD('$old')";

        if ($admin || $this->validateUser($old, true)) {
            $res = $dbh->query($q);
            if (DB::isError($res)) {
                $this->error = $res->getMessage();
                return FALSE;
            }
            if ($res === DB_OK) return TRUE;
        }
        

        return FALSE;
    }

    function isLoggedIn()
    {
        return $this->logged_in;
    }

    function isAdmin()
    {
        return ($this->user_type == 'ADMIN');
    }

    function getError()
    {
        return $this->error;
    }

    function get($what)
    {
        if (isset($this->$what))
            return ($this->$what);
        return NULL;
    }

    function set($what, $value)
    {
        $this->$what = $value;
    }

    function unQuote($str)
    {
        return str_replace("\'", "'", $str);
    }

    function addrBackup($type)
    {
        $addr = $this->getAddress($type);

        if (! DB::isError($res)) {
	    $addr->backup($this->id, $type);
	}
    }

    function userBackup()
    {
        $m = "$this->alias|$this->first_name|$this->middle_name|";
        $m .= "$this->last_name|$this->nick_name|$this->date_of_birth|";
	$m .= "$this->company|$this->official_email|$this->personal_email|";
	$m .= "$this->forwarding_email|$this->chapter_id|$this->mobile_no|";
        $m .= "$this->work_type|$this->webpage|$this->icq|$this->aol|";
	$m .= "$this->yahoo|$this->msn|$this->jabber|$this->preferences|";
	$m .= "$this->last_update";

	XMEC::log('USER_BACKUP', $this->id, $m);
    }
} // class XMEC_user

/////////////////////////////////////////////////////////////
//
// class XMEC_address
//
/////////////////////////////////////////////////////////////

class XMEC_address 
{
    var $house_name = "";
    var $street = "";
    var $area = "";
    var $city = "";
    var $state = "";
    var $country = "";
    var $postal_code = "";
    var $telephone_no = "";
    var $visibility = "PUBLIC";
    var $error = "";

    function get($what)
    {
        if (isset($this->$what))
            return ($this->$what);
        return "";
    }

    function set($what, $v)
    {
	if ($what == 'visibility') {
            if ($v != 'PUBLIC' && $v != 'XMEC' && $v != 'PRIVATE') {
                $v = 'PUBLIC';
            }
        }
        $this->$what = $v;
    }

    function unQuote($str)
    {
        return str_replace("\'", "'", $str);
    }

    function fetch($user_id, &$dbh, $type = 'PRESENT')
    {
        if (!(is_object($dbh) && is_subclass_of($dbh, "db_common"))) {
            $this->error = "Invalid database object";
            return FALSE;
        }

        $query = "select * from xmec_address where user_id = '$user_id' ";
        $query .= " and type = '$type'";

        $res = $dbh->getRow($query, DB_FETCHMODE_ASSOC);
        if (DB::isError($res)) {
            $this->error = $res->getMessage();
            return FALSE;
        }

        if (count($res) <= 1) {
                $this->error = "No data found";
                return FALSE;
        }

        $this->house_name = $this->unQuote($res['house_name']);
        $this->street = $this->unQuote($res['street']);
        $this->area = $this->unQuote($res['area']);
        $this->city = $this->unQuote($res['city']);
        $this->state = $this->unQuote($res['state']);
        $this->country = $this->unQuote($res['country']);
        $this->postal_code = $this->unQuote($res['postal_code']);
        $this->telephone_no = $this->unQuote($res['telephone_no']);
        $this->visibility = $this->unQuote($res['visibility']);
        
        return TRUE;
    }

    function Update($user_id, &$dbh, $type = 'PRESENT')
    {
        if (!(is_object($dbh) && is_subclass_of($dbh, "db_common"))) {
            $this->error = "Invalid database object";
            return FALSE;
        }

        if ($type != 'PERMANENT' && $type != 'PRESENT' && $type != 'COMPANY') {
            $this->error = "Invalid type of address: $type";
            return FALSE;
        }

        $query = "replace xmec_address (user_id, type, house_name, street, ";
        $query .= "area, city, state, country, postal_code, telephone_no, ";
        $query .= "visibility) values (?,?,?,?,?,?,?,?,?,?,?)";

        $key = $dbh->prepare($query);
        $data = array( $this->unQuote($user_id),
                       $this->unQuote($type),
                       $this->unQuote($this->house_name),
                       $this->unQuote($this->street),
                       $this->unQuote($this->area),
                       $this->unQuote($this->city),
                       $this->unQuote($this->state),
                       $this->unQuote($this->country),
                       $this->unQuote($this->postal_code),
                       $this->unQuote($this->telephone_no),
                       $this->visibility );

        $res = $dbh->execute($key, $data);
        if ($res !== DB_OK) {
            if (DB::isError($res)) 
                $this->error = $res->getMessage();
            else
                $this->error = "Unknown error";
        
            return FALSE;
        }

        return TRUE;

    }

    function getError()
    {
        return $this->error;
    }

    function backup($user = 'UNKNOWN', $type = 'PRESENT')
    {
        $m = "$type|$this->house_name|$this->street|$this->area|";
	$m .= "$this->city|$this->state|$this->country|";
	$m .= "$this->postal_code|$this->telephone_no|";
        $m .= "$this->visibility";

	XMEC::log('ADDRESS_BACKUP', $user, $m);
    }
}

/////////////////////////////////////////////////////////////
//
// class XMEC_search_result
//
/////////////////////////////////////////////////////////////

class XMEC_search_result
{
    var $id = "";
    var $name = "";
    var $company = "";
    var $location = "";
    var $year = "";
    
    function XMEC_search_result($d = NULL)
    {
        if (!isset($d) || !is_array($d))
            return ;
        $this->id = $d[0];
        $this->name = $d[1];
        $this->company = $d[2];
        $this->location = $d[3];
        list($tmp,$this->year) = split('/', $d[0]);
    }
}

?>
