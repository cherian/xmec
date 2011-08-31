<?
function renderLoginBox()
{
	global $PHP_SELF;
	$user = XMEC::getUser();
	if (! $user->isLoggedIn()) {	
?>
<TABLE cellSpacing=2 height=80 cellPadding=0 border=0>
<form name=frmlogin method=POST action=login.php>
<input type=hidden name=xgetpage value=<?=$PHP_SELF?>>
<input type=hidden name=action value=login>
  <TR>
  	<TD colspan=2 align=center><img src="images/loginhead.jpg" ></TD>
  </TR>
  <TR>
  	<TD colspan=2 class=fname>Login</TD>
  </TR>
	<TR>
    <TD colspan=2><INPUT name=rollno type=text class=box size=10></TD>
  </TR>
  <TR>
  	<TD colspan=2 class=fname>Password</TD>
  </TR>
	<TR>
    <TD><INPUT name=passwd type=password class=box  size=10></TD>
		<TD  align=right><INPUT name=bttnlogin type=image src="images/go.gif" border=0 width=15 height=15></TD>

  </TR>


<TR>
<TD colspan=2 height=20 align=center><A class=link HREF="loginerror.php"><B>Forgot Password ?</B></A> </TD>

</TR>
</form> 
</TABLE>
<?
	}
}
?>
