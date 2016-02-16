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
			 )
		 );
			
		print_r($result);
	}
}
?>