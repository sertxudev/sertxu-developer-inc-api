<?php
class TokenController {
     
    public function loginToken($post_email, $post_token){
        $email = sanitize::string($post_email);
        $token = sanitize::string($post_token);
        
        $login = new TokenModel();
        $login->setUser($email);
        $login->setToken($token);
        return json_encode($login->loginToken()[0]);
    }
    
    public function createToken($post_user){
        $token = new TokenModel();
        $token->setUser(sanitize::string($post_user));
        $token->setToken(hash('sha256', microtime()));
        if($token->save()){
            return $token->getToken();
        }else{
            return false;
        }        
    }
    
    
}