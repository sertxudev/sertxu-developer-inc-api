<?php

include_once './config.php';

if (!isset($_GET['r'])) {
    $_GET['r'] = null;
}

switch ($_GET['r']) {

    case 'loginUser':
        $user = new UsersController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $user->loginUser($request->email, $request->password);
        break;

    case 'loginToken':
        $user = new TokenController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $user->loginToken($request->email, $request->token);
        break;

    case 'registerUser':
        $user = new UsersController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $user->registerUser($request->nombre, $request->apellidos, $request->email, $request->password, $request->phone, $request->dni, $request->birthday);
        break;

    case 'editUser':
        $user = new UsersController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $user->editUser($request->email, $request->nombre, $request->apellidos, $request->phone, $request->dni, $request->birthday, $request->token, $request->password);
        break;

    case 'obtainNews':
        $news = new NewsController();
        echo $news->obtainNews();
        break;

    case 'obtainFiestas':
        $fiestas = new FiestasController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $fiestas->obtainFiestas($request->date);
        break;

    case 'obtainHoras':
        $reservas = new ReservasController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $reservas->obtenerHoras($request->date, $request->sala);
        break;

    case 'obtainReservas':
        $reservas = new ReservasController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $reservas->obtainReservas($request->token);
        break;
        
    case 'obtainSaldo':
        $saldo = new SaldoController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $saldo->obtainSaldo($request->token);
        break;
    
    case 'realizarPrereserva':
        $reservas = new ReservasController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $reservas->realizarPrereserva($request->token, $request->sala, $request->date, $request->hora);
        break;
    
    case 'realizarReserva':
        $reservas = new ReservasController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $reservas->realizarReserva($request->sala, $request->date, $request->reservas);
        break;
    
    case 'eliminarReserva':
        $reservas = new ReservasController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $reservas->eliminarReserva($request->reservas);
        break;
        
    case 'obtainSalas':
        $saldo = new SalasController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $saldo->obtainSalas();
        break;
    
    case 'obtainSala':
        $saldo = new SalasController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $saldo->obtainSala($request->id);
        break;

    case 'restarSaldo':
        $saldo = new SaldoController();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        echo $saldo->restarSaldo($request->token, $request->saldo);
        break;
}

// Select fiestas del mes actual a partir de la fecha actual
// SELECT * FROM fiestas WHERE (fecha_inicial BETWEEN date(now()) AND LAST_DAY( now() )) OR (fecha_final BETWEEN date(now()) AND LAST_DAY( now() ))

// Select reservas del mes actual a partir de la fecha actual
// SELECT * FROM reservas WHERE fecha_inicial BETWEEN date(now()) AND LAST_DAY(now())