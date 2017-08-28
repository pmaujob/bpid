<?php
$correcto=1; 
$idActividad = trim(strtoupper($_POST["idActividad"]));
$numeroActividad = trim(strtoupper($_POST["numeroActividad"]));
if($idActividad==""){
  	$correcto=0;
}
if($correcto==1){
?>
		
        <td><div class="input-field col s12">
    <select class="browser-default" id="frmFuente_<?php echo $numeroActividad;?>">
                   <option value="" disabled selected>Seleccionar</option>
                   <option value="1">Nacional</option>
                   <option value="2">Departamental</option>
                   <option value="3">Municipal</option>
                   <option value="4">S.G Regalias</option>
                   <option value="5">Cooperacion Internacional</option>
                   <option value="6">SGP</option>
                   <option value="7">Otros</option>
    </select></div></td>
    
     <td>
<input  id="frmValorFuenteNacional_<?php echo $numeroActividad;?>" name="frmValorFuenteNacional_<?php echo $numeroActividad;?> type="text" class="validate" value="0"></td>  
     <td>
<input  id="frmValorEfectivoNacional_<?php echo $numeroActividad;?>" name="frmValorEfectivoNacional_<?php echo $numeroActividad;?>" type="text" class="validate" value="0"></td>
      <td><input  id="frmValorEspecieNacional_<?php echo $numeroActividad;?>" name="frmValorEspecieNacional_<?php echo $numeroActividad;?>" type="text" class="validate" value="0"></td> 
    
    
  
       
		
<?php
}
//error general
if($correcto==0){
?>
<td colspan="4">
		    <div align="center">	
             Error en tiempo de Ejecucion, Reportar Error al Administrador
            </div>
</td></div>
    
        
<?php 
}
?>
