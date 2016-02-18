<?php
class CategoryController extends Controller {
	
	public $modelName = "Category";
	public $formElements = array(
									"categoryName" => 
										array("type" => "text","label" => "Category Name","initial" => ""),
									"categoryId"	=>
										array("type" => "hidden","label" => "","initial" => ""),
								);
	
	public function __construct()
	{
		$this->viewName = $this->modelName . "View";
		$this->initialize();
	}
	
	public function search()
	{
		
		$result = $this->model->find(
			array(
				 "=" => array("categoryId" => 1),
				 "like" => array("categoryName" => "Ak%"),
			 )
		 );
			
		return $result;
	}
	
	function prepareForm()
	{
		return $this->view->createForm($this->formElements);
	}
	
	function formSubmit()
	{
		foreach($this->formElements as $name => $field) 
		{
			if(isset($this->model->metaData[$name]))
			$data[$name] = $_POST[$name];
		}
		$this->model->save($data);
		
	}	
	
	function setInitialValues($id)
	{
		$row = $this->model->findOne($id);
		foreach($row as $field => $value)
		{
			if(isset($this->formElements[$field]))
			$this->formElements[$field]['initial'] = $value;
		}
	}
}
?>