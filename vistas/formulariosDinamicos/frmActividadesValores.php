<?php


if (!empty($_POST['codRadicacion']) && !empty($_POST['idProducto']) && !empty($_POST['idActividad']) ) {

	$codRadicacion=$_POST['codRadicacion'];
	$numProyecto=$_POST['idProducto'];
	$idActividad=$_POST['idActividad'];
	$valorActividad=$_POST['valorActividad'];
	

	?>
	
	<input type="hidden" name="codigoActividad" id="codigoActividad" value="<?php echo $idActividad;?>">
	<input type="hidden" name="numeroActividad" id="numeroActividad">
	<input type="hidden" name="valorActividad" id="valorActividad" value="<?php echo $valorActividad;?>">
	<table class="striped">
        <tbody>
        	<tr>
        	<th>Unidad de Medida</th><th>Cantidad</th><th>Costo Unitario</th><th>Total</th>
        	</tr>
        	<tr>
        	<td><input  id="frmUnidad_<?php echo $idActividad;?>" name="frmUnidad_<?php echo $idActividad;?>" type="text" class="validate"></td>
        	<td><input  id="frmCantidad_<?php echo $idActividad;?>" name="frmCantidad_<?php echo $idActividad;?>"" type="number" class="validate" onchange="calcularValorActividad(<?php echo $idActividad; ?>)"></td>
            <td><input  id="frmCosto_<?php echo $idActividad;?>" name="frmCosto_<?php echo $idActividad;?>" type="number" class="validate" onchange="calcularValorActividad(<?php echo $idActividad; ?>)"></td>
            <td><input  id="frmTotal_<?php echo $idActividad;?>" name="frmTotal_<?php echo $idActividad;?>" type="text" readonly>
			
            </td>
        	</tr>
        	</tbody></table>
        	<table class="centered">
        <tbody>
		<tr>
        	<th colspan="4"><input type="button" value="Agregar Financiacion" name="" class="waves-effect waves-light btn" onclick="agregarFuente('<?php echo $idActividad ?>')"></th>
        	</tr>
        </tbody></table>
        <table class="striped" id="tableActividades_<?php echo $idActividad; ?>">
        <tbody>
        <tr>
        <th>Fuentes de Financiación</th><th>Valor Fuente</th><th>Efectivo</th><th>Especie</th>	
        </tr>
        

        </tbody>
     </table>   

 <div id="datosActividad_<?php echo $idActividad; ?>"></div>

<?php
}
?>

