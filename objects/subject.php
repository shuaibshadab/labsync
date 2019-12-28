<?php
// 'subject' object
class Subject{
 
    // database connection and table name
    private $conn;
    private $table_name = "subject";
 
    // object properties
    public $id;
    public $name;
    public $teacher;
    public $sem;
    public $year;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // get subject
    function getSubjects(){
    
        // query to check if user exists
        $query = "SELECT name
                FROM " . $this->table_name . "
                WHERE teacher = ?
                ";
    
        // prepare the query
        $stmt = $this->conn->prepare( $query );
    
        // sanitize
        $this->teacher=htmlspecialchars(strip_tags($this->teacher));
    
        // bind given email value
        $stmt->bindParam(1, $this->teacher);
    
        // execute the query
        $stmt->execute();
    
        // get number of rows
        $num = $stmt->rowCount();
    
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
            
            return $stmt;
      
        }
    
        // return false if user does not exist in the database
        return false;
    }



}