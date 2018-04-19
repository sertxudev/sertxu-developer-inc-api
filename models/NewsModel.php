<?php
class NewsModel extends DatabaseModel {
    private $id;
    private $title;
    private $description;
    private $icon;
    private $date;

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
    function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    function setTitle(string $title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    function setDescription(string $description) {
        $this->description = $description;
    }

    /**
     * @return string
     */
    function getIcon() {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    function setIcon(string $icon) {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    function getDate() {
        return $this->date;
    }

    /**
     * @param string $date
     */
    function setDate(string $date) {
        $this->date = $date;
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
            return $this->update('news', array(
                'id' => $this->getId(),
                'title' => $this->getTitle(),
                'description' => $this->getDescription(),
                'icon' => $this->getIcon(),
                'date' => $this->getDate()
            ), rtrim($where, $condition." "));
        } else {
            return $this->insert('news', array(
                'title' => $this->getTitle(),
                'description' => $this->getDescription(),
                'icon' => $this->getIcon(),
                'date' => $this->getDate()
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
        $pdo = $this->select('news', $where = "", $fields, $order, $limit, $offset);
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
        return $this->select('news', 'id = '.$id, $fields, $order, $limit, $offset)->fetch(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $title Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByTitle($title, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('news', 'title = '.$title, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $description Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByDescription($description, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('news', 'description = '.$description, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $icon Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByIcon($icon, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('news', 'icon = '.$icon, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
    }

    /**
    * @param string $date Required
    * @param string $fields Not required, default value '*'
    * @param string $order Not required, default value ""
    * @param int $limit Not required, default value null
    * @param int $offset Not required, default value null
    * @return array Return a single array with the values
    */
    function findByDate($date, $fields = '*', $order = "", $limit = null, $offset = null) {
        return $this->select('news', 'date = '.$date, $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);        
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
        return $this->select('news', rtrim($where, $condition." "), $fields, $order, $limit, $offset)->fetchAll(PDO::FETCH_ASSOC);
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
        return $this->delete('news', rtrim($where, $condition." "));
    }

    /**
    * Drop the database
    * 
    * @return boolean True = No errors, False = Something went wrong
    */
    function truncate(){
        if($this->truncateTable('news') === 0){
            return true;
        } else {
            return false; 
        }
    }
}