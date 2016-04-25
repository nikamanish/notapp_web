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
        
        <?php
            
            $file_err = '';
            $branch_err = '';
            $dept_err = '';
                    
            $checked = '';
        
            if(isset($_POST['upload']))
            {   
                if(isset($_POST["notice-type"]))
                {
                    if(!isset($_POST['branch']))
                    {
                        $branch_err =  "Please choose atleast one";
                    }
                    if(!isset($_POST['dept']))
                    {
                        $dept_err =  "Please select a Notice Section";
                    }
                    
                    
                    $checked = "checked";

                    
                    
                    if(isset($_POST["noticeTitle"]) && isset($_POST["class"]) && isset($_POST["branch"]) && isset($_POST["messageText"]) && isset($_POST["dept"]))
                    {
                        $title = $_POST["noticeTitle"];
                        $class = $_POST["class"];
                        $branch = $_POST["branch"];
                        $dept = $_POST["dept"];
                        $type = '2';
                        $name = $_POST["messageText"];
                        $name = '#'.$name;                       
                       
                        
                        
                        function trimMssg($mssg)
                        {
                            $mssg = str_replace('"','',$mssg);
                            $mssg = str_replace("'",'',$mssg);
                            
                            //echo "<br>$mssg<br>";
                            
                            return $mssg;
                        }
                        $name = trimMssg($name);
                        
                        /* $message = 'This is a message.';   */



                        include("connect.php");
                        $cookie_name = "notapp_username";
                        $username = $_COOKIE[$cookie_name];
                        
                        $sql = "select u_id from user where email='$username'";
                        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        //$stmt = mysqli_prepare($conn, "select * from user where email=?");
                        //mysqli_stmt_bind_param($stmt, "s", $username);
                        //mysqli_stmt_execute($stmt); 
                        //$result = $stmt->get_result();
                        
                        $user_details = mysqli_fetch_assoc($result);

                        $u_id = $user_details['u_id'];

                        //dept
                        $dept = strtoupper($dept);

                        //To fetch d_id of selected department...

                        $sql = "select d_id from department where d_name='$dept'";
                        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        
                        //$stmt = mysqli_prepare($conn, "select d_id from department where d_name=?");
                        //mysqli_stmt_bind_param($stmt, "s", $dept);
                        //mysqli_stmt_execute($stmt); 
                        //$result = $stmt->get_result();
                        
                        $dept_details = mysqli_fetch_assoc($result);

                        //d_id
                        $d_id = $dept_details['d_id'];
                        $nb_id = $d_id;
                        
                        
                        
                        
                        $upDate = date('Y-m-d');
                        
                        
                        $sql = "insert into notice(title, n_type, uploadDate, name, u_id, d_id) values ('$title' , '$type', '$upDate'  , '$name' , '$u_id', '$d_id')";
                        
                        
                        //echo "<br>$sql<br>";
                        
                        $result = mysqli_query($conn,$sql) or die("<p>notice insert error</p>");
                        
                        //$stmt = mysqli_prepare($conn, "insert into notice(title, n_type, uploadDate, exp, name, u_id, d_id) values (? , ?, ? , ? , ? , ?, ?)");
                        //mysqli_stmt_bind_param($stmt, "sssssdd", $title , $type, $upDate , $exp , $name , $u_id, $d_id);
                        //mysqli_stmt_execute($stmt); 
                        //$result = $stmt->get_result();

                        $n_id = mysqli_insert_id($conn);
                        
                        $sql = "select c_id from class where c_name='$class'";
                        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        $class_details = mysqli_fetch_assoc($result);

                        $c_id = $class_details['c_id'];

                        $sql = "insert into n_for_c(n_id, c_id) values ('$n_id' , '$c_id')";
                        $result = mysqli_query($conn,$sql) or die("<p>n_for_c insert error</p>");
                        
                        $temp_id = ''.$n_id;
                        
                        $md5="";
                        

                        $msg = array
                        (
                            'title' 	=> $title,
                            'uploadDate'=> $upDate,
                            'name'	     => $user_name,
                            'n_id'=> $temp_id,
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
                            
                            echo "<br> $d_id  $n_id <br>";

                            $sql = "insert into n_for_d(n_id, d_id) values ('$n_id' , '$d_id')";
                            $result = mysqli_query($conn,$sql) or die("<p>n_for_d insert error</p>"); 
                            
                            
                            $sql = "select u_id,gcmRegId from student where d_id='$d_id' and c_id='$c_id'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            
                            $regId = array();
                                
                            while($stud_details = mysqli_fetch_assoc($result))
                            {
                                $temp_id = $stud_details['u_id'];
                                echo "<br>u_id   $temp_id<br>";
                                $flag = 0;
                                $sql = "select prefs from preferences where u_id=$temp_id";
                                $res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                $pref_details = mysqli_fetch_assoc($res);
                                $temp_prefs = $pref_details['prefs'];
                                $prefs_arr = explode(",", $temp_prefs);
                                
                                foreach($prefs_arr as $pref)
                                {
                                    echo $pref." $nb_id $dept<br><br>";
                                    if($pref == $nb_id)
                                    {
                                        $flag = 1;
                                        break;
                                    }
                                }
                                
                                if($flag == 1)
                                {
                                    $regId[] = $stud_details['gcmRegId'];
                                }                                
                            }
                            
                            /*
                            $sql = "select gcmRegId from student where d_id='$d_id' and c_id='$c_id'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            //$stud_details = mysqli_fetch_assoc($result);

                            $regId = array();

                            while($r = mysqli_fetch_assoc($result))
                            {
                                $regId[] = $r['gcmRegId'];
                            }
                            */
                            echo json_encode($regId);

                            include_once 'push/gcm.php';

                            $gcm = new GCM();

                            $gcm_res = $gcm->send_notification($regId, $msg);
                        }                       
                    }
                }
                
                else
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
                    if(!isset($_POST['noticeName']))
                    {
                        $noticeTitle_err =  "Please enter a notice title";
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



                    if(isset($_POST["noticeName"]) && isset($_POST["class"]) && isset($_POST["branch"]) && isset($_FILES["notice"]["tmp_name"]) && isset($_POST["dept"]) && isPDF($_FILES["notice"]["name"]) )
                    {
                        $title = $_POST["noticeName"];
                        $class = $_POST["class"];
                        $branch = $_POST["branch"];
                        $dept = $_POST["dept"];
                       
                        $type = '1';
                        /* $message = 'This is a message.';   */



                        include("connect.php");
                        $cookie_name = "notapp_username";
                        $username = $_COOKIE[$cookie_name];
                        
                        
                        $sql = "select u_id from user where email='$username'";
                        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        
                        //$stmt = mysqli_prepare($conn, "select u_id from user where email=?");
                        //mysqli_stmt_bind_param($stmt, "s", $username);
                        //mysqli_stmt_execute($stmt); 
                        //$result = $stmt->get_result();
                        
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
                        $nb_id = $d_id;

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


                        




                        if (move_uploaded_file($_FILES["notice"]["tmp_name"], $path)) 
                        {

                            echo "The file has been uploaded";
                            $file_size = filesize($_FILES["notice"]["tmp_name"]);
                        } 
                        else 
                        {
                            echo "sorry, there was an error uploading your file.";
                            $file_size = -1;
                        }    

                        

                        $sql = "select c_id from class where c_name='$class'";
                        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        $class_details = mysqli_fetch_assoc($result);

                        $c_id = $class_details['c_id'];


                        $upDate = date('Y-m-d');


                        $sql = "insert into notice(title, n_type, uploadDate, name, u_id, d_id) values ('$title' , '$type', '$upDate'  , '$name' , '$u_id', '$d_id')";
                        $result = mysqli_query($conn,$sql) or die("<p>insert error</p>"); 
                        
                        //$stmt = mysqli_prepare($conn, "insert into notice(title, n_type, uploadDate, exp, name, u_id, d_id) values (? , ?, ? , ? , ? , ?, ?)");
                        //mysqli_stmt_bind_param($stmt, "sssssdd", $title , $type, $upDate , $exp , $name , $u_id, $d_id);
                        //mysqli_stmt_execute($stmt); 
                        //$result = $stmt->get_result();
                        
                        

                        $n_id = mysqli_insert_id($conn);

                        $sql = "insert into n_for_c(n_id, c_id) values ('$n_id' , '$c_id')";
                        $result = mysqli_query($conn,$sql) or die("<p>insert error</p>");
                        $md5 = md5_file($path);

                        //echo "notices/$dept/$name.pdf". "<br>" . "$md5"; 


                        $temp_id = ''.$n_id;

                        $msg = array
                        (
                            'title' 	=> $title,
                            'uploadDate'=> $upDate,
                            'name'	     => $user_name,
                            'n_id'=> $temp_id,
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
                            
                            echo "<br> $d_id  $n_id <br>";

                            $sql = "insert into n_for_d(n_id, d_id) values ('$n_id' , '$d_id')";
                            $result = mysqli_query($conn,$sql) or die("<p>insert error</p>"); 
                            
                            /**/
                            
                            $sql = "select u_id,gcmRegId from student where d_id='$d_id' and c_id='$c_id'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            
                            $regId = array();
                                
                            while($stud_details = mysqli_fetch_assoc($result))
                            {
                                $temp_id = $stud_details['u_id'];
                                echo "<br>u_id   $temp_id<br>";
                                $flag=0;
                                $sql = "select prefs from preferences where u_id=$temp_id";
                                $res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                $pref_details = mysqli_fetch_assoc($res);
                                $temp_prefs = $pref_details['prefs'];
                                
                                echo "<br><br> $temp_prefs <br><br>";
                                
                                $prefs_arr = explode(",", $temp_prefs);
                                
                                foreach($prefs_arr as $pref)
                                {
                                    echo $pref."** $nb_id $dept<br><br>";
                                    if($pref == $nb_id)
                                    {
                                        $flag = 1;
                                        break;
                                    }
                                }
                                
                                if($flag == 1)
                                {
                                    $regId[] = $stud_details['gcmRegId'];
                                }
                                
                            }
                            
                            /*                    
                            
                            
                            $sql = "select gcmRegId from student where d_id='$d_id' and c_id='$c_id'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            //$stud_details = mysqli_fetch_assoc($result);

                            $regId = array();

                            while($r = mysqli_fetch_assoc($result))
                            {
                                $regId[] = $r['gcmRegId'];
                            }
                            */
                            echo json_encode($regId);
                            
                            include_once 'push/gcm.php';

                            $gcm = new GCM();

                            $gcm_res = $gcm->send_notification($regId, $msg);

                        }
                    }                    
                }        
            }    
        ?>
        
        <main>            
            <div class="navbar-fixed">
                <nav class="nav-bar-info z-depth-half teal darken-3">
                    <div class="info">
                        <div class="title">
                            <label class="nav-title">Notapp - Upload</label>
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
                
                <nav class="nav-bar-tabs z-depth-1 teal darken-1">
                    
                    
                    <div class="row">
                        <div class="col s12 l6">
                            <ul class="tab-bar">
                                <li class="tab-new col s3"><a class="active tooltipped" data-position="bottom" data-delay="5" data-tooltip="Upload new notice" href="">New</a></li>
                                <li class="tab-new col s3"><a  href="view.php" class=" tooltipped" data-position="bottom" data-delay="5" data-tooltip="View uploaded notices">View</a></li>
                                <li class="tab-new col s3"><a href="" class="tooltipped" data-position="bottom" data-delay="5" data-tooltip="Need help?">Help</a></li>
                                <li class="tab-new col s3"><a href="aboutus.php" class="tooltipped" data-position="bottom" data-delay="5" data-tooltip="About the Developers">About</a></li>
                                <li class="tab-new invisible col s3 tooltipped" data-position="bottom" data-delay="5" data-tooltip="Sign out"><a href="logout.php">Exit</a></li>
                            </ul>
                        </div>
                    </div>                   
                    
                </nav>
            </div>
            
            <form enctype="multipart/form-data" id="formValidate" class="content" method="post" action="upload.php">
                <div class="row">
                    <div class="col m10 l8 s12 offset-l2 offset-m1">
                        <div class="card white">
                            
                            <div class="card-content grey-text text-darken-1">
                                
                                <div class="input-field">
                                    <div class="switch">
                                        <label>
                                            Notice
                                            <input type="checkbox" value="on" onchange="toggle(this);" class="filled-in" <?php echo $checked;?> id="notice-type" name="notice-type" />
                                            <span class="lever"></span>
                                            Short Message
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                                
                                <script type="text/javascript">
                                    
                                    
                                    function toggle(cb)
                                    {
                                        if(cb.checked)
                                        {
                                            document.getElementById('fileNotice').style.display = 'none';
                                            document.getElementById('shortMessage').style.display = 'block';
                                        }
                                        else
                                        {
                                            document.getElementById('fileNotice').style.display = 'block';
                                            document.getElementById('shortMessage').style.display = 'none';
                                        }
                                    }
                                    
                                    
                                </script>
                                
                                <div id="fileNotice">
                                    <span class="card-title">Choose a File</span>

                                    <div class="file-field input-field">
                                        <div class="row">

                                            <div class="col s12 m8 offset-m2">
                                                <div class="waves-effect waves-light btn-floating left" style="height: 55px; width:55px;">
                                                    <i class="material-icons" style="margin-top: 9px;margin-left: -1px;">attach_file</i>

                                                    <input type="file" name="notice" accept="application/pdf" onchange="document.getElementById('noticeName').value = this.value.split('\\').pop().split('/').pop().split('.')[0]">

                                                </div>


                                                <div class="file-path-wrapper">
                                                    <input class="validate" id="noticeName" placeholder="Title" name="noticeName" type="text">
                                                    <div class="error">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="error">
                                            <?php
                                                echo $file_err;
                                            ?>
                                        </div>                                    
                                    </div>

                                   
                                </div>
                                
                                
                                <div id="shortMessage">
                                    <span class="card-title">Write a short message</span>

                                    <div class="row"> 

                                    <div class="input-field col s12 m8 offset-m2">
                                        <i class="material-icons prefix">title</i>
                                        <input id="noticeTitle" name="noticeTitle" type="text" class="validate">
                                        <label for="noticeTitle">Title</label>
                                        
                                        <div class="error">
                                            
                                        </div>
                                        
                                    </div>

                                        <div class="input-field col s12 m8 offset-m2">
                                            <i class="material-icons prefix">mode_edit</i>
                                            <textarea id="messageText" name="messageText" length="500" class="materialize-textarea"></textarea>
                                            <label for="messageText">Short Message</label>
                                            
                                            <div class="error">
                                            
                                        </div>
                                        </div>
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
                                
                                
                                <div class="row">
                                    
                                    <div class="input-field col s12 m8 offset-m2 sel-input">
                                        <select class="icons" name="dept" id="dept">
                                            <option value="" disabled selected>Choose your option</option>                   
                                            
                                            <?php
                                                //$err_mssge = '<br>before sql<br>';                                            
                                                
                                                $u_id = $user_details['u_id'];
                                            
                                                $sql = "select TBD.d_id from t_belongsto_d TBD inner join teacher T on TBD.t_id = T.t_id where T.u_id=$u_id";
                                            
                                                $res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                                
                                            
                                                while($res_arr = mysqli_fetch_assoc($res))
                                                {
                                                    
                                                    $dept_pref = $res_arr['d_id'];
                                                    
                                                    $sql = "select * from department where d_id='$dept_pref'";
                                                    $dept_prefs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                                    $prefs_arr = mysqli_fetch_assoc($dept_prefs);
                                                    
                                                    $dept_code = strtolower($prefs_arr['d_name']);
                                                    $dept_fullname = $prefs_arr['full_name'];
                                                
                                                    echo "<option value='$dept_code' data-icon='graphics/icons/$dept_code.png' class='circle left'>$dept_fullname</option>";        
                                                }
                                                                                           
                                            
                                            ?>
                                                
                                            
                                                
                                           
                                        </select>
                                        
                                        
                                        
                                        
                                        <label>Notice Board</label>
                                        
                                    </div>
                                </div>
                                <br><br>
                            </div>
                        </div>
                        
                        
                        
                        <div style="width:60px; margin:auto; margin-top:-43px; margin-bottom: 10px;">
                        
                            <button class="btn-floating btn-large waves-effect waves-light" type="submit" name="upload">
                                <i class="material-icons right">file_upload</i>
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
                Materialize.toast('Welcome to Notapp Web', 2000, 'custom-toast');
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







