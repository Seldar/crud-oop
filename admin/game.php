<?php 
include "header.php";
include "../classes/controllers/GameController.php"; 
include "../classes/controllers/CategoryController.php"; 
$game = new GameController();

if(count($_POST) > 0)
	$game->formSubmit();
if(isset($_GET['id']))
	$game->setInitialValues($_GET['id']);

echo $game->prepareForm();
?>