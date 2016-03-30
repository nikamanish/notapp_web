<!DOCTYPE html>
<html>
    <head>
        <!--Import Font awesome Icon Font-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>
        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href=" css/materialize.css"  media="screen,projection"/>
        <link rel="icon" type="image/png" href="myIcon.png">
        <link type="text/css" rel="stylesheet" href=" css/register.css" />
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <title>Notapp - Register</title>
        
    </head>
    
    <body>
        
        <main>
            <nav class="teal">
            
            </nav>
            

            <div class="row container">
                <div class="card white col s12 m10 offset-m1 l8 offset-l2">
                    
                    <?php
                    
                        include("connect.php");
                        if(isset($_POST['register']))
                        {  
                            if($_POST["fname"] && $_POST["lname"] && $_POST["email"] && $_POST["password"] && $_POST["confirm"] && $_POST["dob"] && $_POST["phone"])    
                            {
                                $fname= $_POST["fname"];
                                $lname = $_POST["lname"];
                                $email = $_POST["email"];
                                $password = $_POST["password"];
                                $confirm = $_POST["confirm"];
                                
                                $date = $_POST["dob"];
                                $phone = $_POST["phone"];
                                $dob = date('Y-m-d', strtotime($date));
                                                                
                                
                                

                                if(!checkEmailExist($email))
                                {
                                    if(checkPassword($password, $confirm))
                                    {
                                        
                                        if(isset($_POST["user-type"]))
                                        {
                                            
                                            $passcode = $_POST["passcode"];
                                            {
                                                if(checkPasscode($passcode))
                                                {
                                                    $type = 1;
                                                    insertValues($fname, $lname, $email, $password, $phone, $dob, $type);
                                                    insertStaffValue($email);
                                                }
                                                
                                                else
                                                {
                                                    echo "<p>passcode incorrect<br>you are not a legitimate user<br>your details has been sent to fbi</p>";
                                                }
                                            }                                

                                        }

                                        else
                                        {
                                            
                                            if($_POST["prn"] && $_POST["class"] && $_POST["dept"])
                                            {
                                                $prn = $_POST['prn'];
                                                $class = $_POST['class'];
                                                $dept = $_POST['dept'];
                                                $type = 2;
                                                insertValues($fname, $lname, $email, $password, $phone, $dob, $type);

                                                insertStudentValue($prn, $class, $dept, $email);    
                                            }
                                            else
                                            {
                                                echo "insert all values";
                                            }
                                            
                                        }

                                        header( "Location:index.php" );   
                                        exit();

                                    }
                                    else
                                    {
                                        echo "<p>password don't match</p>";
                                    }
                                }

                                else
                                {
                                    echo "<p>username already in use</p>";
                                }
                            }
                            else
                            {
                                echo "<p>enter all details</p>";
                            }
                        }
                    
                        function insertStudentValue($prn, $class, $dept, $email)
                        {
                            include("connect.php");
                            
                            $sql = "select u_id from user where email='$email'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            $user_details = mysqli_fetch_assoc($result);

                            $u_id = $user_details['u_id']; 
                            
                            $sql = "select c_id from class where c_name='$class'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            $class_details = mysqli_fetch_assoc($result);

                            $c_id = $class_details['c_id'];
                            
                            $dept = strtoupper($dept);
            
                            //To fetch d_id of selected department...

                            $sql = "select d_id from department where d_name='$dept'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            $dept_details = mysqli_fetch_assoc($result);

                            //d_id
                            $d_id = $dept_details['d_id'];
                            
                            $sql = "insert into student(PRN, u_id, c_id, d_id) values ('$prn','$u_id', '$c_id', '$d_id')";
                            $result = mysqli_query($conn,$sql) or die("<p>insert error</p>"); 
                        }
                    
                        function insertStaffValue($email)
                        {
                            include("connect.php");
                            
                            $sql = "select u_id from user where email='$email'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            $user_details = mysqli_fetch_assoc($result);

                            $u_id = $user_details['u_id'];  
                            
                            $sql = "insert into teacher(u_id) values ('$u_id')";
                            $result = mysqli_query($conn,$sql) or die("<p>insert error</p>"); 
                        }

                        function checkPassword($password, $confirm)
                        {
                            if($password == $confirm)
                            {
                                return true;
                            }

                            return false;
                        }

                        function checkPasscode($passcode)
                        {
                            if($passcode == "wce")
                            {
                                return true;
                            }

                            return false;
                        }

                        function checkEmailExist($email)
                        {
                            $ctr = 0;

                            include("connect.php");
                            $sql = "select * from user where email='$email'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $ctr++;
                            } 

                            if($ctr == 0)
                            {
                                return false;
                            }

                            return true;
                        }  

                        function insertValues($fname, $lname, $email,  $password, $phone, $dob, $type)
                        {
                            include("connect.php");
                            
                            echo $type;
                            
                            $sql = "insert into user(f_name, l_name, email, phone, dob, pword, type) values('$fname', '$lname','$email', '$phone', '$dob', '$password', $type)";
                            
                            
                            
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        }
                    ?>
                    
                    <form action="register.php" id="formValidate" class="formValidate right-alert" method="post">
                        <div class="row">
                            
                            <h2 class="center-align"><img src=" graphics/notapp.png" height="70px">Register</h2>
                            
                            <div class="input-field col  s12 m6">
                                <i class="material-icons prefix">person</i>
                                <label for="fname">First Name</label> 
                                <input id="fname" name="fname"  type="text" class="" data-error=".error1">
                                <div class="error1"></div>
                            </div>
                            <div class="input-field col s10 offset-s2 m6">
                                
                                <input id="lname" name="lname" required="" aria-required="true" type="text" class="" data-error=".error2">
                                <label for="lname">Last Name</label>
                                <div class="error2"></div>
                            </div>
                            
                            <div class="input-field col s12">
                                <i class="material-icons prefix">email</i>
                                <input id="email" name="email" type="email" class="" data-error=".error3">
                                <label for="email">Email</label>
                                <div class="error3"></div>
                            </div>
                                                        
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">vpn_key</i>
                                <input id="password" name="password" required="" aria-required="true" type="password" class="validate" data-error=".error4">
                                <label for="password">Password</label>
                                <div class="error4"></div>
                            </div>
                            
                            <div class="input-field col s10 offset-s2 m6">
                                
                                <input id="confirm" name="confirm" required="" aria-required="true" type="password" class="" data-error=".error5">
                                <label for="confirm">Confirm Password</label>
                                <div class="error5"></div>
                            </div>
                            
                            <div class="input-field col s12">
                                 <i class="material-icons prefix">phone</i>
                                <input id="phone" name="phone" maxlength="10" required="" aria-required="true" type="tel" class="" data-error=".error6">
                                <label for="phone">Phone</label>
                                <div class="error6"></div>
                            </div>
                            
                            <div class="input-field col s12">
                                 
                                <i class="material-icons prefix">date_range</i>
                                <input id="dob" type="date" required="" aria-required="true" name="dob"  class="datepicker" data-error=".error7">
                                <label class="active" for="dob">Date of Birth</label>
                                <div class="error7"></div>
                            </div>
                            
                            <div class="input-field col s4 offset-s1">
                                <!--<input type="checkbox" checked value="user-type" onchange="changeMarkup(this);" class="filled-in" id="user-type" />
                                <label for="user-type">Register as Staff?</label>
-->
                                
                                <div class="switch">
                                    <label>
                                        Student
                                        <input type="checkbox" checked value="on" onchange="changeMarkup(this);" class="filled-in" id="user-type" name="user-type" />
                                        <span class="lever"></span>
                                        Staff
                                    </label>
                                </div>
                            </div>
                            
                            <div id="opt-html">
                                <div class="input-field col s7"><i class="material-icons prefix">security</i><input id="passcode" required="" aria-required="true" name="passcode" type="password" class=""><label for="passcode">Secret Passcode</label></div>
                            </div>
                            
                            <script>
                                
                                function changeMarkup(cb)
                                {
                                 
                                    var markup='<div class="input-field col s7"><i class="material-icons prefix">security</i><input id="passcode" name="passcode" type="password" data-error=".error8" class=""><label for="passcode">Secret Passcode</label><div class="input-field"><div class="error8"></div></div></div>';
                                    
                                    document.getElementById('opt-html').innerHTML = markup;
                                    
                                    if(cb.checked)
                                    {
                                        markup = '<div class="input-field col s7"><i class="material-icons prefix">security</i><input id="passcode" name="passcode" type="password" data-error=".error8" class=""><label for="passcode">Secret Passcode</label><div class="input-field"><div class="error8"></div></div></div>'; 
                                    }

                                    else
                                    {
                                        markup = '<div class="input-field col s7"><i class="material-icons prefix">contacts</i><input id="prn" maxlength="10" name="prn" type="text" class=""><label for="prn">PRN</label></div><div class="input-field col s12 m5 offset-m1 sel-input"><select name="class" data-error=".error9" id="class"><optgroup label="B.Tech"><option value="b1" selected>First Year</option><option value="b2">Second Year</option><option value="b3">Third Year</option><option value="b4">Final Year</option></optgroup><optgroup label="M.Tech"><option value="m1">Frst Year</option><option value="m2">Scond Year</option></optgroup></select><label>Select Class</label><div class="input-field"><div class="error9"></div></div></div></div><div class="input-field col s12 m5 sel-input"><select data-error=".error10" id="dept" name="dept" class=""><option value="" disabled selected>Choose your option</option><option value="it" class="filled-in" selected>InfoTech</option><option value="cse">Computer Science</option><option value="eln">Electronics</option><option value="ele">Electrical</option><option value="mech">Mechanical</option><option value="civ">Civil</option></select><label>Select Department</label><div class="input-field"><div class="error10"></div></div></div></div>';        
                                    }
                                    

                                    document.getElementById('opt-html').innerHTML = markup ;
                                    $('select').material_select();
                                }
                                
                            </script>
                            
                            
                            
                        </div>
                        
                        <div class="card-action">
                            
                            <div class="row">
                                
                                <input type="submit" name="register" value="Register" class="btn waves-effect waves-light col s8 offset-s2" />
                            </div>
                            
                        </div>

                    </form>
                </div>
            </div>
            
            

        </main>
        
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src=" js/materialize.js"></script>
        <script type="text/javascript" src=" js/jquery.validate.js"></script>
        <script type="text/javascript" src=" js/register.js"></script>
        
        <script>
            $(document).ready(function() {
            
            $('select').material_select();
                
            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 132, // Creates a dropdown of 15 years to control year
                format: 'yyyy-mm-dd'
              });

                
            });

        </script>
        
    </body>
</html>