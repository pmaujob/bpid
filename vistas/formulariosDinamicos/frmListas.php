<?php
require_once '../../modelo/CargarListas.php';

$fil = $_POST['value'];

$listasRequeridas = CargarListas::getListaGeneral(1);
$listasEspecificas = CargarListas::getListaGeneral(0);

foreach ($listasRequeridas as $fila) {
    ?>
    <li>
        <div class="collapsible-header" id="<?php echo $fila[0]; ?>" style="background: #ffca04"><?php echo ucwords($fila[1]); ?></div>
        <div class="collapsible-body">
            <?php
            $requisitosListaGeneral = CargarListas::getRequisitos($fil, $fila[0]);
            foreach ($requisitosListaGeneral as $fila2) {
                ?>
                <span>
                    <?php echo $fila2[2]; ?>
                </span>
                <p>
                    <label>Elige una opción</label>
                    <select id="<?php echo $fila2[0] . $fila2[1]; ?>" class="<?php echo $fila2[0]; ?> browser-default">
                        <option value="SI" <?php if ($fila2[3] == "SI") echo "selected disabled"; ?>>Si</option>
                        <option value="NO" <?php if ($fila2[3] == "NO") echo "selected"; ?>>No</option>
                        <option value="NA" <?php if ($fila2[3] == "NA") echo "selected"; ?>>No aplica</option>
                    </select>
                </p>
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">mode_edit</i>
                                <label for="REQOBS<?php echo $fila2[1]; ?>">Observaciones:</label>
                                <textarea id="REQOBS<?php echo $fila2[1]; ?>" class="REQOBS materialize-textarea"></textarea>
                            </div>
                        </div>
                    </form>
                </div>                

                <?php
            }
            ?>
        </div>
    </li>
    <?php
}
?>
<li>
    <div class="collapsible-header" id="2000" style="background: #4caf50"><?php echo "Lista Específica"; ?></div>
    <div class="collapsible-body">
        <ul id="collapsible2" class="collapsible" data-collapsible="accordion">
            <?php
            foreach ($listasEspecificas as $filae) {

                $op = $filae[2];
                ?>
                <li>
                    <div class="collapsible-header" id="<?php echo $filae[0]; ?>"><?php echo ucwords($filae[1]); ?></div>
                    <div class="collapsible-body">                      
                        <?php
                        if ($op == "principal") {
                            $lista_requisitos = CargarListas::getRequisitos($fil, $filae[0]);
                            foreach ($lista_requisitos as $fila2) {
                                ?>
                                <span>
                                    <?php echo $fila2[2]; ?>
                                </span>
                                <p>
                                    <label>Elige una opción</label>
                                    <select id="<?php echo $fila2[0] . $fila2[1]; ?>" class="<?php echo $fila2[0]; ?> browser-default">
                                        <option value="SI" <?php if ($fila2[3] == "SI") echo "selected disabled"; ?>>Si</option>
                                        <option value="NO" <?php if ($fila2[3] == "NO") echo "selected"; ?>>No</option>
                                        <option value="NA" <?php if ($fila2[3] == "NA") echo "selected"; ?>>No aplica</option>
                                    </select>
                                </p>
                                <div class="row">
                                    <form class="col s12">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="material-icons prefix">mode_edit</i>
                                                <label for="REQOBS<?php echo $fila2[1]; ?>">Observaciones:</label>
                                                <textarea id="REQOBS<?php echo $fila2[1]; ?>" class="REQOBS materialize-textarea"></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php
                            }
                        } else if ($op == "sub") {
                            $lista_subrequisitos = CargarListas::getSubRequisitos($fil, $filae[0]);
                            ?>
                            <ul id="collapsible4" class="collapsible" data-collapsible="accordion">

                                <?php
                                foreach ($lista_subrequisitos as $fila3) {
                                    ?>
                                    <li>
                                        <div class="collapsible-header" id="<?php echo $fila2[0]; ?>"><?php echo $fila2[2]; ?></div>
                                        <div class="collapsible-body">
                                            <span>
                                                <?php echo $fila3[2]; ?>
                                            </span>
                                            <p>
                                                <label>Elige una opción</label>
                                                <select id="<?php echo $fila3[0] . $fila3[1]; ?>" class="<?php echo $fila3[0]; ?> browser-default">
                                                    <option value="SI" <?php if ($fila3[3] == "SI") echo "selected disabled"; ?>>Si</option>
                                                    <option value="NO" <?php if ($fila3[3] == "NO") echo "selected"; ?>>No</option>
                                                    <option value="NA" <?php if ($fila3[3] == "NA") echo "selected"; ?>>No aplica</option>
                                                </select>
                                            </p>
                                            <div class="row">
                                                <form class="col s12">
                                                    <div class="row">
                                                        <div class="input-field col s12">
                                                            <i class="material-icons prefix">mode_edit</i>
                                                            <label for="SUBOBS<?php echo $fila3[1]; ?>">Observaciones:</label>
                                                            <textarea id="SUBOBS<?php echo $fila3[1]; ?>" class="SUBOBS materialize-textarea"></textarea>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>                
                                        </div>
                                    </li>
                                    <?php
                                }
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