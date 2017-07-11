<?php
  require_once "../librerias/ConexionPDO.php";


class MArchivos
{

    public $con;
      
   
     public function __construc(){
        $this->con = new ConexionPDO();
          $this->con = $this->conectar("PG");
           


    }   
    

   public function ingresarArchivos($ruta,
                                    $nombre_archivo,
                                    $nombre_real,
                                    $numero_programa,
                                    $numero_proyecto   )
   {

   //$sql="select from ing_archivos6('$ruta','$nombre_archivo','$nombre_real','$numero_programa','$numero_proyecto')";
   $sql="select numero_completo from ing_archivos('$ruta','$nombre_archivo','$nombre_real','$numero_programa','$numero_proyecto') 
   as (".'"numero_completo"'." varchar)";  
   $con=new ConexionPDO();  
   $resultado=$con->consultarValor($sql);
   $con->cerrarConexion();  
   return $resultado;
    
	  
   }
   
   
}



?>