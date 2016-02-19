<?php 
class Game extends Model {
	public $tableName = "games";
	public $primaryKey = "gameId";
	public $joinModel = array("Category");
	public $joins = array("categories" => array("categoryId", "mainCategoryId"));

}
?>