<!DOCTYPE html>
<head>
<title>WAW</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php echo config::basehost.config::basedir; ?>s/s.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo config::basehost.config::basedir; ?>s/forms.css" type="text/css" media="screen" />
<!--
		jQuery 2.0.3
-->
<script type="text/javascript" src="<?php config::basehost.config::basedir; ?>j/jquery-2.0.3.min.js" ></script>
<?php

if(!empty($this->js))
{	echo'<!--
		script specifici della view
-->
';

	if(is_array($this->js))
	{
		foreach($this->js as $js)
		{
			echo '<script type="text/javascript" src="'.config::basehost.config::basedir .'j/'.$js.'" ></script>';
		}		
	}else{
		echo '<script type="text/javascript" src="'.config::basehost.config::basedir .'j/'.$this->js.'" ></script>';
	}

}

?>

</head>
