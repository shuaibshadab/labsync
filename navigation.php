<!-- navbar -->
<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container-fluid">
 
        <div class="navbar-header">
            <!-- to enable navigation dropdown when viewed in mobile device -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
 
            <!-- Change "Your Site" to your site name -->
            <a class="navbar-brand" href="<?php echo $home_url; ?>">LabSync</a>
        </div>
 
        <div class="navbar-collapse collapse">
        <?php 
            if($page_title != "Login")
            { 
            ?>
            <ul class="nav navbar-nav">
                <!-- link to the "Cart" page, highlight if current page is cart.php -->
                <li <?php echo $page_title=="Teacher" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $home_url; ?>teacher.php">Subject</a>
                </li>
            </ul>

            <ul class="nav navbar-nav">
                <!-- link to the "Cart" page, highlight if current page is cart.php -->
                <li <?php echo $page_title=="Attendance" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $home_url; ?>attendance.php">Attendance</a>
                </li>
            </ul>

            <ul class="nav navbar-nav">
                <!-- link to the "Cart" page, highlight if current page is cart.php -->
                <li <?php echo $page_title=="Update" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $home_url; ?>dateview.php">Update</a>
                </li>
            </ul>
            
 
            <?php
            }
            // login and logout options will be here 

            // check if users / customer was logged in
            // if user was logged in show "Logout" option
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true && $_SESSION['access_level']=='Teacher'){
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <li <?php echo $page_title=="Edit Profile" ? "class='active'" : ""; ?>>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            &nbsp;&nbsp;<?php echo $_SESSION['username']; ?>
                            &nbsp;&nbsp;<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo $home_url; ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <?php
                }
                
                // show login and register options here 
                // if user was not logged in, show the "login" and "register" options
                else{
                    ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li <?php echo $page_title=="Login" ? "class='active'" : ""; ?>>
                            <a href="<?php echo $home_url; ?>">
                                <span class="glyphicon glyphicon-log-in"></span> Log In
                            </a>
                        </li>
                    </ul>
                    <?php
                    }
            ?>
             
        </div><!--/.nav-collapse -->
 
    </div>
</div>
<!-- /navbar -->