<html>
<HEAD>
<LINK rel=stylesheet href="style.css" type="text/css">
<SCRIPT LANGUAGE=javascript>
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',noresizable'
win = window.open(mypage,myname,settings)
//if(win.window.focus){win.window.focus();}//
}
</SCRIPT>

</HEAD>
<BODY bgcolor="#FFFFFF" topmargin=0 leftmargin=0 marginheight = "0" marginwidth = "0">
<?php
	include 'common.php';
	if (! XMEC::authenticate_user()) {
		echo "<h2>Please login to access this page</h2>
";
		exit ;
	}
?>
<TABLE align=left border=0 cellPadding=0 cellSpacing=0 width="615" height=100%>
<TR>
<TD valign=top width=445><img src="images/head_newsl.gif" width="218" height="35"><BR><BR>
<HR width=100% color="#CCCCCC">
<P><strong><img src="images/letter.gif"><font face=garamond size=3 color="#669999">To Draft an Effective Resume</font></strong></P>
<P><font face=garamond size=3>Many of you may be planning to look for a job in India. Apart from preparing for the tests, brushing up the subjects etc, one has to put some effort in drafting one's resume . Given the scenario that we are in now, the first impression definitely scores more
brownie points. Consider the position of the HR in charge of recruitment in a company. The moment they declare that they going to recruit, his or her mail box and table is bombarded with resumes of all kinds. The HR is now daunted with the tedious task of choosing the eligible ones from the pile of resumes. Given the fact that the number of resumes run in hundreds and even thousands, he or she can choose to be harsh when it comes to discarding resumes without adequate details, poor language, poor format etc. Here are a few tips that we learnt from our seniors when we came over on the  search for a job here. </font></P><BR>
<P><font face=garamond size=3><img src="images/pen.gif"><big><font face=garamond size=3>Legibility</font></big><BR>Make sure that your resume is legible. Always use a standard font like Arial or Times New Roman. Do not use any fancy font for it may not be installed on the personal computer of the person evaluating your resume.Choose a font size that appears good on an A4 size page layout. Size 12 would be readable enough. Take care to see that the paragraphs are aligned, and the spacing between lines are adequate. There is no point in squeezing text into the lesser number of pages at the expense of legibility</font></P><BR>
<P><font face=garamond size=3><img src="images/pen.gif"><big><font face=garamond size=3>Address for Communication</font></big><BR>Make sure that your address for communication is visible at one glance, hence it would be preferable if it is placed on the first page itself. It has been noticed that often addresses from within Bangalore (Chennai or Hyderabad etc) would be given preference over outstation addresses because it helps them avoid the confusions of arrival delays, communication problems etc. Hence it is advised to put a communication address respective of the place where you are applying. In short if you are applying for a company in Bangalore try to devise an  address of communication in Bangalore itself. It is safer to use the mailing address of your relatives, classmates or friends in Bangalore. Avoid using their company addresses lest they be mistaken to be applying for another job from their present company. This may land them in unwarranted trouble. Give the residential address of somebody who will be more than willing to convey the message the earliest. The phone number you put should  preferably be a local number. Make sure that the number you give is accessible most of the time.  The HR wont care  to call you after two or three failed attempts . If you can get the permission of your friends to use their direct office number ( preferably those without extension) that would be perfect .</font></P><BR>
<P><font face=garamond size=3><img src="images/pen.gif"><big><font face=garamond size=3>Content</font></big><BR>Be sure to mention all your technical and personal strengths. Often the interviewer frames his queries based on your strengths, hence it would be foolhardy to mention subjects and domains that you are least comfortable in, as strengths. That doesn't however mean that you should mention subjects in your strengths list only if you have mastered the whole subject. It just means that one should put subjects and skills in strength that one is fairly confident of. Other subjects and skill that you are aware of and possess general knowledge can be posted as your interests.</font></P><BR>
<P><font face=garamond size=3><strong>Please do write a brief description of your Mini Project and Main Project </strong>. Be sure to mention  specific tools and software if you have used any. There is also the possibility that they would have been on the lookout  for someone with that particular kind of experience. Mention what languages, development kits you have used . In case of hardware, mention the critical components used, especially micro-controller, processor etc. Many  have got calls for tests and interviews just because their academic projects caught their interest.</font></P><BR>
<P><font face=garamond size=3><img src="images/pen.gif"><big><font face=garamond size=3>Technical Experience and Achievements</font></big><BR>Be sure to mention any experience that you think might be relevant.</font></P><BR>
<P><font face=garamond size=3>Be sure to mention all technical and personal achievement as they also help them to form an idea about your personality. Do not forget to add details regarding your academic qualification complete with Year of study, College( School ), Name of Degree along with the Institution issuing the same and Aggregate Marks earned. <strong> Please do remember to mention that the BTech Degree is awarded by the Cochin University of Science and Technology.</strong></font></P><BR>
<P><font face=garamond size=3><img src="images/pen.gif"><big><font face=garamond size=3>File Format</font></big><BR><strong>Be sure to make the resume in Microsoft Word Format and try to save it as firstname_surname.rtf</strong> as RTF format happens to be the most virus free Microsoft Office format. <strong>Make sure that the size of your file is reasonable.</strong> Always save a format in .txt as some companies ask for only resumes in txt format.</font></P><BR>
<P><font face=garamond size=3><strong>Make sure that system from which you are sending your resume is not virus infected.</strong> The HR will not bother to either open or let you know if he or she receives an infected file. Verify if the resume you are sending can be opened without hassles. One way to ensure that is to issue a Blind Carbon Copy (bcc) to your own ID.</font></P><BR>

<P><font face=garamond size=3><Strong><i>Note</i></strong></font></p>
<P><i><font face=garamond size=3>We have arrived at these pointers based on our personal experiences when we were on the look out for jobs. Many of the suggestions have came from helpful seniors who have reviewed resumes of all kinds. However there may be other vital points to note too. Please send us your suggestions and analytical remarks so that we can refine the same in the interest of everyone. We have included a resume format for a Fresher for your reference</font></i></P>
<P><i><A href="search.php?&name=muhammad++naufal&worktype=&year=&company=&branch=&location=&.s=Search" class=slink>  Muhammad Naufal</A> & <A href="search.php?&name=robi++thomas&worktype=&year=&company=&branch=&location=&.s=Search" class=slink> Robi Thomas </A></i></P>
<BR><BR>
</TD>
<TD valign=top width=170 align=center><BR><BR><BR><A href="firstname_surname.rtf" class=slink onclick="NewWindow(this.href,'reports','800','650','yes');return false" ><img src="images/resume.jpg" border=0 ><BR>Fresher Resume for Reference </A><BR><BR>
</TD>
</TR>
<TR>
<TD colspan=2>
      <TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TR>
          <TD align=center height=30 valign=top><A href="disc.htm"><font face=arial size=-1 color="#669999">Disclaimer</font></A> || <A href="sitemap.htm"><font face=arial size=-1 color="#669999">Sitemap</font></A> || <A href="mailto:moderator@xmec.net"><font face=arial size=-1 color="#669999">Comments</font></A></TD>
        </TR>
        <TR>
			<TD align=center height=30 valign=bottom><font face=arial size=-1 color="#999999">Site Powered by &nbsp;<A href="http://www.marlabs.com"><img src="images/marlabs.jpg" border=0 align=absmiddle></A> &nbsp;&copy; Copyright 2001</font></TD>
		</TR>
      </TABLE>
</TD></TR></TABLE> 

</BODY>
</HTML>
