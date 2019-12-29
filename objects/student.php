<?php
// 'student' object
class Student{
 
    // database connection and table name
    private $conn;
    private $table_name = "student";
 
    // object properties
    public $id;
    public $roll;
    public $fname;
    public $lname;
    public $sem;
    public $year;
    public $batch;

 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // get subject
    function getStudents($subject){
    
        // query to check if user exists
        $query = "SELECT * FROM student  WHERE batch = '$this->batch' 
        AND  sem=(SELECT sem FROM subject  WHERE name ='$subject' )
        AND  year=(SELECT year FROM subject  WHERE name ='$subject' )";
    
        // prepare the query
        $stmt = $this->conn->prepare( $query );
    
    
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

    function getAttendance($dt, $subject){

        $query = "SELECT student.roll, student.fname, student.lname,attendance.status
                  FROM student,attendance
                  WHERE student.roll = attendance.roll
                  AND attendance.date = '$dt'
                  AND attendance.subject = '$subject'
                  AND student.batch = '$this->batch' ";

            // prepare the query
        $stmt = $this->conn->prepare( $query );
    
    
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