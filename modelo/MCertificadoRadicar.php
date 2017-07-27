<?php

require_once '../librerias/ConexionPDO.php';

    //session_start();
    
    class CargarRadicados{
        
        private $con;
        
        function __construct() {
            
            $this->con = new ConexionPDO();
            $this->con = $this->conectar("PG");

            
        }
        
        public function getRadicados($datos,$op){
            
            $consulta = "select r.cod_radicacion as cod, b.numero_completo as num, r.nombre_proyecto as nombre, substring(r.nombre_proyecto from 1 for 40) || '...' as abr, b.cod_numero_bpid as id from numero_bpid as b inner join radicacion as r on b.cod_numero_bpid=r.cod_bpid where (r.nombre_proyecto like '%".$datos."%' or b.numero_completo like '%".$datos."%')  and r.cod_activacion=".$op." and r.cod_secretaria=1  order by fecha_envio desc  limit 11;";
            
            try{
                
                $res = $this->con->consultar($consulta);
                
                echo '<table>';
                echo '<thead>';
                echo '<tr><th>Código de radicación</th><th>Número</th><th>Nombre del proyecto</th><th>Más</th></tr>';
                echo '</thead>';
                echo '<tbody>';

                if($res->rowCount()){
                    while($res2 = $res->fetch(PDO::FETCH_OBJ)){

                        echo '<tr><td>'.$res2->cod.'</td><t.d>'.$res2->num.'</td><td title="'.$res2->nombre.'">'.$res2->abr.'</td><td><a href="#" title="Ver Más"><div onclick="vercertificado('.$res2->cod.');"><img src="../../vistas/img/anadir.png"></div></a></td></tr>';

                    }
                }else{
                    echo '<tr><td>No se encontraron resultados para la búsqueda.</td></tr>';
                }

                echo '</tbody>';
                echo '</table>';
                
            }catch(ErrorException $e){
                echo 'Error: '.$e;
            }
            
        }
        
    }
    
    if(!empty($_POST['value'])){

        $datos = $_POST['value'];
        $radicados = new CargarRadicados();
        $radicados->getRadicados($datos);
        
    }

?>