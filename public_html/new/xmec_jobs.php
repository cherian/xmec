<?php
require_once 'xmec.inc';

global $jobPostError;
$category = array(
"0" => "Software",
"1" => "Hardware",
"2" => "Biomedical",
"3" => "Marketing",
"4" => "Management"
);

# Warning Novice, Forgotten language mode code.
# The whole idea is to get something working
# do not intend to write it for usability.

# Huh I dont like this class idea in scripts much
# but since I dont know if stuct are there in php
# and can only find some examples which talk 
# about class I will use class instead of struct ;)

function doJobPost($tmp_comp, $tmp_lyof, $tmp_uyof, $tmp_ref,
							$tmp_email, $tmp_fow, $tmp_keyw, $tmp_det) {

  $result = NULL;
  $count = 0;

	$user = XMEC::getUser();
  $dbh =& XMEC::getDB();
  $query = "INSERT INTO job_posts VALUES (0,".
		"'".$tmp_comp . "'," .
		$tmp_lyof . "," .
		$tmp_uyof . "," .
		"'".$tmp_ref  . "'," .
		"'".$tmp_email. "'," .
		$tmp_fow  . "," .
		"'".$tmp_keyw . "'," .
		"'".$tmp_det  . "'," .
		"NOW() )";
  $queryHandle = $dbh->query($query);
  if (DB::isError($queryHandle)) {
  	return $result;
  }

	return $job;

}

function getJobPostDetails($post_id) {
  $result = NULL;
  $count = 0;

	$user = XMEC::getUser();
  $dbh =& XMEC::getDB();
  $query = "SELECT * from job_posts where post_id=".$post_id." order by post_date";
  $queryHandle = $dbh->query($query);
  if (DB::isError($queryHandle)) {
  	return $result;
  }
	$job = $queryHandle->fetchRow();

	return $job;
}

function getJobPosts() {
  $result = NULL;
  $count = 0;

	$user = XMEC::getUser();
  $dbh =& XMEC::getDB();
  $query = "SELECT *, DATE_FORMAT(post_date, '%D %b,%Y') from job_posts order by post_date";
  $queryHandle = $dbh->query($query);
  if (DB::isError($queryHandle)) {
  	return $result;
  }

  while (is_array($title = $queryHandle->fetchRow())) {
  	$result[$count++] = $title;
  }

  return $result;
}

