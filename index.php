<!DOCTYPE html>
<html>
    <head>
        <!--Import Font awesome Icon Font-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,400' rel='stylesheet' type='text/css'>
        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href=" css/materialize.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href=" css/login.css" />
        <link rel="icon" type="image/png" href="myIcon.png">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <title>Notapp - Login</title>
        
    </head>
    
    <body>
        
        <?php
        
            $err_msg = '';
            $cookie_name = "notapp_username";
            if(isset($_COOKIE[$cookie_name]))
            {
                header( "Location:upload.php"); 
                exit();
            }
        
            elseif(isset($_POST['register']))
            {                                    
                header( "Location:register.php"); 
                exit();
            }

            elseif(isset($_POST['login']))
            {
                if($_POST["username"] && $_POST["password"])    
                {
                    $username= $_POST["username"];
                    $password= $_POST["password"];
                    

                    include("connect.php");

                    if(checkUsernameExist($username))
                    {
                        if(checkCorrectPassword($username, $password))
                        {
                            if(isset($_POST['remember']))
                            {
                                setcookie($cookie_name, $username, time() + (10 * 365 * 24 * 60 * 60), "/");    
                            }
                            else
                            {
                                setcookie($cookie_name, $username, time() + (60 * 60 * 24), "/");
                            }
                            
                            
                            header( "Location:upload.php" ); 
                            exit();
                        }

                        else
                        {
                            $err_msg = "Password incorrect";                                
                        }
                    }
                    else
                    {   
                        $err_msg = "Username not registered";
                    }
                }
            }

            function checkUsernameExist($username)
            {
                $ctr = 0;
                $ctr2 = 0;
                $u_id  = 0;

                include("connect.php");
                $sql = "select u_id from user where email='$username'";
                $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                
                
                //$stmt = mysqli_prepare($conn, "select u_id from user where email=?");
                //mysqli_stmt_bind_param($stmt, "s", $username);
                //mysqli_stmt_execute($stmt); 
                //$result = $stmt->get_result();  
                //$result = mysqli_stmt_get_result($stmt);
                //echo mysqli_num_rows($result)."<br>";
                
                while(mysqli_num_rows($result) != 0 && $row = mysqli_fetch_assoc($result))
                {
                    $ctr++;
                    
                    $u_id = $row['u_id'];
                } 
                
                $sql = "select * from teacher where u_id='$u_id'";
                $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                
                while(mysqli_num_rows($result) != 0 && $row = mysqli_fetch_assoc($result))
                {
                    $ctr2++;
                } 
                

                if($ctr == 0 || $ctr2==0)
                {
                    return false;
                }

                return true;
            }  

            function checkCorrectPassword($username, $password)
            {
                include("connect.php");
                
                $sql = "select pword from user where email='$username'";
                $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                
                //$stmt = mysqli_prepare($conn, "select pword from user where email=?");
                //mysqli_stmt_bind_param($stmt, "s", $username);
                //mysqli_stmt_execute($stmt); 
                //$result = $stmt->get_result(); 
                //$result = mysqli_stmt_get_result($stmt);
                
                $row = mysqli_fetch_assoc($result);

                $temp = $row['pword'];
                if($password == $temp)
                {
                    return true;
                }

                return false;
            }
        ?>   
        
        
        <main>
            <nav class="teal">
            
            </nav>
            <div class="row container">
                <div class="card white col s12 m8 offset-m2 l6 offset-l3">
                    <form method="post" id="formValidate" action="index.php">
                        <div class="row">
                            
                            <h2 class="center-align"><img src=" graphics/notapp.png" height="70px">Notapp</h2>
                            
                            <p class="error-msg"><?php echo $err_msg; ?></p>
                            
                            <div class="input-field col  s12 m10 offset-m1">
                                <i class="material-icons prefix">person</i>
                                <input id="username" name="username" type="text" 
                                       <?php                                        
                                            if(isset($_POST['username'])) 
                                            {
                                                $usrnm = $_POST['username'];
                                                echo "value=$usrnm";    
                                            }
                                        ?> 
                                       data-error=".error1" class="">
                                <label for="username">Username</label>
                                <div class="error1"></div>
                            </div>
                            <div class="input-field col s12 m10 offset-m1">
                                <i class="material-icons prefix">vpn_key</i>
                                <input id="password" name="password" type="password" data-error=".error2" class="">
                                <label for="password">Password</label>
                                <div class="error2"></div>
                            </div>
                            
                            <div class="col offset-m1 remember">
                                <input type="checkbox" name="remember" id="remember" class="filled-in" />
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        
                        <div class="card-action">
                            
                            <div class="row">
                                <input type="submit" name="login" value="LOGIN" class="btn waves-effect waves-light col s4 offset-s1" />
                                <a href="register.php">
                                    
                                <div class="btn col wave-effect waves-light s4 offset-s2">Register</div>
                                    
                                </a>
                                
                            </div>
                            
                        </div>

                    </form>
                    
                    <div class="about col s12">
                        <a href="aboutus.php" class="btn-floating btn-large waves-effect waves-light teal"><i class="material-icons">developer_mode</i></a>

                    </div>        
                </div>
            </div>
        </main>
        
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src=" js/materialize.js"></script>
        <script type="text/javascript" src=" js/jquery.validate.js"></script>
        <script type="text/javascript" src=" js/login.js"></script>
        
        <script>
            $(document).ready(function() {
            
            $('select').material_select();
                
            
            });

        </script>
        
    </body>
</html>