<?php
// core configuration
include_once "config/core.php";
 
// set page title
$page_title="Teacher";
 
// include login checker
$require_login=true;
include_once "login_checker.php";

if($_POST)
    {   
        if(isset($_POST['subject']) && isset ($_POST['batch']) )
        {
            $_SESSION['subject'] = $_POST['subject'];
            $_SESSION['batch'] = $_POST['batch'];
            header("Location: {$home_url}attendance.php");
        }
        
    
    }
 
// include page header HTML
include_once 'layout_head.php';
 
echo "<div class='col-md-12'>";
 
    // to prevent undefined index notice
    $action = isset($_GET['action']) ? $_GET['action'] : "";
 
    // if login was successful
    if($action=='login_success'){
        echo "<div class='alert alert-info msg'>";
            echo "<strong>Hi " . $_SESSION['username'] . ", welcome back!</strong>";
        echo "</div>";
    }
 
    // if user is already logged in, shown when user tries to access the login page
    else if($action=='already_logged_in'){
        echo "<div class='alert alert-info msg' >";
            echo "<strong>You are already logged in.</strong>";
        echo "</div>";
    }

    // if user is already logged in, shown when user tries to access the login page
    else if($action=='select_subject_batch'){
        echo "<div class='alert alert-info msg' >";
            echo "<strong>Select Subject and batch first.</strong>";
        echo "</div>";
    }
 
    // content once logged in
    
   
    ?>

    <div class="panel panel-primary">
      <div class="panel-heading">Select A subject</div>
      <div class="panel-body">

      
  <form action='' method='post' id='subject-form'>
            <div class="col-md-6">
                <div class="form-group">
                <label for="select-subject">Select Subject</label>
                    <select class="form-control" id="select-subject" name="subject" required>


                    <?php 
                    // include classes
                    include_once "config/database.php";
                    include_once "objects/subject.php";
                    
                    // get database connection
                    $database = new Database();
                    $db = $database->getConnection();
                    
                    // initialize objects
                    $subject = new Subject($db);
                    
                    // check if subject is in the database
                    $subject->teacher=$_SESSION['username'];
                    
                    // check if email exists, also get user details using this emailExists() method
                    $getsubject = $subject->getSubjects();
                    
                    if($getsubject){
                        while($value = $getsubject->fetch(PDO::FETCH_ASSOC)){
                    ?>
                            <option> <?php  echo $value['name']; ?></option>
                       
                  <?php 
                         }
                     }
                    ?>



                    </select>
                </div>
            </div>
           
            <div class="col-md-6">
            <div class="form-group">
             <label for="select-batch">Select Batch</label>
                <select class="form-control" id="select-batch" name="batch" required>
                <option>1</option>
                <option>2</option>
                </select>
            </div>
            </div>

    <div class="col-md-12">
         <button type="submit"  class="btn btn-primary" href="attendance.php">
                 Go
        </button>
    </div>
    </form>
    </div>
    </div>


    <?php
  
    

echo "</div>";
 
// footer HTML and JavaScript codes
include 'layout_foot.php';
?>
<script type="text/javascript">

$(document).ready(function () {
  setTimeout(function () {
      $('.msg').hide();
  }, 5000);
});


</script>

