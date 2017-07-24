<?php
const req = 'REQ'; // id de la opción de la pregunta seleccionada
const sub = 'SUB';
const reqh = 'REQH'; // id de la pregunta
const subh = 'SUBH';
const rlista = 'RLIS'; // id de la lista
const slista = 'SLIS';
const reqObs = 'REQOBS'; // id de la observación
const subObs = 'SUBOBS';
const reqFile = 'REQFILE'; //id de los archivos adjuntos
const subFile = 'SUBFILE';
const reqFilePre = 'REQFILEPRE'; //id del hidden perteneciente a los archivos para guardar id pregunta
const subFilePre = 'SUBFILEPRE';
const reqFileOb = 'REQFILEOB'; //id del hidden perteneciente a los archivos para validar si son obligatorios o no
const subFileOb = 'SUBFILEOB';

require_once '../../modelo/CargarListas.php';

$fil = $_POST['value'];
$bpid = $_POST['bpid'];
$numProyecto = $_POST['numProyecto'];

$listasRequeridas = CargarListas::getListaGeneral(1);
$listasEspecificas = CargarListas::getListaGeneral(0);

$nOpcionesReq = 0;
$nOpcionesSub = 0;

if (count($listasRequeridas) == 0) {
    echo 'No hay listas requeridas registradas.';
    return;
}

foreach ($listasRequeridas as $filar) {
    ?>
    <li>
        <div class="collapsible-header" style="background: #008643; color: #FFFFFF"><?php echo ucwords($filar[1]); ?></div>
        <div id="<?php echo rlista . $filar[0]; ?>" class="collapsible-body">
            <?php
            $requisitosListaGeneral = CargarListas::getRequisitos($fil, $filar[0]);
            foreach ($requisitosListaGeneral as $filar1) {
                $nOpcionesReq++;
                ?>
                <div style="border: 1px solid #000000; padding: 20px; margin: 15px">
                    <span>
                        <?php echo $filar1[1]; ?>
                    </span>
                    <p>
                        <label>Elija una opción</label>
                        <input id="<?php echo reqh . $nOpcionesReq; ?>" type="hidden" value="<?php echo $filar1[0]; ?>">
                        <select id="<?php echo req . $nOpcionesReq; ?>" class="browser-default">
                            <option value="SI" <?php if ($filar1[2] == "SI") echo "selected disabled"; ?>>Si</option>
                            <option value="NO" <?php if ($filar1[2] == "NO") echo "selected"; ?>>No</option>
                            <option value="NA" <?php if ($filar1[2] == "NA") echo "selected"; ?>>No aplica</option>
                        </select>
                    </p>                   
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">mode_edit</i>
                                    <label for="<?php echo reqObs . $nOpcionesReq; ?>">Observaciones:</label>
                                    <textarea id="<?php echo reqObs . $nOpcionesReq; ?>" class="<?php echo reqObs; ?> materialize-textarea"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <p>
                        <label>Elija un adjunto</label>
                        <br>
                        <input type="hidden" id="<?php echo reqFilePre . $nOpcionesReq; ?>" value="<?php echo $filar1[0]; ?>" />
                        <input type="hidden" id="<?php echo reqFileOb . $nOpcionesReq; ?>" value="<?php echo $filar1[3]; ?>" /><!--saber si el adjunto es obligatorio-->
                        <input type="file" id="<?php echo reqFile . $nOpcionesReq; ?>" name="<?php echo reqFile . $nOpcionesReq; ?>" onchange="validarExtension('<?php echo reqFile . $nOpcionesReq; ?>')">
                    </p>                     
                </div>
                <?php
            }
            ?>
        </div>
    </li>
    <?php
}
if (count($listasEspecificas) == 0) {
    echo 'No hay listas específicas registradas.';
    return;
}
?>    
<li>
    <div class="collapsible-header"><?php echo "Diligencie una Lista Específica"; ?></div>
    <div class="collapsible-body">
        <ul id="collapsible2" class="collapsible" data-collapsible="accordion">
            <?php
            foreach ($listasEspecificas as $filae) {
                $op = $filae[2];
                ?>
                <li>
                    <div class="collapsible-header" id="<?php echo rlista . $filae[0]; ?>"><?php echo ucwords($filae[1]); ?></div>
                    <div class="collapsible-body">                      
                        <?php
                        $lista_requisitos = CargarListas::getRequisitos($fil, $filae[0]);
                        if ($op == "principal") {
                            foreach ($lista_requisitos as $filae1) {
                                $nOpcionesReq++;
                                ?>
                                <div style="border: 1px solid #000000; padding: 20px; margin: 15px">
                                    <span>
                                        <?php echo $filae1[1]; ?>
                                    </span>
                                    <p>
                                        <label>Elija una opción</label>
                                        <input id="<?php echo reqh . $nOpcionesReq; ?>" type="hidden" value="<?php echo $filae1[0]; ?>">
                                        <select id="<?php echo req . $nOpcionesReq; ?>" class="<?php echo req; ?> browser-default">
                                            <option value="SI" <?php if ($filae1[2] == "SI") echo "selected disabled"; ?>>Si</option>
                                            <option value="NO" <?php if ($filae1[2] == "NO") echo "selected"; ?>>No</option>
                                            <option value="NA" <?php if ($filae1[2] == "NA") echo "selected"; ?>>No aplica</option>
                                        </select>
                                    </p>
                                    <div class="row">
                                        <form class="col s12">
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <i class="material-icons prefix">mode_edit</i>
                                                    <label for="<?php echo reqObs . $nOpcionesReq; ?>">Observaciones:</label>
                                                    <textarea id="<?php echo reqObs . $nOpcionesReq; ?>" class="<?php echo reqObs; ?> materialize-textarea"></textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <p>
                                        <label>Elija un adjunto</label>
                                        <br>
                                        <input type="hidden" id="<?php echo reqFilePre . $nOpcionesReq; ?>" value="<?php echo $filae1[0]; ?>" />
                                        <input type="hidden" id="<?php echo reqFileOb . $nOpcionesReq; ?>" value="<?php echo $filae1[3]; ?>" /><!--saber si el adjunto es obligatorio-->
                                        <input type="file" id="<?php echo reqFile . $nOpcionesReq; ?>" name="<?php echo reqFile . $nOpcionesReq; ?>" onchange="validarExtension('<?php echo reqFile . $nOpcionesReq; ?>')">
                                    </p>
                                </div>
                                <?php
                            }
                        } else if ($op == "sub") {
                            ?>
                            <ul id="collapsible4" class="collapsible" data-collapsible="accordion">
                                <?php
                                foreach ($lista_requisitos as $filae2) {
                                    $lista_subrequisitos = CargarListas::getSubRequisitos($fil, $filae2[0]);
                                    ?>
                                    <li>                                    
                                        <div class="collapsible-header" id="<?php echo slista . $filae2[0]; ?>"><?php echo $filae2[1]; ?></div>
                                        <div class="collapsible-body">
                                            <?php
                                            foreach ($lista_subrequisitos as $filas) {
                                                $nOpcionesSub++;
                                                ?>
                                                <div style="border: 1px solid #000000; padding: 20px; margin: 15px">
                                                    <span>
                                                        <?php echo $filas[1]; ?>
                                                    </span>
                                                    <p>
                                                        <label>Elija una opción</label>
                                                        <input id="<?php echo subh . $nOpcionesSub; ?>" type="hidden" value="<?php echo $filas[0]; ?>">
                                                        <select id="<?php echo sub . $nOpcionesSub; ?>" class="<?php echo sub; ?> browser-default">
                                                            <option value="SI" <?php if ($filas[2] == "SI") echo "selected disabled"; ?>>Si</option>
                                                            <option value="NO" <?php if ($filas[2] == "NO") echo "selected"; ?>>No</option>
                                                            <option value="NA" <?php if ($filas[2] == "NA") echo "selected"; ?>>No aplica</option>
                                                        </select>
                                                    </p>
                                                    <div class="row">
                                                        <form class="col s12">
                                                            <div class="row">
                                                                <div class="input-field col s12">
                                                                    <i class="material-icons prefix">mode_edit</i>
                                                                    <label for="<?php echo subObs . $nOpcionesSub; ?>">Observaciones:</label>
                                                                    <textarea id="<?php echo subObs . $nOpcionesSub; ?>" class="<?php echo subObs; ?> materialize-textarea"></textarea>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <p>
                                                        <label>Elija un adjunto</label>
                                                        <br>
                                                        <input type="hidden" id="<?php echo subFilePre . $nOpcionesSub; ?>" value="<?php echo $filas[0]; ?>" />
                                                        <input type="hidden" id="<?php echo subFileOb . $nOpcionesSub; ?>" value="<?php echo $filas[3]; ?>" /><!--saber si el adjunto es obligatorio-->
                                                        <input type="file" id="<?php echo subFile . $nOpcionesSub; ?>" name="<?php echo subFile . $nOpcionesSub; ?>" onchange="validarExtension('<?php echo subFile . $nOpcionesSub; ?>')">
                                                    </p>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </li>
                                <?php }
                                ?>                            
                            </ul> 
                            <?php
                        }
                        ?>   
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>       
    </div>
</li>
<input type="hidden" id="nOpcionesReq" value="<?php echo $nOpcionesReq; ?>">
<input type="hidden" id="nOpcionesSub" value="<?php echo $nOpcionesSub; ?>">
<input type="hidden" id="idRad" value="<?php echo $fil; ?>">
<input type="hidden" id="bpid" value="<?php echo $bpid; ?>">
<input type="hidden" id="numProyecto" value="<?php echo $numProyecto;?>">