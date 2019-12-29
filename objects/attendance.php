<?php
// 'student' object
class Attendance{
 
    // database connection and table name
    private $conn;
    private $table_name = "attendance";
 
    // object properties
    public $id;
    public $roll;
    public $date;
    public $status;
    public $subject;
    public $batch;
    public $modified;

 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    //insert attendance
    function insertAttendance($status = array()){
        // query to check if attendance of the batch is already taken
        $query = "SELECT DISTINCT date FROM attendance
                    WHERE subject = '$this->subject'
                    AND batch = '$this->batch'";
         
            
            // prepare the query
            $stmt = $this->conn->prepare( $query );
        
        
            // execute the query
            $stmt->execute();

			while($stmt && $result = $stmt->fetch(PDO::FETCH_ASSOC)){

				$db_date = $result['date'];

				if($this->date == $db_date){
					$msg = "<div class='alert alert-danger'> <strong>Error!</strong> Today's attendance is already taken!</div>";
					return $msg;
				}
            }

            // query to insert attendance row into attendance table

            foreach($status as $key => $value){
                if($value == "present" ){

                    $query = "INSERT INTO attendance(roll, date, status, subject,batch) 
                    VALUES('$key', '$this->date','$value','$this->subject','$this->batch')";

                    // prepare the query
                    $insert_row = $this->conn->prepare($query)->execute();
                    
                }elseif($value == "absent"){

                    $query = "INSERT INTO attendance(roll, date, status, subject,batch) 
                    VALUES('$key', '$this->date','$value','$this->subject','$this->batch')";

                    // prepare the query
                    $insert_row = $this->conn->prepare($query)->execute();
                    
                }
            }
            if($insert_row){
                $msg = "<div class='alert alert-success'> <strong>Successfully </strong> inserted the student attendance!</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong>attendance not inserted!</div>";
                return $msg;
            }
    }

    function updateAttendance($status = array()){

            // query to insert attendance row into attendance table

            foreach($status as $key => $value){
                if($value == "present" ){

                    $query = "UPDATE attendance set
                            status = 'present' WHERE roll ='$key'
                            AND date='$this->date'
                            AND subject='$this->subject'
                            AND batch = '$this->batch'
                            ";

                    // prepare the query
                    $update_row= $this->conn->prepare($query)->execute();
                    
                }elseif($value == "absent"){

                    $query = "UPDATE attendance set
                            status = 'absent' WHERE roll ='$key'
                            AND date='$this->date'
                            AND subject='$this->subject'
                            AND batch = '$this->batch'
                            ";

                    // prepare the query
                    $update_row = $this->conn->prepare($query)->execute();
                    
                }
            }
            if($update_row){
                $msg = "<div class='alert alert-success'> <strong>Successfully </strong> updated the student attendance!</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-danger'> <strong>Error! </strong>attendance not updated!</div>";
                return $msg;
            }
    }

    public function getAllDates(){

        // get all distinct dates and batches for the subject
        $query = "SELECT DISTINCT date FROM attendance
                    WHERE subject = '$this->subject'
                    AND batch= '$this->batch'";
            // prepare the query
            $stmt = $this->conn->prepare( $query );

            // execute the query
            $stmt->execute();

            return $stmt;

    }

    



}