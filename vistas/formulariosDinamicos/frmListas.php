<?php

require_once '../../modelo/CargarListas.php';

$fil = $_POST['value'];

$lista = CargarListas::getListaGeneral();

?>

<?php
if(count($lista)>0){
    foreach($lista as $fila){
        
        $op = $fila[2];

?>

<li>
    <div class="collapsible-header" id="<?php echo $fila[0]; ?>"><?php echo $fila[1]; ?></div>
    <div class="collapsible-body">
<?php
        if($op=="principal"){
            $lista_requisitos = CargarListas::getRequisitos($fil,$fila[0]);
        }else if($op=="sub"){
            $lista_subrequisitos = CargarListas::getSubRequisitos($fil,$fila[0]);
        }

        if($op=="principal"){
            foreach($lista_requisitos as $fila2){
        ?>
            <span>
                <?php echo $fila2[2]; ?>
            </span>
            <p>
                <label>Elige una opción</label>
                <select id="<?php echo $fila2[0].$fila2[1]; ?>" class="<?php echo $fila2[0]; ?> browser-default">
                    <option value="SI" <?php if($fila2[3]=="SI") echo "selected disabled"; ?>>Si</option>
                    <option value="NO" <?php if($fila2[3]=="NO") echo "selected"; ?>>No</option>
                    <option value="NA" <?php if($fila2[3]=="NA") echo "selected"; ?>>No aplica</option>
                </select>
            </p>
            <div class="row">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">mode_edit</i>
                            <label for="REQOBS<?php echo $fila2[1]; ?>">Observaciones:</label>
                            <textarea id="REQOBS<?php echo $fila2[1]; ?>" class="REQOBS materialize-textarea"></textarea>
                        </div>
                    </div>
                </form>
            </div>                

        <?php

            }
        }else if($op=="sub"){
        
        ?>
        
        <ul id="collapsible" class="collapsible" data-collapsible="accordion">
        
        <?php
        
            foreach($lista_subrequisitos as $fila3){
        ?>

            <li>
                <div class="collapsible-header" id="<?php echo $fila2[0]; ?>"><?php echo $fila2[2]; ?></div>
                <div class="collapsible-body">
                    <span>
                        <?php echo $fila3[2]; ?>
                    </span>
                    <p>
                        <label>Elige una opción</label>
                        <select id="<?php echo $fila3[0].$fila3[1]; ?>" class="<?php echo $fila3[0]; ?> browser-default">
                            <option value="SI" <?php if($fila3[3]=="SI") echo "selected disabled"; ?>>Si</option>
                            <option value="NO" <?php if($fila3[3]=="NO") echo "selected"; ?>>No</option>
                            <option value="NA" <?php if($fila3[3]=="NA") echo "selected"; ?>>No aplica</option>
                        </select>
                    </p>
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">mode_edit</i>
                                    <label for="SUBOBS<?php echo $fila3[1]; ?>">Observaciones:</label>
                                    <textarea id="SUBOBS<?php echo $fila3[1]; ?>" class="SUBOBS materialize-textarea"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>                
                </div>
            </li>

        <?php
            }
        ?>
             
            
                
        <?php
        }
        ?>
        </ul>
        
    </div>
</li>
        <?php
    }
}else
    echo 'No hay listas de chequeo.';

?>