<?php
// core configuration
include_once "config/core.php";
 
// set page title
$page_title="Update";
 
// include login checker
$require_login=true;
include_once "login_checker.php";

$dt=$_GET['dt'];

if(empty($_SESSION['subject']) || empty($_SESSION['batch']) )
{
    header("Location: {$home_url}teacher.php?action=select_subject_batch");
}


// include page header HTML
include_once 'layout_head.php';



echo "<div class='col-md-12'>";


if($_POST)
{
    // include classes
    include_once "config/database.php";
    include_once "objects/attendance.php";
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // initialize objects
    $attendance = new Attendance($db);
    
    // initialize object properties
    $attendance->date=$dt;
    $attendance->subject=$_SESSION['subject'];
    $attendance->batch=$_SESSION['batch'];
    
    // insert attendance and pass the array
    if(isset($_POST['status']))
    {
        $status = $_POST['status'];
        $insertResult = $attendance->updateAttendance($status);
        echo $insertResult;
    }else{
        echo "<div class='alert alert-danger'>";
            echo "<strong>Nothing to update!</strong>";
        echo "</div>";
    }

}
 
    // to prevent undefined index notice
    $action = isset($_GET['action']) ? $_GET['action'] : "";
 
    // if login was successful
    if($action=='login_success'){
        echo "<div class='alert alert-info'>";
            echo "<strong>Hi " . $_SESSION['username'] . ", welcome back!</strong>";
        echo "</div>";
    }

    // content once logged in
    
    ?>

        <div class="panel panel-primary">

            <div class="panel-heading">
                <a class="btn btn-danger" href="dateview.php"> Back</a>
                
            </div>
        <div class="panel-body">

            <div class="well text-center">   
                <strong>
                <?php echo $_SESSION['subject']; ?>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                Batch:<?php echo $_SESSION['batch']; ?>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                 Date: <?php echo $dt ?>
                </strong> 
            </div>
            

            <form action="" method="Post">
                <table class="table table-striped table-hover table-responsive table-bordered">
                    <tr class="danger">
                        <th >Serial</th>
                        <th>Student Roll</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Status</th>
                    </tr>

                    <?php 
                    // include classes
                    include_once "config/database.php";
                    include_once "objects/student.php";
                    
                    // get database connection
                    $database = new Database();
                    $db = $database->getConnection();
                    
                    // initialize objects
                    $student = new Student($db);
                    $student->batch = $_SESSION['batch'];
                    
                    
                    
                    // check if email exists, also get user details using this emailExists() method
                    $getstudent = $student->getAttendance($dt, $_SESSION['subject']);
                    
                    if($getstudent){
                        $i=0;
                        while($value = $getstudent->fetch(PDO::FETCH_ASSOC)){
                           $i++;
                    ?>
                            <tr>
                            <td> <?php echo $i ?> </td>
                            <td > <?php echo $value['roll']; ?></td>
                            <td > <?php echo $value['fname']; ?></td>
                            <td > <?php echo $value['lname']; ?></td>

                            <td> 
                            <label class="customRadio">P
                            <input type="radio"  name="status[<?php echo $value['roll']; ?>]" value="present" 
                            <?php if ($value['status']=="present") {echo "checked";} ?>>
                            <span class="checkmark"></span>
                            </label>
                            <label class="customRadio2">A
                            <input type="radio" name="status[<?php echo $value['roll']; ?>]" value="absent"
                            <?php if ($value['status']=="absent") {echo "checked";} ?>>
                            <span class="checkmark"></span>
                            </label>
                            </td>
                        </tr>
                       
                  <?php 
                         }
                     }
                    ?>
           
                </table>

                <input type="submit" name="submit" class="btn btn-danger" value="Update">
            </form>
        </div>
        </div>

    <?php
 
echo "</div>";
 
// footer HTML and JavaScript codes
include 'layout_foot.php';
?>