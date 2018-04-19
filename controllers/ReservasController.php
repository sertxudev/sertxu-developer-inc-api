<?php

class ReservasController {

    function obtenerHoras($fecha, $sala) {
        $model_reserva = new ReservasModel();
        echo json_encode($model_reserva->obtenerHoras($fecha, $sala));
    }

    function obtainReservas($token) {
        $model_reserva = new ReservasModel();
        $model_token = new TokenModel();
        $model_reserva->setUser($model_token->findByToken($token)[0]['user']);
        echo json_encode($model_reserva->obtainReservas($model_reserva->getUser()));
    }

    function realizarPrereserva($token, $sala, $dia, $horas) {
        $reserva = new ReservasModel();
        $model_token = new TokenModel();
        $response = [];
        $reserva->setSala($sala);
        $reserva->setStatus(1);
        $reserva->setUser($model_token->findByToken($token)[0]['user']);

        foreach ($horas as $hora) {
            $fecha_inicial = new DateTime($dia . ' ' . $hora->hora . ':00:00');
            $fecha_final = new DateTime($dia . ' ' . $hora->hora . ':59:59');
            if (!$reserva->findBy(["fecha_inicial" => $fecha_inicial->format('Y-m-d H:i:s'), "sala" => $sala, "status" => 0])) {

                $reserva->setFecha_inicial($fecha_inicial->format('Y-m-d H:i:s'));
                $reserva->setFecha_final($fecha_final->format('Y-m-d H:i:s'));

                if ($reserva->findBy(["fecha_inicial" => $fecha_inicial->format('Y-m-d H:i:s'), "sala" => $sala, "status" => 1, "user!" => intval($reserva->getUser())])) {
                    if ($reserva->save()) {
                        $response[] = ["id" => $reserva->getLastId(), "hora" => $hora->hora, "code" => 'warning_hour_prereserved'];
                    }
                } else {
                    if ($reserva->save()) {
                        $response[] = ["id" => $reserva->getLastId(), "hora" => $hora->hora, "code" => 'notice_hour_available'];
                    }
                }
            } else {
                $response[] = ["hora" => $hora->hora, "code" => 'error_hour_already_booked'];
            }
        }
        echo json_encode($response);
    }

    function realizarReserva($sala, $dia, $reservas) {
        $reserva = new ReservasModel();
        $response = [];
        $reserva->setStatus(0);

        foreach ($reservas as $id_reserva) {
            $fecha_inicial = new DateTime($dia . ' ' . $id_reserva->hora . ':00:00');

            if (!$reserva->findBy(["fecha_inicial" => $fecha_inicial->format('Y-m-d H:i:s'), "sala" => $sala, "status" => 0])) {
                if ($reserva->save(["id" => $id_reserva->id])) {
                    $response[] = ["id" => $id_reserva->id, "hora" => $id_reserva->hora, "code" => 'notice_hour_booked'];
                }
            } else {
                $response[] = ["id" => $id_reserva->id, "hora" => $id_reserva->hora, "code" => 'error_hour_already_booked'];
            }
        }
        echo json_encode($response);
    }

    function eliminarReserva($reservas) {
        logger::guardar('pepe');
        $reserva = new ReservasModel();
        $response = [];
        $reserva->setStatus(1);

        foreach ($reservas as $id_reserva) {
            logger::guardar($id_reserva->id);
            if ($reserva->save(["id" => $id_reserva->id])) {
                $response[] = ["id" => $id_reserva->id, "hora" => $id_reserva->hora, "code" => 'notice_hour_removed'];
            }
        }
        echo json_encode($response);
    }

}
