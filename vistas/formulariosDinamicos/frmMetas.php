<?php
@session_start();
$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/CargarMetas.php';

$idRad = $_POST['idRad'];
$op = $_POST['op']; //opcion para mostrar programas, subprogramas o metas
$numProyecto = $_POST['numProyecto'];

$programas = CargarMetas::getProgramas();
?>
<div id="divProgramas">
    <span>Seleccione el programa correspondiente al proyecto:</span>
    <div class="input-field col s12">
        <select id="selectProgramas" class="flow-text" onchange="mostrarSubprogramas('selectProgramas');">            
            <option value="" disabled selected>Lista de Programas</option>
            <?php
            foreach ($programas as $programa) {
                ?>
                <option value="<?php echo $programa[0]; ?>"><?php echo $programa[1]; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>
<br>
<div>
    <div id="esperarSubprogramas" style="text-align: center; margin-left: auto; margin-right: auto; display: none;">
        <img src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >
    </div>
    <div id="divSubprogramas" style="display: none;">              
    </div>
</div>
<br>
<div>
    <div id="esperarMetas" style="text-align: center; margin-left: auto; margin-right: auto; display: none;">
        <img src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >
    </div>
    <div id="divMetas" style="display: none;">       
    </div>
</div>
<input type="hidden" id="idRad" value="<?php echo $idRad; ?>" >
