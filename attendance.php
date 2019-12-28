<?php
// core configuration
include_once "config/core.php";
 
// set page title
$page_title="Attendance";
 
// include login checker
$require_login=true;
include_once "login_checker.php";

$currentDate= date("Y-m-d");

if(empty($_SESSION['subject']) || empty($_SESSION['batch']) )
{
    header("Location: {$home_url}teacher.php?action=select_subject_batch");
}

if($_POST)
{
    

}
 
// include page header HTML
include_once 'layout_head.php';





 
echo "<div class='col-md-12'>";
 
    // to prevent undefined index notice
    $action = isset($_GET['action']) ? $_GET['action'] : "";
 
    // if login was successful
    if($action=='login_success'){
        echo "<div class='alert alert-info'>";
            echo "<strong>Hi " . $_SESSION['username'] . ", welcome back!</strong>";
        echo "</div>";
    }
 
    // if user is already logged in, shown when user tries to access the login page
    else if($action=='already_logged_in'){
        echo "<div class='alert alert-info'>";
            echo "<strong>You are already logged in.</strong>";
        echo "</div>";
    }
 
    // content once logged in
    
    ?>

        <div class="panel panel-default">

            <div class="panel-heading">
                <a class="btn btn-success" href="add.php">Add Student</a>
                <a class="btn btn-info pull-right" href="date_view.php"> View All</a>
                
            </div>
        <div class="panel-body">

            <div class="well text-center">   
                <strong>
                <?php echo $_SESSION['subject']; ?>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                Batch:<?php echo $_SESSION['batch']; ?>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                 Date: <?php echo $currentDate; ?>
                </strong> 
            </div>
            

            <form action="" method="Post">
                <table class="table table-striped table-hover table-responsive table-bordered">
                    <tr>
                        <th>Serial</th>
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
                    $getstudent = $student->getStudents($_SESSION['subject']);
                    
                    if($getstudent){
                        $i=0;
                        while($value = $getstudent->fetch(PDO::FETCH_ASSOC)){
                           $i++;
                    ?>
                            <tr>
                            <td> <?php echo $i ?> </td>
                            <td> <?php echo $value['roll']; ?></td>
                            <td> <?php echo $value['fname']; ?></td>
                            <td> <?php echo $value['lname']; ?></td>
                            <td> <input type="radio" name="status[<?php echo $value['roll']; ?>]" value="present">P
                                 <input type="radio" name="status[<?php echo $value['roll']; ?>]" value="absent">A
                            </td>
                        </tr>
                       
                  <?php 
                         }
                     }
                    ?>
           
                </table>

                <input type="submit" name="submit" class="btn btn-primary" value="Submit">

            </form>
        </div>
        </div>

    <?php
 
echo "</div>";
 
// footer HTML and JavaScript codes
include 'layout_foot.php';
?>