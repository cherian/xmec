<?php
include("$PHORUM[settings_dir]/replace.php");

function mod_replace_read_body ($body) {
  global $pluginreplace;
  reset($pluginreplace);
  while(list($key,$val) = each($pluginreplace)) {
    $body = str_replace($key,$val,$body);
  }
  return $body;
}

$plugins["read_body"]["mod_replace"]="mod_replace_read_body";

?>