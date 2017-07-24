<?php
  require_once "../librerias/ConexionPDO.php";


class MRadicar
{

    public $con;
   
       public function __construc(){
        $this->con = new ConexionPDO();
        $this->con = $this->conectar("PG");
      
        
          }   
    

   public function ingresarRadicar( $numero_proyecto,
                                    $nombre_proyecto,
                                    $sector,
                                    $localizacion,
                                    $valor,
                                    $eje,
                                    $programa,
                                    $subprograma,
                                    $poai,
                                    $entidad_proponente,
                                    $entidad_ejecutante,
                                    $num_id_responsable,
                                    $nom_responsable,
                                    $cargo_responsable,
                                    $direccion_responsable,
                                    $telefono_responsable,
                                    $cel_responsable,
                                    $correo_responsable,
                                    $id_usuario,
                                    $nombre_usuario,
                                    $observaciones,
                                    $cod_usuario_ingreso,
                                    $cod_secretaria,
                                    $cod_activacion,
                                    $objetivosEspecificos,
                                    $fuentesFinanciamiento)
   {

    $sql="select from ing_radicacion($cod_activacion,$cod_usuario_ingreso,'$numero_proyecto','$sector','$localizacion','$valor',
                                    '$programa','$subprograma',$poai,'$entidad_proponente','$entidad_ejecutante','$num_id_responsable',
                                    '$nom_responsable','$cargo_responsable','$direccion_responsable','$telefono_responsable','$cel_responsable','$correo_responsable','$id_usuario','$nombre_usuario','$observaciones',$cod_usuario_ingreso,'$nombre_proyecto','$eje',$cod_secretaria,$objetivosEspecificos,$fuentesFinanciamiento)";
     
   
   
   $con = new ConexionPDO();
   $con->conectar("PG");
   $resultado=$con->afectar($sql);
   $con->cerrarConexion();  
      
        return $resultado;
      
   }
}



?>