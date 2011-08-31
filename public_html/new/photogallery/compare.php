<?
/***************************************************
Compare functions for files.php and photogallery.php
***************************************************/

function name_cmp($a, $b)
{
	return strcasecmp($a["name"], $b["name"]);
}

function date_cmp($a, $b)
{
	return $a["date"] > $b["date"];
}

function size_cmp($a, $b)
{
	return $a["size"] > $b["size"];
}
function descr_cmp($a, $b)
{
	return strcasecmp($a["descr"], $b["descr"]);
}

function type_cmp($a, $b)
{
	return strcasecmp($a["type"], $b["type"]);
}
?>
