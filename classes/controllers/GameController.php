<?php
class GameController extends Controller {
	
	public $modelName = "Game";
	
	public function __construct()
	{
		$this->initialize();
	}
	
	public function search()
	{
		
		$result = $this->model->find(
			array(
				 "=" => array("gameId" => 800),
				 "like" => array("title" => "Ya%"),
			 ),
			 array("model" => new Category(),"dir" => "LEFT")
		 );
		 
		 /*$result = $this->model->findOne(
			"800",
			 array("model" => new Category(),"dir" => "LEFT")
		 );*/
			
		return $result;
	}
}
?>