<?php
class CategoryController extends Controller {
	
	public $modelName = "Category";
	
	public function __construct()
	{
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