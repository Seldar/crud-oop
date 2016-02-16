<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("includes.php");
include "classes/models/Category.php";
include "classes/controllers/CategoryController.php";
include "classes/models/Game.php";
include "classes/controllers/GameController.php";
$category = new CategoryController();
$category->search();


$game = new GameController();
$game->search();

?>