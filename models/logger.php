<?php
class logger {

    public static function guardar($texto) {
        if(logging){
            $nombre = _LOGS_FOLDER_."Log_".date("d-m-Y").".txt";
            $fecha = date("d-m-Y H-i-s: ");
            $fopen = fopen($nombre, "a");
            fwrite($fopen, $fecha.$texto."\n");
            fclose($fopen);        
        }
    }
    
}