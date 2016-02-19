<?php 
include "header.php";
require_once "../classes/controllers/CategoryController.php"; 
require_once "../classes/controllers/GameController.php"; 
$category = new CategoryController();

if(count($_POST) > 0)
	$category->formSubmit();
if(isset($_GET['id']))
	$category->setInitialValues($_GET['id']);

echo $category->prepareForm();
?>