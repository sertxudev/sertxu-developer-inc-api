<?php
class SalasController {
     
    public function obtainSala($id){
        $sala = new SalasModel();
        echo json_encode($sala->findById($id));
    }
    
    public function obtainSalas() {
        $sala = new SalasModel();
        echo json_encode($sala->find());
    }

}