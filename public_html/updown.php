<?php
$secure_page=1;
$this_page="updown";
include 'header.php';
?>
<?php
	if (! XMEC::authenticate_user()) {
		echo "<html><h1>Please login to access this page<html>";
		exit ;
	}
	$me =& XMEC::getUser();

	if (!$me->isAdmin()) {
		echo "<html><h1>Not authorized !!</html>";
		exit ;
	}
?>
<?
$extlimit = "yes"; //Do you want to limit the extensions of files uploaded
$limitedext = array(".gif",".jpg",".png",".jpeg",".php"); //Extensions you want files uploaded limited to.
$sizelimit = "no"; //Do you want a size limit, yes or no?
$sizebytes = "200000"; //size limit in bytes
$dl = "http://www.xmec.net/downloads"; //url where files are uploaded
$absolute_path = "/usr163/home/x/m/xmec/public_html/downloads"; //Absolute path to where files are uploaded
$websiteurl = "http://www.xmec.net"; //Url to you website
$websitename = "XMEC";

switch($action) {
default:
echo"
<html>
<head>
<title>Upload Or Download</title>
</head>
<body>
<a href=$PHP_SELF?action=upload>Upload File</a>
 <a href=$PHP_SELF?action=download>Download File</a>
 <a href=$websiteurl>Return to $websitename</a>
<br><br>
Powered by <a href=http://www.zachwhite.com/>PHP Uploader Downloader</a>
</body>
</html>";
break;
case "download":
echo "
<html>
<head>
<title>File Download</title>
</head>
<body><a href=$PHP_SELF?action=upload>Upload File</a> <a href=$websiteurl>Return to $websitename</a>";
$list = "<table width=700 border=1 bordercolor=#000000 style=\"border-collapse: collapse\">";
$list .= "<tr><td width=700><center><b>Click To Download</b></center></td></tr>";
$dir = opendir($absolute_path);
while($file = readdir($dir)) {
if (($file != "..") and ($file != ".")) {
//Download files with spaces fix by Kokesh
$list .= "<tr><td width=700><a href='$dl/$file'>$file</a></center></td></tr>";
}
}
$list .= "</table>";
echo $list;
echo"
<br><br>
Powered by <a href=http://www.zachwhite.com/>PHP Uploader Downloader</a>
</body>
</html>";
break;

case "upload":
echo"
<html>

<head>
<title>File Upload</title>
</head>

<body>

<form method=POST action=$PHP_SELF?action=doupload enctype=multipart/form-data>
<p>File to upload:<br>
<input type=file name=file size=30>
<p><button name=submit type=submit>
Upload
</button>
</form>
<br><br>
Powered by <a href=http://www.zachwhite.com/>PHP Uploader Downloader</a>
</body>

</html>";
break;


//File Upload
case "doupload":
$dir = "dir";
if ($file != "") {

if (file_exists("$absolute_path/$file_name")) {
die("File already exists");
}

if (($sizelimit == "yes") && ($file_size > $sizebytes)) {
die("File is to big. It must be $sizebytes bytes or less.");
}

$ext = strrchr($file_name,'.');
if (($extlimit == "yes") && (!in_array($ext,$limitedext))) {
die("The file you are uploading doesn't have the correct extension.");
}

@copy($file, "$absolute_path/$file_name") or die("The file you are trying to upload couldn't be copied to the server");

} else {
die("Must select file to upload");
}
echo "
<html>
<head>
<title>File Uploaded</title>
</head>
<body>";
echo $file_name." was uploaded";
echo "<br>
<a href=$PHP_SELF?action=upload>Upload Another File</a>
<a href=$PHP_SELF?action=download> Download File</a>
<a href=$websiteurl> Return to $websitename</a><br><br>
Powered by <a href=http://www.zachwhite.com/>PHP Uploader Downloader</a>
</body>
</html>";
break;

}
?>
<?php
include 'footer.php';
?>
