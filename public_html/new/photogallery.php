<?php 

/*
	Script by Tuomas Airaksinen <tuomas.airaksinen@tuma.stc.cx>
				and Maarten den Braber <mdb@twister.cx>
	
	Ideas from imgconvert.sh by Garrett LeSage <garrett@linux.com>

	Published under GNU General Public Licence (GPL)
	You should get whole license information in COPYING
	file distributed with this file. For more information
	see http://www.gnu.org */

$version = "v1.1.5";

/*
	See http://tuma.stc.cx/gallery.php for more info
*/

require("photogallery-config.php");
require("compare.php");

# we make an array which contains list of images (-> sorting)	
$othumbdir = dir($thumbdir);
$pictures = array();

while($entry = $othumbdir->read())
{
	if(is_file("$thumbdir/$entry") && is_readable("$thumbdir/$entry"))
	{
		array_push($pictures, array("name" => $entry,
																 "date" => filemtime("$thumbdir/$entry"),
																 "size" => filesize("$thumbdir/$entry")));
	}
}
$othumbdir->close();
#then we can sort information as ordered
if(! $sort)
	$sort = "name";

usort($pictures, $sort . "_cmp");	

if (! $included )
{
	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n";
	echo "<HTML><HEAD><TITLE>Photogallery</TITLE></HEAD><BODY>\n";
}

if (! $number)
	$number = $defnumber;

if (! $pagenum)
	$pagenum = 1;


/* Some helper functions */

function get_pictinfo($picture)
{
	global $infofile;
	# Read the infofile

	$fp=fopen($infofile,"r");
	$contents=fread($fp, filesize($infofile));
	fclose($fp);
	$start = strpos($contents,$picture) + strlen($picture);
	$tmpstr = substr($contents,$start,strlen($contents));
	$stop = strpos($tmpstr, "\n");
	$pictinfo = substr($contents,$start,$stop);

	return $pictinfo;
}

/*function num2picture($num)
{
	global $thumbdir;
	$othumbdir = dir($thumbdir);
	for($count=0; $count<=($num+1); $count++)
	{
		$entry=$othumbdir->read();
	}
	
	$othumbdir->close;
	return $entry;
}

function picture2num($picture)
{
	global $thumbdir;
	$count = 0;
	
	$othumbdir = dir($thumbdir);

	while($entry=$othumbdir->read())
	{
		$count++;
		if($entry == $picture)
			break;
	}
	$othumbdir->close;
	return $count - 2; // we don't count . and .. (which are first)
}
*/
function num2picture($num)
{
	global $pictures;
  reset($pictures);
  $num--;
	for($count=0; $count<=($num); $count++)
	{
		list(, $entry) = each($pictures);
	}
  return $entry["name"];
}

function picture2num($picture)
{
	global $pictures;
  reset($pictures);
	$count = 0;  
  
  foreach($pictures as $entry)
  {
		$count++;
		if($entry["name"] == $picture)
			break;
	}
	return $count; 
}
/*echo "picture2num(0,1,2)" . picture2num(num2picture(1)) . picture2num(num2picture(2)) . picture2num(num2picture(3)) . "\n";
echo "num2picture(0,1,2)" . num2picture(1) . num2picture(2)
  . num2picture(3) . "\n";*/

/* -- Gallery function ---------------------------------------------------- */

function thumbnails() 
{
	global  $number, $pagenum, $languages, $thumbdir_links, $imgdir_links, $thumbdir, 
          $imgdir, $othumbdir, $oimgdir, $thisfile, $help, $backtogallery, $header, $lang, 
          $tablestart, $lines_in_row, $pagestr, $included, $pictures,
          $clickmestr;

	# Define the next and previous pages
	$prev  = $pagenum - 1;
	$next  = $pagenum + 1;

	# Pages start with 0, but we start with 1 so substract 1
//	$pagenum--;

	# Define when a new page starts
	$start = ($pagenum - 1) * $number + 1;
	$stop = $start + $number;
	
// echo "DEBUG: number: $number, start: $start, stop: $stop\n total: " . ($stop - $start) . "\n";

	# Print language selector
	if (! $included )
	{	
		echo "<CENTER>Choose language: ";

		foreach($languages as $this)
		{	
			if ($lang == $this["short"])
				echo "[" . $this["full"] . "]";
			else
				echo "<A HREF=\"$thisfile?lang=" . $this["short"] . 
					"&action=gallery&pagenum=$pagenum\">[" . $this["full"] . "]</A> ";
		}
		echo "</CENTER>";
		echo "<H1>" . $header[$lang] . " - " . $pagestr[$lang] . " $pagenum</H1>\n";
		echo $help[$lang] . "<BR>\n\n";
	}	
	$total = 0;
  
  echo "<BR><CENTER><B class=head>" . $clickmestr[$lang] . "</B></CENTER>";
  
  # Loop through all the images in the directory
	foreach($pictures as $this)
	{
    $entry = $this["name"];
		$total++;

		if(is_file("$thumbdir/$entry") && is_readable("$thumbdir/$entry"))
		{
			$count = picture2num($entry);
			/*
			echo " DEBUG: count: $count start: $start, stop: $stop, tulos: " . 
					($count < $stop && $count >= $start) . "\n";
			*/
			if($count < $stop && $count >= $start)
			{
				$newline = $count - $start;
				$countloop++;

				if ($newline == 0 || $countloop == $lines_in_row)
				{
					$countloop=0;
					if ($newline < ($lines_in_row - 1)) 
					{
						echo "$tablestart\n";
					}
					else
					{
						echo "</TR><TR>\n";
					}
				}
		
				echo "<TD class=body><P ALIGN=\"center\">";
				echo "<B>$count. </B><SMALL>" . get_pictinfo($entry) . "</SMALL><BR>";
#				echo "$imgdir/$entry\n";
        if(is_file("$imgdir/$entry"))
				{
					echo "<A class=link  HREF=\"" . $thisfile . "?action=full&picture=$entry&lang=$lang\">" . 
						"<IMG BORDER=1 SRC=\"$thumbdir_links/$entry\"></A>";
					echo "<BR></TD>\n";
				}
				else
				{
					echo "<IMG BORDER=1 SRC=\"$thumbdir_links/$entry\">";
					echo "<BR></TD>\n";
				}
				$count++;
			}
		}
	}

	echo "</TD></TR></TABLE>\n<CENTER>";

	$gallery_prev  = "<A class=link HREF=\"$thisfile?action=gallery&pagenum=$prev&number=$number&lang=$lang\">" .
											"<img src=images/back.gif border=0></A>";
	$gallery_next  = "<A class=link HREF=\"$thisfile?action=gallery&pagenum=$next&number=$number&lang=$lang\">" .
											"<img src=images/next.gif border=0></A></CENTER>";
	
	$totalpages = ceil($total / $number); 
	$gallery_pages = 1;

	while ( $totalpages >= $gallery_pages )
	{
		if ($gallery_pages == $pagenum)
			$gallery_number = "$gallery_number$gallery_pages&nbsp;&nbsp;\n";
		else
			$gallery_number = "$gallery_number<A class=link HREF=\"$thisfile?action=gallery&pagenum=" 
				. "$gallery_pages&number=$number&lang=$lang\">$gallery_pages</A>&nbsp;&nbsp;\n";
		$gallery_pages++;
	}

	if ( $pagenum == 1 )
	{
		$gallery_prev = "<img src=images/back.gif border=0>";
	}

	if ( $pagenum == $totalpages )
	{
		$gallery_next = "<img src=images/next.gif border=0>";
	}

	echo "\n<P class=body>\n\n";
	echo "$gallery_prev\n&nbsp;&nbsp;&nbsp;\n\n";
	echo "<B>" . $pagestr[$lang] . ":</B>\n\n&nbsp;$gallery_number\n";
	echo "&nbsp;&nbsp;&nbsp;\n$gallery_next\n"; 

}

/* -- Show full size picture -------------------------------------- */

function fullsize() 
{

	global $picture, $infofile, $languages, $thumbdir, $imgdir,
          $thumbdir_links, $imgdir_links, $othumbdir, 
					$oimgdir, $thisfile, $help, $backtogallery, $lang, 
					$tablestart,$number, $included;
	
	# Find previous and next
	$current = picture2num($picture);

	$count = picture2num("dontfindme.xyz") - 2 ;

	$prev = num2picture($current - 1);
	$next = num2picture($current + 1);


	$pagenum = ceil($current / $number);

	echo "<CENTER><H1><B>$current.</B> " . get_pictinfo($picture) . "</H1>\n";

	$thumb_prev  = "<A HREF=\"$thisfile?action=full&picture=$prev&lang=$lang\">" . 
										"<img src=images/back.gif border=0></a>&nbsp;&nbsp;&nbsp;";
	$thumb_index = "<A class=link HREF=\"$thisfile?action=gallery&number=$number&pagenum=$pagenum&lang=$lang\">"
								 . "<B>" . $backtogallery[$lang] .  "</B></A>";
	$thumb_next  =  "&nbsp;&nbsp;&nbsp;<A HREF=\" $thisfile?action=full&picture=$next&lang=$lang\">" 
								 .	"<img src=images/next.gif border=0></A>\n";
		
	if ($current == 1)
	{
		$thumb_prev = "<img src=images/next.gif border=0>&nbsp;&nbsp;&nbsp;";
	}

	if ($next == "")
	{
		$thumb_next = "&nbsp;&nbsp&nbsp;<img src=images/next.gif border=0>";
	}
		
	$browsestr = "$thumb_prev $thumb_index $thumb_next";
		
	echo "<P class=body>$browsestr<BR><BR>\n";
	if(is_file("$imgdir/$picture"))
    echo "<IMG BORDER=1 SRC=\"$imgdir_links/$picture\"><BR>\n";
  else
  {
    user_error("[no fullsized-image for this image, showing thumbnail instead]", E_USER_WARNING);
    echo "<IMG BORDER=1 SRC=\"$thumbdir_links/$picture\"><BR>\n";
  } 
	echo "<P class=body>$browsestr\n";

}

/* -- Switches ------------------------------------------------------------ */

function gallery()
{
	global $version, $action, $oimgdir, $othumbdir, $imgdir_links,
          $thumbdir_links, $imgdir, $thumbdir;
	$othumbdir	= dir($thumbdir);
	$oimgdir	= dir($imgdir);
	switch($action) 
	{
		case "gallery" :
			thumbnails();
			break;
		case "full" :
			fullsize();
			break;
		default :
			thumbnails();
			break;
	}
	//echo "<BR><BR><SMALL>Generated by " .
		"<A HREF=\"http://tuma.stc.cx/gallery.php\">photogallery script</A> $version.</SMALL></CENTER>";
	$othumbdir->close();
	$oimgdir->close();
}

if(! $included)
{	
	gallery();
	echo "</BODY></HTML>";
}
?>
