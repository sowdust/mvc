<?php require_once('common/config.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WAW</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php echo config::basehost.config::basedir; ?>s/f.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo config::basehost.config::basedir; ?>s/s.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo config::basehost.config::basedir; ?>s/forms.css" type="text/css" media="screen" />
<!--
		jQuery 2.0.3
-->
<script type="text/javascript" src="<?php config::basehost.config::basedir; ?>j/jquery-2.0.3.min.js" ></script>
<?php


	if(is_array($this->js))
	{
		foreach($this->js as $js)
		{
			echo '<script type="text/javascript" src="'.config::basehost.config::basedir .'j/'.$js.'" ></script>';
		}		
	}else{
		echo '<script type="text/javascript" src="'.config::basehost.config::basedir .'j/'.$this->js.'" ></script>';
	}



?>

</head>
