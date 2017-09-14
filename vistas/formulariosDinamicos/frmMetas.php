<?php
@session_start();
$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/CargarMetas.php';
require_once $raiz . '/librerias/SessionVars.php';

$sess = new SessionVars();
$idRad = $_POST['idRad'];
$filtrarSec = $_POST['filtrarSec']; //bandera para traer sólo las metas, o también las dependencias
$numProyecto = $_POST['numProyecto'];

$secretarias = CargarMetas::getSecretarias();
$metas = null;

if ($filtrarSec == 0) {
    ?>
    <div id="divSecretarias">
        <span>Seleccione una o más secretarías:</span>
        <div class="input-field col s12">        
            <?php
            foreach ($secretarias as $secretaria) {
                ?>
                <input type="checkbox" id="<?php echo "secCheck" . $secretaria[0]; ?>" value="<?php echo $secretaria[0]; ?>" onclick="buscarMetas(this, '<?php echo $secretaria[1]; ?>');" />
                <label for="<?php echo "secCheck" . $secretaria[0]; ?>"><?php echo $secretaria[1]; ?></label>
                <br>
                <?php
            }
            ?>
        </div>
    </div>
    <br>
    <?php
} else {
    $metas = CargarMetas::getMetas($sess->getValue('idSec'));
}
?> 
<div>    
    <div id="esperarMetas" style="text-align: center; margin-left: auto; margin-right: auto; display: <?php if ($filtrarSec == 0) echo "none" ?>; ">
        <span>Cargando datos por favor espere...</span>
        <br>
        <img src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >
    </div>
    <div id="divMetas" style="display: none">        
    </div>
</div>
<input type="hidden" id="idRad" value="<?php echo $idRad; ?>">
<input type="hidden" id="idFiltrarSec" value="<?php echo $filtrarSec; ?>">
<input type="hidden" id="idSec" value="<?php echo $sess->getValue('idSec'); ?>">

