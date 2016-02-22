<?php
require_once(dirname(__FILE__) . "/../models/Game.php");
require_once(dirname(__FILE__) . "/../views/GameView.php");
class GameController extends Controller {
	
	public $modelName = "Game";
	public $formElements = array(
									"gameId"	=>
										array("type" => "hidden","label" => "","initial" => ""),
									"title" => 
										array("type" => "text","label" => "Game Title","initial" => ""),
									"description" => 
										array("type" => "textarea","label" => "Game Description","initial" => ""),
									"thumbnail" => 
										array("type" => "file","label" => "Thumbnail","initial" => "","fileType" => "image"),
									"mainCategoryId" => 
										array("type" => "select","label" => "Category","initial" => "","options" => "","optionsFrom" => "Category"),
								);
									
	public function __construct()
	{
		$this->viewName = $this->modelName . "View";
		$this->initialize();		
	}

}
?>