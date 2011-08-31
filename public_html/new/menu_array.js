
//The following line is critical for menu operation, and MUST APPEAR ONLY ONCE. If you have more than one menu_array.js file rem out this line in subsequent files
menunum=0;menus=new Array();_d=document;function addmenu(){menunum++;menus[menunum]=menu;}function dumpmenus(){mt="<script language=javascript>";for(a=1;a<menus.length;a++){mt+=" menu"+a+"=menus["+a+"];"}mt+="<\/script>";_d.write(mt)}
//Please leave the above line intact. The above also needs to be enabled if it not already enabled unless this file is part of a multi pack.



////////////////////////////////////
// Editable properties START here //
////////////////////////////////////

// Special effect string for IE5.5 or above please visit http://www.milonic.co.uk/menu/filters_sample.php for more filters
if(navigator.appVersion.indexOf("MSIE 6.0")>0)
{
	effect = "Fade(duration=0.2);Alpha(style=0,opacity=95);"
}
else
{
	effect = "Shadow(color='#777777', Direction=135, Strength=0)" // Stop IE5.5 bug when using more than one filter
}


timegap=500				// The time delay for menus to remain visible
followspeed=5			// Follow Scrolling speed
followrate=40			// Follow Scrolling Rate
suboffset_top=0;		// Sub menu offset Top position 
suboffset_left=0;		// Sub menu offset Left position

style1=[				// style1 is an array of properties. You can have as many property arrays as you need. This means that menus can have their own style.
"FFFFFF",				// Mouse Off Font Color
"8EBBE6",				// Mouse Off Background Color
"FFFFFF",				// Mouse On Font Color
"0958A3",				// Mouse On Background Color
"FFFFFF",				// Menu Border Color 
12,						// Font Size in pixels
"normal",				// Font Style (italic or normal)
"normal",					// Font Weight (bold or normal)
"Arial, Verdana, Times ",		// Font Name
5,						// Menu Item Padding
,			// Sub Menu Image (Leave this blank if not needed)
,						// 3D Border & Separator bar
"66ffff",				// 3D High Color
"000099",				// 3D Low Color
"0958A3",				// Current Page Item Font Color (leave this blank to disable)
"DBDBDB",					// Current Page Item Background Color (leave this blank to disable)
,						// Top Bar image (Leave this blank to disable)"default/arrowdn.gif"
"ffffff",				// Menu Header Font Color (Leave blank if headers are not needed)
"000099",				// Menu Header Background Color (Leave blank if headers are not needed)
]



addmenu(menu=[		// This is the array that contains your menu properties and details
"mainmenu",			// Menu Name - This is needed in order for the menu to be called
75,					// Menu Top - The Top position of the menu in pixels
325,				// Menu Left - The Left position of the menu in pixels
,					// Menu Width - Menus width in pixels
0,					// Menu Border Width 
,					// Screen Position - here you can use "center;left;right;middle;top;bottom" or a combination of "center:middle"
style1,				// Properties Array - this is set higher up, as above
1,					// Always Visible - allows the menu item to be visible at all time (1=on/0=off)
"left",				// Alignment - sets the menu elements text alignment, values valid here are: left, right or center
effect,				// Filter - Text variable for setting transitional effects on menu activation - see above for more info
,					// Follow Scrolling - Tells the menu item to follow the user down the screen (visible at all times) (1=on/0=off)
1, 					// Horizontal Menu - Tells the menu to become horizontal instead of top to bottom style (1=on/0=off)
0,					// Keep Alive - Keeps the menu visible until the user moves over another menu or clicks elsewhere on the page (1=on/0=off)
,					// Position of TOP sub image left:center:right
,					// Set the Overall Width of Horizontal Menu to 100% and height to the specified amount (Leave blank to disable)
,					// Right To Left - Used in Hebrew for example. (1=on/0=off)
,					// Open the Menus OnClick - leave blank for OnMouseover (1=on/0=off)
,					// ID of the div you want to hide on MouseOver (useful for hiding form elements)
,					// Reserved for future use
,					// Reserved for future use
,					// Reserved for future use
,"&nbsp;&nbsp;About&nbsp;Us","show-menu=aboutsmc",,"About Us",0 // "Description Text", "URL", "Alternate URL", "Status", "Separator Bar"
,"&nbsp;&nbsp;Vision","vision.php",,"Vision",0
,"&nbsp;&nbsp;XMECian","show-menu=xmecian",,"XMECian",0
,"&nbsp;&nbsp;News","show-menu=news",,"News",0
,"&nbsp;&nbsp;Activities","show-menu=activities",,"Activities",0
,"&nbsp;&nbsp;Galleria","show-menu=galleria",,"Galleria",0
,"&nbsp;&nbsp;Members","show-menu=members",,"Members",0
])

	addmenu(menu=["aboutsmc",
	,,110,1,"",style1,,"left",effect,,,,,,,,,,,,
	,"&nbsp;&nbsp;XMEC","/xmec.php",,"XMEC",1
	,"&nbsp;&nbsp;College","/college.php",,"College",1
	,"&nbsp;&nbsp;University","/university.php",,"University",1
	,"&nbsp;&nbsp;Contact Us","/contact.php",,"Contact Us",1
	])


	addmenu(menu=["xmecian",
	,,110,1,"",style1,,"left",effect,,,,,,,,,,,,
	,"&nbsp;&nbsp;Search","/search.php",,"Search",1
	,"&nbsp;&nbsp;Groups","/groups.php",,"Groups",1
	])
	
	
	addmenu(menu=["news",
	,,110,1,"",style1,,"left",effect,,,,,,,,,,,,
	,"&nbsp;&nbsp;XMEC","/xnews.php",,"XMEC News",1
	,"&nbsp;&nbsp;College","/mecnews.php",,"College News",1
	,"&nbsp;&nbsp;Letters","/letters.php",,"Letters",1
	])

	addmenu(menu=["activities",
	,,110,1,"",style1,,"left",effect,,,,,,,,,,,,
	,"&nbsp;&nbsp;College","/colact.php",,"College Activities",1
	,"&nbsp;&nbsp;Chapters","/chapters.php",,"Chapters",1
	,"&nbsp;&nbsp;Careers","/careers.php",,"Careers",1
	])

	addmenu(menu=["galleria",
	,,110,1,"",style1,,"left",effect,,,,,,,,,,,,
	,"&nbsp;&nbsp;Gallery","/gallery.php",,"Gallery",1
	,"&nbsp;&nbsp;Video","/video.php",,"Video",1
	])

	addmenu(menu=["members",
	,,110,1,"",style1,,"left",effect,,,,,,,,,,,,
	,"&nbsp;&nbsp;Calender","/calendar.php",,"Calender",1
	,"&nbsp;&nbsp;Post a Job","/post_job.php",,"Post a Job",1
	,"&nbsp;&nbsp;Discussions ","/phorum/index.php",,"Discussion Board",1
	,"&nbsp;&nbsp;Polls","/polls.php",,"Polls",1
	,"&nbsp;&nbsp;Accounts","/accounts.php",,"Accounts",1
	,"&nbsp;&nbsp;Profile","/editprofile.php",,"Edit Profile",1
	,"&nbsp;&nbsp;Preferences","/preferences.php",,"Edit Preferences",1
	])

dumpmenus()
