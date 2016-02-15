<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("classes/Category.php");
$category = new Category();
$result = $category->find(
	array(
		 "=" => array("categoryId" => 1),
		 "like" => array("categoryName" => "Ak%"),
	 )
 );
	
print_r($result);
?>