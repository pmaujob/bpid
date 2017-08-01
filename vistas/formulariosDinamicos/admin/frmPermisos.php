<?php
require_once '../../../modelo/MModuloConFunciones.php';

const funciones = "FUN";
const idFunciones = "IDFUN";
?>

<table class="striped">
    <thead>
        <tr>
            <th>Módulo</th>
            <th>Función</th>
            <th>¿Tiene permiso?</th>
        </tr>
    </thead>

    <tbody>
        <?php
        
        $res = MModuloConFunciones::getFunciones();
        $cont = 0;
        
        while ($resultado = $res->fetch(PDO::FETCH_OBJ)) {
            ?>
            <tr>
                <td><?php echo $resultado->mod; ?></td>
                <td><?php echo $resultado->fun; ?></td>
                <td>
                    <div class="switch">
                        <label>
                            No
                            <input id="<?php echo funciones.$cont; ?>" type="checkbox">
                            <span class="lever"></span>
                            Si
                        </label>
                        <input id="<?php echo idFunciones.$cont; ?>" type="hidden" value="<?php echo $resultado->id; ?>">
                    </div>
                </td>
            </tr>
            <?php
            $cont++;
        }
        ?>
    </tbody>
    <input id="cont" type="hidden" value="<?php echo $cont; ?>">
</table>