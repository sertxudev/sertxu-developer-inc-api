<?php
class ComprasModel extends DatabaseModel {
    private $id;
    private $id_user;
    private $id_producto;
    private $cantidad;
    private $precio;
    private $saldo_utilizado;
    private $fecha;

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
    function getId_user() {
        return $this->id_user;
    }

    /**
     * @param string $id_user
     */
    function setId_user(string $id_user) {
        $this->id_user = $id_user;
    }

    /**
     * @return string
     */
    function getId_producto() {
        return $this->id_producto;
    }

    /**
     * @param string $id_producto
     */
    function setId_producto(string $id_producto) {
        $this->id_producto = $id_producto;
    }

    /**
     * @return string
     */
    function getCantidad() {
        return $this->cantidad;
    }

    /**
     * @param string $cantidad
     */
    function setCantidad(string $cantidad) {
        $this->cantidad = $cantidad;
    }

    /**
     * @return string
     */
    function getPrecio() {
        return $this->precio;
    }

    /**
     * @param string $precio
     */
    function setPrecio(string $precio) {
        $this->precio = $precio;
    }

    /**
     * @return string
     */
    function getSaldo_utilizado() {
        return $this->saldo_utilizado;
    }

    /**
     * @param string $saldo_utilizado
     */
    function setSaldo_utilizado(string $saldo_utilizado) {
        $this->saldo_utilizado = $saldo_utilizado;
    }

    /**
     * @return string
     */
    function getFecha() {
        return $this->fecha;
    }

    /**
     * @param string $fecha
     */
    function setFecha(string $fecha) {
        $this->fecha = $fecha;
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
            return $this->update('compras', array(
                'id' => $this->getId(),
                'id_user' => $this->getId_user(),
                'id_producto' => $this->getId_producto(),
                'cantidad' => $this->getCantidad(),
                'precio' => $this->getPrecio(),
                'saldo_utilizado' => $this->getSaldo_utilizado(),
                'fecha' => $this->getFecha()
            ), rtrim($where, $condition." "));
        } else {
            return $this->insert('compras', array(
                'id_user' => $this->getId_user(),
                'id_producto' => $this->getId_producto(),
                'cantidad' => $this->getCantidad(),
                'precio' => $this->getPrecio(),
                'saldo_utilizado' => $this->getSaldo_utilizado(),
                'fecha' => $this->getFecha()
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
        $pdo = $this->select('compras', $where = "", $fields, $order, $limit, $offset);
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
        return $this->select('compras', 'id = '.$id, $fields, $order, $limit, $offset)->fetch(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $id_user Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findById_user($id_user, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('compras', 'id_user = '.$id_user, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param int $id_producto Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findById_producto($id_producto, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('compras', 'id_producto = '.$id_producto, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param int $cantidad Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByCantidad($cantidad, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('compras', 'cantidad = '.$cantidad, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param int $precio Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByPrecio($precio, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('compras', 'precio = '.$precio, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param int $saldo_utilizado Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findBySaldo_utilizado($saldo_utilizado, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('compras', 'saldo_utilizado = '.$saldo_utilizado, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $fecha Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByFecha($fecha, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('compras', 'fecha = '.$fecha, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
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
        return $this->select('compras', rtrim($where, $condition." "), $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);
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
        return $this->delete('compras', rtrim($where, $condition." "));
    }

    /**
    * Drop the database
    * 
    * @return boolean True = No errors, False = Something went wrong
    */
    function truncate(){
        if($this->truncateTable('compras') === 0){
            return true;
        } else {
            return false; 
        }
    }
}