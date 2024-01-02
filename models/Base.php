<?php

namespace Model;

class Base
{
    public $errors = [];
    public $id=0;

    public static $db;
    protected static $dbCol = [];
    protected static $dbTable = '';
    
    public $lastInsertId = 0;
    

    public function save()
    {
        $this->validate();
        $properties = $this->sanitize();
        
        $values = [];
        foreach($properties as $key => $value) {
            $values[] = "{$key}='{$value}'";
        }

        $query = " UPDATE ".static::$dbTable." SET ";
        $query .=  join(', ', $values );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // showFormat($query, true);
        
        $result = self::$db->query($query);
        // showFormat($result, true);
        return $result;
    }

    public function create() {   
        $this->validate();
        $attributes = $this->sanitize();
        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$dbTable . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        //showFormat($query);
        
        if (empty($this->errors)){
            $result = self::$db->query($query);
            $selectId = self::$db->query("SELECT LAST_INSERT_ID();");
            $row = $selectId->fetch_row();
            $this->lastInsertId = $row[0];
        }
        
        return $result ?? false;
    }

    public function delete () {
        if ($this->id && $this->id>0) {
            $query = "DELETE FROM ".static::$dbTable." WHERE id=".$this->id;
            
            $result = self::$db->query($query);
            return $result;
        }
    }

    public function validate()
    {
        $this->errors = [];

        foreach (static::$dbCol as $value) {
            
            if (!$this->$value) {
                $errors[] = $value . " inválido";
            }
        }
        
    }

    public function attributes()
    {
        $cols = [];
        foreach (static::$dbCol as $column) {
            if ($column === 'id') continue;
            $cols[$column] = $this->$column;
        }
        return $cols;

        
    }

    public function sanitize()
    {
        $attributes = $this->attributes();
        $sanitiy = [];

        foreach ($attributes as $key => $value) {
            $sanitiy[$key] = self::$db->escape_string($value);
        }
        
        return $sanitiy;
    }

    # STATIC 
    public static function setDB($DB)
    {
        self::$db = $DB;
    }

    public static function all() {
        $query = "SELECT * FROM " . static::$dbTable . "";
        $result = self::consult($query);
        return $result;
    }

    public static function find($value, $key = "id", $limit = false) {
        $query = "SELECT * FROM " . static::$dbTable  ." WHERE {$key} = {$value} ";
        $query .= $limit ? "LIMIT 1" : "";
        
        $result = self::consult($query);
        return array_shift( $result ) ;
    }
    
    public static function get($limit) {
        $query = "SELECT * FROM " . static::$dbTable . " LIMIT {$limit}";
        $result = self::consult($query);

        return $result;
    }

    protected static function consult($query) : array {

        $result = self::$db->query($query);
        $array = [];
        while($register = $result->fetch_assoc()) {
            $array[] = static::createObject($register);
        }

        $result->free();
        return $array;
    }

    protected static function createObject($array) {
        $obj = new static;
        foreach($array as $key => $value ) {
            if(property_exists($obj, $key)) {
                $obj->$key = $value;
            }
        }
        return $obj;
    }
}
