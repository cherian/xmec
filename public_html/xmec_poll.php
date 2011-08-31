<?php
require_once 'xmec.inc';

global $pollError;

# Warning Novice, Forgotten language mode code.
# The whole idea is to get something working
# do not intend to write it for usability.

# Huh I dont like this class idea in scripts much
# but since I dont know if stuct are there in php
# and can only find some examples which talk 
# about class I will use class instead of struct ;)

class XMEC_pollAnswers {
  var $ansSeq = 0;
  var $ansDesc = "";
  var $votes = 0;

  function XMEC_pollAnswers($ans = null) {

    if (!isset($ans) || !is_array($ans)) {
      return ;
    }

    $this->ansSeq = $ans[1];
    $this->ansDesc= $ans[2];
    $this->votes  = $ans[3];
  }

}

class XMEC_poll {

  var $pollID       = 0;
  var $title        = "";
  var $pollQuestion = "";
  var $startDate    = "";
  var $endDate      = "";
  var $isAnonymous  = "";
  var $numAnswers   = 0;
  var $answers      = "";
  var $startDatefmt = "";
  var $endDatefmt   = "";

  function XMEC_poll($question = null) {

    if (!isset($question) || !is_array($question)) {
      return ;
    }

    $this->pollID       = $question[0];
    $this->title        = $question[1];
    $this->pollQuestion = $question[2];
    $this->startDate    = $question[3];
    $this->endDate      = $question[4];
    $this->isAnonymous  = $question[5];
  
    $dbh =& XMEC::getDB();
    $query = "SELECT * FROM poll_answers WHERE".
              "( poll_id = '" . $this->pollID . "')";
    $queryHandle = $dbh->query($query);
    if (DB::isError($queryHandle)) {
      $pollError = "Database Query Failed.<BR>";
      return;
    }
  
    while(is_array($answer = $queryHandle->fetchRow())) {
      $this->answers[$this->numAnswers++] = new XMEC_pollAnswers($answer);
    }
  }

	function hasUserVoted($user = null) {
		$query = "SELECT vote_ans from poll_responses where (".
							"(poll_id = ".$this->pollID.") and".
							"(user_id = '".$user->id."'))";
		$dbh =& XMEC::getDB();
		$queryHndl = $dbh->query($query);
		if (DB::isError($queryHndl)) {
			$pollError = "Database Query failed.<BR>";
			return (-1);
		}
		$res = $queryHndl->fetchRow();
		return $res[0];
	}

}

#----------------------------------------------------------
# returns an array of XMEC_poll object.
# INPUTS:
#   None
# OUTPUTS
#		array of XMEC_poll object on Sucess	
#   null array on failure 
#----------------------------------------------------------

function getOpenPolls() {
  $polls = array();
  $count = 0;

  $dbh =& XMEC::getDB();
  $query = 
    "SELECT * , DATE_FORMAT(start_date,'%b %D,%Y'), DATE_FORMAT(end_date, '%b %D,%Y') FROM poll_questions WHERE (".
    "(start_date <= NOW()) AND ".
    "(end_date >= NOW()) )";

  $queryHandle = $dbh->query($query);
  if (DB::isError($queryHandle)) {
    $pollError = "Database Query Failed.<BR>";
		echo 'DB error<br>';
    return $result;
  }

  while (is_array($question = $queryHandle->fetchRow())) {
    $polls[$count++] = new XMEC_poll($question);
    $polls[$count-1]->startDatefmt = $question[6];
    $polls[$count-1]->endDatefmt = $question[7];
  }

  return ($polls);

}

#----------------------------------------------------------
# INPUTS:
#		pollID and Object of the type XMEC_user
# OUTPUTS
#		XMEC_poll object on Sucess
#		null on failure 
#----------------------------------------------------------

function getPoll($pollID) {

  $poll = NULL;

  $dbh =& XMEC::getDB();
  $query =  "SELECT * , DATE_FORMAT(start_date,'%b %D,%Y'), DATE_FORMAT(end_date, '%b %D,%Y') FROM poll_questions WHERE " . 
            "( poll_id = " . $pollID . ")";

  $queryHandle = $dbh->query($query);
  if (DB::isError($queryHandle)) {
    $pollError = "Database Query Failed.<BR>";
    return $poll;
  }

  $question = $queryHandle->fetchRow();
  if (!is_array($question)) {
   $pollError = "Database Query Failed.<BR>";
   return $poll;
  }

  $poll = new XMEC_poll($question);
  $poll->startDatefmt = $question[6];
  $poll->endDatefmt = $question[7];

  return ($poll);

}

#----------------------------------------------------------
#----------------------------------------------------------
function createPoll($pollTitle,$pollQuestion,
                    $pollAns,$pollStart,
                    $pollEnd,$pollAnon) {

  # Revisit Validation required for dates.

  $dbh =& XMEC::getDB();
  $query = "INSERT INTO poll_questions VALUES ('" . 
            $tmp          . "','" . 
            $pollTitle    . "','" . 
            $pollQuestion . "'," . 
            "DATE_FORMAT('" . $pollStart . "', '%Y-%m-%d %T')," . 
            "DATE_FORMAT('" . $pollEnd . "', '%Y-%m-%d %T'),'" . 
            $pollAnon     . "')";

  $queryHandle = $dbh->query($query);
  if (DB::isError($queryHandle)) {
    echo "Database Query Failed.<BR>";
    return 1;
  }

    # LAST_INSERT_ID
    $pollAns = str_replace("\r\n", "\n", $pollAns);
    $pollAns = str_replace("\r", "\n", $pollAns);
    $answers = explode("\n",  $pollAns);
    $ansSeq = 1;
    foreach ($answers as $ans) {
      $query = "INSERT INTO poll_answers VALUES( LAST_INSERT_ID()," . 
                $ansSeq++ . ",'" . $ans . "', 0)";
  		$queryHandle = $dbh->query($query);
  		if (DB::isError($queryHandle)) {
        echo "Database Query Failed.<BR>";
				return 1;
      }
    }
		return 0;
}

function getTitles() {
  $result = NULL;
  $count = 0;

	$user = XMEC::getUser();
  $dbh =& XMEC::getDB();
  #$query = "SELECT pollID,title,endDate FROM poll_questions where (endDate < '".
  #					$currentDate ."') order by endDate desc";
	if ($user->isAdmin()) {
  $query = "SELECT poll_id,title,DATE_FORMAT(end_date,'%b %D,%Y') FROM poll_questions order by end_date desc";
	} else { 
  $query = "SELECT poll_id,title,DATE_FORMAT(end_date,'%b %D,%Y') FROM poll_questions where ".
  				"(end_date < NOW()) order by end_date desc";
	}
  $queryHandle = $dbh->query($query);
  if (DB::isError($queryHandle)) {
  	return $result;
  }

  while (is_array($title = $queryHandle->fetchRow())) {
  	$result[$count++] = $title;
  }

  /* $result['count'] = $count; */

  return $result;
}
function deletePoll($pollID) {
	$dbh =& XMEC::getDB();
	$query = "delete from poll_responses where poll_id =".$pollID;
	$queryHandle = $dbh->query($query); 
	if (DB::isError($result)) return 1;
	$query = "delete from poll_answers where poll_id =".$pollID;
	$queryHandle = $dbh->query($query); 
	if (DB::isError($result)) return 1;
	$query = "delete from poll_questions where poll_id =".$pollID;
	$queryHandle = $dbh->query($query); 
	if (DB::isError($result)) return 1;

	return 0;
	
}

function registerVote($pollID, $user, $ansSeq) {

  $dbh =& XMEC::getDB();
  $query = "UPDATE poll_answers SET votes=votes+1 WHERE (" . 
            "( poll_id = " . $pollID . ") AND" .
  				  "( ans_seq = " . $ansSeq . "))";

  $queryHandle = $dbh->query($query);
  $query = "INSERT INTO poll_responses VALUES (" . 
            $pollID . ",'" . $user->id . "'," . $ansSeq . ",null)";
  $queryHandle = $dbh->query($query);
  if (DB::isError($queryHandle)) {
    $pollError = "Database Query Failed.<BR>";
    return FALSE;
  }
  return TRUE;
}

function registerReVote($pollID, $user, $ansSeq) {

  $dbh =& XMEC::getDB();
  $query = "SELECT vote_ans FROM poll_responses where ( " . 
            "(poll_id='" . $pollID."') and (user_id='".$user->id."'))";
  $earlierAns = $dbh->getOne($query);

  $query = "UPDATE poll_answers SET votes=votes-1 WHERE (" . 
            "(poll_id=" . $pollID . ") and (ans_seq=" . $earlierAns . "))";
  $queryHandle = $dbh->query($query);

  $query = "UPDATE poll_answers SET votes=votes+1 WHERE (" . 
            "(poll_id = " .$pollID . ") and " . 
            "(ans_seq=" . $ansSeq . "))";
  $queryHandle = $dbh->query($query);

  $query = "UPDATE poll_responses SET vote_ans=".$ansSeq." where (" . 
            "(poll_id=".$pollID.") and " . 
            "(user_id='".$user->id."'))"; 
  $queryHandle = $dbh->query($query);
}

?>
