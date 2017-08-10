<?php
require_once '../../../modelo/MModuloConFunciones.php';

const funciones = "FUN";
const idFunciones = "IDFUN";

$op;

if(isset($_POST['op']) && !empty($_POST['op']))
    $op = $_POST['op'];

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
        
        $res;
        if($op=="1")
            $res = MModuloConFunciones::getFunciones();
        else
            $res = MModuloConFunciones::
                
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