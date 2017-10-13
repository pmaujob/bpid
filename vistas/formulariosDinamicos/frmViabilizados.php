<?php
require_once '../../modelo/CargarViabilizados.php';
require_once '../../modelo/CargarMetas.php';

const metaSelect = 'METASELECT';

if (!empty($_POST['bpid']) && !empty($_POST['numProyecto'])) {

    $numBpid = $_POST['bpid'];
    $numProyecto = $_POST['numProyecto'];

    $datosViabilizados = CargarViabilizados::getViabilizados($numBpid,1);
    $datosObjetivos = CargarViabilizados::getViabilizados($numBpid,2);
    $datosFinanciacion = CargarViabilizados::getViabilizados($numBpid,3);
    $datosActividades=CargarViabilizados::getViabilizados($numBpid,4);
    
    $proyectName = "";
    $metasProyecto = CargarMetas::getProyectMetas($numProyecto)->fetchAll(PDO::FETCH_BOTH);         
    ?>
    
<div class="contenedor_tabla">  
  <table class="striped">
        <thead>
            <tr>
                <th colspan="2" >DATOS INICIALES DEL PROYECTO:<?php echo $numProyecto;?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($datosViabilizados) > 0) {
               
                foreach ($datosViabilizados as $fila) {
                    ?>
                    <tr>
                        <th>Nombre del Proyecto</th><td><?php $proyectName = $fila[1]; echo $fila[1]; ?></td>
                    </tr>
                    <tr>
                        <th>Problema Central</th><td><?php echo $fila[2]; ?></td>
                    </tr>
                    <tr>
                        <th>Poblacion Objetivo</th>
                        <td><?php echo number_format($fila[5], 0,'', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Sector</th>
                        <td><?php echo $fila[7]; ?></td>
                    </tr>
                    <tr>
                        <th>Valor Proyecto</th>
                        <td><?php echo "$".$fila[8]; ?></td>
                    </tr>
                    <tr>
                        <th>Localizacion</th>
                        <td><?php echo $fila[9]; ?></td>
                    </tr>
                    <tr>
                        <th>Objetivo General</th>
                        <td><?php echo $fila[3]; ?></td>
                    </tr>                    
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td>No se encontraron resultados para la búsqueda.</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>  
    <table class="striped">        
        <thead>
     <tr><th colspan="2" style="text-align:center;">OBJETIVOS ESPECIFICOS PROYECTO </th></tr>
        </thead>
        <tbody>
            <?php

            if (count($datosObjetivos) > 0) {
                foreach ($datosObjetivos as $obj) {
                    ?>
                    <tr>
                         <td><?php echo $obj[0]; ?></td>
                    </tr>                    
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td>No se encontraron resultados para la búsqueda.</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        </table>       
     <table class="striped">         
        <thead>
     <tr>
         <th colspan="3" style="text-align:center;">FUENTES DE FINANCIACIÓN </th>
     </tr>
     <tr>
     <th>Tipo de Recursos</th>
     <th>Valor Financiación</th>
     <th>Periodo Financiación</th>
    </tr>
        </thead>
        <tbody>
            <?php

            if (count($datosFinanciacion) > 0) {
                foreach ($datosFinanciacion as $fin) {
                    ?>
                    <tr>
                         <td><?php echo $fin[0]; ?></td>
                         <td><?php echo number_format($fin[1]) ?></td>
                         <td><?php echo $fin[2]; ?></td>
                    </tr>                    
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td>No se encontraron resultados para la búsqueda.</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        </table>     
        <br>
        <table class="striped">
        <thead>
     <tr>
         <th colspan="4" style="text-align:center;">ACTIVIDADES DE PROYECTO</th>
     </tr>
     <tr>
     <th>Actividad</th>
     <th>Valor Actividad</th>
     <th>Seleccionar Meta</th>
     <th>Editar</th>
    </tr>
        </thead>
        <tbody>
            <?php

            if (count($datosActividades) > 0) {
                foreach ($datosActividades as $act) {
                    ?>

                    <tr>
                        <td>
                            <a  title="<?php echo $act[6];?>" style='text-decoration:none;color:black'>
                                    <?php 
                                    $texto=substr($act[6],0, 25);
                                    echo $texto."...";?>
                            </a>                              
                        </td>
                         <td><?php echo number_format($act[7]); ?></td>
                         
                        <td>                            
                        <select id="<?php echo metaSelect . $act[0]; ?>" class="browser-default">
                        <option value="0" selected disabled>Seleccione una Meta</option>                                    
                        <?php   
                        for($i=0;$i<count($metasProyecto);$i++){ 
                            $meta = $metasProyecto[$i];
                            ?>
                            <option value="<?php echo $meta[0]; ?>"><?php echo $meta[2] . " - " . $meta[1]; ?></option>
                        <?php
                        }                                 
                        unset($meta);
                        ?> 
                        </select>
                        </td>
                        
                         <td>
                            <a class="waves-effect waves-light modal-trigger" href="#modal1" title="Ver Más">
                                <div onclick="editarActividades(<?php echo $act[2]; ?>,<?php echo $act[0]; ?>,<?php echo $act[5];?>,<?php echo $act[7];?>)">
                                    <img src="../../vistas/img/anadir.png">
                                </div>
                            </a>
                        </td>
                    </tr>
                    
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td>No se encontraron resultados para la búsqueda.</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        </table>       
    <?php 
}
?>
</div>
<input type="hidden" id="proyectName" value="<?php echo $proyectName; ?>">
