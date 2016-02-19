<?php
abstract class View 
{
	public function createForm($fields)
	{

		foreach($fields as $name => $field)
		{
			switch($field['type'])
			{
				case "text":
				$input =<<<EOT
				<input value="{$field['initial']}" type="text" name="$name" />
EOT;
				$label = $field['label'];
				break;
				case "hidden":
				$input =<<<EOT
				<input value="{$field['initial']}" type="hidden" name="$name" />
EOT;
				$label = $field['label'];
				break;
				case "select":
				$input =<<<EOT
				<select name="$name">
				<option value=""> - Select - </option>
				{$field['options']}
				</select>
EOT;
				$label = $field['label'];
				break;
				case "file":
				$input =<<<EOT
				<input type="file" name="$name" />{$field['initial']}
EOT;
				$label = $field['label'];
				break;	
				case "textarea":
				$input =<<<EOT
				<textarea name="$name">{$field['initial']}</textarea>
EOT;
				$label = $field['label'];
				break;			
				
			}
			$formElementHTML[] = array($label,$input);
		}
		return $this->formTemplate($formElementHTML);

	}	
}
?>