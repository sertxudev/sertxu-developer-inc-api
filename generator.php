<?php
ini_set("display_errors", 0);

$set_namespace_models = 'models';
$set_namespace_controllers = 'controllers';
$set_dbModel = 'DatabaseModel';

$set_dbAddress  = 'localhost';
$set_dbType     = 'mysql';
$set_dbName     = 'database';
$set_dbUser     = 'username';
$set_dbPass     = 'password';

////////////////////////////////////////////////////////////////////////////////

$set_tableName  = 'users';

$set_rows = array(
    'id' => 'int_unique_AI',
    'name' => 'string',
    'surname' => 'string',
    'email' => 'string_unique',
    'password' => 'string',
    'phone' => 'string_unique',
    'dni' => 'string_unique',
    'birthday' => 'string',
    'tipo' => 'int',
);

createTableModel($set_namespace_models, $set_dbModel, $set_tableName, $set_rows);
createTableController($set_namespace_controllers, $set_tableName);

////////////////////////////////////////////////////////////////////////////////

$set_tableName  = 'saldo';

$set_rows = array(
    'id_user' => 'int_unique',
    'saldo' => 'int',
);

createTableModel($set_namespace_models, $set_dbModel, $set_tableName, $set_rows);
createTableController($set_namespace_controllers, $set_tableName);

////////////////////////////////////////////////////////////////////////////////

$set_tableName  = 'token';

$set_rows = array(
    'id' => 'int_unique_AI',
    'user' => 'int',
    'token' => 'string',
);

createTableModel($set_namespace_models, $set_dbModel, $set_tableName, $set_rows);
createTableController($set_namespace_controllers, $set_tableName);

////////////////////////////////////////////////////////////////////////////////

$set_tableName  = 'salas';

$set_rows = array(
    'id' => 'int_unique_AI',
    'nombre' => 'string',
    'foto' => 'string',
    'descripcion' => 'string',
);

createTableModel($set_namespace_models, $set_dbModel, $set_tableName, $set_rows);
createTableController($set_namespace_controllers, $set_tableName);

////////////////////////////////////////////////////////////////////////////////

$set_tableName  = 'reservas';

$set_rows = array(
    'id' => 'int_unique_AI',
    'sala' => 'int',
    'fecha_inicial' => 'string',
    'fecha_final' => 'string',
    'user' => 'int',
    'status' => 'int',
);

createTableModel($set_namespace_models, $set_dbModel, $set_tableName, $set_rows);
createTableController($set_namespace_controllers, $set_tableName);

////////////////////////////////////////////////////////////////////////////////

$set_tableName  = 'news';

$set_rows = array(
    'id' => 'int_unique_AI',
    'title' => 'string',
    'description' => 'string',
    'icon' => 'string',
    'date' => 'string',
);

createTableModel($set_namespace_models, $set_dbModel, $set_tableName, $set_rows);
createTableController($set_namespace_controllers, $set_tableName);

////////////////////////////////////////////////////////////////////////////////

$set_tableName  = 'fiestas';

$set_rows = array(
    'id' => 'int_unique_AI',
    'fecha_inicial' => 'string',
    'fecha_final' => 'string',
);

createTableModel($set_namespace_models, $set_dbModel, $set_tableName, $set_rows);
createTableController($set_namespace_controllers, $set_tableName);

////////////////////////////////////////////////////////////////////////////////

$set_tableName  = 'compras';

$set_rows = array(
    'id' => 'int_unique_AI',
    'id_user' => 'string',
    'id_producto' => 'int',
    'cantidad' => 'int',
    'precio' => 'int',
    'saldo_utilizado' => 'int',
    'fecha' => 'string',
);

createTableModel($set_namespace_models, $set_dbModel, $set_tableName, $set_rows);
createTableController($set_namespace_controllers, $set_tableName);

////////////////////////////////////////////////////////////////////////////////

createDatabaseModel($set_namespace_models, $set_dbModel);
createLogger($set_namespace_models);
createConfig($set_namespace_models, $set_namespace_controllers, $set_dbAddress, $set_dbType, $set_dbName, $set_dbUser, $set_dbPass);
createSanitizer($set_namespace_models);


/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// GENERATING MODEL FILES //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

function createTableModel($namespace_model, $dbModel, $tableName, $rows) {

$file = '<?php
class '.ucfirst($tableName).'Model extends '.$dbModel.' {';

    foreach($rows as $key => $value){
        $file .= '
    private $'.$key.';';
    }

    foreach($rows as $key => $value){
        $file .= '

    /**
     * @return string
     */
    function get'.ucfirst($key).'() {
        return $this->'.$key.';
    }

    /**
     * @param string $'.$key.'
     */
    function set'.ucfirst($key).'(string $'.$key.') {
        $this->'.$key.' = $'.$key.';
    }';
    }

    $file .= '

    /**
    * If the $identifier is not defined, this function will INSERT using the values defined in the object.
    * 
    * If it\'s defined, this function will UPDATE using the values defined in the object, and the condition will be the $identifier.
    * You can define the $condition too.
    * 
    * Ex. save(array(\'id\' => 1));
    * 
    * Ex. save(array(\'id\' => 1, \'status\' => 0), \'OR\');
    * 
    * 
    * @param array $identifier Not required
    * @param string $condition Not required, default value "AND"
    * 
    * @return int Return the number of columns affected
    *
    */
    function save(array $identifier = null, string $condition = \'AND\') {
        if($identifier){
            $where = \'\';
            foreach ($identifier as $key => $value){
                (is_int($value)) ? $where .= $key.\' = \'.$value.\' \'.$condition.\' \' : $where .= $key.\' = "\'.$value.\'" \'.$condition.\' \';
            }
            return $this->update(\''.$tableName.'\', array(';

        $string = '';
        foreach($rows as $key => $value){
            $string .= '
                \''.$key.'\' => $this->get'.ucfirst($key).'(),';
        }
        $file .= rtrim($string,',');

        $file .= '
            ), rtrim($where, $condition." "));
        } else {
            return $this->insert(\''.$tableName.'\', array(';

    $string = '';
    foreach($rows as $key => $value){
        if(explode('_', $value)[2] !== 'AI'){
            $string .= '
                \''.$key.'\' => $this->get'.ucfirst($key).'(),';
        }        
    }
    $file .= rtrim($string,',');

    $file .= '
            ));
        }
    }';

    $file .= '

    /**
    * @param string $fields Not required, default value \'*\'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a global array with every row in a single array
    */
    function find($fields = \'*\', $order = "", $limit = null, $offset = null) {
        $pdo = $this->select(\''.$tableName.'\', $where = "", $fields, $order, $limit, $offset);
        return $pdo->fetchAll(PDO::FETCH_ASSOC);
    }';

    foreach($rows as $key => $value){
        $file .= '

    /**
    * @param '.explode('_', $value)[0].' $'.$key.' Required
    * @param string $fields Not required, default value \'*\'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findBy'.ucfirst($key).'($'.$key.', $fields = \'*\', $order = "", $limit = null, $offset = null) {
        return $this->select(\''.$tableName.'\', \''.$key.' = \'.$'.$key.', $fields, $order, $limit, $offset)';
    if(isset(explode('_', $value)[1]) && (explode('_', $value)[1] == 'unique')){
        $file .= '->fetch(PDO::FETCH_ASSOC);';
    }else{
        $file .= '->fetchAll(PDO::FETCH_ASSOC);';
    }
    $file .= '        
    }';
    }

    $file .= '

    /**
    * @param array $identifier Not required
    * @param string $condition Not required, default value "AND"
    * 
    * Ex. findBy(array(\'id\' => 1));
    * 
    * Ex. findBy(array(\'id\' => 1, \'status\' => 0), \'OR\');
    * 
    * 
    * @param string $fields Not required, default value \'*\'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a global array with every row in a single array
    */
    function findBy(array $identifier, $condition = "AND" , $fields = \'*\', $order = "", $limit = null, $offset = null) {
        $where = \'\';
        foreach ($identifier as $key => $value){
            (is_int($value)) ? $where .= $key.\' = \'.$value.\' \'.$condition.\' \' : $where .= $key.\' = "\'.$value.\'" \'.$condition.\' \';
        }
        return $this->select(\''.$tableName.'\', rtrim($where, $condition." "), $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);
    }';

    $file .= '

    /**
    * @param array $identifier Not required
    * @param string $condition Not required, default value "AND"
    * 
    * Ex. destroy(array(\'id\' => 1));
    * 
    * Ex. destroy(array(\'id\' => 1, \'status\' => 0), \'OR\');
    * 
    * 
    * @return int Return the number of columns affected
    */
    function destroy(array $identifier, $condition = "AND") {
        $where = \'\';
        foreach ($identifier as $key => $value){
            (is_int($value)) ? $where .= $key.\' = \'.$value.\' \'.$condition.\' \' : $where .= $key.\' = "\'.$value.\'" \'.$condition.\' \';
        }
        return $this->delete(\''.$tableName.'\', rtrim($where, $condition." "));
    }';

    $file .= '

    /**
    * Drop the database
    * 
    * @return boolean True = No errors, False = Something went wrong
    */
    function truncate(){
        if($this->truncateTable(\''.$tableName.'\') === 0){
            return true;
        } else {
            return false; 
        }
    }
}';

    $content = <<<EOF
$file
EOF;
    if(!file_exists('./'.$namespace_model)){
        mkdir('./'.$namespace_model);
    }
    file_put_contents('./'.$namespace_model.'/'.ucfirst($tableName).'Model.php', $content);
    echo './'.$namespace_model.'/'.ucfirst($tableName).'Model.php Created <br>';
}

function createTableController($namespace_controller, $tableName){
$file = '<?php
class '.ucfirst($tableName).'Controller {
     
    

}';

    $content = <<<EOF
$file
EOF;
    if(!file_exists('./'.$namespace_controller)){
        mkdir('./'.$namespace_controller);
    }
    file_put_contents('./'.$namespace_controller.'/'.ucfirst($tableName).'Controller.php', $content);
    echo './'.$namespace_controller.'/'.ucfirst($tableName).'Controller.php Created <br>';
}

function createDatabaseModel($namespace, $dbModel){

$file = '<?php
class '.$dbModel.' {

    private $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO(_TYPE_ . ":dbname=" . _BBDD_ . ";host=" . _HOST_, _USER_, _PASS_);
            $this->conexion->query("SET NAMES \'utf8\'");
            logger::guardar("Connected to the DDBB");
        } catch (PDOException $e) {
            echo \'Connection failed: \' . $e->getMessage();
            logger::guardar("Error while connecting: " . $e->getMessage());
        }
    }

    public function query(string $query) {
        try {
            return $this->conexion->query($query)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            logger::guardar("Error while executing the query: " . $e->getMessage());
        }
    }

    public function select(string $table, $where = "", $fields = \'*\', $order = "", $limit = null, $offset = null){
        $query = \'SELECT \' . $fields . \' FROM \' . $table
               . (($where) ? \' WHERE \' . $where : "")
               . (($order) ? \' ORDER BY \' . $order.\'\' : "")
               . (($limit) ? \' LIMIT \' . $limit : "")
               . (($offset && $limit) ? \' OFFSET \' . $offset : "");
        logger::guardar($query);
        return $this->conexion->query($query);
    }

    public function insert($table, array $data){
        $fields = implode(\', \', array_keys($data));
        $values = implode(\'", "\', array_values($data));
        $query = \'INSERT INTO \' . $table . \' (\' . $fields . \') VALUES ("\' . $values . \'")\';
        logger::guardar($query);
        return $result = $this->conexion->exec($query);
    }

    public function update($table, array $data, $where = ""){
        $set = array();
        foreach ($data as $field => $value) {
            if($value){
                $value = (is_int($value))? $value : \'"\'.$value.\'"\';
                $set[] = $field . \' = \' . $value;
            }
        }
        $set = implode(\', \', $set);
        $query = \'UPDATE \' . $table . \' SET \' . $set 
               . (($where) ? \' WHERE \' . $where : "");
        logger::guardar($query);
        return $this->conexion->exec($query);
    }

    public function delete($table, $where = ""){
        $query = \'DELETE FROM \' . $table
               . (($where) ? \' WHERE \' . $where : "");
        logger::guardar($query);
        return $this->conexion->exec($query);
    }

    public function truncateTable($table){
        $query = \'TRUNCATE \' . $table;
        logger::guardar($query);
        return $this->conexion->exec($query);
    }
}';
    
    $content = <<<EOF
$file
EOF;
    if(!file_exists('./'.$namespace)){
        mkdir('./'.$namespace);
    }
    file_put_contents('./'.$namespace.'/'.ucfirst($dbModel).'.php', $content);
    echo './'.$namespace.'/'.ucfirst($dbModel).'.php Created<br>';
    echo '';
}

function createLogger($namespace_model){
    
$file = '<?php
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
    
}';

    $content = <<<EOF
$file
EOF;
    if(!file_exists('./'.$namespace_model)){
        mkdir('./'.$namespace_model);
    }
    file_put_contents('./'.$namespace_model.'/logger.php', $content);
    echo './'.$namespace_model.'/logger.php Created <br>';

}

function createConfig($namespace_model, $namespace_controller, $dbAddress, $dbType,$dbName, $dbUser, $dbPass){

$file = '<?php

define("_LOGS_FOLDER_", "logs/");

if(file_exists(_LOGS_FOLDER_."logging")){
    define("logging", true);
}else{
    define("logging", false);
}

if(logging){
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

define("_HOST_", "'.$dbAddress.'");
define("_BBDD_", "'.$dbName.'");
define("_USER_", "'.$dbUser.'");
define("_PASS_", "'.$dbPass.'");
define("_TYPE_", "'.$dbType.'");

spl_autoload_register(function ($class) {
    if(strstr($class, \'Controller\')) {
        include \'./'.$namespace_controller.'/\'.$class.\'.php\';
    } else {
        include \'./'.$namespace_model.'/\'.$class.\'.php\';
    }
});';

    $content = <<<EOF
$file
EOF;
    
    file_put_contents('./config.php', $content);
    echo './config.php Created <br>';
    
}

function createSanitizer($namespace_model){
    
$file = '<?php
    
class sanitize {
    
    public static function string(string $string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }
    
    public static function email(string $email){
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }
}';

    $content = <<<EOF
$file
EOF;
    if(!file_exists('./'.$namespace_model)){
        mkdir('./'.$namespace_model);
    }
    file_put_contents('./'.$namespace_model.'/sanitize.php', $content);
    echo './'.$namespace_model.'/sanitize.php Created <br>';

}