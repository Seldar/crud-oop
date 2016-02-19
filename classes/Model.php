<?php
abstract class Model {
	public $primaryKey;
	public $tableName;
	public $metaData;
	public $joinedTables;
	
	function __construct($noNesting=0)
	{
		$this->db = Database::initialize();
		$query = "SHOW FIELDS FROM " . $this->tableName;
		$result = $this->db->query($query);
		while($row = $result->fetch_assoc())
		{
			if(strpos($row['Type'],"int") > -1)
			$this->metaData[$row['Field']] = "i";
			else if(strpos($row['Type'],"char") > -1 || strpos($row['Type'],"text") > -1 || strpos($row['Type'],"enum") > -1)
			$this->metaData[$row['Field']] = "s";
			else if(strpos($row['Type'],"double") > -1 || strpos($row['Type'],"float") > -1)
			$this->metaData[$row['Field']] = "d";
			else if(strpos($row['Type'],"blob") > -1)
			$this->metaData[$row['Field']] = "b";
			else
			$this->metaData[$row['Field']] = "";
		}
		if(isset($this->joinModel) && !$noNesting)
		{
			foreach($this->joinModel as $model)
			{
				$this->joinedTables[$model] = new $model(1);
			}
		}
		
	}
	
	function findOne($id, $join = null) {
		$table = $this->tableName;
		
		if(count($join) > 0)
		{
			$table .= " " . $join['dir'] . " JOIN " . $join['model']->tableName . " ON " . $this->tableName . "." . $join['model']->joins[$this->tableName][0] . " = " . $join['model']->tableName . "." . $join['model']->joins[$this->tableName][1];
		}
		
		$query = "SELECT * FROM " . $table . " WHERE " . $this->primaryKey . " = ?";
		$statement = $this->db->prepare($query);
		$statement->bind_param($this->metaData[$this->primaryKey], $id);
		$statement->execute();
		
		$meta = $statement->result_metadata(); 
		while ($field = $meta->fetch_field()) 
		{ 
			$params[] = &$row[$field->name]; 
		}		
		call_user_func_array(array($statement, 'bind_result'), $params); 

		$statement->fetch();
		
        foreach($row as $key => $val) 
        { 
            $result[$key] = $val; 
        }
		
		return $result;
	}

	function find($where = null, $join = null) {
		$data = array();
		$types = "";
		
		$table = $this->tableName;
		if(count($join) > 0)
		{
			$table .= " " . $join['dir'] . " JOIN " . $join['model']->tableName . " ON " . $this->tableName . "." . $join['model']->joins[$this->tableName][0] . " = " . $join['model']->tableName . "." . $join['model']->joins[$this->tableName][1];
		}
				
		$query = "SELECT * FROM " . $table;
		if(count($where) > 0)
		{
			$query .= " WHERE ";
			foreach($where as $operator => $condition)
			{
				foreach($condition as $attribute => $value)
				{
					$params[] = $value;
					$queryParts[] = $attribute . " " . $operator . " ?";
					$types .= $this->metaData[$attribute];
				}
			}
			$query .= implode(" AND ", $queryParts);
			
			$statement = $this->db->prepare($query);
			
			array_unshift($params,$types);
		    foreach($params as $key => $value)
	        {
				$refs[$key] = &$params[$key];
			}
			call_user_func_array(array($statement, 'bind_param'), $refs); 			
		}
		else
		$statement = $this->db->prepare($query);

		$statement->execute();
		
		$meta = $statement->result_metadata(); 
		while ($field = $meta->fetch_field()) 
		{ 
			$args[] = &$row[$field->name]; 
		}		
		call_user_func_array(array($statement, 'bind_result'), $args); 

		while($statement->fetch())
		{
			foreach($row as $key => $val) 
			{ 
				$result[$key] = $val; 
			}
			$data[] = $result;
		}
		return $data;		
	}
	function add($data) {
		$types = "";
		foreach($data as $key => $val)
		{
			$ext[] = $key . " = ?";
			$params[] = $val;
			$types .= $this->metaData[$key];
		}
		$query = "INSERT INTO " . $this->tableName . " SET " . implode(",",$ext);			
		$statement = $this->db->prepare($query);
		array_unshift($params,$types);
		foreach($params as $key => $value)
		{
			$refs[$key] = &$params[$key];
		}
		call_user_func_array(array($statement, 'bind_param'), $refs); 				
		
		$result = $statement->execute();
		return $result;
	}
	function remove($id) {
		$query = "DELETE FROM " . $this->tableName . " WHERE " . $this->primaryKey . " = ?";
		$statement = $this->db->prepare($query);
		$statement->bind_param($this->metaData[$this->primaryKey], $id);
		
		$result = $statement->execute();
		return $result;		
	}
	function save($data, $where = null) {
		$types = "";
		if(!$data[$this->primaryKey])
		return $this->add($data);
		else
		$where["="][$this->primaryKey] = $data[$this->primaryKey];

		foreach($data as $key => $val)
		{
			$ext[] = $key . " = ?";
			$params[] = $val;
			$types .= $this->metaData[$key];
		}
		$query = "UPDATE " . $this->tableName . " SET " . implode(",",$ext);
								
		if(count($where) > 0)
		{
			$query .= " WHERE ";

			foreach($where as $operator => $condition)
			{
				foreach($condition as $attribute => $value)
				{
					$params[] = $value;
					$queryParts[] = $attribute . " " . $operator . " ?";
					$types .= $this->metaData[$attribute];
				}
			}
			$query .= implode(" AND ", $queryParts);

			$statement = $this->db->prepare($query);
			
			array_unshift($params,$types);
		    foreach($params as $key => $value)
	        {
				$refs[$key] = &$params[$key];
			}
			call_user_func_array(array($statement, 'bind_param'), $refs); 			
		}
		else
		$statement = $this->db->prepare($query);

		$result = $statement->execute();
		return $result;

	}
}
?>