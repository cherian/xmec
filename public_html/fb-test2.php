<?php            
require 'facebook/facebook.php';
$fb= new Facebook(array(
  'appId'  => '101039650020031',
  'secret' => '4cd18604efbe1d7691981b26532c7c0b',
  'cookie' => true,
));

$fb->destroySession() ;
echo $_COOKIE['fbsr_101039650020031'];
?>

