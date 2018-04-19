<?php
    
class sanitize {
    
    public static function string(string $string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }
    
    public static function email(string $email){
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }
}