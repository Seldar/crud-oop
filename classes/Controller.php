<?php
class Controller
{
	public $model;
	public $modelName;
	
	public function initialize()
	{
		$this->model = new $this->modelName();
	}
}
?>