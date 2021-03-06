<?php

class CambiarFormatos {

    public static function cambiarFecha($fecha) {

        $fecha = strtotime($fecha); // convierte la fecha de formato mm/dd/yyyy a marca de tiempo
        $diasemana = date("w", $fecha); // optiene el número del dia de la semana. El 0 es domingo
        switch ($diasemana) {
            case "0":
                $diasemana = "Dom";
                break;
            case "1":
                $diasemana = "Lun";
                break;
            case "2":
                $diasemana = "Mar";
                break;
            case "3":
                $diasemana = "Mié";
                break;
            case "4":
                $diasemana = "Jue";
                break;
            case "5":
                $diasemana = "Vie";
                break;
            case "6":
                $diasemana = "Sáb";
                break;
        }
        $dia = date("d", $fecha); // día del mes en número
        $mes = date("m", $fecha); // número del mes de 01 a 12
        switch ($mes) {
            case "01":
                $mes = "Enero";
                break;
            case "02":
                $mes = "Febrero";
                break;
            case "03":
                $mes = "Marzo";
                break;
            case "04":
                $mes = "Abril";
                break;
            case "05":
                $mes = "Mayo";
                break;
            case "06":
                $mes = "Junio";
                break;
            case "07":
                $mes = "Julio";
                break;
            case "08":
                $mes = "Agosto";
                break;
            case "09":
                $mes = "Septiembre";
                break;
            case "10":
                $mes = "Octubre";
                break;
            case "11":
                $mes = "Noviembre";
                break;
            case "12":
                $mes = "Diciembre";
                break;
        }
        $ano = date("Y", $fecha); // optenemos el año en formato 4 digitos
        $fecha = $dia . " " . $mes . ", " . $ano; // unimos el resultado en una unica cadena
        return $fecha; //enviamos la fecha al programa
    }

    public static function convertirAJsonItems($array) {

        if ($array != null && count($array) > 0) {


            $json = json_encode($array,JSON_UNESCAPED_UNICODE,JSON_UNESCAPED_SLASHES);
            $items = '{ "Items" :';
            $json = "'" . $items . $json . "}'";

            return $json;
        } else {
            return null;
        }
    }

}

function tildes($cadena) {
    $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹");
    $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E");
    $texto = str_replace($no_permitidas, $permitidas, $cadena);
    return $texto;
}

?>