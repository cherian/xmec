<?php
	$secure_page=1;
	include 'header.php';
	$auth = XMEC::authenticate_user();
	$user =& XMEC::getUser();
	if(!$user->isAdmin()) {
	  echo '<BR><BR><H2><CENTER>You Are Not Authorized !</CENTER></H2>';
      include 'footer.php';
	  exit ;
	}
    
    $import_script = $__xmec_import_script;
?>	
<BR>
<BR>
<CENTER>
<TABLE cellSpacing=0 cellPadding=0 border=1 width="90%">
<tr><td align=middle><br>
<TABLE cellSpacing=0 cellPadding=0 border=0 width="80%">
<TBODY>
<?php
  $show_form = true;
  $fname = "file1";

  if ($upl == "true") {
    if ($sm != "on") {
      $import_script = $import_script . " -n"; # no emails
    }
    if ($dr == "on") {
      $import_script = $import_script . " -d"; # dry run
    }
    if ($db == "on") {
      $import_script = $import_script . " -v"; # debug
    }
  } else if ($del == "true") {
    $fname = "file2";
    $import_script = $import_script . " -e"; # delete
    if ($dr1 == "on") {
      $import_script = $import_script . " -d"; # dry run
    }
    if ($db1 == "on") {
      $import_script = $import_script . " -v"; # debug
    }
  }

  if ($del == "true" || $upl == "true") {
    if ($_FILES[$fname]['error'] == 0) {
      $filename = $_FILES[$fname]['name'];
      $ext = substr($filename, strrpos($filename, '.'));
      if ($ext != '.xls' && $ext != '.XLS') {
        print "<tr><td>Please upload a .xls file.</td></tr>";
      } else {
        # process the file
        $fd = popen ("$import_script -f ". $_FILES[$fname]['tmp_name'] . " 2>&1 ","r");
        print "<tr><td align=left>Processing... </td></tr>";
        flush();
        if ($dr == "on") {
          print "<tr><td align=left>*** Dry run ***</td></tr>";
        }
        while (!feof ($fd)) {
          $buffer = fgets($fd, 4096);
          print "<tr><td align=left>";
          print $buffer;
          print "</td></tr>";
          flush();
        }
        if ($dr == "on") {
          print "<tr><td align=left>*** Dry run ***</td></tr>";
        }
        pclose ($fd);
        $show_form = false;
      } 
      unlink($_FILES[$fname]['tmp_name']);
    } else {
      print "<tr><td>Upload error.<br>&nbsp;</td></tr>";
    }
  } 
  if ($show_form) {
?>
<form name=f1 method=POST action="<?=$PHP_SELF?>?upl=true" enctype="multipart/form-data">
<tr>
  <td><b>Insert student data into DB</b></td>
</tr>
<tr>
  <td>Please use <a href=downloads/templ.xls>this template</a> for uploads</td>
</tr>
<tr>
  <td><br><input type=checkbox name=sm checked>Send Email <input type=checkbox name=dr checked>Dry run <input type=checkbox name=db>Verbose output
  </td>
<tr>
  <td><br>Upload file: <input type=file name=file1> <input type=submit value=Upload>
  </td>
</tr>
</form>
</TBODY>
</TABLE>
<br>
</td></tr>
</table>
<br>
<TABLE cellSpacing=0 cellPadding=0 border=1 width="90%">
<tr><td align=middle><br>
<TABLE cellSpacing=0 cellPadding=0 border=0 width="80%">
<TBODY>
<form name=f1 method=POST action="<?=$PHP_SELF?>?del=true" enctype="multipart/form-data">
<tr>
  <td><b>Delete student data from DB</b></td>
</tr>
<tr>
  <td>Please use <a href=downloads/templ.xls>this template</a> for uploads (only ROLL_NO is mandatory)</td>
</tr>
<tr>
  <td><br><input type=checkbox name=dr1 checked>Dry run <input type=checkbox name=db1>Verbose output
  </td>
<tr>
  <td><br>Upload file: <input type=file name=file2> <input type=submit value=Upload>
  </td>
</tr>
</form>
<?php } ?>
</TBODY>
</TABLE>
<br>
</td></tr>
</table>

</CENTER>
<BR><BR>
<?php
include 'footer.php';
?>
