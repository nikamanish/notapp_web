<!DOCTYPE html>
<html>
    <head>
        <!--Import Font awesome Icon Font-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href=" css/materialize.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href=" css/upload.css" />
        
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
            
            $file_err = '';
            $branch_err = '';
            $dept_err = '';
        
            if(isset($_POST['upload']))
            {   
                if(!isset($_FILES["notice"]["tmp_name"]))
                {
                    $file_err =  "Please insert a file";
                }
                
                if(!isset($_POST['branch']))
                {
                    $branch_err =  "Please choose atleast one";
                }
                if(!isset($_POST['dept']))
                {
                    $dept_err =  "Please select a Notice Section";
                }
                
                
                
                function isPDF($file)
                {
                    
                    if(strcasecmp(pathinfo($file, PATHINFO_EXTENSION), 'PDF') == 0)
                    {
                        return true;
                    }
                    return false;
                }
                
                if(!isPDF($_FILES["notice"]["name"]))
                {
                    $file_err = "File selected is not a pdf";    
                }
                
                
                
                if(isset($_POST["title"]) && isset($_POST["class"]) && isset($_POST["branch"]) && isset($_FILES["notice"]["tmp_name"]) && isset($_POST["dept"]) && isPDF($_FILES["notice"]["name"]) )
                {
                    $title = $_POST["title"];
                    $class = $_POST["class"];
                    $branch = $_POST["branch"];
                    $dept = $_POST["dept"];
                    $expiration = $_POST["expiration"];
                    $type = $_POST["type"];
                    /* $message = 'This is a message.';   */



                    include("connect.php");
                    $cookie_name = "notapp_username";
                    $username = $_COOKIE[$cookie_name];
                    $sql = "select u_id from user where email='$username'";
                    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                    $user_details = mysqli_fetch_assoc($result);

                    $u_id = $user_details['u_id'];

                    //dept
                    $dept = strtoupper($dept);

                    //To fetch d_id of selected department...

                    $sql = "select d_id from department where d_name='$dept'";
                    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                    $dept_details = mysqli_fetch_assoc($result);

                    //d_id
                    $d_id = $dept_details['d_id'];

                    //to create random string

                    function RandomString()
                    {
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $randstring = '';
                        for ($i = 0; $i < 10; $i++) 
                        {
                            $randstring .= $characters[rand(0, strlen($characters)-1)];
                        }
                        return $randstring;
                    }

                    $dept = strtolower($dept);
                    
                    $name = RandomString();

                    $ext = pathinfo($_FILES["notice"]["name"],PATHINFO_EXTENSION);

                    $path = "notices/" . $dept . "/" . $name . ".pdf";


                    $exp =  date('Y-m-d', strtotime($expiration));


                    
                    
                    if (move_uploaded_file($_FILES["notice"]["tmp_name"], $path)) 
                    {

                        //echo "The file has been uploaded";
                        $file_size = filesize($_FILES["notice"]["tmp_name"]);
                    } 
                    else 
                    {
                        //echo "sorry, there was an error uploading your file.";
                        $file_size = -1;
                    }    
                    
                    if($exp == '1970-01-01' || $exp == null)
                    {
                        $exp =  date('Y-m-d', strtotime('2016-07-04'));
                    } 

                    $sql = "select c_id from class where c_name='$class'";
                    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                    $class_details = mysqli_fetch_assoc($result);

                    $c_id = $class_details['c_id'];
                    

                    $upDate = date('Y-m-d');


                    $sql = "insert into notice(title, n_type, uploadDate, exp, name, u_id, d_id) values ('$title' , '$type', '$upDate' , '$exp' , '$name' , '$u_id', '$d_id')";
                    $result = mysqli_query($conn,$sql) or die("<p>insert error</p>"); 

                    $n_id = mysqli_insert_id($conn);

                    $sql = "insert into n_for_c(n_id, c_id) values ('$n_id' , '$c_id')";
                    $result = mysqli_query($conn,$sql) or die("<p>insert error</p>");
                    $md5 = md5_file("notices/$dept/$name.pdf");
                    
                    $temp_id = ''.$n_id;
                    
                    $msg = array
                    (
                        'title' 	=> $title,
                        'uploadDate'=> $upDate,
                        'name'	     => $user_name,
                        'n_id'=> $temp_id,
                        'exp'	=> $exp,
                        'dept'	=> $d_id,
                        'link' => $name,
                        'md5' => $md5
                    /*  'message' => $message  */

                    );
                    
                    
                    echo json_encode($msg);

                    ///later...database flaw

                    foreach ($_POST['branch'] as $x)
                    {
                        $sql = "select d_id from department where d_name='$x'";
                        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        $dept_details = mysqli_fetch_assoc($result);

                        $d_id = $dept_details['d_id'];

                        $sql = "insert into n_for_d(n_id, d_id) values ('$n_id' , '$d_id')";
                        $result = mysqli_query($conn,$sql) or die("<p>insert error</p>"); 
                        
                        
                        $sql = "select gcmRegId from student where d_id='$d_id' and c_id='$c_id'";
                        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        //$stud_details = mysqli_fetch_assoc($result);
                        
                        $regId = array();
                        
                        while($r = mysqli_fetch_assoc($result))
                        {
                            $regId[] = $r['gcmRegId'];
                        }
                        
                        //echo json_encode($regId);
                        
                        include_once 'push/gcm.php';
     
                        $gcm = new GCM();
                                                
                        $gcm_res = $gcm->send_notification($regId, $msg);
                        
                    }
                    
                    
                }
            }    


        ?>
                
        <header>
            <ul id="nav-mobile" class="side-nav fixed white darken-4 black-text text-lighten-5">
                <br />
                
                <div class="row nav-head">
                    <div class="col s5 offset-s1">
                        <a href="#" class="dp-a">
                        
                        <?php
                            if(!$user_details['avatar'])
                            {
                                echo "<img src=' graphics/placeholder.png' alt='' class='circle dp ' height='75px' width='75px'>";
                            }
                        
                            else
                            {
                                echo "<img src=' graphics/dp.jpg' alt='' class='circle dp ' height='75px' width='75px'>";
                            }
                        ?>
                        </a>
                        
                        
                    </div>
                    <div class="col s11 offset-s1">
                        <label class="user_name white-text">
                            <?php                            
                                echo $user_name."<br>";
                            ?>
                        </label>    
                        <label class="email white-text">
                            <?php
                                echo $username;
                            ?>                        
                        </label>
                    </div>
                </div>
                
                
                
                <li class="selected waves-effect waves-dark"><a><i class="fa fa-upload fa-2x fa-fw"></i>Upload</a></li>
                <li class="waves-effect waves-dark"><a  href="view.php"><i class="fa fa-file-text fa-2x fa-fw"></i>View</a></li>
                
                <div class="divider nav-divider">
                </div>
                
                <li class="waves-effect waves-dark"><a href="#"><i class="fa fa-question-circle fa-2x fa-fw"></i>Help</a></li>
                <li class="waves-effect waves-dark"><a href="aboutus.php"><i class="fa fa-info-circle fa-2x fa-fw"></i>About Us</a></li>
                
                <div class="divider nav-divider">
                </div>
                
                <li class="waves-effect waves-dark"><a href="logout.php"><i class="fa fa-sign-out fa-2x fa-fw"></i>Sign Out</a></li>
                
            </ul>
            
        </header>
        <main>            
            <div class="navbar-fixed">
                <nav class="teal">
                    <a href="#" data-activates="nav-mobile" class="button-collapse waves-effect waves-light"><i class="material-icons">menu</i></a>
                    <label class="page-title">Notapp - Upload</label>
                </nav>

            </div>
            
            <form enctype="multipart/form-data" id="formValidate" method="post" action="upload.php">
                <div class="row">
                    <div class="col m10 l8 s12 offset-l2 offset-m1">
                        <div class="card white">
                            <div class="card-content grey-text text-darken-1">
                                <span class="card-title">Choose a File</span>
                                <div class="file-field input-field">
                                    <div class="row">
                                        <div class="waves-effect waves-light btn col s4 m3 l2 offset-m1  offset-l2">
                                            <span>Select</span>
                                            <input type="file" name="notice" accept="application/pdf" onchange="document.getElementById('title').value = this.value.split('\\').pop().split('/').pop().split('.')[0]">
                                        </div>
                                        <div class="file-path-wrapper col s8 m7 l6">
                                            <input class="file-path validate" name="notice_name" type="text">
                                        </div>
                                    </div>
                                    
                                    <div class="error">
                                        <?php
                                            echo $file_err;
                                        ?>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="card white">
                            <div class="card-content grey-text text-darken-1">
                                <span class="card-title">Enter Notice Title</span>
                                <div class="row">
                                    <div class="input-field col s12 m10 offset-m1">
                                        <i class="material-icons prefix">mode_edit</i>
                                        <input id="title" name="title" type="text" class="validate">
                                        
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        
                        <div class="card white">
                            <div class="card-content grey-text text-darken-1">
                                <span class="card-title">Select Recipients</span>
                                <div class="row">
                                    
                                    
                                    <div class="input-field filled-in col m5 l5 s12 sel-input">
                                        <select multiple  name="branch[]">
                                            <option value="" disabled selected>Choose your option</option>
                                            <option value="it" class="filled-in">InfoTech</option>
                                            <option value="cse">Computer Science</option>
                                            <option value="eln">Electronics</option>
                                            <option value="ele">Electrical</option>
                                            <option value="mech">Mechanical</option>
                                            <option value="civ">Civil</option>
                                        </select>
                                        
                                        <label>Select Department</label>
                                        
                                        <div class="error">
                                            <?php
                                                echo $branch_err;
                                            ?>
                                        </div>  
                                    </div>

                                    <div class="input-field col s12 m5 l5 offset-m1 offset-l1 sel-input">                                  
                                        <select name="class">                                            
                                            <optgroup label="B.Tech">
                                                <option value="b1">First Year</option>
                                                <option value="b2">Second Year</option>
                                                <option value="b3">Third Year</option>
                                                <option value="b4">Final Year</option>
                                            </optgroup>
                                            <optgroup label="M.Tech">
                                                <option value="m1">Frst Year</option>
                                                <option value="m2">Scond Year</option>
                                            </optgroup>
                                        </select>
    
                                        <label>Select Class</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card white">
                            <div class="card-content grey-text text-darken-1">
                                
                                <div class="input-field">
                                    <div class="error">
                                        <?php
                                            echo $dept_err;
                                        ?>
                                    </div>                                   
                                </div>
                                
                                <span class="card-title">Select Notice Section</span>
                                
                                <div class="row dept-row">                                     
                                    <div class="col s3">
                                                                         
                                        <label for="it" class="dept">
                                            <input id="it" value="it" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/it.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">InfoTech</h6>
                                        </label>                                           
                                    </div>
                                    
                                    <div class="col s3">
                                        
                                        <label for="cse" class="dept">
                                            <input id="cse" value="cse" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/cse.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Computer Science</h6>
                                        </label>  
                                        
                                    </div>
                                    
                                    <div class="col s3">
                                        
                                        <label for="eln" class="dept">
                                            <input id="eln" value="eln" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" alt="" src=" graphics/icons/eln.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Electronics</h6>
                                        </label>  
                                    </div>                                    
                                
                                    <div class="col s3">
                                        
                                        <label for="ele" class="dept">
                                            <input id="ele" value="ele" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/ele.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Electrical</h6>
                                        </label>  
                                    </div>

                                </div>
                                
                                <div class="row dept-row bottom-row">
                                
                                    <div class="col s3">
                                        
                                        <label for="mech" class="dept">
                                            <input id="mech" value="mech" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/mech.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Mechanical</h6>
                                        </label>  
                                    </div>
                                    
                                    <div class="col s3">
                                        
                                        <label for="civ" class="dept">
                                            <input id="civ" value="civ" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/civ.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Civil</h6>
                                        </label>  
                                    </div>
                                    
                                    <div class="divider dept-divider col s10 offset-s1 "></div>
                                
                                </div>
                                
                                <div class="row dept-row">   
                                    
                                    <div class="col s3">
                                                                         
                                        <label for="phy" class="dept">
                                            <input id="phy" value="phy" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/phy.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Physics</h6>
                                        </label>                                           
                                    </div>
                                    
                                    <div class="col s3">
                                        
                                        <label for="chem" class="dept">
                                            <input id="chem" value="chem" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/chem.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Chemistry</h6>
                                        </label>  
                                        
                                    </div>
                                    
                                    <div class="col s3">
                                        
                                        <label for="bio" class="dept">
                                            <input id="bio" value="bio" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/bio.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Biology</h6>
                                        </label>  
                                    </div>                                    
                                
                                    <div class="col s3">
                                        
                                        <label for="math" class="dept">
                                            <input id="math" value="math" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/math.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Maths</h6>
                                        </label>  
                                    </div>
                                    
                                    <div class="divider dept-divider col s10 offset-s1 "></div>

                                </div>
                                
                                <div class="row dept-row">   
                                    
                                    <div class="col s3">
                                                                         
                                        <label for="admin" class="dept">
                                            <input id="admin" value="admin" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/admin.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Admin</h6>
                                        </label>                                           
                                    </div>
                                    
                                    <div class="col s3">
                                        
                                        <label for="tpo" class="dept">
                                            <input id="tpo" value="tpo" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/tpo.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Training &amp Placement </h6>
                                        </label>  
                                        
                                    </div>
                                    
                                    <div class="col s3">
                                        
                                        <label for="exam" class="dept">
                                            <input id="exam" value="exam" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/exam.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Exam Cell</h6>
                                        </label>  
                                    </div>                                    
                                
                                    <div class="divider dept-divider col s10 offset-s1 "></div>

                                </div>
                                
                                <div class="row dept-row">   
                                    
                                    <div class="col s3">
                                                                         
                                        <label for="rector" class="dept">
                                            <input id="rector"  value="rector" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/rector.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Rector</h6>
                                        </label>                                           
                                    </div>
                                    
                                    <div class="col s3">
                                        
                                        <label for="sports" class="dept">
                                            <input id="sports" value="sports" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/sports.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Sports &amp Gym</h6>
                                        </label>  
                                        
                                    </div>
                                    
                                    <div class="col s3">
                                        
                                        <label for="scholarship" class="dept">
                                            
                                            <input id="scholarship" value="scholarship" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/scholarship.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Scholarship</h6>
                                        </label>  
                                    </div>
                                    
                                    <div class="col s3">
                                        
                                        <label for="library" class="dept">
                                            
                                            <input id="library" value="library" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/library.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Library</h6>
                                        </label>  
                                    </div>
                                </div>
                                
                                <div class="row dept-row bottom-row">   
                                    
                                    <div class="col s3">
                                                                         
                                        <label for="lostfound" class="dept">
                                            <input id="lostfound"  value="lostfound" name="dept" type="radio" class="dept-icon" />
                                            <img class="responsive-img" src=" graphics/icons/lostfound.png" width="150px">
                                            <h6 class="center-align dept-name flow-text">Lost &amp Found</h6>
                                        </label>                                           
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="card white">
                            <div class="card-content grey-text text-darken-1">
                                <span class="card-title">Select Expiration Date (optional)</span>                       
                                <div class="row date">
                                     <div class="input-field col s12 m10 offset-m1">
                                 
                                        <i class="material-icons prefix">date_range</i>
                                        <input id="expiration" type="date" name="expiration"  class="datepicker">
                                        <label class="active" for="expiration">Expiration Date</label>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        
                        <div class="card white">
                            <div class="card-content grey-text text-darken-1">
                                <span class="card-title">Select Type</span>                       
                                <div class="row">
                                    
                                    <div class="input-field col m6 offset-m3 s12 sel-input">
                                        <select name="type">
                                                                   
                                            <option value="1" selected>Notice</option>
                                            <option value="2">Academic Notes</option>
                                            
                                        </select>
                                        
                                        <label>Type</label>
                                    </div>
                                    
                                    <input type="submit" name="upload" value="upload" class="btn waves-effect waves-light col s8 offset-s2 m4 offset-m4 upload-btn"/>
                                    
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </main>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src=" js/materialize.min.js"></script>
        <script type="text/javascript" src=" js/jquery.validate.js"></script>
        <script type="text/javascript" src=" js/upload.js"></script>
        <script>
            $(document).ready(function() {
            Materialize.fadeInImage('#profilepic');
            Materialize.showStaggeredList('#staggered-list');
            $('select').material_select();
            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 8, // Creates a dropdown of 15 years to control year
                format: 'yyyy-mm-dd'
              });   
            
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
