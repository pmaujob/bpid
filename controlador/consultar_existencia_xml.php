<?php
require_once '../ConexionPDO.php';

    //session_start();
    
    class ConsultasXml{
        
        private $con;
		public $ruta_proyecto;
		public $nombre_archivo;
		public $extension;
        
        function __construct() {
            
            $this->con = new ConexionPDO();
            
        }
         public function asignar($ruta_tmp,$nombre_archivo,$extension){

	       $this->ruta_proyecto=$ruta_tmp;//carpeta 
	       $this->nombre_archivo=$nombre_archivo;
	       $this->extension=$extension;

        }
        public function getXml(){
			if($this->validarExtension())  
			{	
				$datos=simplexml_load_file($this->ruta_proyecto);
				$numero_proyecto=utf8_decode($datos->Id);
				$consulta = "select cod_radicacion as numero from radicacion where num_proyecto='$numero_proyecto' and cod_activacion=1";
				
             	try{
					$res = $this->con->cantidadRegistros($consulta);
					
				   	if($res>0)
						return 1;
					else
						return 0;
                }catch(ErrorException $e){
                echo 'Error: '.$e;
            	}
            
        	}else
				return 2;
		}
        
    	public function validarExtension(){
		
		if($this->extension=="xml" or $this->extension=="XML")
			return true;
		else
			return false;
		}
     }
     if(!empty($_FILES['frm_archivo'])){

        $consultaxml = new ConsultasXml();
		$ruta_tmp=$_FILES['frm_archivo']['tmp_name'];//ruta temporal del archivo
		$nombre_archivo=  $_FILES['frm_archivo']['name'];//verificar si el nombre esta bn escrito
		$trozos = explode(".",$nombre_archivo); 
		$extension = end($trozos);
		$consultaxml->asignar($ruta_tmp,$nombre_archivo,$extension);
        echo $consultaxml->getXml();
        
    }
    ?>