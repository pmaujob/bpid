<?php


if (!empty($_POST['codRadicacion']) && !empty($_POST['idProducto']) && !empty($_POST['idActividad']) ) {

	$codRadicacion=$_POST['codRadicacion'];
	$numProyecto=$_POST['idProducto'];
	$idactividad=$_POST['idactividad'];
	?>
	<table class="striped">
        <tbody>
        	<tr>
        	<th>Unidad de Medida</th><th>Cantidad</th><th>Costo Unitario</th><th>Total</th>
        	</tr>
        	<tr>
        	<td><input  id="frmUnidad_"<?php echo idActividad;?> name="frmUnidad_"<?php echo idActividad;?> type="text" class="validate"></td>
        	<td><input  id="frmCantidad_"<?php echo idActividad;?> name="frmCantidad_"<?php echo idActividad;?> type="text" class="validate"></td>
            <td><input  id="frmCosto_"<?php echo idActividad;?> name="frmCosto_"<?php echo idActividad;?> type="text" class="validate"></td>
            <td><input  id="frmTotal_"<?php echo idActividad;?> name="frmTotal_"<?php echo idActividad;?> type="text" class="validate"></td>
        	</tr>
        <tr>
        <th>Fuentes de Financiación</th><th>Valor Fuente</th><th>Efectivo</th><th>Especie</th>	
        </tr>
        <tr>
        <td>Nacional</td><td></td><td></td><td></td>
        </tr>
        <tr>
        <td>Departamental</td><td></td><td></td><td></td>
        </tr>
        <tr>
        <td>Municipal</td><td></td><td></td><td></td>
        </tr>
        <tr>
        <td>S.G Regalías</td><td></td><td></td><td></td>
        </tr>
        <tr>
        <td>Coperación Internacional</td><td></td><td></td><td></td>
        </tr>
        <tr>
        <td>Otros</td><td></td><td></td><td></td>
        </tr>
        </tbody>
     </table>   



<?php
}
?>

