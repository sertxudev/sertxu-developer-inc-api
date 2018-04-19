<?php
class UsersModel extends DatabaseModel {
    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $phone;
    private $dni;
    private $birthday;
    private $tipo;

    /**
     * @return string
     */
    function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     */
    function setId(string $id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    function setName(string $name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    function getSurname() {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    function setSurname(string $surname) {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    function setEmail(string $email) {
        $this->email = $email;
    }

    /**
     * @return string
     */
    function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     */
    function setPassword(string $password) {
        $this->password = $password;
    }

    /**
     * @return string
     */
    function getPhone() {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    function setPhone(string $phone) {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    function getDni() {
        return $this->dni;
    }

    /**
     * @param string $dni
     */
    function setDni(string $dni) {
        $this->dni = $dni;
    }

    /**
     * @return string
     */
    function getBirthday() {
        return $this->birthday;
    }

    /**
     * @param string $birthday
     */
    function setBirthday(string $birthday) {
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    function getTipo() {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    function setTipo(string $tipo) {
        $this->tipo = $tipo;
    }

    /**
    * If the $identifier is not defined, this function will INSERT using the values defined in the object.
    * 
    * If it's defined, this function will UPDATE using the values defined in the object, and the condition will be the $identifier.
    * You can define the $condition too.
    * 
    * Ex. save(array('id' => 1));
    * 
    * Ex. save(array('id' => 1, 'status' => 0), 'OR');
    * 
    * 
    * @param array $identifier Not required
    * @param string $condition Not required, default value "AND"
    * 
    * @return int Return the number of columns affected
    *
    */
    function save(array $identifier = null, string $condition = 'AND') {
        if($identifier){
            $where = '';
            foreach ($identifier as $key => $value){
                (is_int($value)) ? $where .= $key.' = '.$value.' '.$condition.' ' : $where .= $key.' = "'.$value.'" '.$condition.' ';
            }
            return $this->update('users', array(
                'id' => $this->getId(),
                'name' => $this->getName(),
                'surname' => $this->getSurname(),
                'email' => $this->getEmail(),
                'password' => $this->getPassword(),
                'phone' => $this->getPhone(),
                'dni' => $this->getDni(),
                'birthday' => $this->getBirthday(),
                'tipo' => $this->getTipo()
            ), rtrim($where, $condition." "));
        } else {
            return $this->insert('users', array(
                'name' => $this->getName(),
                'surname' => $this->getSurname(),
                'email' => $this->getEmail(),
                'password' => $this->getPassword(),
                'phone' => $this->getPhone(),
                'dni' => $this->getDni(),
                'birthday' => $this->getBirthday(),
                'tipo' => $this->getTipo()
            ));
        }
    }

    /**
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a global array with every row in a single array
    */
    function find($fields = '*', $order = "", $limit = null, $offset = null) {
        $pdo = $this->select('users', $where = "", $fields, $order, $limit, $offset);
        return $pdo->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
    * @param int $id Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findById($id, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('users', 'id = '.$id, $fields, $order, $limit, $offset)->fetch(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $name Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByName($name, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('users', 'name = '.$name, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $surname Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findBySurname($surname, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('users', 'surname = '.$surname, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $email Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByEmail($email, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('users', 'email = '.$email, $fields, $order, $limit, $offset)->fetch(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $password Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByPassword($password, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('users', 'password = '.$password, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $phone Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByPhone($phone, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('users', 'phone = '.$phone, $fields, $order, $limit, $offset)->fetch(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $dni Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByDni($dni, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('users', 'dni = '.$dni, $fields, $order, $limit, $offset)->fetch(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $birthday Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByBirthday($birthday, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('users', 'birthday = '.$birthday, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param int $tipo Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByTipo($tipo, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('users', 'tipo = '.$tipo, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param array $identifier Not required
    * @param string $condition Not required, default value "AND"
    * 
    * Ex. findBy(array('id' => 1));
    * 
    * Ex. findBy(array('id' => 1, 'status' => 0), 'OR');
    * 
    * 
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a global array with every row in a single array
    */
    function findBy(array $identifier, $condition = "AND" , $fields = '*', $order = "", $limit = null, $offset = null) {
        $where = '';
        foreach ($identifier as $key => $value){
            (is_int($value)) ? $where .= $key.' = '.$value.' '.$condition.' ' : $where .= $key.' = "'.$value.'" '.$condition.' ';
        }
        return $this->select('users', rtrim($where, $condition." "), $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
    * @param array $identifier Not required
    * @param string $condition Not required, default value "AND"
    * 
    * Ex. destroy(array('id' => 1));
    * 
    * Ex. destroy(array('id' => 1, 'status' => 0), 'OR');
    * 
    * 
    * @return int Return the number of columns affected
    */
    function destroy(array $identifier, $condition = "AND") {
        $where = '';
        foreach ($identifier as $key => $value){
            (is_int($value)) ? $where .= $key.' = '.$value.' '.$condition.' ' : $where .= $key.' = "'.$value.'" '.$condition.' ';
        }
        return $this->delete('users', rtrim($where, $condition." "));
    }

    /**
    * Drop the database
    * 
    * @return boolean True = No errors, False = Something went wrong
    */
    function truncate(){
        if($this->truncateTable('users') === 0){
            return true;
        } else {
            return false; 
        }
    }
    
    public function loginUser(){
        return $this->query("SELECT U.name as name, U.surname as surname, U.email as email, U.phone as phone, U.dni as dni, U.birthday as birthday, T.token as token "
                . "FROM users as U JOIN tokens AS T ON U.id=T.user WHERE U.email='$this->email' AND U.password='$this->password'");
    }
}