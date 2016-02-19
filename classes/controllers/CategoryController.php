<?php
require_once(dirname(__FILE__) . "/../models/Category.php");
require_once(dirname(__FILE__) . "/../views/CategoryView.php");
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
	

}
?>