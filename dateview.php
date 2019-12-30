<?php
// core configuration
include_once "config/core.php";
 
// set page title
$page_title="Update";
 
// include login checker
$require_login=true;
include_once "login_checker.php";


if(empty($_SESSION['subject']) || empty($_SESSION['batch']) )
{
    header("Location: {$home_url}teacher.php?action=select_subject_batch");
}


// include page header HTML
include_once 'layout_head.php';



echo "<div class='col-md-12'>";

if($_POST)
{
    
}
 
    
    // content once logged in
    
    ?>

        <div class="panel panel-primary">

            <div class="panel-heading">
                <a class="btn btn-danger" href="attendance.php"> Back</a>   
            </div>
        <div class="panel-body">

            <div class="well text-center">   
                <strong>
                <?php echo $_SESSION['subject']; ?>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                Batch:<?php echo $_SESSION['batch']; ?>
                </strong> 
            </div>
            

            <form action="" method="Post">
                <table class="table table-striped table-hover table-responsive table-bordered">
                    <tr class="info">
                        <th>Serial</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>

                    <?php 
                    // include classes
                    include_once "config/database.php";
                    include_once "objects/attendance.php";
                    
                    // get database connection
                    $database = new Database();
                    $db = $database->getConnection();
                    
                    // initialize objects
                    $attendance = new Attendance($db);
                    $attendance->batch = $_SESSION['batch'];
                    $attendance->subject = $_SESSION['subject'];
                    
                    
                    
                    // get all the dates for the subject attendance
                    $result = $attendance->getAllDates();
                    
                    if($result){
                        $i=0;
                        while($value = $result->fetch(PDO::FETCH_ASSOC)){
                           $i++;
                    ?>
                            <tr>
                            <td> <?php echo $i ?> </td>
                            <td > <?php echo $value['date']; ?></td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="view.php?dt=<?php echo $value['date']; ?>">View</a>
                                <a class="btn btn-danger" href="update.php?dt=<?php echo $value['date']; ?>">Update</a>
                            </td>
                            </tr>
                       
                  <?php 
                         }
                     }
                    ?>
           
                </table>
            </form>
        </div>
        </div>

    <?php
 
echo "</div>";
 
// footer HTML and JavaScript codes
include 'layout_foot.php';
?>