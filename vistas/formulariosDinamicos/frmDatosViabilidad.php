<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MGetDatosViabilidad.php';

$idRad = $_POST['idRad'];

$estado = true;

$datosDimensiones = MGetDatosViabilidad::getDatosViabilidad($idRad);

foreach ($datosDimensiones as $fila) {
    ?>

    <ul class="collection">
        <li class="collection-item avatar">
            <i class="material-icons circle <?php echo $fila[2]; ?> <?php if ($estado && $fila[2] !== 'green')
        $estado = false;
    echo $fila[2];
    ?>-text">brightness_1</i>
            <span class="title" style="font-weight: bold;"><?php echo $fila[1]; ?></span>
            <p>
    <?php echo $fila[0]; ?>
            </p>
        </li>
    </ul>

    <?php
}
    ?>

    <div class="row">
        <div class="col s12">
            <div class="card-panel teal">
                <span class="white-text">
                    <?php if (!$estado) { ?>El proyecto no es viable.<?php }else{ ?>El proyecto ha sido viabilizado con exito.<?php } ?>
                </span>
            </div>
        </div>
    </div>

    <?php
?>