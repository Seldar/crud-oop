<?php
abstract class Model {
	public $primaryKey;
	public $tableName;
	public $metaData;
	
	function __construct()
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
		}
		
	}
	
	function findOne($id) {
		$query = "SELECT * FROM " . $this->tableName . " WHERE " . $this->primaryKey . " = ?";
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

	function find($where = null) {
		$data = array();
		$types = "";
		$query = "SELECT * FROM " . $this->tableName;
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
		foreach($data as $key => $val)
		{
			$ext[] = $key . " = '" . $val . "'";
		}
		$query = "INSERT INTO " . $this->tableName . " SET " . implode(",",$ext);
		$result = $this->db->query($query);
		return $result;
	}
	function remove($id) {
		$query = "DELETE FROM " . $this->tableName . " WHERE " . $this->primaryKey . " = '" . $id . "'";
		$result =$this->db->query($query);
		return $result;		
	}
	function update($data, $where = null) {
		foreach($data as $key => $val)
		{
			$ext[] = $key . " = '" . $val . "'";
		}
		$query = "UPDATE " . $this->tableName . " SET " . implode(",",$ext);
		if($where)
		$query .= " WHERE " . $where;
		$result = $this->db->query($query);
		return $result;		
	}
}
?>