<?php
require_once '../../modelo/CargarViabilizados.php';
require_once '../../modelo/CargarMetas.php';

const metaSelect = 'METASELECT';
const actId = 'ACTID';

if (!empty($_POST['bpid']) && !empty($_POST['numProyecto'])) {

    $numBpid = $_POST['bpid'];
    $numProyecto = $_POST['numProyecto'];
    $idRad = $_POST['idRad'];

    $datosViabilizados = CargarViabilizados::getViabilizados($numBpid, 1);
    $datosObjetivos = CargarViabilizados::getViabilizados($numBpid, 2);
    $datosFinanciacion = CargarViabilizados::getViabilizados($numBpid, 3);
    $datosActividades = CargarViabilizados::getViabilizados($numBpid, 4);

    $proyectName = "";
    $contMeta = 0;
    $metasProyecto = CargarMetas::getProyectMetas($numProyecto)->fetchAll(PDO::FETCH_BOTH);
    ?>

    <div class="contenedor_tabla"> 
        <table class="striped">
            <thead>
                <tr style="background-color: #008643">
                    <th colspan="2" style="color: #ffffff">¿DESEA ACTUALIZAR EL ARCHIVO MGA WEB?</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>

                        <p style="margin-left: 44px;">
                           <input name="group1" type="radio" id="test1"  />
                            <label for="test1">SI</label>
                        </p>
                        <p style="margin-left: 44px;">
                            <input name="group1" type="radio" id="test2" />
                            <label for="test2">NO</label>
                        </p>
                    <td>
                </tr>



            </tbody>
        </table> 
        <table class="striped">
            <thead>
                <tr style="background-color: #008643">
                    <th colspan="2" style="text-align:center; color: #ffffff">DATOS INICIALES DEL PROYECTO:<?php echo $numProyecto; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($datosViabilizados) > 0) {

                    foreach ($datosViabilizados as $fila) {
                        ?>
                        <tr>
                            <th>Nombre del Proyecto</th><td><?php
                                $proyectName = $fila[1];
                                echo $fila[1];
                                ?></td>
                        </tr>
                        <tr>
                            <th>Problema Central</th><td><?php echo $fila[2]; ?></td>
                        </tr>
                        <tr>
                            <th>Poblacion Objetivo</th>
                            <td><?php echo number_format($fila[5], 0, '', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Sector</th>
                            <td><?php echo $fila[7]; ?></td>
                        </tr>
                        <tr>
                            <th>Valor Proyecto</th>
                            <td><?php echo "$" . $fila[8]; ?></td>
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
                <tr style="background-color: #008643">
                    <th colspan="2" style="text-align:center; color: #ffffff">OBJETIVOS ESPECIFICOS PROYECTO </th></tr>
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
        <table class="striped" >         
            <thead>
                <tr style="background-color: #008643">
                    <th colspan="3" style="text-align:center; color: #ffffff" >FUENTES DE FINANCIACIÓN </th>
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
                <tr style="background-color: #008643">
                    <th colspan="4" style="text-align:center; color: #ffffff">ACTIVIDADES DE PROYECTO</th>
                </tr>
                <tr>
                    <th style="width:40%;">Actividad</th>
                    <th style="width:20%;">Valor Actividad</th>
                    <th style="width:40%;">Seleccionar Meta</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($datosActividades) > 0) {
                    foreach ($datosActividades as $act) {
                        $contMeta++;
                        ?>
                        <tr>
                            <td>
                                <input type="hidden" id="<?php echo actId . $contMeta ?>" value="<?php echo $act[5]; ?>">
                                <p style="text-align: justify; margin-top: -4px;">
                                    <?php echo $act[5] . "; " . $act[6]; ?>                                    
                                </p>
                            </td>
                            <td style="text-align: center;"><?php echo "$" . number_format($act[7]); ?></td>
                            <td>                            
                                <select id="<?php echo metaSelect . $contMeta; ?>" class="browser-default">
                                    <option value="0" selected disabled>Seleccione una Meta</option>                                    
                                    <?php
                                    for ($i = 0; $i < count($metasProyecto); $i++) {
                                        $meta = $metasProyecto[$i];
                                        ?>
                                        <option value="<?php echo $meta[0]; ?>" style="" ><?php echo $meta[2] . " - " . $meta[1]; ?></option>
                                        <?php
                                    }
                                    unset($meta);
                                    ?> 
                                </select>
                            </td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <th colspan="4" style="text-align:center;">
                            <button class="btn waves-effect waves-light" onclick="guardarMetas();">Guardar
                                <i class="material-icons right">send</i>
                            </button>
                        </th>
                    </tr>
                    <?php
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
    </div>    
    <?php
}
?>
<input type="hidden" id="contMeta" value="<?php echo $contMeta; ?>">
<input type="hidden" id="contItemMeta" value="<?php echo count($metasProyecto); ?>">
<input type="hidden" id="idRad" value="<?php echo $idRad; ?>">
<input type="hidden" id="proyectName" value="<?php echo $proyectName; ?>">
