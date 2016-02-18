<?php 
include "header.php";
include "../classes/models/Category.php";
include "../classes/views/CategoryView.php";
include "../classes/controllers/CategoryController.php"; 
$category = new CategoryController();
if(count($_POST) > 0)
$category->formSubmit();
if(isset($_GET['id']))
{
	$category->setInitialValues($_GET['id']);
}
echo $category->prepareForm();
?>