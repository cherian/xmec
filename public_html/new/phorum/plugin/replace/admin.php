<?php

if($do!="props") return;

if(isset($update)) {
  $data="";
  if(isset($HTTP_POST_VARS["key1"])) {
    $num=1;
    $data="<?php\n\$pluginreplace = array();\n";
    while(isset(${"key".$num})) {
      if(!empty(${"key".$num}) && !empty(${"val".$num})) {
        $key=${"key".$num};
        $val=${"val".$num};

        if(get_magic_quotes_gpc()){
            $key=stripslashes($key);
            $val=stripslashes($val);
        }
        $key=str_replace("'", "\\'", $key);
        $val=str_replace("'", "\\'", $val);
        $data .= "\$pluginreplace['$key']='$val';\n";
        $pluginreplace[$key]=$val;
      }
      $num++;
    }
    $data .= "?>\n";
  }
  if($fp = @fopen("$PHORUM[settings_dir]/replace.php","w")) {
    fputs($fp,$data);
    fclose($fp);
  } else {
    echo("Permission denied for writing \"plugin/$plugindirname/settings.php\", please check file permissions.\n<br>");
    echo("Optionally, you may issue the following command from the phorum directory:<br>\n");
    echo("<p><div align=\"left\">cat &lt;&lt;EOF &gt; plugin/$plugindirname/settings.php<br>\n".nl2br(htmlspecialchars(str_replace("\$","\\$",$data)))."EOF</div></p>\n");
  }
}

if(file_exists("$PHORUM[settings_dir]/replace.php")) {
    include("$PHORUM[settings_dir]/replace.php");
}

?>

<form action="<?php $PHP_SELF; ?>" method="POST">
<input type="hidden" name="page" value="<?php echo $page; ?>" />
<input type="hidden" name="plugin" value="<?php echo $plugin; ?>" />
<input type="hidden" name="do" value="<?php echo $do; ?>" />
<input type="hidden" name="update" value="1" />

<table border="1" cellspacing="0" cellpadding="3">
<tr>
    <td align="center" valign="middle" bgcolor="#000080" colspan="2">
        <font face="Arial,Helvetica" color="#FFFFFF"><b>Replace Plugin Admin</b>
    </td>
</tr>

<?php

$num=1;
while(list($key,$val) = @each($pluginreplace)) {
  echo("<tr>\n<td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\">\n<font face=\"Arial,Helvetica\">");

  echo("<b>$num</b>. Replace <INPUT TYPE=\"text\" NAME=\"key$num\" VALUE=\"".htmlspecialchars($key)."\">");
  echo("</font>\n</td>\n<td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\">\n<font face=\"Arial,Helvetica\">");
  echo(" with <INPUT TYPE=\"text\" NAME=\"val$num\" VALUE=\"".htmlspecialchars($val)."\"><br>\n");
  echo("</font>\n</td>\n</tr>\n\n");
  $num++;
}

$i=$num+5;
while($i>$num) {
  echo("<tr><td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\"><font face=\"Arial,Helvetica\">");
  echo("<b>New</b>. Replace <INPUT TYPE=\"text\" NAME=\"key$num\">");
  echo("</font></td><td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\"><font face=\"Arial,Helvetica\">");
  echo("with <INPUT TYPE=\"text\" NAME=\"val$num\"><br>\n");
  echo("</font></td></tr>");
  $num++;
}

  echo("<tr><td align=\"center\" bgcolor=\"#FFFFFF\" colspan=\"2\"><font face=\"Arial,Helvetica\">");

echo("<input type=\"submit\" value=\" Apply \">\n");
echo("</form>\n</td></tr>");
echo("</tr>\n</table>");

?>