var str;
//checks if the given string is numeric
	function CheckAlphaNumeric(str) {
		for (var i = 0; i < str.length; i++) {
		  if (!IsAlphanumeric(str.charAt(i))) {
		    return (false);
		  }
		}
		return (true);
	}
	
	
	//checks if the given string is numeric
	function CheckNumeric(str) {
		for (var i = 0; i < str.length; i++) {
		  if (!IsNumeric(str.charAt(i))) {
		    return (false);
		  }
		}
		return (true);
	}
	
	
	//checks if the given character is alphanumeric
	function IsAlphanumeric(ch) {
		var Alphas = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
		if (Alphas.indexOf(ch) == -1) {
		  return (false);
		} else {
		  return (true);
		}
	}
	
	//checks if the given character is alphanumeric,space,hyphen or underscore
	function IsAlphanumericspace(ch) {
		var Alphas = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_#';,.() ";
		if (Alphas.indexOf(ch) == -1) {
		  return (false);
		} else {
		  return (true);
		}
	}
	
		
	//checks if the given character is numeric
	function IsNumeric(ch) {
		var Numerics = "1234567890";
		if (Numerics.indexOf(ch) == -1) {
		  return (false);
		} else {
		  return (true);
		}
	}    
	
	// alphanumeric,space,hyphen and underscore allowed. First character cannot be a space,hyphen or underscore
	function CheckAlphaNumericSpace(str)
	{
		if((str.charAt(0) == " ")||(str.charAt(0) == "-")||(str.charAt(0) == "_"))
			return false;
		for (var i = 0; i < str.length; i++) {
		  if (!IsAlphanumericspace(str.charAt(i))) {
		    return (false);
		  }
		}
		return (true);
	}	
	
	
	// Check for Third character to be a hyphen
	function CheckHyphen(str){
		if (str.charAt(2) != "-"){
			return false;
		}
		else{
			return true;
		}
	}
	
	
	function CheckDate(sDate){
//	window.onerror=null // for all other strange errors
	var err=0
	
	if (sDate.length != 10) err=1
	sDay = sDate.substring(0, 2)// day
	sDelimiter1 = sDate.substring(2, 3)// '/'
	sMonth = sDate.substring(3, 5)// month
	sDelimiter2 = sDate.substring(5, 6)// '/'
	sYear = sDate.substring(6, 10)// year
	
	//basic error checking
	if (sMonth<1 || sMonth>12) err = 1
	if (sDelimiter1 != '/') err = 1
	if (sDay<1 || sDay>31) err = 1
	if (sDelimiter2 != '/') err = 1
	if (sYear<1900 || sYear>2100) err = 1
	
	//advanced error checking

	// months with 30 days
	if (sMonth==4 || sMonth==6 || sMonth==9 || sMonth==11){
		if (sDay==31) err=1
	}

	// february, leap year
	if (sMonth==2){
		// feb
		var g=parseInt(sYear/4)
		if (isNaN(g)) {
			err=1
		}
		if (sDay>29) err=1
		if (sDay==29 && ((sYear/4)!=parseInt(sYear/4))) err=1
	}

	if (err==1)
			return false;
	
	return true;
}
//function to check if the given date is greater than the current date
//returns true if greater else false
function IsDateGreaterToday(sDate)
{
	var sday,sMonth,sYear,sValue=1900;
	
	sDay = sDate.substring(0, 2)// day
	sDelimiter1 = sDate.substring(2, 3)// '/'
	sMonth = sDate.substring(3, 5)// month
	sDelimiter2 = sDate.substring(5, 6)// '/'
	sYear = sDate.substring(6, 10)// year

	
		//note month in the javascript date object is 0 to 11
		//var clrdate=  Date.UTC(sYear, sMonth-1, sDay);
			
		var toDay = new Date();
		
		 // Capture today's date
		// Extract the year, the month, and the day.
		var thisYear = toDay.getYear() ;
		var thisMonth = toDay.getMonth();
		var thisDay =  toDay.getDate();	  
		thisYear = sValue + thisYear;       
		//toDay = Date.UTC(thisYear,thisMonth,thisDay);

	/*	if(clrdate < toDay )
		{
			return false;
							
		}
		*/
		if(thisYear > sYear)
		{
		return false
		}
		if(thisYear < sYear)
		{
		return true
	    }        
		/*
		if(clrdate > toDay ) 
		{	 
				
			return true;
		}*/	

}

//to compare two dates
//function to check if the to date is greater than the from date
//returns true if greater else false

function CompareDates(sDate1,sDate2)
{
	var sday,sMonth,sYear;
	
	sDay = sDate1.substring(0, 2)// day
	sDelimiter1 = sDate1.substring(2, 3)// '/'
	sMonth = sDate1.substring(3, 5)// month
	sDelimiter2 = sDate1.substring(5, 6)// '/'
	sYear = sDate1.substring(6, 10)// year
	
	//note month in the javascript date object is 0 to 11
	var fromdate=  Date.UTC(sYear, sMonth -1, sDay);
			
	sDay = sDate2.substring(0, 2)// day
	sDelimiter1 = sDate2.substring(2, 3)// '/'
	sMonth = sDate2.substring(3, 5)// month
	sDelimiter2 = sDate2.substring(5, 6)// '/'
	sYear = sDate2.substring(6, 10)// year
	
	//note month in the javascript date object is 0 to 11
	var todate=  Date.UTC(sYear, sMonth -1, sDay); 
				
		
	if(fromdate > todate ) 
	{
		return false;
			
	}
			
	if(fromdate < todate ) {
		return true;
	}	

	}


// to check if entered email address is valid
 function CheckEmailStr(str) {
					count=0,count1=0;
			for (var i = 0; i < str.length; i++) {
				if (str.charAt(i) == "@") 
				count++;
				if (str.charAt(i) == ".")
				count1++;
			}
		
	if((count < 1) || (count1 < 1)){
		alert("Please Enter Valid Email Id");
		return false;
	}
return true;				  
	
}
	
// validate if its a real number for cost 
function CheckDecimalNumeric(str) {

if((str.charAt(0) == ".")){
			return (false);
}

 for (var i = 0; i < str.length; i++) {
		  if (!IsDecimalNumeric(str.charAt(i))) {
		    return (false);
		  }
   }
 if(!CheckDeciCount(str)) {
   return (false);
   }
    if (!CheckPosition(str)) {
		return (false);
      }
  return (true);
  
}

//checks if the given character is numeric,decimal
	function IsDecimalNumeric(ch) {
		var Numerics = "1234567890.";
		if (Numerics.indexOf(ch) == -1) {
		  return (false);
		} else {
		  return (true);
		}
	}  	

	
// to check whether decimal point is not more than one
function CheckDeciCount(str) {
	count=0;
	for (var i = 0; i < str.length; i++) {
		if (str.charAt(i) == ".") 
			count++;
	}	
	if((count > 1)){
		return false;
	}
		
return true;				
}	

// check if there are more than 2 digits after decimal point
function CheckPosition(str) {
for (var i = 0; i < str.length; i++){
		   	if (str.charAt(i) == ".") {
		   		pos=i;
		   			if((str.length-pos)>3){
		   				return false;
		   			}
		   	}
	}
	return true;
}
//function to check if the given date is greater than the current date
//returns true if greater else false
function IsDateGreaterFromCurr(sDate,nDays)
{
//diffence between fromdate and todate should not be more than n days
		var MINUTE = 60 * 1000
		var HOUR = MINUTE * 60
		var DAY = HOUR * 24
		
	
		var sday,sMonth,sYear;
		
		//alert(sFromDate);
		sDay = sDate.substring(0, 2)// day
		sMonth = sDate.substring(3, 5)// month
		sYear = sDate.substring(6, 10)// year
		
		Fdate = new Date(sYear,sMonth-1,sDay)
	
		var toDay = new Date();  // Capture today's date
		
		ndays=(toDay-Fdate)/DAY
		
		if( ndays <2){
			alert("The Date of Booking must be current date + 2");
			return false;
		}	
		return true;
		}
