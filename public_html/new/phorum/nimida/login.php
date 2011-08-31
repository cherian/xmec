<?php
  // login.php

    function check_login(){
        global $admindir, $PHORUM, $q, $DB;

        $success=false;

	$user =& XMEC::getUser();
	if ($user->isLoggedIn()) {
            $PHORUM["admin_user"] = xmec_user_to_phorum_user($user);

             if(is_array($PHORUM["admin_user"]["forums"])){
                    $success=true;
              }
        }

        if(!$success && $user->isAdmin())
		$success = true;

	if (!$success && $user->isLoggedIn()) {
		echo '<br><br>You need admin previliges..<br>';
	} else if (!$success) {
		echo '<br><br>You need to login first.<br>';
	}
        	
	if (!$success) {
		include "$admindir/footer.php";
		exit();
	}
    }

?>
