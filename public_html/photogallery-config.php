<?

/* -- User configuration -------------------------------------------------- */

# Strings (internationalize by inserting new items into arrays)

#default language:

$langdefault = "en";

#Enable this if you just want to include gallery page into any 
#other page and then call gallery() when you need it.

$included = 1;

#Languages that gallery page will support 

$languages = array(
	"en" => array(
		"short" => "en", // must be same as array handle!!!
		"full" => "English" 
		),
	"fi" => array(
		"short" => "fi",
		"full" => "Suomi"
		),
	);

#Internationalized strings. Define your's.

# Page title
$header = array(
	"en" => "XMEC Photo Gallery",
	"fi" => "Valokuvia"
	); 

# Help text above the gallery
$help = array(
	"en" => "Click on a thumbnail for a bigger version",
	"fi" => "Napsauta kuvia nähdäksesi ne suurempana"
	);

$backtogallery = array(
	"en" => "Back to the thumbnail view",
	"fi" => "Takaisin pikkukuvanäkymään"
	);

$clickmestr = array(
	"en" => "XMEC Gallery",
	"fi" => "Napsauta kuvia nähdäksesi ne suurempana!"
	);

$pagestr = array(
	"en" => "Page",
	"fi" => "Sivu"
	);

# Tags for the start of a picture-table
$tablestart = "<CENTER><TABLE BORDER=0 CELLSPACING=5 CELLPADDING=7 ALIGN=\"center\"><TR>";
# Number of images per thumbnail page
$defnumber	= 9;

$lines_in_row=3;

# This file, for the link back to the gallery index
$thisfile = "$page.php";

#The directory containing picture directories (thumb&big).
$picdir	= "gallery";

#In which order we sort pictures (valid alternatives are name, date and size)
$sort = "name";

# Directory with thumbnails (relative to $picdir)
$thumbdir = "$picdir/thumbnails";

# Link version, for example, if you want to load images from another site
# for example: $thumbdir_links = "http://somehost.com/my_pictures/$thumbdir";
$thumbdir_links = "$thumbdir";


# Directory with full-sized images (relative to $picdir)
$imgdir = "$picdir/big";

#similary to big pictures
$imgdir_links = "$imgdir";



#don't touch this. This just must be here to define language.
if (! $lang)
	$lang=$langdefault;

# File with picture-info
$infofile = "$picdir/pictureinfo-$lang.txt";

?>
