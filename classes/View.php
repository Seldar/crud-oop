<?php
class View 
{
	function createForm($fields)
	{
		$html =<<<EOT
		<form action="" method="post" enctype="application/x-www-form-urlencoded">
		<table class="tablesorter" cellspacing="1" cellpadding="1" border="1"> 
EOT;
		foreach($fields as $name => $field)
		{
			switch($field['type'])
			{
				case "text":
				$html .=<<<EOT
				<tr><td>{$field['label']}:</td><td><input value="{$field['initial']}" type="text" name="$name" /></td></tr> 
EOT;
				break;
				case "hidden":
				$html .=<<<EOT
				<tr style='display:none'><td colspan=2><input value="{$field['initial']}" type="hidden" name="$name" /></td></tr> 
EOT;
				break;				
				
			}
		}
		$html .= <<<EOT
		<tr>
	<td colspan = "2"><input type="submit" value="Submit" /></td>
</tr>
</table>
EOT;
		return $html;
	}
}
?>