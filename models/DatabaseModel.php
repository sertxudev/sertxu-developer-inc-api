<?php

class DatabaseModel {

    private $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO(_TYPE_ . ":dbname=" . _BBDD_ . ";host=" . _HOST_, _USER_, _PASS_);
            $this->conexion->query("SET NAMES 'utf8'");
            logger::guardar("Connected to the DDBB");
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            logger::guardar("Error while connecting: " . $e->getMessage());
        }
    }

    public function query(string $query) {
        logger::guardar($query);
        return $this->conexion->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select(string $table, $where = "", $fields = '*', $order = "", $limit = null, $offset = null) {
        $query = 'SELECT ' . $fields . ' FROM ' . $table
                . (($where) ? ' WHERE ' . $where : "")
                . (($order) ? ' ORDER BY ' . $order . '' : "")
                . (($limit) ? ' LIMIT ' . $limit : "")
                . (($offset && $limit) ? ' OFFSET ' . $offset : "");
        logger::guardar($query);
        return $this->conexion->query($query);
    }

    public function insert($table, array $data) {
        $fields = implode(', ', array_keys($data));
        $values = implode('", "', array_values($data));
        $query = 'INSERT INTO ' . $table . ' (' . $fields . ') VALUES ("' . $values . '")';
        logger::guardar($query);
        return $result = $this->conexion->exec($query);
    }

    public function update($table, array $data, $where = "") {
        $set = array();
        foreach ($data as $field => $value) {

            if (isset($value)) {
                $value = (is_int($value)) ? $value : '"' . $value . '"';
                $set[] = $field . ' = ' . $value;
            }
        }
        $set = implode(', ', $set);
        $query = 'UPDATE ' . $table . ' SET ' . $set
                . (($where) ? ' WHERE ' . $where : "");
        logger::guardar($query);
        return $this->conexion->exec($query);
    }

    public function delete($table, $where = "") {
        $query = 'DELETE FROM ' . $table
                . (($where) ? ' WHERE ' . $where : "");
        logger::guardar($query);
        return $this->conexion->exec($query);
    }

    public function truncateTable($table) {
        $query = 'TRUNCATE ' . $table;
        logger::guardar($query);
        return $this->conexion->exec($query);
    }

    public function getLastId() {
        return $this->conexion->lastInsertId();
    }

}
