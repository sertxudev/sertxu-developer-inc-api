<?php
class SaldoController {
     
    public function obtainSaldo($token){
        $model_token = new TokenModel();
        $model_saldo = new SaldoModel();
        return json_encode($model_saldo->findById_user($model_token->findByToken($token)[0]['user'], "saldo"));
    }
    
    public function restarSaldo($token, $saldo){
        $model_token = new TokenModel();
        $model_saldo = new SaldoModel();
        $id_user = $model_token->findByToken($token)[0]['user'];
        $model_saldo->setSaldo($model_saldo->findById_user($id_user)['saldo'] - $saldo);
        return $model_saldo->save(['id_user' => $id_user]);
    }

}