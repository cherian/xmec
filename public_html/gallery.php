<?php
$secure_page=0;
$this_page = "gallery";
include 'header.php';
?>
<?php

$page="gallery";

require("photogallery.php");



gallery(); 

?>

<?php
include 'footer.php';
?>
