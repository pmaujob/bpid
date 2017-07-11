<?php

require_once '../../modelo/CargarRadicados.php';

if(!empty($_POST['value'])){

    $datos = $_POST['value'];

    $res = CargarRadicados::getRadicados($datos);

?>


<table>
    <thead>
        <tr><th>Código de radicación</th><th>Número</th><th>Nombre del proyecto</th><th>Más</th></tr>
    </thead>
    <tbody>
    <?php
    
    if(count($res)>0){
        foreach($res as $fila){
    
    ?>
        
        <tr><td><?php echo $fila[0]; ?></td><td><?php echo $fila[1]; ?></td><td title="<?php echo $fila[2]; ?>"><?php echo $fila[3]; ?></td><td><a href="#" title="Ver Más"><div onclick="mas(<?php echo $fila[0]; ?>);"><img src="../../vistas/img/anadir.png"></div></a></td></tr>
        
    <?php
        }
    }else{
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