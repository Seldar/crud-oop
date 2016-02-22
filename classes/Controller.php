<?php
abstract class Controller
{
	public $model;
	public $modelName;
	public $viewName;
	public $formElements;
	
	public function initialize()
	{
		$this->model = new $this->modelName();
		$this->view = new $this->viewName();
	}
		
	public function formSubmit()
	{
		foreach($this->formElements as $name => $field) 
		{
			if(isset($this->model->metaData[$name]))
			{
				if(isset($_POST[$name]))
				$data[$name] = $_POST[$name];
				
				if($field['type'] == "file" && isset($FILE[$name])  && $_FILES[$name]['error'] != 4)
				{
					$uploadFiles[$field['fileType']][$name] = $FILE[$name];
				}
			}
			
		}
		$this->model->save($data);
		$last_id = $_POST[$this->model->primaryKey] ? $_POST[$this->model->primaryKey] : $this->model->db->insert_id;
		if(isset($uploadFiles))
		{
			foreach($uploadFiles as $fileType => $files)
			{
				$FileUpload = new FileUpload($fileType);
				foreach($files as $name => $file)
				{
					$upload = $uploadClass->upload($this->tableName,$name,$last_id);
					if($upload[0])
					{
						$data = array($name => $upload[1],$this->model->primaryKey => $last_id);
						$this->model->save($data);
					}
					else
					$error = $upload[1];					
				}
			}
		}
	}
	
	public function fillOptions()	
	{
		foreach($this->formElements as $name => $field) 
		{
			if($field['type'] == "select")
			{
				$selectHTML = "";
				$selectData = $this->model->joinedTables[$field['optionsFrom']]->find();
				foreach($selectData as $row)
				{
					$selectHTML .= '<option value="' . $row[$this->model->joinedTables[$field['optionsFrom']]->primaryKey] . '" ' . ($field['initial'] == $row[$this->model->joinedTables[$field['optionsFrom']]->primaryKey] ? "selected" : "") . '>' . $row[$this->model->joinedTables[$field['optionsFrom']]->identifier] . '</option>';
					$selectArr[$row[$this->model->joinedTables[$field['optionsFrom']]->primaryKey]] = $row[$this->model->joinedTables[$field['optionsFrom']]->identifier];
				}
				$this->formElements[$name]['options'] = $selectHTML;
				$this->formElements[$name]['optionsArr'] = $selectArr;
			}
		}		
	}
	
	public function prepareForm()
	{
		$this->fillOptions();
		return $this->view->createForm($this->formElements);
	}

	public function createFilter()
	{
		$this->fillOptions();
		$this->setInitialValuesFromForm();		
		return $this->view->filterTemplate($this->formElements);		
	}	
	
	public function createList()
	{
		$where = array();
		if(isset($_POST))
		{
			foreach($_POST as $field => $value)
			{
				if(isset($this->formElements[$field]))
				{
					if($this->formElements[$field]['type'] == "text" || $this->formElements[$field]['type'] == "textarea")
					{
						$where["like"][$field] = "%$value%";
					}
					if($this->formElements[$field]['type'] == "select")
					{
						$where["="][$field] = $value;
					}					
				}
			}
		}
		$data = $this->model->find($where);
		return $this->view->indexTemplate($data,$this->formElements);
	}		
	
	public function setInitialValues($id)
	{
		$row = $this->model->findOne($id);
		foreach($row as $field => $value)
		{
			if(isset($this->formElements[$field]))
			$this->formElements[$field]['initial'] = $value;
		}
	}	
	
	public function setInitialValuesFromForm()
	{
		foreach($_POST as $field => $value)
		{
			if(isset($this->formElements[$field]))
			$this->formElements[$field]['initial'] = $value;
		}
	}	
}
?>