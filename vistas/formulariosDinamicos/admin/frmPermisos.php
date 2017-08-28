<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MModuloConFunciones.php';

const funciones = "FUN";
const idFunciones = "IDFUN";

$op;

if (isset($_POST['op']) && !empty($_POST['op']))
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
        if ($op == "1")
            $res = MModuloConFunciones::getFunciones();
        else if ($op == "2") {
            if (isset($_POST['cedula']) && !empty($_POST['cedula']))
                $cedula = $_POST['cedula'];
            $res = MModuloConFunciones::getFuncionesUser($cedula);
        }

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
                            <input id="<?php echo funciones . $cont; ?>" type="checkbox" <?php if ($op == "2" && $resultado->ced != "") echo "checked"; ?>>
                            <span class="lever"></span>
                            Si
                        </label>
                        <input id="<?php echo idFunciones . $cont; ?>" type="hidden" value="<?php echo $resultado->id; ?>">
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