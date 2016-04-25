<!DOCTYPE html>
<html>
    <head>
        <!--Import Font awesome Icon Font-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href=" css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/try.css" />
        <link type="text/css" rel="stylesheet" href="css/upload.css" />
        
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
            
                if($_COOKIE['type'] != 'register')
                {   
                    header( "Location:upload.php");
                    exit();
                }
            
                
                $username = $_COOKIE[$cookie_name];
                //$username = 'nikamanish007@gmail.com';
                $sql = "select * from user where email='$username'";
                $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
            
                //$stmt = mysqli_prepare($conn, "select * from user where email=?");
                //mysqli_stmt_bind_param($stmt, "s", $username);
                //mysqli_stmt_execute($stmt); 
                //$result = $stmt->get_result();
            
                $user_details = mysqli_fetch_assoc($result);

                $user_name = $user_details['f_name'] . ' ' . $user_details['l_name'];
                
                echo $user_name;
            ?>
        </title>
        
    </head>
    
    <body> 
        
       
        
        <main>            
            <div class="navbar-fixed">
                <nav class="nav-bar-info z-depth-half teal darken-3">
                    <div class="info">
                        <div class="title">
                            <label class="nav-title">Notapp - Subscribe</label>
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
                
            </div>
            
            
            <?php
                $dept_err = '';
            
                include("connect.php");
                if(isset($_POST['subscribe']))
                {  
                    $u_id = $user_details['u_id'];

                    $sql = "select t_id from teacher where u_id=$u_id";
                    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                    $teacher_detail = mysqli_fetch_assoc($result);

                    $t_id = $teacher_detail['t_id'];

                    if(isset($_POST["dept"]))
                    {
                        foreach($_POST['dept'] as $dept)
                        {

                            $sql = "select d_id from department where d_name='$dept'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            $dept_details = mysqli_fetch_assoc($result);

                            $d_id = $dept_details['d_id'];                           


                            $sql = "insert into t_belongsto_d(t_id, d_id) values ('$t_id', '$d_id')";
                            $result = mysqli_query($conn,$sql) or die("<p>dept insert error</p>"); 
                        }
                        setcookie('type', 'register', time() - (60 * 60), "/");
                        header( "Location:upload.php");
                        exit();
                    }
                    else
                    {
                        $dept_err='Select atleast one Section';
                    }                        
                }
            ?>
            
            <form enctype="multipart/form-data" id="formValidate" class="content" method="post" action="subscribe.php">
                <div class="row">
                    <div class="col m10 l8 s12 offset-l2 offset-m1">
                       
                        
                        <div class="card white">
                            <div class="card-content grey-text text-darken-1">
                                
                                <div class="input-field">
                                    <div class="error">
                                        <?php
                                            echo $dept_err;
                                        ?>
                                    </div>                                   
                                </div>
                                
                                <span class="card-title">Choose sections you want to post notices for</span>
                                
                                
                                <div class="row">
                                
                                    
                                    
                                    <div class="input-field col s12 m8 offset-m2 sel-input">
                                        <select class="icons" id="dept" multiple  name="dept[]">
                                            
                                            
                                            <option value="" disabled selected>Departments</option>
                                            <option value="it" data-icon="graphics/icons/it.png" class="circle left">Information Technology</option>
                                            <option value="cse" data-icon="graphics/icons/cse.png" class="circle left">Computer Science</option>
                                            <option value="eln" data-icon="graphics/icons/eln.png" class="circle left">Electronics</option>
                                            <option value="ele" data-icon="graphics/icons/ele.png" class="circle left">Electrical</option>
                                            <option value="mech" data-icon="graphics/icons/mech.png" class="circle left">Mechanical</option>
                                            <option value="civ" data-icon="graphics/icons/civ.png" class="circle left">Civil</option>



                                            <option value="" disabled selected>Sciences</option>
                                            <option value="phy" data-icon="graphics/icons/phy.png" class="circle left">Physics</option>
                                            <option value="chem" data-icon="graphics/icons/chem.png" class="circle left">Chemistry</option>
                                            <option value="math" data-icon="graphics/icons/math.png" class="circle left">Mathematics</option>
                                            <option value="bio" data-icon="graphics/icons/bio.png" class="circle left">Biology</option>




                                            <option value="" disabled selected>Departmental Clubs</option>
                                            <option value="sait" data-icon="graphics/icons/sait.png" class="circle left">SAIT</option>
                                            <option value="acses" data-icon="graphics/icons/acses.png" class="circle left">ACSES</option>
                                            <option value="elesa" data-icon="graphics/icons/elesa.png" class="circle left">ELESA</option>
                                            <option value="eesa" data-icon="graphics/icons/eesa.png" class="circle left">EESA</option>
                                            <option value="mesa" data-icon="graphics/icons/mesa.png" class="circle left">MESA / MESC</option>
                                            <option value="cesa" data-icon="graphics/icons/cesa.png" class="circle left">CESA</option>


                                            <option value="" disabled selected>Other Clubs</option>
                                            <option value="wlug" data-icon="graphics/icons/wlug.png" class="circle left">WLUG</option>
                                            <option value="pace" data-icon="graphics/icons/pace.png" class="circle left">PACE</option>
                                            <option value="rotaract" data-icon="graphics/icons/rotaract.png" class="circle left">Rotaract</option>
                                            <option value="softa" data-icon="graphics/icons/softa.png" class="circle left">SOFTA</option>
                                            <option value="artcircle" data-icon="graphics/icons/lostfound.png" class="circle left">Art Circle</option>


                                            <option value="" disabled selected>Administration</option>
                                            <option value="admin" data-icon="graphics/icons/admin.png" class="circle left">Admin / Office</option>
                                            <option value="tpo" data-icon="graphics/icons/tpo.png" class="circle left">Training & Placement</option>
                                            <option value="exam" data-icon="graphics/icons/exam.png" class="circle left">Exam Cell</option>


                                            <option value="" disabled selected>Miscellaneous</option>
                                            <option value="rector" data-icon="graphics/icons/rector.png" class="circle left">Rector</option>
                                            <option value="sports" data-icon="graphics/icons/sports.png" class="circle left">Sports & Gym</option>
                                            <option value="scholarship" data-icon="graphics/icons/scholarship.png" class="circle left">Scholarship</option>
                                            <option value="library" data-icon="graphics/icons/library.png" class="circle left">Library</option>
                                            <option value="lostfound" data-icon="graphics/icons/lostfound.png" class="circle left">Lost & Found</option>                                                
                                            
                                        </select>
                                        
                                        
                                        
                                        
                                        <label>Notice Board</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <div style="width:60px; margin:auto; margin-top:-43px; margin-bottom: 10px;">
                        
                            <button class="btn-floating btn-large waves-effect waves-light" type="submit" name="subscribe">
                                <i class="material-icons right">done_all</i>
                            </button>
                        </div>
                        
                        <!--
                                                     
                        <div style="width:60px; margin:auto; margin-top:50px; margin-bottom: 100px;">

                            <div class="waves-effect waves-light btn-floating left" style="height: 55px; width:55px; display: inline-block;">
                                <i class="material-icons" style="margin-top: 9px;margin-left: -1px;">file_upload</i>
                                <input type="submit" name="upload" value="upload"/>
                            </div>
                        </div>
                                
                        -->
                        

                                                        
                            
                    </div>
                </div>
            </form>
            
           
        </main>
        
        
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src=" js/materialize.min.js"></script>
        <script type="text/javascript" src=" js/jquery.validate.js"></script>
        <script type="text/javascript" src=" js/upload.js"></script>
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
                
                if(document.getElementById('notice-type').checked)
                {
                    document.getElementById('fileNotice').style.display = 'none';
                    document.getElementById('shortMessage').style.display = 'block';
                }
                else
                {
                    document.getElementById('fileNotice').style.display = 'block';
                    document.getElementById('shortMessage').style.display = 'none';
                }
            
            });

        </script>
        
        <script>
        (function($){
          $(function(){

            $('.button-collapse').sideNav();

          }); // end of document ready
        })(jQuery);
        
        </script>
        
       
    </body>
</html>



