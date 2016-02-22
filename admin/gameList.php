<?php 
include "header.php";
require_once "../classes/controllers/CategoryController.php"; 
require_once "../classes/controllers/GameController.php"; 
$game = new GameController();
echo $game->createFilter();
echo $game->createList();
?>