<?php
function traduce_fecha($fecha)
{
    $fecha     = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia       = date('l', strtotime($fecha));
    $mes       = date('F', strtotime($fecha));
    $anio      = date('Y', strtotime($fecha));
    $dias_ES   = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN   = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES  = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN  = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $nombredia . " " . $numeroDia . " de " . $nombreMes . " de " . $anio;
}

#FUNCION QUE SIRVE PARA LIMPIAR CADENAS, PUEDE SER UTILIZADA CUANDO SE VA HA SUBIR UN ARCHIVO
#O CUANDO SE QUIERA VALIDAR UNA CADENA QUE NO CONTENGA CARACTERES PELIGROSOS
#
function tildes($cadena)
{
    #BUSCA ALGUNO DE ESTOS CARACTERES
    $a_tofind = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'à', 'á', 'â', 'ã', 'ä', 'å',
        'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø',
        'È', 'É', 'Ê', 'Ë', 'è', 'é', 'ê', 'ë', 'Ç', 'ç',
        'Ì', 'Í', 'Î', 'Ï', 'ì', 'í', 'î', 'ï',
        'Ù', 'Ú', 'Û', 'Ü', 'ù', 'ú', 'û', 'ü', 'ÿ', 'Ñ', 'ñ', ' ', '´', "'", ">", "<", "/", "-");
    # Y LOS DEJA SIN TILDES, SIGNOS ETC
    $a_replac = array('A', 'A', 'A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a', 'a',
        'O', 'O', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'o', 'o',
        'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e', 'C', 'c',
        'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i',
        'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u', 'y', 'N', 'n', '', '_', '', '', '', '', "");

    $nombreLimpia = str_replace($a_tofind, $a_replac, $cadena);
    return $nombreLimpia; //    me retorna la cadena sin caracteres especiales
}
