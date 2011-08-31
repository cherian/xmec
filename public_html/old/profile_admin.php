<?php

	include 'xmec.inc';
	if (! XMEC::authenticate_user()) {
		echo "<html><h1>Please login to access this page<html>";
		exit ;
	}

	$me =& XMEC::getUser();

	if (!$me->isAdmin()) {
		echo "<html><h1>Not authorized !!</html>";
		exit ;
	}

	reset($HTTP_POST_VARS);

	$action = chop($HTTP_POST_VARS["todo"]);
	if ($REQUEST_METHOD == "GET")
		$action = chop($HTTP_GET_VARS["todo"]);

	$id = chop($HTTP_POST_VARS["id"]);
	if ($REQUEST_METHOD == "GET")
		$id = chop($HTTP_GET_VARS["id"]);

	$user = new XMEC_user();	
	if ($id != "") {
		$user->setID($id);
		if ( !$user->fetchInfo()) {
			echo "<html><h1>Error getting user info !!</html>";
			exit ;
		}
	} else {
		echo "<html><h1>No ID selected !!</html>";
		exit ;
	}
	
	if ($action == "Update") {
 		if ($CBWork != "NULL")
			$user->set('work_type',ucwords($CBWork));
		else 
			$user->set('work_type', ucwords(trim($TBWork)));

		$user->set('first_name', $TBFname);
		$user->set('middle_name', $TBMname);
		$user->set('last_name', $TBLname);
		$user->set('company', $TBCname);
		$user->set('sex', $CBSex);
		$user->set('date_of_birth', $TBDob);
		$user->set('marital_status', $CBMstatus);
		$user->set('official_email', $TBEAddrO);
		$user->set('personal_email', $TBEAddrP);

		
		if ( ! $user->Update()) {
			XMEC::error_exit ("Update failed: ". $user->getError());
		} else {
			// re-read everything from DB..
			$user->fetchInfo();
		}

		$addr = new XMEC_address();

		$addr->set('house_name', $TBHname);
		$addr->set('street', $TBPStr);
		$addr->set('area', $TBPArea);
		$addr->set('city', $TBPCity);
		$addr->set('state', $TBPState);
		$addr->set('country', $TBPCountry);
		$addr->set('postal_code', $TBPPin);
		$addr->set('telephone_no', $TBHPhone);

		if (($p = $user->getAddressVisibility('PERMANENT')))
			$addr->set('visibility', $p);

		if (! $user->setAddress($addr, 'PERMANENT')) {
			XMEC::error_exit ("Update failed: ". $user->getError());
		}

		$addr->set('house_name', $TBCname);
		$addr->set('street', $TBCStr);
		$addr->set('area', $TBCArea);
		$addr->set('city', $TBCCity);
		$addr->set('state', $TBCState);
		$addr->set('country', $TBCCountry);
		$addr->set('postal_code', $TBCPin);
		$addr->set('telephone_no', $TBWPhone);

		if (($p = $user->getAddressVisibility('COMPANY')))
			$addr->set('visibility', $p);

		if (! $user->setAddress($addr, 'COMPANY')) {
			XMEC::error_exit ("Update failed: ". $user->getError());
		}
		
		$addr->set('house_name', $TBTHname);
		$addr->set('street', $TBTStr);
		$addr->set('area', $TBTArea);
		$addr->set('city', $TBTCity);
		$addr->set('state', $TBTState);
		$addr->set('country', $TBTCountry);
		$addr->set('postal_code', $TBTPin);
		$addr->set('telephone_no', $TBTPhone);

		if (($p = $user->getAddressVisibility('PRESENT'))) 
			$addr->set('visibility', $p);

		if (! $user->setAddress($addr, 'PRESENT')) {
			XMEC::error_exit ("Update failed: ". $user->getError());
		}

		if (empty($target)) {
			$target="members.php";
		}
		echo "<html><head><h2>Your profile has been updated successfully</h2></head></html>"; 

		exit;
	} else {
		$paddr = $user->getAddress('PERMANENT');
		$caddr = $user->getAddress('PRESENT');
		$oaddr = $user->getAddress('COMPANY');
		$work_types = XMEC::get_work_types(); 
	}

?>


<HTML>
<HEAD>
<LINK rel=stylesheet href="style.css" type="text/css">
</HEAD>
<BODY topmargin=0 leftmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<Form name="Fcr" method=post action=<?=$PHP_SELF?>>
<input type=hidden name=id value=<?=$id?>>
<TABLE align=left border=0 cellPadding=10 cellSpacing=0 width="615">
<TR><TD valign=top width=615>
<TABLE border=0 cellPadding=0 cellSpacing=0 background="">
  
<TR>
     <TD colSpan=4 height=35>
      <FONT face=Verdana size=2 color="#000000"><STRONG>PERSONAL INFORMATION</STRONG></FONT>&nbsp;&nbsp;&nbsp;
      <FONT face=arial size=1 color="#FF0000">(All the fields shown in Bold are mandatory fields)</FONT> 
       </TD>
 </TR>
 <TR>
	<TD colspan=4 height=20>&nbsp;</TD>
 </TR>
  <TR>
    <TD height=35><STRONG><FONT face=Verdana size=2>First Name</FONT> </STRONG> </TD>
    <TD><FONT face=Verdana size=2><INPUT name=TBFname style ="HEIGHT: 19px; WIDTH: 143px" value="<?=htmlentities($user->get('first_name'))?>"></FONT></TD>
   
    <TD>
      <P><FONT face=Verdana size=2>Middle Name </FONT>  <A href="javascript:showlayer('4');"><img src="images/lens.gif" border=0></A> </P></TD>
    <TD><FONT face=Verdana size=2><INPUT name=TBMname 
            style="HEIGHT: 19px; 
     WIDTH: 146px" value="<?=htmlentities($user->get('middle_name'))?>"></FONT></TD>
    </TR>
  <TR>
    <TD height=35><STRONG><FONT face=Verdana size=2> Surname</FONT> </STRONG> </TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBLname 
            style="HEIGHT: 19px; 
     WIDTH: 144px" value="<?=htmlentities($user->get('last_name'))?>"></FONT></TD>
   
    <TD><STRONG><FONT face=Verdana size=2>Sex</FONT></STRONG></TD>
    <TD><SELECT  name=CBSex
      style="HEIGHT: 19px; WIDTH: 146px" 
           > 
      <OPTION value="NULL">Select One</OPTION>
  <OPTION <?if ($user->get('sex') == "M") echo "selected";?> value="M">Male</OPTION>
  <OPTION <?if ($user->get('sex') == "F") echo "selected";?> value="F">Female</OPTION>
  </SELECT></FONT></TD>
   </TR>
   <TR> 
    <TD nowrap height=35><FONT face=Verdana size=2><STRONG>DOB </STRONG><EM>(dd/mm/yyyy)</EM>  </FONT><EM> 
      </EM>  </TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBDob 
      style="HEIGHT: 19px; WIDTH: 144px" maxlength=10 value="<?=htmlentities($user->get('date_of_birth'))?>"
       ></FONT></TD>
    
    <TD><FONT face=Verdana size=2>Marital Status</FONT> </TD>
    <TD><SELECT  name=CBMstatus 
      style="HEIGHT: 19px; WIDTH: 144px" 
           >
      <OPTION value="S">Single</OPTION>
      <OPTION <?if ($user->get('marital_status') == "M") echo "selected";?> value="M">Married</OPTION>
      </SELECT></TD>
    </TR>
  <TR>
    <TD nowrap height=35>
      <P><FONT size=2><FONT face=Verdana><STRONG>Email</STRONG> <EM>(Personal)</EM></FONT></FONT></P></TD>
    <TD><FONT face=Verdana size=2><INPUT name=TBEAddrP 
      style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($user->get('personal_email'))?>"
           ></FONT></TD>
   
    <TD><FONT size=2><FONT face=Verdana>Email <EM>(Official)</EM></FONT></FONT></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBEAddrO 
      style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($user->get('official_email'))?>"
           ></FONT></TD>
   </TR>
   <TR>
    <TD height=35><STRONG><FONT face=Verdana size=2>Field of Work </FONT></STRONG><A href="javascript:showlayer('1');"><img src="images/lens.gif" border=0></A>
         
      </TD>
    <TD><SELECT name=CBWork style="HEIGHT: 19px; LEFT: 1px; TOP: 1px; WIDTH: 145px" 
           >
    <OPTION value="NULL">Others..</OPTION>
<?php
	for ($i = 0; $i < sizeof($work_types); $i++) {
		if ($user->get('work_type') == $work_types[$i])
			$sel = " selected";
		else 
			$sel = "";
    	echo "<OPTION value=\"".htmlentities($work_types[$i])."\"$sel>".htmlentities($work_types[$i])."</OPTION>";
	}
?>
    </SELECT></TD>
  
    <TD><FONT face=Verdana size=2>If 
            other,add</FONT>  </TD>
    <TD><FONT face=Verdana size=2><INPUT 
            name=TBWork
            style="HEIGHT: 19px; WIDTH: 143px"></FONT></TD>
  </TR>
   <TR>
	<TD colspan=4 height=20>&nbsp;</TD>
 </TR>
  <TR>
  
    <TD colSpan=2 height=35>
      <P align=center><FONT face=Verdana 
      size=2><STRONG>PERMANENT ADDRESS</STRONG></FONT> </P> </TD>
    <TD  colspan =2>
      <P align=center><FONT face=Verdana 
      size=2><STRONG>OFFICIAL ADDRESS</STRONG></FONT> <A href="javascript:showlayer('2');"><img src="images/lens.gif" border=0></A> </P></TD>
    </TR>
     <TR>
	<TD colspan=4 height=20>&nbsp;</TD>
 </TR>
  <TR>
    <TD nowrap height=35><FONT face=Verdana size=2><STRONG>House Name/No.</STRONG> 
      </FONT> </TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBHname
         
      style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($paddr->get('house_name'))?>"
           ></FONT></TD>
    <TD><FONT face=Verdana size=2>Organisation&nbsp;Name</FONT> </TD>
    <TD><FONT face=Verdana size=2><INPUT name=TBCname 
      style="HEIGHT: 19px; WIDTH: 144px"  value="<?=htmlentities($oaddr->get('house_name'))?>"
           ></FONT></TD></TR>
  <TR>
    <TD height=35><FONT face=Verdana size=2>Street 
Address</FONT> </TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBPStr style="HEIGHT: 19px; WIDTH: 145px" value="<?=htmlentities($paddr->get('street'))?>"
           ></FONT></TD>
    <TD><FONT face=Verdana size=2>Street 
Address</FONT></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBCStr 
      style="HEIGHT: 19px; WIDTH: 145px" value="<?=htmlentities($oaddr->get('street'))?>"
           ></FONT></TD></TR>
  <TR>
    <TD height=35><STRONG><FONT face=Verdana 
      size=2>Area</FONT></STRONG></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBPArea 
      style="HEIGHT: 19px; WIDTH: 145px" value="<?=htmlentities($paddr->get('area'))?>"
           ></FONT></TD>
    <TD><FONT face=Verdana size=2>Area</FONT></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBCArea 
      style="HEIGHT: 19px; WIDTH: 146px" value="<?=htmlentities($oaddr->get('area'))?>"
           ></FONT></TD></TR>
  <TR>
    <TD height=35><STRONG><FONT face=Verdana size=2>City/Town</FONT></STRONG></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBPCity 
      style="HEIGHT: 19px; WIDTH: 145px" value="<?=htmlentities($paddr->get('city'))?>"
           ></FONT></TD>
    <TD><FONT face=Verdana size=2>City/Town</FONT></TD>
    <TD><FONT face=Verdana size=2><INPUT 
      name=TBCCity 
      style="HEIGHT: 19px; WIDTH: 146px" value="<?=htmlentities($oaddr->get('city'))?>"
           ></FONT></TD></TR>
  <TR>
    <TD height=35><STRONG><FONT face=Verdana size=2>State</FONT></STRONG></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBPState 
      style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($paddr->get('state'))?>"
           ></FONT></TD>
      <TD><FONT face=Verdana size=2>State</FONT></STRONG></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBCState 
      style="HEIGHT: 19px; WIDTH: 146px" value="<?=htmlentities($oaddr->get('state'))?>"
           ></FONT></TD></TR>
  <TR>
    <TD height=35><STRONG><FONT face=Verdana size=2>Country</FONT></STRONG></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBPCountry 
      style="HEIGHT: 19px; WIDTH: 143px" value="<?=htmlentities($paddr->get('country'))?>"
           ></FONT></TD>
    <TD><FONT face=Verdana size=2>Country</FONT></TD>
    <TD><FONT face=Verdana size=2><INPUT name=TBCCountry 
      style="HEIGHT: 19px; WIDTH: 146px" value="<?=htmlentities($oaddr->get('country'))?>"
           ></FONT></TD></TR>
  <TR height=35>
    <TD><FONT face=Verdana size=2>Pin Code</FONT> </TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBPPin 
      style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($paddr->get('postal_code'))?>"
           ></FONT></TD>
    <TD><FONT face=Verdana size=2>Pin Code</FONT> </TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBCPin 
      style="HEIGHT: 19px; WIDTH: 147px" value="<?=htmlentities($oaddr->get('postal_code'))?>"
           ></FONT></TD></TR>
  <TR>
    <TD height=35><FONT face=Verdana size=2>Home Phone</FONT> </TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBHPhone 
      style="HEIGHT: 18px; WIDTH: 145px" value="<?=htmlentities($paddr->get('telephone_no'))?>"
           ></FONT></TD>
    <TD><FONT face=Verdana size=2>Work Phone</FONT> </TD>
    <TD><FONT face=Verdana size=2><INPUT  
      name=TBWPhone 
      style="HEIGHT: 19px; WIDTH: 148px" value="<?=htmlentities($oaddr->get('telephone_no'))?>"
           ></FONT></TD></TR>
  <TR><TD colspan=4 height=20>&nbsp;</TD></TR>
  <TR>
    <TD align = middle colspan="4" height=35>
      <P align=center><FONT face=Verdana 
      size=2><STRONG>PRESENT ADDRESS</STRONG></FONT> <A href="javascript:showlayer('3');"><img src="images/lens.gif" border=0></A></P> 
       </TD>
   </TR>
   <TR><TD colspan=4 height=20>&nbsp;</TD></TR>
  <TR>
    <TD height=35><FONT face=Verdana size=2><STRONG>House Name/No.</STRONG> </FONT> </TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBTHname 
      style="HEIGHT: 19px; WIDTH: 143px"  value="<?=htmlentities($caddr->get('house_name'))?>"
           ></FONT></TD>
    <TD><FONT face=Verdana size=2>Phone</FONT></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBTPhone 
      style="HEIGHT: 19px; WIDTH: 147px" value="<?=htmlentities($caddr->get('telephone_no'))?>" 
           ></FONT></TD></TR>
  <TR>
    <TD height=35><FONT face=Verdana size=2>Street 
      Address</FONT></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBTStr 
      style="HEIGHT: 18px; WIDTH: 144px" value="<?=htmlentities($caddr->get('street'))?>"
           ></FONT></TD>
    <TD><STRONG><FONT face=Verdana size=2>Area</FONT></STRONG></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBTArea 
      style="HEIGHT: 19px; WIDTH: 147px" value="<?=htmlentities($caddr->get('area'))?>"
           ></FONT></TD></TR>
  <TR>
    <TD height=35><STRONG><FONT face=Verdana size=2>City/Town</FONT></STRONG></TD>
    <TD><FONT face=Verdana size=2><INPUT   name=TBTCity 
      style="HEIGHT: 18px; WIDTH: 144px" value="<?=htmlentities($caddr->get('city'))?>"
           ></FONT></TD>
    <TD><STRONG><FONT face=Verdana size=2>State</FONT></STRONG></TD>
    <TD><FONT face=Verdana size=2><INPUT  name=TBTState 
      style="HEIGHT: 19px; WIDTH: 147px" value="<?=htmlentities($caddr->get('state'))?>"
           ></FONT></TD></TR>
  <TR>
    <TD height=35><STRONG><FONT face=Verdana size=2>Country</FONT></STRONG></TD>
    <TD><FONT face=Verdana size=2><INPUT name=TBTCountry 
      style="HEIGHT: 18px; WIDTH: 145px" value="<?=htmlentities($caddr->get('country'))?>"
           ></FONT></TD>
    <TD><FONT face=Verdana size=2>Pin Code</FONT> </TD>
    <TD><FONT face=Verdana size=2><INPUT name=TBTPin 
      style="HEIGHT: 19px; WIDTH: 146px" value="<?=htmlentities($caddr->get('postal_code'))?>"
           ></FONT></TD></TR>
    <TR>
    <TD height=20 colspan=4>&nbsp;</TD>
	</TR>
  <TR>
     <TD colspan=2 align=center height=35>
      <INPUT  name=todo type=submit value=Update style="HEIGHT: 24px; WIDTH: 96px">
</TD>
     <TD colspan=2 align=center height=35>
      <INPUT  name=cancel type=button value=Close OnClick="javascript:window.close();" style="HEIGHT: 24px; WIDTH: 96px">
</TD>
  </TR>

</TABLE>
</TD>
</TR></TABLE>
</FORM>
</BODY>
</HTML>
