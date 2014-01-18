Ciao,
<?php
	if(isset($this->user) && $this->user->get_type() >= 0)
	{
		echo $this->user->get_info()['nick'];
	}else{
		echo 'Anonimo';
	}
?> 
!