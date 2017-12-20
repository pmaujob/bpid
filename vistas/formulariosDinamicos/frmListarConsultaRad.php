<?php
@session_start();
$raiz = $_SESSION['raiz'];

const rTitLista = "RTITLISTA"; //id del titulo de la lista
const sTitLista = "STITLISTA";

require_once $raiz . '/modelo/CargarDatosRadicacion.php';

$idRad = $_POST['idRad'];
$numProyecto = $_POST['numProyecto'];

$listas = CargarDatosRadicacion::getDatosListas($idRad, 'principal');

foreach ($listas as $lista) {
    ?>
    <li>
        <div id="<?php echo rTitLista . $lista[0]; ?>" class="collapsible-header item_lista_obligatoria"><span><?php echo $lista[1]; ?></span></div>
        <div>
            <?php
            $requisitos = CargarDatosRadicacion::getDatosRequisitos($idRad, $lista[0], 'principal');
            foreach ($requisitos as $requisito) {
                ?>
                <div class="cardview_checklist">
                    <p style="text-align: justify; margin-top: -4px;">
                        <?php echo $requisito[1]; ?>
                    </p>   
                    <p>
                        <label>Observaciones:</label>
                        <textarea class="materialize-textarea" disabled style="color: #000000" ><?php echo $requisito[4]; ?></textarea>
                    </p>
                    <p>
                        <?php
                        if ($requisito[3] != "") {
                            ?>
                            <label>Archivo adjunto: </label>
                            <a href="../../archivos/proyectos/<?php echo $numProyecto; ?>/requisitos/<?php echo $requisito[3]; ?>" target="_blank" style="text-decoration: underline"><?php echo $requisito[3]; ?></a>
                            <?php
                        } else {
                            ?>
                            <span>
                                No se adjuntó ningún archivo
                            </span>
                            <?php
                        }
                        ?>                        
                    </p>
                </div>
                <?php
            }
            ?>
        </div>
    </li>
    <br>  
    <?php
}

$sublistas = CargarDatosRadicacion::getDatosListas($idRad, 'sub');

foreach ($sublistas as $sublista) {
    ?>
    <li>
        <div id="<?php echo rTitLista . $sublista[0]; ?>" class="collapsible-header item_lista_obligatoria"><span><?php echo $sublista[1]; ?></span></div>
        <div style="padding: 20px">
            <ul class="collapsible">
                <?php
                $requisitos = CargarDatosRadicacion::getDatosSubrequisitos($idRad, null, 0);
                foreach ($requisitos as $requisito) {
                    ?>
                    <li>
                        <div class="collapsible-header item_lista_especifica" style="background: #CBD773; color: white;"><span><?php echo $requisito[1]; ?></span></div>
                       <div style="padding-bottom: 10px">
                            <?php
                            $subitems = CargarDatosRadicacion::getDatosSubrequisitos($idRad, $requisito[0], 1);
                            foreach ($subitems as $subitem) {
                                ?>
                                <div class="cardview_checklist">
                                    <p style="text-align: justify; margin-top: -4px;">
                                        <?php echo $subitem[1]; ?>
                                    </p>   
                                    <p>
                                        <label>Observaciones:</label>
                                        <textarea class="materialize-textarea" disabled style="color: #000000" ><?php echo $subitem[4]; ?></textarea>
                                    </p>
                                    <p>
                                        <?php
                                        if ($subitem[3] != "") {
                                            ?>
                                            <label>Archivo adjunto: </label>
                                            <a href="../../archivos/proyectos/<?php echo $numProyecto; ?>/subrequisitos/<?php echo $subitem[3]; ?>" target="_blank" style="text-decoration: underline"><?php echo $subitem[3]; ?></a>
                                            <?php
                                        } else {
                                            ?>
                                            <span>
                                                No se adjuntó ningún archivo
                                            </span>
                                            <?php
                                        }
                                        ?>                        
                                    </p>
                                </div>
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
    <?php
}
?>

