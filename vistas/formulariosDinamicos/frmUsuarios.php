<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/CargarUsuarios.php';

if (!empty($_POST['value'])) {

    $datos = $_POST['value'];
    $res = CargarUsuarios::getUsuarios($datos);
    ?>
    <table>
        <!--<thead>
            <tr><th>Cédula</th><th>Nombres</th><th>Apellidos</th><th>Agregar</th></tr>
        </thead> -->
        <tbody>
            <?php
            if (count($res) > 0) {
                foreach ($res as $fila) {
                    ?>

                    <tr>
                        <td><?php echo $fila[0]; ?></td>
                        <td><?php echo $fila[1]; ?></td>
                        <td><?php echo $fila[2]; ?></td>
                        <td>
                            <a href="#" title="Agregar">
                                <div onclick="agregaru(<?php echo $fila[0]; ?>,<?php echo "'".$fila[1]."'"; ?>,<?php echo "'".$fila[2]."'"; ?>);">
                                    <img style="width: 30px;" src="../../vistas/img/add.png">
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

    <?php
}
?>