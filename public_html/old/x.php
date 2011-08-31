<?php   
foreach ($GLOBALS as $k => $v)
	echo "$k => $v <br>\n";

echo "HTTP_ENV_VARS <br>\n";
foreach ($GLOBALS['HTTP_ENV_VARS'] as $k => $v)
	echo "$k => $v <br>\n";

echo "HTTP_SERVER_VARS <br>\n";
foreach ($GLOBALS['HTTP_SERVER_VARS'] as $k => $v)
	echo "$k => $v <br>\n";

?>	
