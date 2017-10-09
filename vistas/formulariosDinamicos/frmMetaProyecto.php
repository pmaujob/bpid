<?php
require_once '../../modelo/CargarRadicados.php';
require_once '../../modelo/MSysConf.php';

if (!empty($_POST['value'])) {

    $op = $_POST['op'];
    $sysConf = new MSysConf();

    $datos = $_POST['value'];
    $res = CargarRadicados::getRadicados($datos,$op); //2 para consultar por cod_activacion
    ?>
    <table>
        <thead>
            <tr>
                <th>ID MGA</th>
                <th>Código Bpid</th>
                <th>Nombre del Proyecto</th>
                <th>Consultar</th>
            </tr>
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
                            <a href="#" title="Editar">
                                <div onclick="listarMetasProducto(<?php echo $fila[0]; ?>, <?php echo $sysConf->getFiltrarDep(); ?>, <?php echo $fila[5]; ?>);">
                                    <img src="../../vistas/img/anadir.png">
                                </div>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td>No se encontraron resultados para la búsqueda.</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>
