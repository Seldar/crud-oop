<?php
class Controller
{
	public $model;
	public $modelName;
	public $viewName;
	
	public function initialize()
	{
		$this->model = new $this->modelName();
		$this->view = new $this->viewName();
	}
}
?>