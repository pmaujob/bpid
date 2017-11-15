<?php
@session_start();
$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/SessionVars.php';
require_once $raiz . '/modelo/CargarRadicados.php';

$buscarValue = $_POST['value'];
$op = $_POST['op'];
$res = CargarRadicados::getRadicados($buscarValue, $op);
$contRow = 0;
?>

<table>
    <thead>
        <tr><th>ID MGA</th><th>Código Bpid</th><th>Nombre del Proyecto</th><th>Editar</th></tr>
    </thead>
    <tbody>
        <?php
        if (count($res) > 0) {
            foreach ($res as $fila) {
                $contRow++; 
                ?>
                <tr id="<?php echo "cerRow" . $contRow; ?>">
                    <td><?php echo $fila[5]; ?></td>
                    <td><?php echo $fila[1]; ?></td>
                    <td title="<?php echo $fila[2]; ?>"><?php echo $fila[3]; ?></td>
                    <td>
                        <a href="#" title="Ver Más">
                            <div onclick="seleccionar(<?php echo $fila[0]; ?>, '<?php echo $fila[6]; ?>','<?php echo "cerRow" . $contRow; ?>');">
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
<input id="contRow" type="hidden" value="<?php echo $contRow; ?>">
