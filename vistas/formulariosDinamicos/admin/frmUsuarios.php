<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MCargarUsuarios.php';

const check = "CHECK";

if (!empty($_POST['value'])) {

    $datos = $_POST['value'];

    $res = MCargarUsuarios::getDatosUsuario($datos);
    ?>
    <div class="contenedor_tabla">
        <table class="striped">
            <thead>
                <tr><th>Número de cédula</th><th>Nombres</th><th>Apellidos</th><th>Correo</th><th>Activo</th><th>Permisos</th></tr>
            </thead>
            <tbody>
    <?php
    if (count($res) > 0) {
        foreach ($res as $fila) {
            ?>

                        <tr>
                            <td><?php echo $fila[0]; ?></td>
                            <td><?php echo $fila[1]; ?></td>
                            <td><?php echo $fila[2]; ?></td>
                            <td><?php echo $fila[3]; ?></td>
                            <td>
                                <div class="switch">
                                    <label>
                                        No
                                        <input id="<?php echo check.$fila[0]; ?>" type="checkbox" onchange="activar(<?php echo $fila[0]; ?>,'<?php echo check.$fila[0]; ?>')" <?php if ($fila[4] == 1) echo "checked"; ?>>
                                        <span class="lever"></span>
                                        Si
                                    </label>
                                </div>
                            </td>
                            <td>
                                <a href="#" title="Asignar permisos">
                                    <div onclick="permisos(<?php echo $fila[0]; ?>);">
                                        <img src="../../../vistas/img/permisos.png">
                                    </div>
                                </a>
                            </td>
                        </tr>

            <?php
        }
    } else {
        ?>

                    <tr><td>No se encontraron resultados para la búsqueda.</td></tr>

        <?php
    }
    ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>