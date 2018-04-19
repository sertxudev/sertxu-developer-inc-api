<?php
class UsersController {
     
    public function loginUser($post_email, $post_pass){
        $login = new UsersModel();
        $login->setEmail(sanitize::string($post_email));
        $login->setPassword(hash('sha512', sanitize::string($post_pass)));
        $result = $login->loginUser();
        if($result){
            return json_encode($result[0]);
        }else{
            return json_encode(false);
        }
    }
    
    public function registerUser($post_name, $post_surname, $post_email, $post_pass, $post_phone, $post_dni, $post_birthday){
        
        $register = new UsersModel();
        
        $register->setName(sanitize::string($post_name));
        $register->setSurname(sanitize::string($post_surname));
        $register->setEmail(sanitize::string($post_email));
        $register->setPassword(hash('sha512', sanitize::string($post_pass)));
        $register->setPhone(sanitize::string($post_phone));
        $register->setDni(sanitize::string($post_dni));
        $register->setBirthday(sanitize::string($post_birthday));
        $register->setTipo(0);
        
        if($register->save()){
            $token = new TokenController();
            $session = $token->createToken($register->getLastId());
            if($session){
                $saldo = new SaldoModel();
                $saldo->setId_user($register->getLastId());
                $saldo->setSaldo(0);
                $saldo->save();
                $result = ['name' => $register->getName(),
                    'surname' => $register->getSurname(),
                    'email' => $register->getEmail(),
                    'phone' => $register->getPhone(),
                    'dni' => $register->getDni(),
                    'birthday' => $register->getBirthday(),
                    'token' => $session];
                
                return json_encode($result);
            }
        }
        return json_encode(false);
    }
    
    public function editUser($email, $name, $surname, $phone, $dni, $birthday, $token, $password = false) {
        $edit = new UsersModel();
        $edit->setEmail($email);
        $edit->setBirthday($birthday);
        $edit->setDni($dni);
        $edit->setName($name);
        $edit->setPhone($phone);
        $edit->setSurname($surname);
        if($password){
            $edit->setPassword(hash('sha512', $password));
        }
        
        $model_token = new TokenModel();
        $id_user = $model_token->findByToken($token)[0]['user'];
        
        return json_encode($edit->save(['id' => $id_user]));
    }
}