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
        <tr><th>ID MGA</th><th>Código Bpid</th><th>Nombre del Proyecto</th><th>Generar</th></tr>
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
                        <a href="#" title="<?php echo ($fila[6] == 'A' ? "Certificado NO Viabilidad" : "Certificado Viabilidad");?>">
                            <img style="width: 25%;" src="<?php echo "../../vistas/img/" . ($fila[6] == 'A' ? "cer_no_viabilidad" : "cer_viabilidad") . ".png" ?>" onclick="seleccionar(<?php echo $fila[0]; ?>, '<?php echo $fila[6]; ?>','<?php echo "cerRow" . $contRow; ?>');">
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
