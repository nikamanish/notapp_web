<!DOCTYPE html>
<html>
    <head>
        <!--Import Font awesome Icon Font-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href=" css/materialize.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href=" css/view.css" />
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>
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

                $name = $user_details['f_name'] . ' ' . $user_details['l_name'];
                
                echo $name;
            ?>
        </title>
        
    </head>
    <body>
        
        
                
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
                                echo $name;
                            ?>
                        </label>    
                        <label class="email white-text">
                            <?php
                                echo $username;
                            ?>                        
                        </label>
                    </div>
                </div>
                
                
                
                <li class="waves-effect waves-dark"><a href="upload.php" class=""><i class="fa fa-upload fa-2x fa-fw"></i>Upload</a></li>
                <li class="selected waves-effect waves-dark"><a><i class="fa fa-file-text fa-2x fa-fw"></i>View</a></li>
                
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
                    <label class="page-title">Notapp - View</label>
                </nav>

            </div>
            
            <div class="row">
                <div class="col s12 row">
                    <?php
                        
                        $u_id = $user_details['u_id'];
                        
                        $sql = "select * from notice where u_id='$u_id' order by n_id desc";
                        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        
                        $ctr = 0;
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $d_id = $row['d_id'];
                            $n_id = $row['n_id'];
                            
                            $sql = "select d_name from department where d_id='$d_id'";
                            $dept_res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            $dept_details = mysqli_fetch_assoc($dept_res);
                            $dept = $dept_details['d_name'];
                            $dept = strtolower($dept);
                            $exp = $row['exp'];
                            $upDate = $row['uploadDate'];
                            $title = $row['title'];
                            $name = $row['name'];
                            $classes = " ";
                            $classes = printDepts($n_id);
                            
                            $upDate = alphaDate($upDate);
                            $exp = alphaDate($exp);
                            
                            echo "<div class='col s12 m4'>
                                    <div class='card'>
                                        <div class='card-image waves-effect waves-block waves-light'>
                                            <img class='activator' src=' graphics/icons/$dept.png'>
                                        </div>
                                        <div class='card-content'>
                                            <span class='card-title activator grey-text text-darken-4'>$title<i class='material-icons right'>more_vert</i></span>
                                            <a href='notices/$dept/$name.pdf' target='_blank' class='right'><i class='material-icons right'>description</i></a>

                                        </div>
                                        <div class='card-reveal'>
                                            <span class='card-title grey-text text-darken-4'>$title<i class='material-icons right'>close</i></span>
                                            <p>Uploaded on $upDate</p>
                                            <ul>
                                                $classes                                                
                                            </ul>
                                            <p>Expires on $exp</p>
                                        </div>
                                    </div>
                                </div>";
                                $ctr++;
                        }
                    
                        if($ctr == 0)
                        {
                           echo "<div class='col s12 m12'>
                                    <div class='card'>
                                        <div class='card-image waves-effect waves-block waves-light'>
                                            <img class='activator' src=' graphics/mat1.jpg'>
                                        </div>
                                        <div class='card-content'>
                                            <span class='card-title activator grey-text text-darken-4'>No notices uploaded by you yet<i class='material-icons right'>more_vert</i></span>
                                            <a href='upload.php'  class='right'><i class='material-icons right'>file_upload</i></a>

                                        </div>
                                        <div class='card-reveal'>
                                            <span class='card-title grey-text text-darken-4'>Nothing Yet<i class='material-icons right'>close</i></span>
                                            <p>Upload the notices you want to be delivered to your students</p>
                                            
                                        </div>
                                    </div>
                                </div>";
                        }
                    
                        function printDepts($n_id)
                        {
                            include("connect.php");
                            
                            $sql = "select c_id from n_for_c where n_id='$n_id'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            $row = mysqli_fetch_assoc($result);
                            
                            $c_id = $row['c_id'];
                            
                            $sql = "select full_name from class where c_id='$c_id'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            $row = mysqli_fetch_assoc($result);
                            
                            $c_name = $row['full_name'];
                            
                            $sql = "select * from n_for_d where n_id='$n_id'";
                            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                            
                            $classes = '';
                            
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $d_id = $row['d_id'];
                                
                                $sql = "select full_name from department where d_id='$d_id'";
                                $res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                $r = mysqli_fetch_array($res);
                                $d_name = $r['full_name'];
                                
                                $classes.= "<li>$c_name $d_name</li>";
                            }
                            
                            return $classes;                            
                        }
                    
                        function alphaDate($date)
                        {
                            $frags = explode("-", $date);
                            
                            $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"); 
                            $index = (int)($frags[1]);
                            return $frags[2] . ' ' . $month[$index -1] . ' ' . $frags[0];
                        }
                    ?>
                </div>
            
            </div>
            
            
            

        </main>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src=" js/materialize.min.js"></script>
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
