<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MDatosRegistro.php';
require_once $raiz . '/modelo/CargarViabilizados.php';

$idRad = $_POST['idRad'];
$numBpid = $_POST['bpid'];
$numProyecto = $_POST['nump'];

$res = MDatosRegistro::getDatosRegistro($idRad)->fetch(PDO::FETCH_OBJ);
$datosActividades = CargarViabilizados::getViabilizados($numBpid, 4);
$firmas = MDatosRegistro::getDatosFirmas();

?>
<div class="contenedor_tabla">
    <table class="striped">
        <thead>
            <tr style="background-color: #008643">
                <th colspan="2" style="color: #ffffff; text-align: center;">Información del Proyecto</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <ul class="collapsible" data-collapsible="accordion">
        <li>
            <div class="collapsible-header"><i class="material-icons">dashboard</i>Información general del Proyecto</div>
            <div class="collapsible-body">
                <div class="row">
                    <table class="striped">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Código BPID</strong>
                                </td>
                                <td>
                                    <?php echo $res->nump; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Fecha de Radicación</strong>
                                </td>
                                <td>
                                    <?php echo $res->fece; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Fecha de Viabilidad</strong>
                                </td>
                                <td>
                                    <?php echo $res->fecf; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Fecha de Ingreso en el BPID</strong>
                                </td>
                                <td>
                                    <?php echo $res->fece; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Secretaria a la que pertenece el proyecto</strong>
                                </td>
                                <td>
                                    <?php echo $res->noms; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Nombre del Proyecto</strong>
                                </td>
                                <td>
                                    <?php echo $res->nomp; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Entidad Proponente</strong>
                                </td>
                                <td>
                                    <?php echo $res->epro; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Entidad Ejecutora</strong> 
                                </td>
                                <td>
                                    <?php echo $res->eejec; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">compare</i>Información Productos y Actividades</div>
            <div class="collapsible-body">

                <ul class="collapsible" data-collapsible="accordion">
                    <?php

                    if (count($datosActividades) > 0) {
                        $aux = -1;
                        foreach ($datosActividades as $act) {
                            if ($aux == -1) {
                                $aux = $act[1];
                                ?>  
                                <li>
                                    <div class="collapsible-header" style="background-color: #008643; color: #ffffff;"><i class="material-icons">add</i><strong>PRODUCTO : </strong><?php echo $act[3]; ?></div>
                                    <div class="collapsible-body">
                                        <table class="striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 40%; text-align: center" >ACTIVIDAD</th>
                                                    <th style="width: 30%;  text-align: center">VALOR </th>
                                                    <th style="width: 30%;  text-align: center">META</th>
                                                </tr>
                                            </thead>  
                                            <tbody>

                                                <?php
                                            } else if ($aux != $act[1]) {
                                                $aux = $act[1];
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </li>
                                <li>
                                    <div class="collapsible-header" style="background-color: #008643; color: #ffffff;"><i class="material-icons">add</i><strong>PRODUCTO : </strong><?php echo $act[3]; ?></div>
                                    <div class="collapsible-body">
                                        <table class="striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 40%;  text-align: center">ACTIVIDAD</th>
                                                    <th style="width: 30%;  text-align: center">VALOR </th>
                                                    <th style="width: 30%;  text-align: center">META</th>
                                                </tr>
                                            </thead>  
                                            <tbody>
                                                <?php
                                            }
                                            ?>
                                        <span>

                                            <tr>
                                                <td style="width: 40%;">
                                                    <p style="text-align: justify; margin-top: -4px;">
                                                        <?php echo $act[6]; ?>                                    
                                                    </p>
                                                </td>
                                                <td style="text-align: center;" style="width: 30%;">
                                                    <?php echo "$" . number_format($act[7]); ?>
                                                </td>
                                                <td style="width: 30%;">                            
                                                    <p style="text-align: justify; margin-top: -4px;">
                                                        <?php echo $act[8]; ?>                                    
                                                    </p>
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
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">featured_play_list</i>Lista de chequeo con sus respectivos archivos.</div>
            <div class="collapsible-body">
                <a class="waves-effect waves-light btn" onclick="listarDatosRadicacion(<?php echo $idRad; ?>,<?php echo $numProyecto; ?>);"><i class="material-icons left">filter_list</i>Ver listas de chqueo</a>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">playlist_add_check</i>Diligenciar los datos para la etapa de registro</div>
            <div class="collapsible-body">
                <div class="input-field col s12">
                    <input name="num_proyecto" type="hidden" value="<?php echo $numProyecto; ?>">
                    <input name="idRad" type="hidden" value="<?php echo $idRad; ?>">
                    <select id="tipo_reg" name="tipo_reg">
                        <option value="" disabled selected>Seleccione su opción</option>
                        <option value="1">Con Fines Informativos</option>
                        <option value="2">Sin Fines Informativos</option>
                    </select>
                    <label>Tipo de registro</label>
                </div>
                <br><br><br><br>
                <div class="input-field col s12">
                    <select id="concepto_post" name="concepto_post">
                        <option value="" disabled selected>Seleccione su opción</option>
                        <option value="1">Favorable</option>
                        <option value="2">Desfavorable</option>
                    </select>
                    <label>Concepto control posterior</label>
                </div>
                <br><br><br><br>
                <div class="input-field col s12">
                    <input placeholder="Motivación" id="motivacion" name="motivacion" type="text" class="validate">
                    <label for="motivacion">Motivación de la Viabilidad o No Viabilidad</label>
                </div>
                <br><br><br><br>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Seleccione Archivo</span>
                        <input id="archivo" name="archivo" type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input id="archivo_text" name="archivo_text" class="file-path validate" type="text">
                    </div>
                </div>
                <br><br><br><br>
                <div class="input-field col s12">
                    <select id="secretario" name="secretario">
                        <option value="" disabled selected>Seleccione su opción</option>
                        <?php
                        foreach ($firmas as $firm) {
                            ?>
                            <option value="<?php echo $firm[0]; ?>"><?php echo $firm[1]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <label>Firma</label>
                </div>
                <br><br><br><br>
            </div>
        </li>
    </ul>

    <div class="row">
        <div class="col s12 m5 l5">

        </div>
        <div class="col s12 center-align">
            <a class="waves-effect waves-light btn" onclick="registrar();"><i class="material-icons left">send</i>Registrar</a>
        </div>
    </div>

</div>