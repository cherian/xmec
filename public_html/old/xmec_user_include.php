<?
require_once 'DB.php';
include_once 'xmec_defines.php';

//
// Globals
//

$__xmec_db = NULL;
$__xmec_user = NULL;

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

        if (!isset($__xmec_db) || 
                !is_subclass_of($__xmec_db, "db_common")) {
            $__xmec_db = DB::connect($__xmec_dsn, true);
            if (DB::isError($__xmec_db)) {
                XMEC::error_exit($db->getMessage());
            }
        }

        return &$__xmec_db;
    }

	function &getUser()
	{
		global $__xmec_user;

		if (!isset($__xmec_user) ||
				get_class($__xmec_user) != "xmec_user") {
			$__xmec_user = new XMEC_user();
		}

		return &$__xmec_user;
	}

	function error_exit($msg = "")
	{
		// die() for the time being..
		die($msg);
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
    var $preferences = NULL;

    var $user_type = NULL;

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

            // convert it into NN/YYYY form BUG: after 2080 ...
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
        $dbh = XMEC::getDB();

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

        return TRUE;
    }


    function validateUser($pass)
    {
        
        if ($this->isValid())
            return TRUE;

        $dbh = XMEC::getDB();

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
            $query .= " a.password = PASSWORD('$pass')";
        } else {
            $query .= " where user_id = '$this->id' and ";
            $query .= " password = PASSWORD('$pass') ";
        }
        
        $res = $dbh->getOne($query);
        if (DB::isError($res)) {
            $this->error = $res->getMessage();
            return FALSE;
        }

        if (!isset($res)) {
            $this->error =  "Invalid credentials/User doesn't exist";
            return FALSE;
        }

        $this->user_type = $res;
        return TRUE;
    }


    function Update()
    {
        $dbh = XMEC::getDB();

        if (!(is_object($dbh) && 
              is_subclass_of($dbh, "db_common"))) {
            $this->error = "Invalid database object ";
            return FALSE;
        }

        $q = "update xmec_user set alias = ?, first_name = ?, middle_name = ?,";
        $q .= "last_name = ?, nick_name = ?, sex = ?, marital_status = ?, ";
        $q .= "date_of_birth = ?, branch = ?, company = ?, official_email= ?,";
        $q .= "personal_email = ?, forwarding_email = ?, chapter_id = ?, ";
        $q .= "mobile_no = ?, work_type = ?, webpage = ?, icq = ?, aol = ?,";
        $q .= "yahoo = ?, msn = ?, jabber = ?, preferences = ?  where id = ?";

        $key = $dbh->prepare($q);
        $data = array ( $this->alias,
                         $this->first_name,
                         $this->middle_name,
                         $this->last_name,
                         $this->nick_name,
                         $this->sex,
                         $this->marital_status,
                         $this->date_of_birth,
                         $this->branch,
                         $this->company,
                         $this->official_email,
                         $this->personal_email,
                         $this->forwarding_email,
                         $this->chapter_id,
                         $this->mobile_no,
                         $this->work_type,
                         $this->webpage,
                         $this->icq,
                         $this->aol,
                         $this->yahoo,
                         $this->msn,
                         $this->jabber,
                         $this->preferences,
                         $this->id );

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
        $dbh = XMEC::getDB();

        if (!is_object($addr) ||
              !is_subclass_of($dbh, "db_common")) {
            $this->error = "Invalid address object";
            return FALSE;
        }

        if(!$addr->Update($this->id, $dbh, $type)) {
            $this->error = $addr->getError();
            return FALSE;
        }

        return TRUE;
    }

    function isValid()
    {
        return ($this->user_type != NULL);
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

} // class XMEC_user

/////////////////////////////////////////////////////////////
//
// class XMEC_address
//
/////////////////////////////////////////////////////////////

class XMEC_address 
{
    var $house_name;
    var $street;
    var $area;
    var $city;
    var $state;
    var $country;
    var $postal_code;
    var $telephone_no;
    var $visibility;
    var $error;

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

    function fetch($user_id, &$dbh, $type = 'PRESENT')
    {
        if (!(is_object($dbh) && is_subclass_of($dbh, "db_common"))) {
            $this->error = "Invalid database object";
            return FALSE;
        }

        $query = "select * from xmec_address where user_id = '$user_id' ";
        $query = " and type = '$type'";

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

        if ($type != 'PERMANENT' || $type != 'PRESENT' || $type != 'COMPANY') {
            $this->error = "Invalid type of address";
            return FALSE;
        }

        $query = "replace xmec_address (user_id, type, house_name, street, ";
        $query .= "area, city, state, country, postal_code, telephone_no, ";
        $query .= "visibility) values (?,?,?,?,?,?,?,?,?,?,?)";

        $key = $dbh->prepare($query);
        $data = array( $user_id,
                       $type,
                       $this->house_name,
                       $this->street,
                       $this->area,
                       $this->city,
                       $this->state,
                       $this->country,
                       $this->postal_code,
                       $this->telephone_no,
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
}

?>
