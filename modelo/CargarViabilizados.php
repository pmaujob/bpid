<?php

require_once '../../librerias/ConexionPDO.php';
  
class CargarViabilizados{

    public static function getViabilizados($numBpid,$op){
        
        switch ($op) {
            case 1:
                 $consulta='select pro,'//0
                   .'problema,'//1
                   .'obj,'//2
                   .'numben,'//3
                   .'eje,'//4
                   .'spro,'//5
                   .'sec,'//6
                   .'val,'//7
                   .'localizacion '//8
                   .'from get_datos_viabilidad('.$numBpid.','.$op.') as ("pro" varchar, "problema" varchar, "obj" varchar, "numben" integer, "eje" varchar, "spro" varchar, "sec" varchar, "val" varchar, "localizacion" varchar);';
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