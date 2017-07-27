<?php
require_once '../../modelo/CargarRadicados.php';

if (!empty($_POST['value']) && !empty($_POST['op'])) {

    $datos = $_POST['value'];
    $op = $_POST['op'];

    $res = CargarRadicados::getRadicados($datos,$op);
    
    ?>

    <table>
        <thead>
            <tr><th>Numero de Proyecto</th><th>Número Bpid</th><th>Nombre del proyecto</th><th>Certificado</th></tr>
        </thead>
        <tbody>
            <?php
            if (count($res) > 0) {
                foreach ($res as $fila) {
                    ?>

                    <tr>
                        <td><?php echo $fila[5]; ?></td>
                        <td><?php echo $fila[1]; ?></td>
                        <td title="<?php echo $fila[2]; ?>"><?php echo $fila[3]; ?></td>
                        <td>
                            <a href="#" title="Ver Más">
                                <div onclick="mas(<?php echo $fila[0]; ?>,<?php echo $fila[4]; ?>,<?php echo $fila[5]; ?>);">
                                    <img src="../../vistas/img/anadir.png">
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