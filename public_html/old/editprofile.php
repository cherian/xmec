<?php

	include 'xmec.inc';
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
		$user->addrBackup('PERMANENT');

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
		$user->addrBackup('COMPANY');
		
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
		$user->addrBackup('PRESENT');

		if (empty($target)) {
			$target="members.php";
		}
		$user->userBackup();
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
		alert("Your profile will be updated without Organisation or Company details");

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
     <TD colspan=4 align=center height=35><br>
      <INPUT  name=BSubmit type=button value=Update onClick="javascript:check(); return false;" style="HEIGHT: 24px; WIDTH: 96px">
  </TR>

</TABLE>
</TD>
</TR></TABLE>
</FORM>

<div id='Layer1' z-index=3 style='top:250px; position: absolute; left: 25px; width: 460px; border: 0px; visibility: hidden;background-color:#F0F0D4'>
<TABLE border=1 cellPadding=5 cellSpacing=0 bordercolor="#000000" bgcolor="#F0F0D4">
<TR>
	<TD>
	
<TABLE border=0 cellPadding=0 cellSpacing=0>
<TR>	
	<TD align=right><A href="javascript:hidelayer('1');"><font face=verdana color=#000000 size=1>|X</font></A></TD>
</TR>
<TR>	
	<TD><font face=arial color=#000000 size=1px>
		Please try to match details regarding your work / studies from the most suitable choices. If none of the options match, retain the option 'Others'and add type of work / studies in adjacent fields.</font>
	</TD>
</TR>
</TABLE>
	
	</TD>
</TR>
</TABLE>
</div>

<div id='Layer2' z-index=3 style='top:250px; position: absolute; left: 25px; width: 460px; border: 0px; visibility: hidden;background-color:#F0F0D4'>
<TABLE border=1 cellPadding=5 cellSpacing=0 bordercolor="#000000" bgcolor="#F0F0D4">
<TR>
	<TD>
	
<TABLE border=0 cellPadding=0 cellSpacing=0>
<TR>	
	<TD align=right><A href="javascript:hidelayer('2');"><font face=verdana color=#000000 size=1>|X</font></A></TD>
</TR>
<TR>	
	<TD><font face=arial color=#000000 size=1px>
		Please enter the accurate details of your Company or College of Education including PIN code and Telephone Number. This is to ease efforts of people looking for information regarding your College or Company. If not applicable leave the entire Organisation Address section blank. </font>
	</TD>
</TR>
</TABLE>
	
	</TD>
</TR>
</TABLE>
</div>

<div id='Layer3' z-index=3 style='top:605px; position: absolute; left: 25px; width: 460px; border: 0px; visibility: hidden;background-color:#F0F0D4'>
<TABLE border=1 cellPadding=5 cellSpacing=0 bordercolor="#000000" bgcolor="#F0F0D4">
<TR>
	<TD>
	
<TABLE border=0 cellPadding=0 cellSpacing=0>
<TR>	
	<TD align=right><A href="javascript:hidelayer('3');"><font face=verdana color=#000000 size=1>|X</font></A></TD>
</TR>
<TR>	
	<TD><font face=arial color=#000000 size=1px>
		Please update accurate details regarding your Current Address as this assists MECians and XMECians enquiring about XMECian presence in different geographies around the Globe. </font>
	</TD>
</TR>
</TABLE>
	
	</TD>
</TR>
</TABLE>
</div>

<div id='Layer4' z-index=3 style='top:250px; position: absolute; left: 25px; width: 460px; border: 0px; visibility: hidden;background-color:#F0F0D4'>
<TABLE border=1 cellPadding=5 cellSpacing=0 bordercolor="#000000" bgcolor="#F0F0D4">
<TR>
	<TD>
	
<TABLE border=0 cellPadding=0 cellSpacing=0>
<TR>	
	<TD align=right><A href="javascript:hidelayer('4');"><font face=verdana color=#000000 size=1>|X</font></A></TD>
</TR>
<TR>	
	<TD><font face=arial color=#000000 size=1px>
		You can enter your Nickname at the expense of your middle name as there can be searches based on the more popular Nicknames. </font>
	</TD>
</TR>
</TABLE>
	
	</TD>
</TR>
</TABLE>
</div>

</BODY>
</HTML>
