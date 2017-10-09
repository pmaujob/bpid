<?php

require_once '../../librerias/ConexionPDO.php';
  
class CargarViabilizados{

    public static function getViabilizados($numBpid,$op){
        
        switch ($op) {
            case 1:
                
                 $consulta='select r,'//0
                   .'pro,'//1
                   .'despro,'//2
                   .'pob,'//3
                   .'dessubpro,'//4
                   .'sec,'//5
                   .'val,'//6
                   .'loc '//7
                   .'from get_datos_viabilidad('.$numBpid.','.$op.') as ("r" integer ,"pro" varchar, "despro" varchar, "pob" integer, "dessubpro" varchar, "sec" varchar, "val" varchar, "loc" varchar);';
                break;
             case 2:
                 $consulta='select obj '
                   .'from get_datos_viabilidad('.$numBpid.','.$op.') as ("obj" varchar);';
                break;
              case 3:
                 $consulta='select origen,'//0
                   .'valor,'//1
                   .'periodo '//8
                   .'from get_datos_viabilidad('.$numBpid.','.$op.') as ("origen" varchar, "valor" numeric, "periodo" integer);';
                break;   
               case 4:
                 $consulta='select id,'//0
                   .'nump,'//1
                   .'codr,'//2
                   .'nom,'//3
                   .'val,'//4
                   .'idact,'//5
                   .'des,'//5
                   .'val '//6
                   .'from get_datos_viabilidad('.$numBpid.','.$op.') as ("id" integer , "nump"  integer,"codr"  integer, "nom"  varchar,"idact"  integer,"des"  varchar,"val"  numeric);';
                break;       
            
            default:
                # code...
                break;
        }
        

                
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();
        return $res;

    }

}

?>