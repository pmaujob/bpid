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
                                    $nombreArchivo,
                                    $nombreReal,
                                    $numeroPrograma,
                                    $numeroProyecto,
                                    $codigoControl)
   {

   //$sql="select from ing_archivos6('$ruta','$nombreArchivo','$nombreReal','$numeroPrograma','$numeroProyecto')";
   $sql="select numero_completo from ing_archivos('$ruta','$nombreArchivo','$nombreReal','$numeroPrograma','$numeroProyecto','$codigoControl') 
   as (".'"numero_completo"'." varchar)";  
   $con=new ConexionPDO(); 
   $con->conectar("PG"); 
   $resultado=$con->consultarValor($sql);
   $con->cerrarConexion();  
   return $resultado;
    
	  
   }
   
   
}



?>