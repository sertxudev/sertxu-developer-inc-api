<?php

class FiestasController {

    function obtainFiestas($date) {
        $fiestas = new FiestasModel();
        $array = $fiestas->obtainFiestas($date);

        $result = array();
        foreach ($array as $v) {
            $result = array_merge($result, $this->obtenerDias($v));
        }
        
        echo json_encode($result);
        
    }

    private function obtenerDias($array) {

        if ($array['fecha_inicial'] > $array['fecha_final']) {
            return false;
        }

        $startDate = new DateTime($array['fecha_inicial']);
        $endDate = new DateTime($array['fecha_final']);

        $periodInt = new DateInterval("P1D");
        $endDate->add($periodInt);

        $periodo = new DatePeriod($startDate, $periodInt, $endDate);
        $result = array();
        foreach ($periodo as $n => $dias) {
            $result[$n] = [
                "dia" => $dias->format("d"), 
                "mes" => $dias->format("m"), 
                "anno" => $dias->format("Y"),
                "label" => "Fiesta"
                ];
        }
        return $result;
    }
}
