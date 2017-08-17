<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MGetListaCriterios.php';

const criterios = "PRE";
const idObservaciones = "OBS";

$cont = 0;

$listasDimensiones = MGetListaCriterios::getLista();

foreach ($listasDimensiones as $fila) {
    ?>

    <li>
        <div id="<?php echo rTitLista . $fila[0]; ?>" class="collapsible-header item_lista_obligatoria"><span><?php echo $fila[1]; ?></span></div>
        <div id="<?php echo rlista . $fila[0]; ?>" class="collapsible-body">

            <?php
            $listasCriterios = MGetListaCriterios::getCriterios($fila[0]);
            ?>

            <table class="striped">
                <thead>
                    <tr>
                        <th>Pregunta</th>
                        <th>Descripción</th>
                        <th>Respuesta</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($listasCriterios as $fila2) {
                        ?>
                        <tr class="cardview_checklist" style="margin-bottom: 16px;">
                            <td style="padding-left: 16px;"><?php echo $fila2[1]; ?></td>
                            <td><?php echo $fila2[2]; ?></td>
                            <td style="width: 175px;">
                                <div class="switch"  style="margin-right: 60px;">
                                    <label style="margin-right: 60px;">
                                        No
                                        <input id="<?php echo criterios . $cont; ?>" type="checkbox" value="<?php echo $fila2[0]; ?>">
                                        <span class="lever"></span>
                                        Si
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label for="">Observaciones:</label>
                                <textarea id="<?php echo idObservaciones . $cont; ?>" class="materialize-textarea" style="color: #000000; margin-bottom: 46px;"></textarea>
                            </td>
                        </tr>
        <?php
        $cont++;
    }
    ?>
                </tbody>
            </table>
        </div>
    </li>

    <?php
}
?>

<input id="cont" type="hidden" value="<?php echo $cont; ?>">