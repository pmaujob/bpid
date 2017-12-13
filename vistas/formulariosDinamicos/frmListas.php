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
        <div id="<?php echo rTitLista . $filar[0]; ?>" class="collapsible-header item_lista_obligatoria" onclick="mostrarTitulo('<?php echo $filar[1]; ?>');" ><span><?php echo $filar[1]; ?></span></div>
        <div id="<?php echo rlista . $filar[0]; ?>" class="collapsible-body">
            <?php
            $requisitosListaGeneral = CargarListas::getRequisitos($fil, $filar[0]);
            ?>
            <table class="striped">                
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($requisitosListaGeneral as $filar1) {
                        $nOpcionesReq++;
                        if ($filar1[2] == "NO") {
                            $noCont++;
                        }
                        ?>
                        <tr class="cardview_checklist">
                            <td style="width: 55%;">
                                <p style="text-align: justify; margin-top: -4px;">
                                    <?php echo $filar1[1]; ?>                                    
                                </p>
                            </td>
                            <td style="width: 15%;">
                                <p style="margin-bottom: 15%;">
                                    <input id="<?php echo reqh . $nOpcionesReq; ?>" type="hidden" value="<?php echo $filar1[0]; ?>">
                                    <select id="<?php echo req . $nOpcionesReq; ?>" class="browser-default" onchange="validarNo('<?php echo req . $nOpcionesReq; ?>');" >
                                        <option value="SI" <?php if ($filar1[2] == "SI") echo "selected"; ?>>Si</option>
                                        <option value="NO" <?php if ($filar1[2] == "NO") echo "selected"; ?>>No</option>
                                        <option value="NA" <?php if ($filar1[2] == "NA") echo "selected"; ?>>No aplica</option>
                                    </select>
                                </p>
                            </td>

                            <td style="width: 30%;">
                                <input type="hidden" id="<?php echo reqFilePre . $nOpcionesReq; ?>" value="<?php echo $filar1[0]; ?>" />

                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>Archivo</span>
                                        <input type="file" id="<?php echo reqFile . $nOpcionesReq; ?>" name="<?php echo reqFile . $nOpcionesReq; ?>" data-listId="<?php echo rTitLista . $filar[0]; ?>" onchange="validarExtension('<?php echo reqFile . $nOpcionesReq; ?>')">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                </div>

                                <input type="hidden" id="<?php echo reqFileExist . $nOpcionesReq; ?>" value="<?php echo $filar1[3]; ?>">
                            </td>
                        </tr>
                        <?php
                        if ($filar1[3] != "") {
                            ?>
                            <tr>
                                <td colspan="3">
                                    <label style="color: black;">Archivo adjunto: </label>
                                    <a id="" href="../../archivos/proyectos/<?php echo $numProyecto; ?>/requisitos/<?php echo $filar1[3]; ?>" target="_blank" style="text-decoration: underline"><?php echo $filar1[3]; ?></a>
                                </td>
                            </tr> 
                            <tr>
                            </tr>
                            <?php
                        }
                        ?>                      
                        <tr>
                            <td colspan="3">
                                <label for="<?php echo reqObs . $nOpcionesReq; ?>" id="<?php echo reqObsLbl . $nOpcionesReq; ?>" style="color: black;" >Observaciones:</label>
                                <textarea id="<?php echo reqObs . $nOpcionesReq; ?>" class="<?php echo reqObs; ?> materialize-textarea"><?php echo $filar1[4]; ?></textarea>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
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
    <div id="RTITLISTAE" class="collapsible-header item_lista_especifica" style="background: #F9C000; color: white;"><span><?php echo "Diligencie una Lista Específica"; ?></span></div>
    <div class="collapsible-body">
        <ul id="collapsible2" class="collapsible" data-collapsible="accordion">
            <?php
            foreach ($listasEspecificas as $filae) {
                $op = $filae[2];
                ?>
                <li>
                    <div id="<?php echo rTitLista . $filae[0]; ?>" class="collapsible-header item_lista_especifica" onclick="mostrarTitulo('<?php echo $filae[1]; ?>');"><span><?php echo $filae[1]; ?></span></div>
                    <div class="collapsible-body">                      
                        <?php
                        $lista_requisitos = CargarListas::getRequisitos($fil, $filae[0]);
                        if ($op == "principal") {
                            ?>
                            <table class="striped">                
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Archivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($lista_requisitos as $filae1) {
                                        $nOpcionesReq++;
                                        if ($filae1[2] == "NO") {
                                            $noCont++;
                                        }
                                        ?>
                                        <tr class="cardview_checklist">
                                            <td style="width: 55%;">
                                                <p style="text-align: justify; margin-top: -4px;">
                                                    <?php echo $filae1[1]; ?>
                                                </p>
                                            </td>
                                            <td style="width: 15%;">
                                                <p style="margin-bottom: 15%;">
                                                    <input id="<?php echo reqh . $nOpcionesReq; ?>" type="hidden" value="<?php echo $filae1[0]; ?>">
                                                    <select id="<?php echo req . $nOpcionesReq; ?>" class="<?php echo req; ?> browser-default" onchange="validarNo('<?php echo req . $nOpcionesReq; ?>');">
                                                        <option value="SI" <?php if ($filae1[2] == "SI") echo "selected"; ?>>Si</option>
                                                        <option value="NO" <?php if ($filae1[2] == "NO") echo "selected"; ?>>No</option>
                                                        <option value="NA" <?php if ($filae1[2] == "NA") echo "selected"; ?>>No aplica</option>
                                                    </select>
                                                </p>
                                            </td>
                                            <td style="width: 30%;">
                                                <input type="hidden" id="<?php echo reqFilePre . $nOpcionesReq; ?>" value="<?php echo $filae1[0]; ?>" />

                                                <div class="file-field input-field">
                                                    <div class="btn">
                                                        <span>Archivo</span>
                                                        <input type="file" id="<?php echo reqFile . $nOpcionesReq; ?>" name="<?php echo reqFile . $nOpcionesReq; ?>" data-listFatherId="RTITLISTAE" data-listId="<?php echo rTitLista . $filae[0]; ?>" onchange="validarExtension('<?php echo reqFile . $nOpcionesReq; ?>')">
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input class="file-path validate" type="text">
                                                    </div>
                                                </div>

                                                <input type="hidden" id="<?php echo reqFileExist . $nOpcionesReq; ?>" value="<?php echo $filae1[3]; ?>">
                                            </td>
                                        </tr>
                                        <?php
                                        if ($filae1[3] != "") {
                                            ?>
                                            <tr>
                                                <td colspan="3">
                                                    <label style="color: black;">Archivo adjunto: </label>
                                                    <a id="" href="../../archivos/proyectos/<?php echo $numProyecto; ?>/requisitos/<?php echo $filae1[3]; ?>" target="_blank" style="text-decoration: underline"><?php echo $filae1[3]; ?></a>
                                                </td>
                                            </tr> 
                                            <tr>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="3">
                                                <label id="<?php echo reqObsLbl . $nOpcionesReq; ?>" for="<?php echo reqObs . $nOpcionesReq; ?>" style="color: black;">Observaciones:</label>
                                                <textarea id="<?php echo reqObs . $nOpcionesReq; ?>" class="<?php echo reqObs; ?> materialize-textarea" ><?php echo $filae1[4]; ?></textarea>
                                            </td>
                                        </tr>                                            
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else if ($op == "sub") {
                            ?>
                            <ul id="collapsible4" class="collapsible" data-collapsible="accordion">
                                <?php
                                foreach ($lista_requisitos as $filae2) {
                                    $lista_subrequisitos = CargarListas::getSubRequisitos($fil, $filae2[0]);
                                    ?>
                                    <li>                                    
                                        <div id="<?php echo sTitLista . $filae2[0]; ?>" class="collapsible-header item_lista_especifica" style="border-bottom: 1px solid #000000 " onclick="mostrarSubtitulo('<?php echo $filae2[1]; ?>');"><span><?php echo $filae2[1]; ?></span></div>
                                        <div class="collapsible-body">
                                            <table class="striped">                
                                                <thead>
                                                    <tr>
                                                        <th>Descripción</th>
                                                        <th>Estado</th>
                                                        <th>Archivo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($lista_subrequisitos as $filas) {
                                                        $nOpcionesSub++;
                                                        if ($filas[2] == "NO") {
                                                            $noCont++;
                                                        }
                                                        ?>
                                                        <tr class="cardview_checklist">
                                                            <td style="width: 50%;">
                                                                <p style="text-align: justify; margin-top: -4px;">
                                                                    <?php echo $filas[1]; ?>
                                                                </p>
                                                            </td>
                                                            <td style="width: 15%;">
                                                                <p style="margin-bottom: 15%;">
                                                                    <input id="<?php echo subh . $nOpcionesSub; ?>" type="hidden" value="<?php echo $filas[0]; ?>">
                                                                    <select id="<?php echo sub . $nOpcionesSub; ?>" class="<?php echo sub; ?> browser-default" onchange="validarNo('<?php echo sub . $nOpcionesSub; ?>');">
                                                                        <option value="SI" <?php if ($filas[2] == "SI") echo "selected"; ?>>Si</option>
                                                                        <option value="NO" <?php if ($filas[2] == "NO") echo "selected"; ?>>No</option>
                                                                        <option value="NA" <?php if ($filas[2] == "NA") echo "selected"; ?>>No aplica</option>
                                                                    </select>
                                                                </p>
                                                            </td>
                                                            <td style="width: 35%;">
                                                                <input type="hidden" id="<?php echo subFilePre . $nOpcionesSub; ?>" value="<?php echo $filas[0]; ?>" />

                                                                <div class="file-field input-field">
                                                                    <div class="btn">
                                                                        <span>Archivo</span>
                                                                        <input type="file" id="<?php echo subFile . $nOpcionesSub; ?>" name="<?php echo subFile . $nOpcionesSub; ?>" data-listGFatherId="RTITLISTAE" data-listFatherId="<?php echo rTitLista . $filae[0]; ?>" data-listId="<?php echo sTitLista . $filae2[0]; ?>" onchange="validarExtension('<?php echo subFile . $nOpcionesSub; ?>')">
                                                                    </div>
                                                                    <div class="file-path-wrapper">
                                                                        <input class="file-path validate" type="text">
                                                                    </div>
                                                                </div>

                                                                <input type="hidden" id="<?php echo subFileExist . $nOpcionesSub; ?>" value="<?php echo $filas[3]; ?>">
                                                            </td>
                                                        </tr>      
                                                        <?php
                                                        if ($filas[3] != "") {
                                                            ?>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <label style="color: black;">Archivo adjunto: </label>
                                                                    <a id="" href="../../archivos/proyectos/<?php echo $numProyecto; ?>/requisitos/<?php echo $filas[3]; ?>" target="_blank" style="text-decoration: underline"><?php echo $filas[3]; ?></a>
                                                                </td>
                                                            </tr>
                                                            <tr>

                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td colspan="3">
                                                                <label id="<?php echo subObsLbl . $nOpcionesSub; ?>" for="<?php echo subObs . $nOpcionesSub; ?>" style="color: black;">Observaciones:</label>
                                                                <textarea id="<?php echo subObs . $nOpcionesSub; ?>" class="<?php echo subObs; ?> materialize-textarea"><?php echo $filas[4]; ?></textarea>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>                                                
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