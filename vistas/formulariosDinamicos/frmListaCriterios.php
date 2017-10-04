<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MGetListaCriterios.php';

const criterios = "PRE";
const Observaciones = "OBS";
const idDimensiones = "IDDIMEN";

$idRad = $_POST['idRad'];

$cont = 0;
$contDimensiones = 0;

$listasDimensiones = MGetListaCriterios::getLista($idRad);

foreach ($listasDimensiones as $fila) {
    ?>

    <li>
        <div id="<?php echo rTitLista . $fila[0]; ?>" class="collapsible-header item_lista_obligatoria"><span><?php echo $fila[1]; ?></span></div>
        <div id="<?php echo rlista . $fila[0]; ?>" class="collapsible-body">

            <?php
            $listasCriterios = MGetListaCriterios::getCriterios($fila[0], $idRad);
            ?>

            <table class="striped">
                <thead>
                    <tr>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($listasCriterios as $fila2) {
                        ?>
                        <tr class="cardview_checklist" style="margin-bottom: 16px;">
                            <td style="padding-left: 16px;"><?php echo $fila2[1]; ?></td>
                            <td style="width: 175px;">
                                <div class="switch"  style="margin-right: 60px;">
                                    <label style="margin-right: 60px;">
                                        No
                                        <input id="<?php echo criterios . $cont; ?>" type="checkbox" value="<?php echo $fila2[0]; ?>" <?php echo $fila2[2] == 'Si' ? 'checked' : '' ?>>
                                        <span class="lever"></span>
                                        Si
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $cont++;
                    }
                    ?>
                    <tr>
                        <td colspan="3">
                            <label for="">Observaciones:</label>
                            <textarea id="<?php echo Observaciones . $contDimensiones; ?>" class="materialize-textarea" style="color: #000000; margin-bottom: 46px;"><?php echo $fila[2]; ?></textarea>
                            <input id="<?php echo idDimensiones . $contDimensiones; ?>" type="hidden" value="<?php echo $fila[0]; ?>">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </li>

    <?php
    $contDimensiones++;
}
?>

<input id="cont" type="hidden" value="<?php echo $cont; ?>">
<input id="contDimensiones" type="hidden" value="<?php echo $contDimensiones; ?>">