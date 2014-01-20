<?php

class form {
	
	protected $fields;
	protected $selects;
	protected $values;
	protected $types;

	function __contruct()
	{
		;
	}

	function add($type,$name,$value,$id = null, $validation = null)
	{
		$campo = array();
		$campo['type'] = $type;
		$campo['name'] = $name;
		$campo['value'] = $value;

		if(isset($id))
		{
			$campo['id'] = $id;
		}
		if(isset($validation))
		{
			$campo['validation'] = $validation;
		}

		$this.fields[] = $campo;
	}

	function add_select($name,$options,$id = null)
	{
		$campo = array();
		$campo['type'] = 'select';
		$campo['name'] = $name;
		$campo['options'] = $options;
		if(isset($id))
		{
			$campo['id'] = $id;
		}
		$this->selects[] = $campo;
	}
}


?>