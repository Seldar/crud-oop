<?php 
class Category extends Model {
	public $tableName = "categories";
	public $primaryKey = "categoryId";
	public $joins = array("games" => array("mainCategoryId", "categoryId"));

}
?>