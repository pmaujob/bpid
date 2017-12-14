<?php
require_once '../../modelo/CargarViabilizados.php';
require_once '../../modelo/CargarMetas.php';

const metaSelect = 'METASELECT';
const actId = 'ACTID';
const prodiv = 'PRODIV';

if (!empty($_POST['bpid']) && !empty($_POST['numProyecto'])) {

    $numBpid = $_POST['bpid'];
    $numProyecto = $_POST['numProyecto'];
    $idRad = $_POST['idRad'];

    $datosViabilizados = CargarViabilizados::getViabilizados($numBpid, 1);
    $datosObjetivos = CargarViabilizados::getViabilizados($numBpid, 2);
    $datosFinanciacion = CargarViabilizados::getViabilizados($numBpid, 3);
    $datosActividades = CargarViabilizados::getViabilizados($numBpid, 4);

    $proyectName = "";
    $contActs = 0;
    $metasProyecto = CargarMetas::getProyectMetas($numProyecto)->fetchAll(PDO::FETCH_BOTH);
    ?>
    <div id="d_error" title="ALERTA"></div>
    <div id="d_errormetas" title="ALERTA"></div>
    <div id="modal2" class="modal" style="max-width: 250px;">
        <div class="modal-content center-align">
            <p>ERROR</p>
            <i class="large material-icons green-text">info_outline</i>

        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-light btn light-blue blueb" onclick="closeModa2()">Aceptar</a>
        </div>
    </div>
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
                            <input name="group1" type="radio" id="test1" value="0" onclick="verarchivoMga(this.value)" />
                            <label for="test1">SI</label>
                        </p>
                        <p style="margin-left: 44px;">
                            <input name="group1" type="radio" id="test2" value="1" onclick="verarchivoMga(this.value)"/>
                            <label for="test2">NO</label>
                        </p>
                    <td>
                </tr>
                <tr style='display:none' id="fila_mga">
                    <td><strong>Seleccione Archivo MGA</strong></td>
                    <td>
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Subir Archivo MGA XML</span>
                                <input type="file" id="frm_archivo" name="frm_archivo" onchange="archivo_xml()" multiple
                                       alt="Cargar Archivo MGA WEB">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Seleccionar archivo XML">
                            </div>
                        </div>
                    </td>   

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
                            <th>Problema Central</th><td style="text-align:justify"><?php echo $fila[2]; ?></td>
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
                        <tr>
                            <th>Desicion:</th>
                            <td style="text-align:justify"><?php echo $fila[10]; ?></td>
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
                    <th colspan="6" style="text-align:center; color: #ffffff" >FUENTES DE FINANCIACIÓN </th>
                </tr>
                <tr>
                    <th>Tipo de Recursos</th>
                    <th>Valor </th>
                    <th>Periodo</th>
                    <th>Etapa </th>
                    <th>Tipo Entidad </th>
                    <th>Nombre Entidad </th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (count($datosFinanciacion) > 0) {
                    foreach ($datosFinanciacion as $fin) {
                        ?>
                        <tr>
                            <td><?php echo $fin[0]; ?></td>
                            <td><?php echo "$" . number_format($fin[1]) ?></td>
                            <td><?php echo $fin[2]; ?></td>
                            <td><?php echo $fin[3]; ?></td>
                            <td><?php echo $fin[4]; ?></td>
                            <td><?php
                                if ($fin[5] == -1) {
                                    $fin[5] = "";
                                };
                                echo $fin[5];
                                ?></td>
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
                    <th colspan="4" style="text-align:center; color: #ffffff">CADENA DE VALOR DE LA ALTERNATIVA</th>
                </tr>

        </table>
        <ul class="collapsible" data-collapsible="accordion">
            <?php
            if (count($datosActividades) > 0) {
                $aux = -1;
                $acum = 0;
                foreach ($datosActividades as $act) {
                    //echo "<br>aux:$aux-act:$act[1]<br>";
                    $contActs++;
                    if ($aux == -1) {
                        $acum++;
                        $aux = $act[1];
                        ?>  
                        <li>
                            <div class="collapsible-header" onclick="infoproductos(this)" id="<?php echo prodiv . $acum; ?>"><i class="material-icons">add</i><strong>PRODUCTO : </strong><?php echo $rest = substr($act[3], 0, 80); ?></div>
                            <div class="collapsible-body">
                                <table class="striped">
                                    <thead>
                                        <tr style="background-color: #008643">
                                            <th colspan="3" style=" text-align: center; color: #ffffff" ><strong>DATOS DEL PRODUCTO</strong></th>
                                        </tr>
                                        <tr>
                                            <th style=" text-align: center" >

                                                <input  placeholder="Cantidad" id="first_name" type="text"    value="<?php echo $act[9]; ?>" readonly style="text-align: center">
                                                <label for="first_name" style="text-align: center; color: #000"><strong>Cantidad</strong></label>

                                            </th>
                                            <th style=" text-align: center" >
                                                <input placeholder="Costo" id="frm_costo" type="text" value="<?php echo number_format($act[10], 0, '', '.'); ?>" readonly style="text-align: center">
                                                <label for="first_name" style="text-align: center; color: #000"><strong>Costo</strong></label>
                                            </th>
                                            <th style=" text-align: center" >
                                                <input placeholder="Unidad de Medida" id="frm_unidad_<?php echo $acum ?>" type="text"  style="text-align: center" >
                                                <label for="first_name" style="text-align: center; color: #000"><strong>Unidad de Medida</strong></label>
                                                <input  id="frm_producto_<?php echo $acum ?>" type="hidden"  value="<?php echo $act[1]; ?>" >
                                                <input  id="frm_producto_id<?php echo $acum ?>" type="hidden"  value="<?php echo $act[0]; ?>" >
                                            </th>
                                        </tr>

                                        <tr style="background-color: #008643">
                                            <th style="width: 40%; text-align: center;color: #ffffff " >ACTIVIDAD</th>
                                            <th style="width: 30%;  text-align: center; color: #ffffff">VALOR </th>
                                            <th style="width: 30%;  text-align: center; color: #ffffff">META</th>
                                        </tr>
                                    </thead>  
                                    <tbody>

                                        <?php
                                    } else if ($aux != $act[1]) {
                                        $acum++;
                                        $aux = $act[1];
                                        ?>
                                    </tbody>
                                </table>
                            </div>                            
                        </li>
                        <li>
                            <div class="collapsible-header" onclick="infoproductos(this)" id="<?php echo prodiv . $acum; ?>"><i class="material-icons" id="<?php echo $acum; ?>">add</i><strong>PRODUCTO : </strong><?php echo substr($act[3], 0, 80); ?></div>
                            <div class="collapsible-body" >
                                <table class="striped">
                                    <thead>
                                        <tr style="background-color: #008643">
                                            <th colspan="3" style=" text-align: center; color: #ffffff" ><strong>DATOS DEL PRODUCTO</strong></th>
                                        </tr>
                                        <tr>
                                            <th>

                                                <input  placeholder="Cantidad" id="first_name" type="text"    value="<?php echo $act[9]; ?>" readonly style="text-align: center">

                                                <label for="first_name" style="text-align: center; color: #000"><strong>Cantidad</strong></label>

                                            </th>
                                            <th style=" text-align: center" >
                                                <input placeholder="Costo" id="first_name" type="text" value="<?php echo number_format($act[10], 0, '', '.'); ?>" readonly style="text-align: center">
                                                <label for="first_name" style="text-align: center; color: #000"><strong>Costo</strong></label>
                                            </th>
                                            <th style=" text-align: center" >
                                                <input placeholder="Unidad de Medida" id="frm_unidad_<?php echo $acum ?>" type="text" style="text-align: center" >
                                                <label  for="first_name" style="text-align: center; color: #000"><strong>Unidad de Medid</strong></label>
                                                <input  id="frm_producto_<?php echo $acum ?>" type="hidden"  value="<?php echo $act[1]; ?>" >
                                                <input  id="frm_producto_id<?php echo $acum ?>" type="hidden"  value="<?php echo $act[0]; ?>" >

                                            </th>
                                        </tr>

                                        <tr style="background-color: #008643">
                                            <th style="width: 40%;  text-align: center; color: #ffffff">ACTIVIDAD</th>
                                            <th style="width: 30%;  text-align: center; color: #ffffff" >VALOR </th>
                                            <th style="width: 30%;  text-align: center; color: #ffffff">META</th>
                                        </tr>
                                    </thead>  
                                    <tbody>
                                        <?php
                                    }
                                    ?>
                                <span>

                                    <tr>
                                        <td style="width: 40%;">
                                            <input type="hidden" id="<?php echo actId . $contActs ?>" value="<?php echo $act[5]; ?>">
                                            <p style="text-align: justify; margin-top: -4px;">
                                                <?php echo $act[6]; ?>                                    
                                            </p>
                                        </td>
                                        <td style="text-align: center;" style="width: 30%;"><?php echo "$" . number_format($act[7]); ?></td>
                                        <td style="width: 30%;">    
                                            <input  type="hidden" id="frm_collapsible_<?php echo $contActs ?>"  value="<?php echo $acum ?>">
                                            <select id="<?php echo metaSelect . $contActs; ?>" class="browser-default">
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

                                </span>   
                                <?php
                            }
                            ?>
                    </div></li>  
                <?php
            } else {
                
            }
            ?>
            </thead>  

            </tbody></table>
        </ul>
    </div>    
    <?php
}
?>

<input type="hidden" id="contActs" value="<?php echo $contActs; ?>">
<input type="hidden" id="contItemMeta" value="<?php echo count($metasProyecto); ?>">
<input type="hidden" id="idRad" value="<?php echo $idRad; ?>">
<input type="hidden" id="proyectName" value="<?php echo $proyectName; ?>">
<input type="hidden" id="frmacum" value="<?php echo $acum; ?>">
<table class="striped">
    <thead>
        <tr>
            <th colspan="4" style="text-align:center;">
                <button id="btnGuardar" class="btn waves-effect waves-light" onclick="guardarMetas();">Guardar
                    <i class="material-icons right">send</i>
                </button>
            </th>
        </tr>
    </thead>  
    <tbody>
</table>