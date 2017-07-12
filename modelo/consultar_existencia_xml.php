<?php
require_once '../librerias/ConexionPDO.php';

    //session_start();
    
    class ConsultasXml{
        
        private $con;
		public $rutaProyecto;
		public $nombreArchivo;
		public $extension;
                public $codigoControl;
        
        function __construct() {
            
            $this->con = new ConexionPDO();
            $this->con->conectar("PG");
           

       
            
        }
         public function asignar($ruta_tmp,$nombreArchivo,$extension){
	       $this->rutaProyecto=$ruta_tmp;//carpeta 
	       $this->nombreArchivo=$nombreArchivo;
	       $this->extension=$extension;
               $this->codigoControl=hash_file('md5',$ruta_tmp);
            
        }
        public function getXml(){
			if($this->validarExtension())  
			{	
				$datos=simplexml_load_file($this->rutaProyecto);
				$numero_proyecto=utf8_decode($datos->Id);
				$consulta="select cod_radicacion as numero from radicacion where num_proyecto='$numero_proyecto' and cod_activacion=1";
				    	try{
					$res=$this->con->consultar($consulta);
                                      
					 	if($res->rowCount()>0)
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
		$nombreArchivo=  $_FILES['frm_archivo']['name'];//verificar si el nombre esta bn escrito
		$trozos = explode(".",$nombreArchivo); 
		$extension = end($trozos);
		$consultaxml->asignar($ruta_tmp,$nombreArchivo,$extension);
        echo $consultaxml->getXml();
       
        
    }

 
    
    ?>