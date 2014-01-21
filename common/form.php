<?php

// TODO campi piu' generali, migliore metodo di aggiunta opzioni

class input{

	protected $name;
	protected $id;
	protected $type;
	protected $value;
	protected $class;
	protected $legend;
	protected $options = array();
	protected $js = array();

	function __construct($type,$name,$value = '')
	{
		$this->type = $type;
		$this->name = $name;
		$this->value = $value;
	}

	function set_id($id)
	{
		$this->id = $id;
	}

	function add_js($js)
	{
		$this->js[] = $js;
	}

	function set_options($options)
	{
		$this->options = $options;
	}

	function set_legend($legend)
	{
		$this->legend = $legend;
	}

	function to_html()
	{
		switch ($this->type)
		{
			
			case 'text':
			case 'password':

				$r = (isset($this->legend)) ? '<legend>'. $this->legend . '</legend>' : '';
				$r.= '<input type = "'.$this->type.'" name="'.$this->name.'" value="'.$this->value.'"';
				$r.= ' id = ' .$this->id;
				foreach ($this->js as $js)
				{
					$r.= ' ' . $js[0] .'=' . $js[1] . ';return false;" ';
				}
				$r.=' />';
				$r.='<div id = "errori-'.$this->id.'"></div>';
				break;
			
			case 'select':
				$r = '<select name ="'.$this->name.'" id="'.$this->id.'">';
					foreach($this->options as $value => $name)
					{
						$r .= '<option value ="'.$value.'" ';
						if($this->value == $value)
						{
							$r.= ' selected';
						}
						$r .='>'.$name.'</option>';
					}
				$r .= '</select>';
				break;
			case 'textarea':
				$r = '<textarea name="'.$this->name.'" id="'.$this->id.'" >'.$this->value.'</textarea>';
				break;
			case 'submit':
				$r = '<input type = "submit" name ="'.$this->name.'" value="'.$this->value.'"';
				foreach($this->js as $js)
				{
					$r.= ' ' . $js[0] .'=' . $js[1] . ';return false;" ';
				}
				$r.=' />';
				break;
			default:
				$r = 'Strano input field';
				break;
		}

		return $r;
	}
}


class form {
	
	protected $fields;
	protected $action;
	protected $method;
	protected $type;
	protected $name;
	protected $id;

	function __construct($name = null, $action = null, $method = null, $type = null)
	{
		$this->name = $name;
		$this->action = $action;
		$this->method = ( null == $method ) ? 'POST' : $method;
		$this->type = ( null == $type ) ? 'application/x-www-form-urlencoded' : $type;
	}

	function set_type($type)
	{
		$this->type = $type;
	}

	function set_action($action)
	{
		$this->action = $action;
	}

	function set_method($method)
	{
		$this->method = $method;
	}

	function set_id($id)
	{
		$this->id = $id;
	}

	function set_name($name)
	{
		$this->name = $name;
	}

	function add($field)
	{
		$this->fields[] = $field;
	}

	function to_html()
	{
		$r = '<div id="errori-form-'.$this->id.'"></div>'
			.'<form name="'.$this->name .'" method="'.$this->method
			.'" action="'.$this->action.'" type="'.$this->type.'" id="'.$this->id.'">';
		foreach($this->fields as $field)
		{
			$r.= $field->to_html();
		}

		$r.= '</form>';

		return $r;
	}
}


?>