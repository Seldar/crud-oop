<?php 
class Category extends Model {
	public $tableName = "categories";
	public $primaryKey = "categoryId";
	public $joinModel = array("Game");
	public $joins = array("games" => array("mainCategoryId", "categoryId"));

}
?>