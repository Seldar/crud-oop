<?php
class CategoryView extends View
{
	public function formTemplate($formElementHTML)
	{
		$html =<<<EOT
		<form action="" method="post" enctype="application/x-www-form-urlencoded">
		<table class="tablesorter" cellspacing="1" cellpadding="1" border="1"> 
EOT;
		foreach($formElementHTML as $field)
		{
			if($field[0])
			$html .=<<<EOT
				<tr><td>{$field[0]}:</td><td>{$field[1]}</td></tr> 
EOT;
			else
			$html .=<<<EOT
				{$field[1]}
EOT;
		}
		$html .= <<<EOT
		<tr>
	<td colspan = "2"><input type="submit" value="Submit" /></td>
</tr>
</table>
EOT;
		return $html;
	}
	
	public function filterTemplate($formElements)
	{
		$formElementHTML = $this->array2Form($formElements);
		$html =<<<EOT
		<form action="" method="post" enctype="application/x-www-form-urlencoded">
		<table class="tablesorter" cellspacing="1" cellpadding="1" border="1"> 
EOT;
		foreach($formElementHTML as $field)
		{
			if($field[0])
			$html .=<<<EOT
				<tr><td>{$field[0]}:</td><td>{$field[1]}</td></tr> 
EOT;
			else
			$html .=<<<EOT
				{$field[1]}
EOT;
		}
		$html .= <<<EOT
		<tr>
	<td colspan = "2"><input type="submit" value="Filter" /></td>
</tr>
</table>
EOT;
		return $html;
	}
	
	public function indexTemplate($data,$fields)
	{
		$html =<<<EOT
		<table class="tablesorter" cellspacing="1" cellpadding="1" border="1"> 
EOT;
		$html .= "<tr>";
		foreach($fields as $field => $val)
		{
			$html .= "<th>$field</th>";
		}
		$html .= "</tr>";
		foreach($data as $row)
		{
			$html .= "<tr>";
			foreach($fields as $field => $val)
			{
				$html .= "<td>" . $row[$field] . "</td>";
			}	
			$html .= "</tr>";		
		}		
$html .= <<<EOT
</table>
EOT;
		return $html;		
	}
	
}
?>