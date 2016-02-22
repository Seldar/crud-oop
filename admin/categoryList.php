<?php 
include "header.php";
require_once "../classes/controllers/CategoryController.php"; 
require_once "../classes/controllers/GameController.php"; 
$category = new CategoryController();
echo $category->createFilter();
echo $category->createList();
?>