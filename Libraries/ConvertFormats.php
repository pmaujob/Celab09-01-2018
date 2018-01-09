<?php

class ConvertFormats {

    public static function formatDate($fecha) {

        $fecha = strtotime($fecha);
        $diasemana = date("w", $fecha);
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
        $dia = date("d", $fecha);
        $mes = date("m", $fecha);
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
        $ano = date("Y", $fecha);
        $fecha = $dia . " de " . $mes . " de " . $ano;
        return $fecha;
    }

    public static function convertToJsonItems($array) {
        if ($array != null && count($array) > 0) {
            $json = json_encode($array, JSON_UNESCAPED_SLASHES);
            $items = '{ "Items" :';
            $json = "'" . $items . $json . "}'";
            return $json;
        } else {
            return null;
        }
    }

}
?>

