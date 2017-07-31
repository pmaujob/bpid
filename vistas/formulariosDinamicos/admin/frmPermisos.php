<?php
require_once '../../../modelo/MModuloConFunciones.php';

const funciones = "FUN";
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
        
        while ($resultado = $res->fetch(PDO::FETCH_OBJ)) {
            ?>
            <tr>
                <td><?php echo $resultado->mod; ?></td>
                <td><?php echo $resultado->fun; ?></td>
                <td>
                    <div class="switch">
                        <label>
                            No
                            <input id="<?php echo funciones.$resultado->id; ?>" type="checkbox">
                            <span class="lever"></span>
                            Si
                        </label>
                    </div>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>