<?php
class FiestasModel extends DatabaseModel {
    private $id;
    private $fecha_inicial;
    private $fecha_final;

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
    function getFecha_inicial() {
        return $this->fecha_inicial;
    }

    /**
     * @param string $fecha_inicial
     */
    function setFecha_inicial(string $fecha_inicial) {
        $this->fecha_inicial = $fecha_inicial;
    }

    /**
     * @return string
     */
    function getFecha_final() {
        return $this->fecha_final;
    }

    /**
     * @param string $fecha_final
     */
    function setFecha_final(string $fecha_final) {
        $this->fecha_final = $fecha_final;
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
            return $this->update('fiestas', array(
                'id' => $this->getId(),
                'fecha_inicial' => $this->getFecha_inicial(),
                'fecha_final' => $this->getFecha_final()
            ), rtrim($where, $condition." "));
        } else {
            return $this->insert('fiestas', array(
                'fecha_inicial' => $this->getFecha_inicial(),
                'fecha_final' => $this->getFecha_final()
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
        $pdo = $this->select('fiestas', $where = "", $fields, $order, $limit, $offset);
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
        return $this->select('fiestas', 'id = '.$id, $fields, $order, $limit, $offset)->fetch(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $fecha_inicial Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByFecha_inicial($fecha_inicial, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('fiestas', 'fecha_inicial = '.$fecha_inicial, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $fecha_final Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByFecha_final($fecha_final, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('fiestas', 'fecha_final = '.$fecha_final, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
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
        return $this->select('fiestas', rtrim($where, $condition." "), $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);
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
        return $this->delete('fiestas', rtrim($where, $condition." "));
    }

    /**
    * Drop the database
    * 
    * @return boolean True = No errors, False = Something went wrong
    */
    function truncate(){
        if($this->truncateTable('fiestas') === 0){
            return true;
        } else {
            return false; 
        }
    }
    
    function obtainFiestas($date){
        return $this->query("SELECT * FROM fiestas WHERE (fecha_inicial BETWEEN '$date' "
                . "AND LAST_DAY( '$date' )) OR (fecha_final BETWEEN '$date' "
                . "AND LAST_DAY( '$date' ))");
    }
}