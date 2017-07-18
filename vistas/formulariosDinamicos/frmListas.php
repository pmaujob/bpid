<?php
const req = 'REQ'; // id de la opción de la pregunta seleccionada
const sub = 'SUB';
const reqh = 'REQH'; // id de la pregunta
const subh = 'SUBH';
const rlista = 'RLIS'; // id de la lista
const slista = 'SLIS';
const reqObs = 'REQOBS'; // id de la observación
const subObs = 'SUBOBS';

require_once '../../modelo/CargarListas.php';

$fil = $_POST['value'];

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
                        <?php echo $filar1[2]; ?>
                    </span>
                    <p>
                        <label>Elige una opción</label>
                        <input id="<?php echo reqh . $nOpcionesReq; ?>" type="hidden" value="<?php echo $filar1[1]; ?>">
                        <select id="<?php echo req . $nOpcionesReq; ?>" class="browser-default">
                            <option value="SI" <?php if ($filar1[3] == "SI") echo "selected disabled"; ?>>Si</option>
                            <option value="NO" <?php if ($filar1[3] == "NO") echo "selected"; ?>>No</option>
                            <option value="NA" <?php if ($filar1[3] == "NA") echo "selected"; ?>>No aplica</option>
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
                        <label>Elige un adjunto</label>
                        <br>
                        <input type="hidden" name="MAX_FILE_SIZE"/>
                        <input id="<?php echo "reqArchivo" . $nOpcionesReq++; ?>" type="file" />
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
                                        <?php echo $filae1[2]; ?>
                                    </span>
                                    <p>
                                        <label>Elige una opción</label>
                                        <input id="<?php echo reqh . $nOpcionesReq; ?>" type="hidden" value="<?php echo $filae1[1]; ?>">
                                        <select id="<?php echo req . $nOpcionesReq; ?>" class="<?php echo req; ?> browser-default">
                                            <option value="SI" <?php if ($filae1[3] == "SI") echo "selected disabled"; ?>>Si</option>
                                            <option value="NO" <?php if ($filae1[3] == "NO") echo "selected"; ?>>No</option>
                                            <option value="NA" <?php if ($filae1[3] == "NA") echo "selected"; ?>>No aplica</option>
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
                                </div>
                                <?php
                            }
                        } else if ($op == "sub") {
                            ?>
                            <ul id="collapsible4" class="collapsible" data-collapsible="accordion">
                                <?php
                                foreach ($lista_requisitos as $filae2) {
                                    $lista_subrequisitos = CargarListas::getSubRequisitos($fil, $filae2[1]);
                                    ?>
                                    <li>                                    
                                        <div class="collapsible-header" id="<?php echo slista . $filae2[1]; ?>"><?php echo $filae2[2]; ?></div>
                                        <div class="collapsible-body">
                                            <?php
                                            foreach ($lista_subrequisitos as $filas) {
                                                $nOpcionesSub++;
                                                ?>
                                                <div style="border: 1px solid #000000; padding: 20px; margin: 15px">
                                                    <span>
                                                        <?php echo $filas[2]; ?>
                                                    </span>
                                                    <p>
                                                        <label>Elige una opción</label>
                                                        <input id="<?php echo subh . $nOpcionesSub; ?>" type="hidden" value="<?php echo $filas[1]; ?>">
                                                        <select id="<?php echo sub . $nOpcionesSub; ?>" class="<?php echo sub; ?> browser-default">
                                                            <option value="SI" <?php if ($filas[3] == "SI") echo "selected disabled"; ?>>Si</option>
                                                            <option value="NO" <?php if ($filas[3] == "NO") echo "selected"; ?>>No</option>
                                                            <option value="NA" <?php if ($filas[3] == "NA") echo "selected"; ?>>No aplica</option>
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