<?php 
class Game extends Model {
	public $tableName = "games";
	public $primaryKey = "gameId";
	public $joins = array("categories" => array("categoryId", "mainCategoryId"));

}
?>