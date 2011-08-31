<?php
//	include 'xmec.inc';
	$secure_page=1;
	$this_page="profile";
	include 'header.php';


	if (! XMEC::authenticate_user()) {
		echo "<html><h2>Please login to access this page<html>";
		exit ;
	}

	reset($HTTP_POST_VARS);
	$action = chop($HTTP_POST_VARS["todo"]);
	if ($REQUEST_METHOD == "GET")
		$action = chop($HTTP_GET_VARS["todo"]);

	$user =& XMEC::getUser();

	if ($action == "update") {

		$user->userBackup();

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
		$user->set('nick_name', $TBNname);
		$user->set('yahoo', $TBPostG);
		$user->set('msn', $TBPost);
		$user->set('chapter_id', $CBChapter);
		$user->set('alias', $TBAlias);
		$user->set('forwarding_email', $TBEAddrF);
		$user->set('aol', $TBSpouse);
		$user->set('jabber', $TBSporg);




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

		$user->addrBackup('PERMANENT');
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

		$user->addrBackup('COMPANY');
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

		$user->addrBackup('PRESENT');
		if (! $user->setAddress($addr, 'PRESENT')) {
			XMEC::error_exit ("Update failed: ". $user->getError());
		}

		if (empty($target)) {
			$target="preferences.php";
		}
		echo "<html><head><script language=javascript>alert(\"Your profile has been updated successfully\"); document.location=\"$target\";</script></head></html>";

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
<script Language="JavaScript" src="jslibxmec.js">
</script>
<SCRIPT language="javascript">
function check()
{

 if (false == validate()) {
      //parent.self.location.href="xmec_createmem.htm";
  } else {
	if (document.Fcr.TBCname.value == "")
		alert("Your profile will be updated without organisation details");

   document.Fcr.action = "<?=$PHP_SELF."?target=$target"?>";
   document.Fcr.method = "POST";
   document.Fcr.todo.value = "update";
   document.Fcr.submit();
  }
  return false;
 }
function validate()
{
	if((document.Fcr.TBFname.value == "") || (!CheckAlphaNumeric(document.Fcr.TBFname.value))){
	alert("Please enter Firstname");
	return false;
	 }
	if((document.Fcr.TBLname.value=="") || (!CheckAlphaNumeric(document.Fcr.TBLname.value))){
	alert("Please enter Lastname");
	return false;
	}
	if(!CheckAlphaNumeric(document.Fcr.TBMname.value)){
	alert("Please verify Middlename");
	return false;
	}
	if(document.Fcr.CBSex.options[document.Fcr.CBSex.selectedIndex].value == "NULL"){
	alert ("Please specify Gender");
	return false;
	}


	if((document.Fcr.TBDob.value == "" ) ||(false == CheckDate(document.Fcr.TBDob.value)) ||(IsDateGreaterToday(document.Fcr.TBDob.value))){
			alert("Please Enter your Date of Birth in the correct format");
			return false;
		}
	if(!CheckEmailStr(document.Fcr.TBEAddrP.value )){
//	 alert("Please verify Personal Email");
	return false;
	}

    if(document.Fcr.TBEAddrO.value != ""){
	if(!CheckEmailStr(document.Fcr.TBEAddrO.value )){
//	 alert("Please verify Official Email");
	return false;
	}
	}
	index = document.Fcr.CBWork.selectedIndex;
	if(document.Fcr.CBWork.options[index].value  == "NULL" &&
		 document.Fcr.TBWork.value == ""){
	alert("Please specify your Area of Work or Study ");
	return false;
	}
 //   if(document.Fcr.CBVisible.value  == "NULL"){
//	alert("Please specify Year of Joining MEC");
//	return false;
//	}
	if(document.Fcr.TBHname.value  == "") {
	alert("Please enter Permanent Residence House Name/ No");
	return false;
	}

	//if(!CheckAlphaNumericSpace(document.Fcr.TBHname.value )){
	//alert("Please enter Permanent House Name/No");
	//return false;
    //}

   // if(document.Fcr.TBCStr.value != ""){
	//if(!CheckAlphaNumericSpace(document.Fcr.TBCStr.value)){
	//alert("Please enter Company Street Address");
	//return false;
	//}
   // }

  if(document.Fcr.TBCname.value != "")
  {
    if(document.Fcr.TBCArea.value == ""){
	alert("Please enter the Area where your Organisation is located");
	return false;
    }
    //if(!CheckAlphaNumeric(document.Fcr.TBCArea.value)){
    //alert("Pls enter Company Area");
    //return false;
   // }
    if(document.Fcr.TBCCity.value == ""){
	alert("Please enter the City where your Organisation is located");
	return false;
    }
    //if(!CheckAlphaNumeric(document.Fcr.TBCCity.value)){
    //alert("Pls enter the Company City name");
    //return false;
    //}
    if(document.Fcr.TBCState.value == ""){
	alert("Please enter the State where your Orgnisation is located");
	return false;
    }
    //if(!CheckAlphaNumeric(document.Fcr.TBCState.value)){
    //alert("Please enter Company State Name");
    //return false;
   // }
   if(document.Fcr.TBCCountry.value == ""){
	alert("Please enter the Country where your Organisation is located");
	return false;
	    }
	//if(!CheckAlphaNumeric(document.Fcr.TBCCountry.value)){
	//alert("Pls enter Company Country Name");
	//return false;
	//}

    if(document.Fcr.TBCPin.value == ""){
	alert("Please enter Organisation Pin code");
	return false;
	}
	if(!CheckNumeric(document.Fcr.TBCPin.value)){
	alert("Please enter the Orgnisation Pin code in numerals without space in between");
	return false;
    }
    if(document.Fcr.TBWPhone.value == ""){
	alert("Please enter Organisation Phone Number");
	return false;
	}
   // if(!CheckAlphaNumericSpace(document.Fcr.TBWPhone.value )){
//	alert("Please enter Company Phone Number");
//	return false;
//    }
  }
  if(document.Fcr.TBPArea.value == ""){
	alert("Please enter the Area where your Permanent residence is located");
	return false;
    }
    //if(!CheckAlphaNumeric(document.Fcr.TBPArea.value)){
    //alert("Pls enter Company Area");
    //return false;
   // }
    if(document.Fcr.TBPCity.value == ""){
	alert("Please enter the City where your Permanent residence is located");
	return false;
    }
    //if(!CheckAlphaNumeric(document.Fcr.TBPCity.value)){
    //alert(" the ");
    //return false;
    //}
    if(document.Fcr.TBPState.value == ""){
	alert("Please enter the State where your Permanent residence is located");
	return false;
    }
    //if(!CheckAlphaNumeric(document.Fcr.TBPState.value)){
    //alert("Please enter Permanent Adderss State Name");
    //return false;
   // }
   if(document.Fcr.TBPCountry.value == ""){
	alert("Please enter the Country where your Permanent residence is located");
	return false;
	    }
	//if(!CheckAlphaNumeric(document.Fcr.TBPCountry.value)){
	//alert("Pls enter Company Country Name");
	//return false;
	//}

    if(document.Fcr.TBPPin.value != ""){
	if(!CheckNumeric(document.Fcr.TBPPin.value)){
	alert("Please enter Permanent Address Pin code. Please use numerals without spaces in between");
	return false;
    }
    }
    if(document.Fcr.TBHPhone.value != ""){
	if(!CheckAlphaNumericSpace(document.Fcr.TBHPhone.value )){
	alert("Please enterPermanent Address Phone Number");
	return false;
    }
    }
    if(document.Fcr.TBTHname.value == "") {
	alert("Please enter House Name/No of your Present residence");
	return false;
	}

	//if(!CheckAlphaNumericSpace(document.Fcr.TBTHname.value )){
	//alert("Please enter your Present residence House Name/No");
	//return false;
    //}

    if(document.Fcr.TBTArea.value == ""){
	alert("Please enter the Area where your Present residence is located");
	return false;
    }
    //if(!CheckAlphaNumeric(document.Fcr.TBTArea.value)){
    //alert("Please enter Current Address Area");
    //return false;
   // }
    if(document.Fcr.TBTCity.value == ""){
	alert("Please enter the City where your Present residence is located");
	return false;
    }
    //if(!CheckAlphaNumeric(document.Fcr.TBTCity.value)){
    //alert("Please enter the Current Address City");
    //return false;
    //}
    if(document.Fcr.TBTState.value == ""){
	alert("Please enter the State where your Present residence is located");
	return false;
    }
    //if(!CheckAlphaNumeric(document.Fcr.TBTState.value)){
    //alert("Please enter Current Adderss State Name");
    //return false;
   // }
   if(document.Fcr.TBTCountry.value == ""){
	alert("Please enter the Country where your Present residence is located");
	return false;
	    }
	//if(!CheckAlphaNumeric(document.Fcr.TBTCountry.value)){
	//alert("Pls enter Current Address Country Name");
	//return false;
	//}

    if(document.Fcr.TBTPin.value != ""){
	if(!CheckNumeric(document.Fcr.TBTPin.value)){
	alert("Please enter Present residence Pin code");
	return false;
    }
    }
    if(document.Fcr.TBTPhone.value != ""){
	if(!CheckAlphaNumericSpace(document.Fcr.TBTPhone.value )){
	alert("Please enter Current Address Phone Number");
	return false;
    }
    }
 return true;
 }

function showlayer(x)
{
if (document.all){
document.all("Layer"+x).style.visibility="visible"}

if (document.layers){
document.layers["Layer"+x].visibility="visible"}
//return true;
setTimeout(hideall, 8000);
}

function hideall()
{
hidelayer(1);
hidelayer(2);
hidelayer(3);
hidelayer(4);
}

function hidelayer(x)
{
if (document.all){
document.all("Layer"+x).style.visibility="hidden"}

if (document.layers){
document.layers["Layer"+x].visibility="hidden"}
//return true;
}

</SCRIPT>
</HEAD>
<BODY topmargin=0 leftmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<Form name="Fcr">
<input type=hidden name=todo value=null>
<TABLE align=left border=0 cellPadding=10 cellSpacing=0 width="100%">
 <TR>
	<TD align=center height=35 class=head>PERSONAL INFORMATION(All the fields shown in Red are mandatory fields)</TD>
 </TR>
 <TR>
	<TD align=center>
<!-- Alias Box starts -->
<TABLE cellSpacing=0 cellPadding=0 border=0>
<TBODY>
  <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    </TR>
    <TR>
    <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
    <TD colSpan=2 rowSpan=2>
      <!--contents starts-->
	<TABLE border=0 width=325 cellPadding=0 cellSpacing=10 background="">
	<TR>
	    <TD class=fbody>Alias <EM>(Login name)</EM></TD>
	    <TD><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBAlias value="<?=htmlentities($user->get('alias'))?>"></TD>
	</TR>
	</TABLE>
      <!--contents ends-->
    </TD>
    <TD vAlign=top width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_topb.gif" width=3></TD>
  </TR>
  <TR>
    <TD vAlign=bottom width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_bottomb.gif" width=3></TD>
    <TD vAlign=bottom width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_bottomb.gif" width=3></TD>
  </TR>
    <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    <TD align=left background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_left_bottomt.gif" width=8></TD>
    <TD align=right background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_right_bottomt.gif" width=8></TD>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
  </TR>
  </TBODY>
</TABLE>
<!-- Alias Box ends -->
<BR>
<!-- Name Box starts -->
<TABLE cellSpacing=0 cellPadding=0 border=0>
<TBODY>
  <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    </TR>
    <TR>
    <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
    <TD colSpan=2 rowSpan=2>
      <!--contents starts-->
	<TABLE border=0 width=500 cellPadding=0 cellSpacing=0 background="">
 <TR>
    <TD height=35 class=name width=100>First Name</TD>
    <TD width=150><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBFname value="<?=htmlentities($user->get('first_name'))?>"></TD>

    <TD class=fbody width=100>
      Middle Name</TD>
    <TD width=150><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBMname  value="<?=htmlentities($user->get('middle_name'))?>"></TD>
    </TR>
  <TR>
    <TD height=35 class=name>Surname</TD>
    <TD><INPUT  class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBLname  value="<?=htmlentities($user->get('last_name'))?>"></TD>
    <TD height=35 class=fbody>Nick Name</TD>
    <TD><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBNname value="<?=htmlentities($user->get('nick_name'))?>"></TD>
	</TR>
	</TABLE>
      <!--contents ends-->
    </TD>
    <TD vAlign=top width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_topb.gif" width=3></TD>
  </TR>
  <TR>
    <TD vAlign=bottom width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_bottomb.gif" width=3></TD>
    <TD vAlign=bottom width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_bottomb.gif" width=3></TD>
  </TR>
    <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    <TD align=left background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_left_bottomt.gif" width=8></TD>
    <TD align=right background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_right_bottomt.gif" width=8></TD>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
  </TR>
  </TBODY>
</TABLE>
<!-- Name Box ends -->
<BR>
<!-- DOB Box starts -->
<TABLE cellSpacing=0 cellPadding=0 border=0>
<TBODY>
  <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    </TR>
    <TR>
    <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
    <TD colSpan=2 rowSpan=2>
      <!--contents starts-->
  <TABLE border=0 width=500 cellPadding=0 cellSpacing=0 background="">
	<TR>
 	<TD nowrap height=35 class=name width=100>DOB<BR><EM>(dd/mm/yyyy)</EM></TD>
    	<TD width=150><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBDob value="<?=htmlentities($user->get('date_of_birth'))?>"></TD>
	<TD class=name width=100>Sex</TD>
    	<TD width=150><SELECT  class=cbox style="HEIGHT: 19px; WIDTH: 144px" name=CBSex >
      		<OPTION value="NULL">Select One</OPTION>
  		<OPTION <?if ($user->get('sex') == "M") echo "selected";?> value="M">Male</OPTION>
  		<OPTION <?if ($user->get('sex') == "F") echo "selected";?> value="F">Female</OPTION>
  		</SELECT></TD>
	</TR>
	<TR>
	<TD class=fbody>Marital Status</TD>
    	<TD><SELECT  class=cbox style="HEIGHT: 19px; WIDTH: 144px" name=CBMstatus >
      		<OPTION value="S">Single</OPTION>
      		<OPTION <?if ($user->get('marital_status') == "M") echo "selected";?> value="M">Married</OPTION>
      		</SELECT></TD>
	<TD height=35 class=fbody>Spouse Name</TD>
	<TD><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBSpouse value="<?=htmlentities($user->get('aol'))?>"></TD>
	</TR>
	</TABLE>

<!--contents ends-->
    </TD>
    <TD vAlign=top width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_topb.gif" width=3></TD>
  </TR>
  <TR>
    <TD vAlign=bottom width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_bottomb.gif" width=3></TD>
    <TD vAlign=bottom width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_bottomb.gif" width=3></TD>
  </TR>
    <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    <TD align=left background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_left_bottomt.gif" width=8></TD>
    <TD align=right background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_right_bottomt.gif" width=8></TD>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
  </TR>
  </TBODY>
</TABLE>
<!-- DOB Box ends -->
<BR>
<!-- Career Box starts -->
<TABLE cellSpacing=0 cellPadding=0 border=0>
<TBODY>
  <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    </TR>
    <TR>
    <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
    <TD colSpan=2 rowSpan=2>
      <!--contents starts-->
  	<TABLE border=0 width=500 cellPadding=0 cellSpacing=0 background="">
	<TR>
	<TD height=35 class=fbody width=100>Designation</TD>
    <TD width=150><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBPost value="<?=htmlentities($user->get('msn'))?>"></TD>
	<TD class=fbody width=100>Post Graduation</TD>
    <TD width=150><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBPostG  value="<?=htmlentities($user->get('yahoo'))?>"></TD>
	</TR>
	<TR>
	<TD height=35 class=fbody>Field of Work</TD>
	<TD><SELECT class=cbox style="HEIGHT: 19px; WIDTH: 144px" name=CBWork maxlength=20>
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
	<TD class=fbody>If other,add</TD>
    <TD><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBWork></TD>
	</TR>
	<TR>
    <TD nowrap height=35 class=fbody>Email<EM>(Personal)</EM></TD>
    <TD><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBEAddrP value="<?=htmlentities($user->get('personal_email'))?>"></TD>
    <TD class=fbody>Email <EM>(Official)</EM></TD>
    <TD><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBEAddrO value="<?=htmlentities($user->get('official_email'))?>"></TD>
	</TR>
	</TABLE>

<!--contents ends-->
    </TD>
    <TD vAlign=top width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_topb.gif" width=3></TD>
  </TR>
  <TR>
    <TD vAlign=bottom width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_bottomb.gif" width=3></TD>
    <TD vAlign=bottom width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_bottomb.gif" width=3></TD>
  </TR>
    <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    <TD align=left background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_left_bottomt.gif" width=8></TD>
    <TD align=right background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_right_bottomt.gif" width=8></TD>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
  </TR>
  </TBODY>
</TABLE>
<!-- Career Box ends -->
<BR>
<!-- personal Box starts -->
<TABLE cellSpacing=0 cellPadding=0 border=0>
<TBODY>
  <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    </TR>
    <TR>
    <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
    <TD colSpan=2 rowSpan=2>
      <!--contents starts-->
  	<TABLE border=0 width=500 cellPadding=0 cellSpacing=0 background="">
  <TR>
    <TD colSpan=4 align=center height=35 class=name><strong>PERMANENT ADDRESS</strong></TD>
  </TR>
  <TR>
    <TD nowrap height=35 width=100 class="name">House Name/No.</TD>
    <TD width=150><INPUT  class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBHname value="<?=htmlentities($paddr->get('house_name'))?>"></TD>
    <TD width=100 height=35 class=fbody>Street</TD>
    <TD width=150><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBPStr value="<?=htmlentities($paddr->get('street'))?>"></TD>
  </TR>
  <TR>
    <TD height=35 class=name>Area</TD>
    <TD><INPUT  name=TBPArea class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($paddr->get('area'))?>"></TD>
    <TD height=35 class=name>City/Town</TD>
    <TD><INPUT  name=TBPCity class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($paddr->get('city'))?>"></TD>
  </TR>
  <TR>
    <TD height=35 class=name>State</TD>
    <TD><INPUT  name=TBPState class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($paddr->get('state'))?>"></TD>
	<TD height=35 class=name>Country</TD>
    <TD><INPUT class=box name=TBPCountry style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($paddr->get('country'))?>"></TD>
  </TR>
  <TR height=35>
    <TD class=fbody>Pin Code</TD>
    <TD><INPUT  name=TBPPin class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($paddr->get('postal_code'))?>"></TD>
    <TD height=35 class=fbody>Home Phone</TD>
    <TD><INPUT  name=TBHPhone class=box style="HEIGHT: 18px; WIDTH: 144px" value="<?=htmlentities($paddr->get('telephone_no'))?>"></TD>
    </TR>
</TABLE>
<!--contents ends-->
    </TD>
    <TD vAlign=top width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_topb.gif" width=3></TD>
  </TR>
  <TR>
    <TD vAlign=bottom width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_bottomb.gif" width=3></TD>
    <TD vAlign=bottom width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_bottomb.gif" width=3></TD>
  </TR>
    <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    <TD align=left background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_left_bottomt.gif" width=8></TD>
    <TD align=right background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_right_bottomt.gif" width=8></TD>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
  </TR>
  </TBODY>
</TABLE>
<!-- personal Box ends -->
<BR>
<!-- official Box starts -->
<TABLE cellSpacing=0 cellPadding=0 border=0>
<TBODY>
  <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    </TR>
    <TR>
    <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
    <TD colSpan=2 rowSpan=2>
      <!--contents starts-->
<TABLE border=0 width=500 cellPadding=0 cellSpacing=0 background="">
  <TR>
    <TD  align=center colspan =4 height=35 class=name><strong>OFFICIAL ADDRESS</strong></TD>
    </TR>
  <TR>
    <TD height=35 class=fbody width=100>Organisation</TD>
    <TD width=150><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBCname value="<?=htmlentities($oaddr->get('house_name'))?>"></TD>
	<TD height=35 class=fbody width=100>Street</TD>
    <TD width=150><INPUT class=box style="HEIGHT: 19px; WIDTH: 144px" name=TBCStr value="<?=htmlentities($oaddr->get('street'))?>"></TD>
  </TR>
  <TR>
    <TD height=35 class=fbody>Area</TD>
    <TD><INPUT  name=TBCArea class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($oaddr->get('area'))?>"></TD>
    <TD height=35 class=fbody>City/Town</TD>
    <TD><INPUT class=box name=TBCCity style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($oaddr->get('city'))?>"></TD>
  </TR>
  <TR>
    <TD height=35 class=fbody>State</TD>
    <TD><INPUT  name=TBCState class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($oaddr->get('state'))?>"></TD>
    <TD height=35 class=fbody>Country</TD>
    <TD><INPUT name=TBCCountry class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($oaddr->get('country'))?>"></TD>
  </TR>
  <TR>
    <TD height=35 class=fbody>Pin Code</TD>
    <TD><INPUT  name=TBCPin class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($oaddr->get('postal_code'))?>"></TD>
    <TD height=35 class=fbody>Work Phone</TD>
    <TD><INPUT  name=TBWPhone class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($oaddr->get('telephone_no'))?>"></TD>
  </TR>
</TABLE>
<!--contents ends-->
    </TD>
    <TD vAlign=top width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_topb.gif" width=3></TD>
  </TR>
  <TR>
    <TD vAlign=bottom width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_bottomb.gif" width=3></TD>
    <TD vAlign=bottom width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_bottomb.gif" width=3></TD>
  </TR>
    <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    <TD align=left background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_left_bottomt.gif" width=8></TD>
    <TD align=right background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_right_bottomt.gif" width=8></TD>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
  </TR>
  </TBODY>
</TABLE>
<!-- official Box ends -->
<BR>
<!-- address Box starts -->
<TABLE cellSpacing=0 cellPadding=0 border=0>
<TBODY>
  <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    </TR>
    <TR>
    <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
    <TD colSpan=2 rowSpan=2>
      <!--contents starts-->
<TABLE border=0 width=500 cellPadding=0 cellSpacing=0 background="">
  <TR>
    <TD align=center colspan="4" height=35 class=name><STRONG>PRESENT ADDRESS</STRONG></TD>
   </TR>
  <TR>
    <TD height=35 class=name width=100>House Name/No.</TD>
    <TD width=150><INPUT  name=TBTHname class=box style="HEIGHT: 19px; WIDTH: 144px"  value="<?=htmlentities($caddr->get('house_name'))?>"></TD>
    <TD class=fbody width=100>Phone</TD>
    <TD width=150><INPUT  name=TBTPhone class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($caddr->get('telephone_no'))?>"></TD>
  </TR>
  <TR>
    <TD height=35 class=fbody>Street</TD>
    <TD><INPUT  name=TBTStr class=box style="HEIGHT: 18px; WIDTH: 144px" value="<?=htmlentities($caddr->get('street'))?>"></TD>
    <TD class=name>Area</TD>
    <TD><INPUT  name=TBTArea class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($caddr->get('area'))?>"></TD>
  </TR>
  <TR>
    <TD height=35 class=name>City/Town</TD>
    <TD><INPUT   name=TBTCity class=box style="HEIGHT: 18px; WIDTH: 144px" value="<?=htmlentities($caddr->get('city'))?>"></TD>
    <TD class=name>State</FONT></STRONG></TD>
    <TD><INPUT  name=TBTState class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($caddr->get('state'))?>"></TD>
  </TR>
  <TR>
    <TD height=35 class=name>Country</TD>
    <TD><INPUT name=TBTCountry class=box style="HEIGHT: 18px; WIDTH: 144px" value="<?=htmlentities($caddr->get('country'))?>"></TD>
    <TD class=fbody>Pin Code</TD>
    <TD><INPUT name=TBTPin class=box style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($caddr->get('postal_code'))?>"></TD>
  </TR>
</TABLE>
<!--contents ends-->
    </TD>
    <TD vAlign=top width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_topb.gif" width=3></TD>
  </TR>
  <TR>
    <TD vAlign=bottom width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_bottomb.gif" width=3></TD>
    <TD vAlign=bottom width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_bottomb.gif" width=3></TD>
  </TR>
    <TR>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    <TD align=left background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_left_bottomt.gif" width=8></TD>
    <TD align=right background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_right_bottomt.gif" width=8></TD>
    <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
  </TR>
  </TBODY>
</TABLE>
<!-- address Box ends -->
</TD>
</TR>
  <TR>
     <TD align=center height=35><br>
      <INPUT  name=BSubmit type=button value=Update onClick="javascript:check(); return false;" style="HEIGHT: 24px; WIDTH: 96px">
  </TR>

</TABLE>
</FORM>

</BODY>
</HTML>
<?php
include 'footer.php';
?>

