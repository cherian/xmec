<?php
	include_once 'xmec.inc';
require 'facebook/facebook.php';
$fb= new Facebook(array(
  'appId'  => '101039650020031',
  'secret' => '4cd18604efbe1d7691981b26532c7c0b',
  'cookie' => true,
));
$uid=$fb->getUser();
if($uid!=0)
{
echo $uid;
    $user_profile = $fb->api('/me');
echo $user_profile["name"];
if(XMEC::fb_login($uid,$user_profile))
{
		
$user =& XMEC::getUser();
$target = "index.php";
                header("Location: $target");
}
else
{
$target = "login.php";
//                header("Location: $target");

require 'header.php';
echo "Your fbid is not in our systems please send a mail to our admin (vyas.thottathil@gmail.com) with your details so he can add you to our system";
}

}
else
{
require 'header.php';

?>

<div id="fb-root"></div>
 <div class="fb-login-button" data-scope="email,user_checkins">
        Login with Facebook
      </div>
<?
}
?>
<script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '101039650020031',
          status     : true, 
          cookie     : true,
          xfbml      : true,
          oauth      : true,
        });

        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
      };

      (function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
       }(document));
    </script>
  </body>
</html>
