
<?php
	//require_once "../bpid_conf/configuracion.php"
	
	class ValidarDatos
	{
		
		public  function validarEmail($email)
		{
			if(preg_match('/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/', $email)){
				return true;
			} else {
				return false;
			}
		}
		
	}

?>