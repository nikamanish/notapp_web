<!DOCTYPE html>
<html>
    <head>
        <!--Import Font awesome Icon Font-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href=" css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/try.css" />
        <link type="text/css" rel="stylesheet" href="css/setting.css" />
        
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400' rel='stylesheet' type='text/css'>
        <link rel="icon" type="image/png" href="myIcon.png">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <title>
            
            <?php            
                include("connect.php");
                $cookie_name = "notapp_username";
                if(!isset($_COOKIE[$cookie_name]))
                {
                    header( "Location:index.php"); 
                    exit();
                }

            
                $username = $_COOKIE[$cookie_name];
                //$username = 'nikamanish007@gmail.com';
                $sql = "select * from user where email='$username'";
                $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));            
                $user_details = mysqli_fetch_assoc($result);

                $user_name = $user_details['f_name'] . ' ' . $user_details['l_name'];
                
                echo $user_name;
            ?>
        </title>
        
    </head>
    
    <body>
        
        
        <?php
        
            $js_mssge = '';
            if(isset($_POST['change']))
            {   
                $password = $_POST['new'];
                $current_input = $_POST['current'];
                $current = $user_details['pword'];
                
                if($current === $current_input)
                {
                    $sql = "update user set pword= '$password' where email='$username'";
                    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));      
                    
                    $js_mssge .= "<script type='text/javascript'>makeToast('Password Changed Successfully')</script>";
                    
                }
            }
        ?>
        
        <main>            
            <div class="navbar-fixed">
                <nav class="nav-bar-info z-depth-half teal darken-3">
                    <div class="info">
                        <div class="title">
                            <label class="nav-title">Notapp - Settings</label>
                        </div>        
                        
                        <div class="dp">
                            <?php
                                //if(!$user_details['avatar'])
                                {
                                    echo "<img src=' graphics/placeholder.png' alt='' height='40px'>";
                                }

                                //else
                                {
                                    //echo "<img src=' graphics/dp.jpg' alt='' height='40px'>";
                                }
                            ?>
                        </div>
                        
                        <div class="text-info">
                            <p class="email">
                                <?php
                                    echo $username;
                                ?>
                            </p>
                            <div class="signout-div">
                                <a class="signout" href="logout.php">Sign out</a>
                            </div>
                        </div>
                    </div>                    
                </nav>
                
                <nav class="nav-bar-tabs z-depth-1 teal darken-1 pc-nav">                    
                    
                    <div class="row">
                        <div class="col s10 l6">
                            <ul class="tab-bar">
                                <li class="tab-new col s3"><a class="tooltipped" data-position="bottom" data-delay="5" data-tooltip="Upload new notice" href="upload.php">Upload</a></li>
                                <li class="tab-new col s3"><a  href="view.php" class=" tooltipped" data-position="bottom" data-delay="5" data-tooltip="View uploaded notices">View</a></li>
                                <li class="tab-new col s3"><a href="" class="tooltipped" data-position="bottom" data-delay="5" data-tooltip="Need help?">Help</a></li>
                                <li class="tab-new col s3"><a href="aboutus.php" class="tooltipped" data-position="bottom" data-delay="5" data-tooltip="About the Developers">About</a></li>
                                <li class="tab-new invisible col s3 tooltipped" data-position="bottom" data-delay="5" data-tooltip="General settings"><a href=""><i class="material-icons prefix">settings</i></a></li>
                                <li class="tab-new invisible col s3 tooltipped" data-position="bottom" data-delay="5" data-tooltip="Sign out"><a href="logout.php">Exit</a></li>
                            </ul>
                        </div>
                        <div class="col right setting-div selected waves-light waves-effect">
                            <a class="setting-icon "><i class="material-icons prefix">settings</i></a>
                        </div>
                    </div>                   
                    
                </nav>
                
                <nav class="nav-bar-tabs z-depth-1 teal darken-1 phone-nav invisible">                    
                    
                    <div class="row">
                        <div class="col s12 l6">
                            <ul class="tab-bar">
                                <li class="tab-new col s3"><a class="" data-position="bottom" data-delay="5"  href="upload.php"><i class="material-icons prefix">file_upload</i></a></li>
                                <li class="tab-new col s3"><a  href="view.php" class=" " data-position="bottom"><i class="material-icons prefix">description</i></a></li>
                                <li class="tab-new active col s3 " data-position="bottom" data-delay="5" ><a href="" class="active"><i class="material-icons  prefix">settings</i></a></li>
                                <li class="tab-new col s3"><a href="" class="" data-position="bottom" data-delay="5" ><i class="material-icons prefix">help</i></a></li>
                                <li class="tab-new col s3"><a href="aboutus.php" class="" data-position="bottom" ><i class="material-icons prefix">developer_mode</i></a></li>
                                <li class="tab-new  col s3 " data-position="bottom" data-delay="5" ><a href="logout.php"><i class="material-icons prefix">exit_to_app</i></a></li>
                            </ul>
                        </div>
                    </div> 
                </nav>
            </div>
            
            <form enctype="multipart/form-data" id="password" class="content" method="post" action="setting.php">
                <div class="row">
                    <div class="col m10 l8 s12 offset-l2 offset-m1">
                        <div class="card white">
                            <div class="card-content grey-text text-darken-1">
                                <span class="card-title">Change Password</span>
                                
                                <div class="row">
                                    
                                    
                                    <div class="input-field col s12 m8 offset-m2">
                                        <i class="material-icons prefix">lock</i>
                                        <input id="current" name="current" required="" aria-required="true" type="password" class="validate" data-error=".error1">
                                        <label for="current">Current Password</label>
                                        <div class="error1"></div>
                                    </div>
                                    
                                    
                                    
                                    <div class="input-field col s12 m8 offset-m2">
                                        <i class="material-icons prefix">done</i>
                                        <input id="new" name="new" required="" aria-required="true" type="password" class="validate" data-error=".error2">
                                        <label for="new">New Password</label>
                                        <div class="error2"></div>
                                    </div>
                                    
                                    
                                    
                                    <div class="input-field col s12 m8 offset-m2">
                                        <i class="material-icons prefix">done_all</i>
                                        <input id="repeat" name="repeat" required="" aria-required="true" type="password" class="validate" data-error=".error3">
                                        <label for="repeat">Repeat Password</label>
                                        <div class="error3"></div>
                                    </div>
                                    
                                </div>
                            </div>
                            <br>
                        </div>
                         <div style="width:60px; margin:auto; margin-top:-43px; margin-bottom: 10px;">
                            <button class="btn-floating btn-large waves-effect waves-light" type="submit" name="change">
                                <i class="material-icons right">autorenew</i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            
        </main>
        
        
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src=" js/materialize.min.js"></script>
        <script type="text/javascript" src=" js/jquery.validate.js"></script>
        <script type="text/javascript" src=" js/setting.js"></script>
        <script>
            $(document).ready(function() 
            {
                
                $('.tooltipped').tooltip({delay: 50});
                Materialize.fadeInImage('#profilepic');
                Materialize.showStaggeredList('#staggered-list');
                $('select').material_select();
                $('.datepicker').pickadate({
                    selectMonths: true, // Creates a dropdown to control month
                    selectYears: 8, // Creates a dropdown of 15 years to control year
                    format: 'yyyy-mm-dd'
                  });
                
                
            
            });
            
            function makeToast(mssg)
            {
                Materialize.toast(mssg, 3000, 'rounded');
            }


        </script>
        
        <?php
            echo $js_mssge;
        ?>
        
       
    </body>
</html>







