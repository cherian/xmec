<?php
include_once 'xmec.inc';
if (preg_match("/^\/([^\/]+).*/", $REDIRECT_URL, $matches)) {
  $alias = $matches[1];
  $alias = substr($alias, 0, 25);
  $tmpuser = new XMEC_User();
  $tmpuser->setID($alias);
  if ($tmpuser->fetchInfo()) {
    $redir = trim($tmpuser->webpage);
  }
  if (isset($redir)) {
    header("Location: $redir");
    exit ;
  }
}

$secure_page=0;
include 'header.php';
$user = XMEC::getUser();
 
?>
<TABLE BGCOLOR="white" align=left border=0 cellPadding=0 cellSpacing=0 width="615" height="100%">
<TR>
<TD width=615 class=head><B>File Not Found !!</B><P class=body><BR><BR>Hi <B><?php echo $user->first_name ?> <?php echo $user->last_name ?></B><BR>
You have requested a page that does not exist. If you've reached this page by selecting a bookmark that worked previously, it's likely the file moved to a new location. Some links may have been renamed in the later version ofthe site. Please contact the <a href="comments.php" class=flink>Webmasters XMEC</A> if you have any specific queries in this regard.<BR><BR><BR></P>

</TD>
<TR>
<TD align=center><P><a href="index.php" class=flink>XMEC - Alumni of Model Engineering College</A></P>
</TD></TR>
</TR></TABLE>

<?php
include 'footer.php';
?>
