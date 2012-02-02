<?php
	include('SimpleImage.php');
        include 'xmec.inc';
        include 'header.php';

       if (! XMEC::authenticate_user()) {
                echo "<html><h2>Please login to access this page<html>";
                exit ;
        }
	$res = & XMEC::getUser(); 

	$img="profile/thumbnails/".str_replace("/","_",$res->get('id')).".jpg";
?>
CURRENT IMAGE:<br>
<img src=<?
if (file_exists($img) )echo $img."?r=".rand();
else
echo "profile/thumbnails/default.jpg";
?>>
<br>
Upload New Image
<?

echo $img ;
 if( isset($_POST['submit']) && $_FILES['uploaded_image']['tmp_name']!="") {
echo $img ;
      $image = new SimpleImage();
      $image->load($_FILES['uploaded_image']['tmp_name']);
      $image->resizethumbnail();
      $image->save($img);
   } else {
 
?>
 
   <form action="image.php" method="post" enctype="multipart/form-data">
      <input type="file" name="uploaded_image" />
 
      <input type="submit" name="submit" value="Upload" />
 
   </form>
 
<?php
   }

?>

