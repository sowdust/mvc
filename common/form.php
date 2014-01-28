<?php

// TODO campi piu' generali, migliore metodo di aggiunta opzioni

class input{

	protected $name;
	protected $id;
	protected $type;
	protected $value;
	protected $class;
	protected $legend;
	protected $readonly = false;
	protected $options = array();
	protected $js = array();
	protected $checks = array();
	protected $rows;
	protected $cols;
	protected $obbligatorio = false;

	function __construct($type,$name,$value = '')
	{
		$this->type = $type;
		$this->name = $name;
		$this->value = $value;
	}

	function set_row_col($row,$col)
	{
		$this->rows = $row;
		$this->cols = $col;
	}

	function set_value($value)
	{
		$this->value = $value;
	}

	function set_readonly($bool)
	{
		$this->readonly = $bool;
	}

	function set_id($id)
	{
		$this->id = $id;
	}

	function add_js($js)
	{
		$this->js[] = $js;
		$this->checks[] = $js[1];
	}

	function get_checks()
	{
		return $this->checks;
	}

	function set_options($options)
	{
		$this->options = $options;
	}

	function set_legend($legend)
	{
		$this->legend = $legend;
	}

	function set_obbligatorio()
	{
		$this->obbligatorio = true;
	}

	function set_class($class)
	{
		$this->class = $class;
	}

	function get_name()
	{
		return $this->name;
	}

	function get_id()
	{
		return $this->id;
	}

	function get_obbligatorio()
	{
		return $this->obbligatorio;
	}

	function to_html()
	{
		switch ($this->type)
		{
			
			//	TEXT E PASSWORD
			case 'text':
			case 'password':
			case 'file':

				$r = (isset($this->legend)) ? '<legend for="'.$this->name.'">'. $this->legend . '</legend>' : '';
				$r.= '<input type = "'.$this->type.'" name="'.$this->name.'" value="'.$this->value.'"';
				$r.= ' id = "' .$this->id.'" class = "' .$this->class.'"';
				foreach ($this->js as $js)
				{
					$r.= ' ' . $js[0] .' = "' . $js[1] . ';return false;" ';
				}
				if($this->readonly)
				{
					$r.= ' READONLY';
				}
				$r.=' />';
				$r.='<div id = "errori-'.$this->id.'"></div>';
				break;

			//	SELECT
			case 'select':
				$r = (isset($this->legend)) ? '<legend for="'.$this->name.'">'. $this->legend . '</legend>' : '';
				$r.= '<select name ="'.$this->name.'" id="'.$this->id.'">';
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
			
			//	TEXTAREA
			case 'textarea':
				$r = (isset($this->legend)) ? '<legend for="'.$this->name.'">'. $this->legend . '</legend>' : '';
				$r.= '<textarea name="'.$this->name.'" id="'.$this->id;
				if($this->readonly)
				{
					$r.= ' READONLY';
				}
				foreach ($this->js as $js)
				{
					$r.= ' ' . $js[0] .' = "' . $js[1] . ';return false;" ';
				}
				$r.= (isset($this->rows) && isset($this->cols)) ? ' rows="'.$this->rows.'" cols="'.$this->cols.'"' : '';

				$r.='" >'.$this->value.'</textarea>';
				break;
			

			//	BOTTONE INVIO
			case 'submit':
				$r = '<input type = "submit" name ="'.$this->name.'" value="'.$this->value.'"';
				foreach($this->js as $js)
				{
					$r.= ' ' . $js[0] .'=' . $js[1] . ';return false;" ';
				}
				$r.=' />';
				break;


			//	FILE UPLOAD
			case 'file':

				$r = (isset($this->legend)) ? '<legend for="'.$this->name.'">'. $this->legend . '</legend>' : '';
				$r.= '<input type = "'.$this->type.'" name="'.$this->name.'" value="'.$this->value.'"';
				$r.= ' id = "' .$this->id.'" class = "' .$this->class.'"';
				foreach ($this->js as $js)
				{
					$r.= ' ' . $js[0] .' = "' . $js[1] . ';return false;" ';
				}
				if($this->readonly)
				{
					$r.= ' READONLY';
				}
				$r.=' />';
				$r.='<div id = "errori-'.$this->id.'"></div>';
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
	protected $obbligatori = array();

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

	function add($field,$obbligatorio = false)
	{
		if($obbligatorio)
		{
			$this->obbligatori[] = $field->get_name();
			$field->set_obbligatorio();
		}
		$this->fields[] = $field;
	}

	function to_html()
	{
		$r = ($this->checks_to_js() ) ? $this->checks_to_js() : '' ;
		
		$r.= '<div id="errori-form-'.$this->id.'"></div>'
			.'<form name="'.$this->name .'" method="'.$this->method
			.'" action="'.$this->action.'" enctype="'.$this->type.'" id="'.$this->id.'" onsubmit="return valida_tutto(this,lista_elementi,obbligatori);">';
		foreach($this->fields as $field)
		{
			$r.= $field->to_html();
		}

		$r.= '</form>';

		return $r;
	}


	##	!BUG!				   / .'
	##					 .---. \/
	##	La funxione		(._.' \()
	##	Setta a 1	 	^"""^"
	##	Inizialmente il controllo su input
	##	Ma se poi l'utente inserisce qualcosa nel campo che non va bene
	##  Va a 0 e ci rimane anche se viene svuotata
	##	Va aggiunto l'elenco delle obbligatorie per poter fare un if nel caso
	##	data!=OK in funziona valida(,) in modo che, se vuote, vadano a 1


	//	tutta da rifare mi sa


	function checks_to_js()
	{
		$r = '<script type="text/javascript" language="javascript"> '
			.'var lista_elementi = new Array(); '
			.'var obbligatori = new Array(); ';

		foreach($this->fields as $key => $val)
		{ 
			$r.=' lista_elementi.push("'. $val->get_id() .'"); ';
			$r.= ($val->get_obbligatorio()) ? ' obbligatori.push(1); '
				: ' obbligatori.push(0); ';
    	}

    	$r.=' </script>';

    	return $r;
	}

}


?>