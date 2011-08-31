
var item = new Array();

c=0; item[c]=new Array("Index.html","","Home Page","alumni,xmec,mecians,engineers","Alumni of Model Engineering College");
c++; item[c]=new Array("xmec.html","","XMEC","ex MEC,xmecians,exmec","A brief on the Alumni of Model Engineering College");
c++; item[c]=new Array("college.html","","College","model,engineering,college,kochi,thrikkakara,ihrd,cusat, kerala,entrance exam, uniform","Brief on Model Engineering College");
c++; item[c]=new Array("contact.html","","Contacts","contact,principal,head,department,HOD,webmasters,moderator,chapter,placement,email","XMEC Contact List");
c++; item[c]=new Array("vision.html","","Vision","dream, team, rating, arts,sports","Vision of XMECians");
c++; item[c]=new Array("search.php","","XMECian Search","email,ID,company,organisation,college,batchmates,MS,MBA,university,address,phone,mobile,wipro,infosys,intel,tcs,cts,profile,software,hardware,biomedical,batch,bangalore,chennai,USA","Search for XMECians");
c++; item[c]=new Array("groups.html","","XMEC Groups and Mailing Lists","mailing list,yahoogroups,batch,jobs,moderator","To contact the various batches of XMEC");
c++; item[c]=new Array("mecnews.html","","College News","News, microsoft,excel,model,college","News from Model Engineering College");
c++; item[c]=new Array("xnews.html","","XMEC News","BBC,news,xmec,EDN asia,IIM,chapter,get together","News from XMECians around the world");
c++; item[c]=new Array("letters.html","","NewsLetters","communication, sukulal,resume,gre,ms,mba,biomedical, career,homage,prinicipal,xmecian,paper","Letters and information posted in XMEC");
c++; item[c]=new Array("colact.html","","College Activities","Meeting, excel,linux,student","A brief on the various events and activities in College");
c++; item[c]=new Array("chapters.html","","XMEC Chapters","Meeting, chapter,bangalore,chennai,kochi,US,east coast,west,reports, get together,party","A brief on the various chapters of XMEC");
c++; item[c]=new Array("careers.html","","Career Options","career,fresher,resume,job,post,openings,experience","Pointers from XMECians regarding careers");
c++; item[c]=new Array("gallery.html","","XMEC Galleria","images,photo,gallery,get together,mec,college,hostel","Images from XMEC");
c++; item[c]=new Array("video.html","","XMEC Multimedia","video,US West,","Videos from XMEC");
c++; item[c]=new Array("accounts.html","","XMEC Accounts","dollar,rs,account,expense,treasurer,bank,state,number,members","Detailed XMEC Accounts for the financial year");
c++; item[c]=new Array("editprofile.php","","XMEC Database Creation","profile,record,update,name,address,member,company,members","To update your profile in XMEC Database");
c++; item[c]=new Array("preferences.php","","XMEC Profile Preferences","change password,subscribe,xmec@yahoogroups,restrict,preferences,members","To update your preferences/password for XMEC Profile");
c++; item[c]=new Array("help.html","","XMEC Login Help","roll number,problem, error,help,forgot,login,date,birth,members","Help for Login Problems for XMECians");
c++; item[c]=new Array("discussion.php","","XMEC Discussion Board","forum,discussion,bulletin,boards,thread,technical,issues,members","XMECians can post and discuss on various topics");
c++; item[c]=new Array("polls.php","","XMEC Polls","polls,opinions,results,members","XMECians can express their opinion on various topics");
c++; item[c]=new Array("calender.php","","XMEC Calender","birthday,date,marriage,get together,calendar,claender,reminder,members","Important events and dates for XMECians");



page="<html><head><title>:: XMEC Search Results ::</title><script language='javascript'>function getURL(location){window.opener.location.href=location;}</script></head><body bgcolor='#FFFFFF'><center><table border=0 cellspacing=2 cellpadding=5 width=100%><tr><td colspan=2 height=50 align=left valign=middle bgcolor=#2777C0><font face=arial size=2 color=#FFFFFF><strong>Search Results</strong></font></td></tr>";

function search() 
{
	win = window.open("","","scrollbars=yes,resizable=yes,location=no,directories=no,toolbar=no,status=no,menubar=no,width=580,height=400,left=30,top=40");
	win.document.write(page);
	str = new String(document.frmsearch.txtsearch.value)
	str1 = new String(str.toLowerCase())
	txt = str1.split(" ");
	fnd = new Array(); total=0;
	for (i = 0; i < item.length; i++) 
	{
		fnd[i] = 0;
		order = new Array(0, 4, 2, 3);
		for (j = 0; j < order.length; j++)
			for (k = 0; k < txt.length; k++)
				if (item[i][order[j]].toLowerCase().indexOf(txt[k]) > -1 && txt[k] != "")
				fnd[i] += (j+1);
	}
	for (i = 0; i < fnd.length; i++) 
	{
		n = 0; w = -1;
		for (j = 0;j < fnd.length; j++)
		if (fnd[j] > n) 
		{ 
			n = fnd[j]; w = j; 
		};
		if (w > -1) 
			total += showresult(w, win, n);
			fnd[w] = 0;
	}
	win.document.write("</center></table><hr><br><div><font face=arial size=2 color=#4F585F><strong>Total found: "+total+"</strong></font></div><br></body></html>");
	win.document.close();
}

function showresult(which,wind,num) 
{
	link = item[which][1] + item[which][0]; 
	line = "<tr><td><font face=arial size=2 color=#4F585F><a href=Javascript:getURL('"+link+"') title='"+item[which][2]+"'><font face=arial size=2 color=#4F585F><strong>"+item[which][2]+"</strong></font></a><br>"+ item[which][4] + "</font></td><td><font face=arial size=2 color=#4F585F><strong> Score: "+num+"</strong></td></tr>";
	wind.document.write(line);
	return 1;
}