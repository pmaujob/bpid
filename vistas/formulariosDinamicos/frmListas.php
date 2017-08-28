<?php
@session_start();
$raiz = $_SESSION['raiz'];

const req = 'REQ'; // id de la opción de la pregunta seleccionada
const sub = 'SUB';
const reqh = 'REQH'; // id de la pregunta
const subh = 'SUBH';
const rTitLista = "RTITLISTA"; //id del titulo de la lista
const sTitLista = "STITLISTA";
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
const reqFileExist = 'REQFILEEXIST'; //id del hidden para validar si el requisito ya tiene un archivo subido
const subFileExist = 'SUBFILEEXIST';
const reqObsLbl = 'REQOBSLBL';
const subObsLbl = 'SUBOBSLBL';

$noCont = 0;

require_once $raiz . '/modelo/CargarListas.php';

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
        <div id="<?php echo rTitLista . $filar[0]; ?>" class="collapsible-header item_lista_obligatoria" onclick="focusearTituloLista('<?php echo rTitLista . $filar[0]; ?>');" ><span><?php echo $filar[1]; ?></span></div>
        <div id="<?php echo rlista . $filar[0]; ?>" class="collapsible-body">
            <?php
            $requisitosListaGeneral = CargarListas::getRequisitos($fil, $filar[0]);
            foreach ($requisitosListaGeneral as $filar1) {
                $nOpcionesReq++;
                if ($filar1[2] == "NO") {
                    $noCont++;
                }
                ?>
                <div class="cardview_checklist row">
                    <span>
                        <?php echo $filar1[1]; ?>
                    </span>
                    <p>
                        <input id="<?php echo reqh . $nOpcionesReq; ?>" type="hidden" value="<?php echo $filar1[0]; ?>">
                        <select id="<?php echo req . $nOpcionesReq; ?>" class="browser-default" onchange="validarNo('<?php echo req . $nOpcionesReq; ?>');" >
                            <option value="SI" <?php if ($filar1[2] == "SI") echo "selected"; ?>>Si</option>
                            <option value="NO" <?php if ($filar1[2] == "NO") echo "selected"; ?>>No</option>
                            <option value="NA" <?php if ($filar1[2] == "NA") echo "selected"; ?>>No aplica</option>
                        </select>
                    </p>
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">mode_edit</i>
                                    <label for="<?php echo reqObs . $nOpcionesReq; ?>" id="<?php echo reqObsLbl . $nOpcionesReq; ?>" >Observaciones:</label>
                                    <textarea id="<?php echo reqObs . $nOpcionesReq; ?>" class="<?php echo reqObs; ?> materialize-textarea"><?php echo $filar1[5]; ?></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <p>
                        <input type="hidden" id="<?php echo reqFileExist . $nOpcionesReq; ?>" value="<?php echo $filar1[4]; ?>">
                        <?php
                        if ($filar1[4] != "") {
                            ?>
                            <label>Archivo adjunto: </label>
                            <a id="" href="../../archivos/proyectos/<?php echo $numProyecto; ?>/requisitos/<?php echo $filar1[4]; ?>" target="_blank" style="text-decoration: underline"><?php echo $filar1[4]; ?></a>
                            <?php
                        }
                        ?>
                        <br>
                        <label>Seleccione Archivo</label>
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
    <div class="collapsible-header item_lista_especifica" style="background: #F9C000; color: white;"><span><?php echo "Diligencie una Lista Específica"; ?></span></div>
    <div class="collapsible-body">
        <ul id="collapsible2" class="collapsible" data-collapsible="accordion">
            <?php
            foreach ($listasEspecificas as $filae) {
                $op = $filae[2];
                ?>
                <li>
                    <div id="<?php echo rTitLista . $filae[0]; ?>" class="collapsible-header item_lista_especifica" onclick="focusearTituloLista('<?php echo rTitLista . $filae[0]; ?>');"><span><?php echo $filae[1]; ?></span></div>
                    <div class="collapsible-body">                      
                        <?php
                        $lista_requisitos = CargarListas::getRequisitos($fil, $filae[0]);
                        if ($op == "principal") {
                            foreach ($lista_requisitos as $filae1) {
                                $nOpcionesReq++;
                                if ($filae1[2] == "NO") {
                                    $noCont++;
                                }
                                ?>
                                <div class="cardview_checklist">
                                    <span>
                                        <?php echo $filae1[1]; ?>
                                    </span>
                                    <p>
                                        <label>Elija una opción</label>
                                        <input id="<?php echo reqh . $nOpcionesReq; ?>" type="hidden" value="<?php echo $filae1[0]; ?>">
                                        <select id="<?php echo req . $nOpcionesReq; ?>" class="<?php echo req; ?> browser-default" onchange="validarNo('<?php echo req . $nOpcionesReq; ?>');">
                                            <option value="SI" <?php if ($filae1[2] == "SI") echo "selected"; ?>>Si</option>
                                            <option value="NO" <?php if ($filae1[2] == "NO") echo "selected"; ?>>No</option>
                                            <option value="NA" <?php if ($filae1[2] == "NA") echo "selected"; ?>>No aplica</option>
                                        </select>
                                    </p>
                                    <div class="row">
                                        <form class="col s12">
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <i class="material-icons prefix">mode_edit</i>
                                                    <label id="<?php echo reqObsLbl . $nOpcionesReq; ?>" for="<?php echo reqObs . $nOpcionesReq; ?>">Observaciones:</label>
                                                    <textarea id="<?php echo reqObs . $nOpcionesReq; ?>" class="<?php echo reqObs; ?> materialize-textarea" ><?php echo $filae1[5]; ?></textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>                                   
                                    <p>
                                        <input type="hidden" id="<?php echo reqFileExist . $nOpcionesReq; ?>" value="<?php echo $filae1[4]; ?>">
                                        <?php
                                        if ($filae1[4] != "") {
                                            ?>
                                            <label>Archivo adjunto: </label>
                                            <a id="" href="../../archivos/proyectos/<?php echo $numProyecto; ?>/requisitos/<?php echo $filae1[4]; ?>" target="_blank" style="text-decoration: underline"><?php echo $filae1[4]; ?></a>
                                            <?php
                                        }
                                        ?>
                                        <br>
                                        <label>Seleccione Archivo</label>
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
                                        <div id="<?php echo sTitLista . $filae2[0]; ?>" class="collapsible-header item_lista_especifica" style="border-bottom: 1px solid #000000 " onclick="focusearTituloLista('<?php echo sTitLista . $filae2[0]; ?>');"><span><?php echo $filae2[1]; ?></span></div>
                                        <div class="collapsible-body">
                                            <?php
                                            foreach ($lista_subrequisitos as $filas) {
                                                $nOpcionesSub++;
                                                if ($filas[2] == "NO") {
                                                    $noCont++;
                                                }
                                                ?>
                                                <div class="cardview_checklist">
                                                    <span>
                                                        <?php echo $filas[1]; ?>
                                                    </span>
                                                    <p>
                                                        <label>Elija una opción</label>
                                                        <input id="<?php echo subh . $nOpcionesSub; ?>" type="hidden" value="<?php echo $filas[0]; ?>">
                                                        <select id="<?php echo sub . $nOpcionesSub; ?>" class="<?php echo sub; ?> browser-default" onchange="validarNo('<?php echo sub . $nOpcionesSub; ?>');">
                                                            <option value="SI" <?php if ($filas[2] == "SI") echo "selected"; ?>>Si</option>
                                                            <option value="NO" <?php if ($filas[2] == "NO") echo "selected"; ?>>No</option>
                                                            <option value="NA" <?php if ($filas[2] == "NA") echo "selected"; ?>>No aplica</option>
                                                        </select>
                                                    </p>
                                                    <div class="row">
                                                        <form class="col s12">
                                                            <div class="row">
                                                                <div class="input-field col s12">
                                                                    <i class="material-icons prefix">mode_edit</i>
                                                                    <label id="<?php echo subObsLbl . $nOpcionesSub; ?>" for="<?php echo subObs . $nOpcionesSub; ?>">Observaciones:</label>
                                                                    <textarea id="<?php echo subObs . $nOpcionesSub; ?>" class="<?php echo subObs; ?> materialize-textarea"><?php echo $filas[5]; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <p>
                                                        <input type="hidden" id="<?php echo subFileExist . $nOpcionesSub; ?>" value="<?php echo $filas[4]; ?>">
                                                        <?php
                                                        if ($filas[4] != "") {
                                                            ?>
                                                            <label>Archivo adjunto: </label>
                                                            <a id="" href="../../archivos/proyectos/<?php echo $numProyecto; ?>/requisitos/<?php echo $filas[4]; ?>" target="_blank" style="text-decoration: underline"><?php echo $filas[4]; ?></a>
                                                            <?php
                                                        }
                                                        ?>
                                                        <br>
                                                        <label>Seleccione Archivo</label>
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
<input type="hidden" id="totalArchivosReq" name="totalArchivosReq" value="0">
<input type="hidden" id="totalArchivosSub" name="totalArchivosSub" value="0">
<input type="hidden" id="nOpcionesReq" name="nOpcionesReq" value="<?php echo $nOpcionesReq; ?>">
<input type="hidden" id="nOpcionesSub" name="nOpcionesSub" value="<?php echo $nOpcionesSub; ?>">
<input type="hidden" id="idRad" name="idRad" value="<?php echo $fil; ?>">
<input type="hidden" id="bpid" name="bpid" value="<?php echo $bpid; ?>">
<input type="hidden" id="numProyecto" name="numProyecto" value="<?php echo $numProyecto; ?>">
<input type="hidden" id="noCont" name="noCont" value="<?php echo $noCont; ?>">