<!DOCTYPE html>
<html>
    <head>
        <!--Import Font awesome Icon Font-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href=" css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/try.css" />
        <link type="text/css" rel="stylesheet" href="css/view2.css" />
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

                $name = $user_details['f_name'] . ' ' . $user_details['l_name'];
                
                echo $name;
            ?>            
        </title>
        
    </head>
    
    <body> 
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
                                <li class="tab-new col s3 "><a  href="view.php" class="active tooltipped" data-position="bottom" data-delay="5" data-tooltip="View uploaded notices">View</a></li>
                                <li class="tab-new col s3"><a href="" class="tooltipped" data-position="bottom" data-delay="5" data-tooltip="Need help?">Help</a></li>
                                <li class="tab-new col s3"><a href="aboutus.php" class="tooltipped" data-position="bottom" data-delay="5" data-tooltip="About the Developers">About</a></li>
                                <li class="tab-new col invisible s3 tooltipped" data-position="bottom" data-delay="5" data-tooltip="General settings"><a href="setting.php"><i class="material-icons prefix">settings</i></a></li>
                                <li class="tab-new invisible col s3 tooltipped" data-position="bottom" data-delay="5" data-tooltip="Sign out"><a href="logout.php">Exit</a></li>
                            </ul>
                        </div>
                        <div class="col right setting-div waves-light waves-effect">
                            <a class="setting-icon " href="setting.php"><i class="material-icons prefix">settings</i></a>
                        </div>
                    </div>                   
                    
                </nav>
                
                <nav class="nav-bar-tabs z-depth-1 teal darken-1 phone-nav invisible">                    
                    
                    <div class="row">
                        <div class="col s12 l6">
                            <ul class="tab-bar">
                                <li class="tab-new col s3"><a class="" data-position="bottom" data-delay="5"  href="upload.php"><i class="material-icons prefix">file_upload</i></a></li>
                                <li class="tab-new col s3 active"><a  href="" class="active" data-position="bottom"><i class="material-icons prefix">description</i></a></li>
                                <li class="tab-new  col s3 " data-position="bottom" data-delay="5" ><a href="setting.php"><i class="material-icons prefix">settings</i></a></li>
                                <li class="tab-new col s3"><a href="" class="" data-position="bottom" data-delay="5" ><i class="material-icons prefix">help</i></a></li>
                                <li class="tab-new col s3"><a href="aboutus.php" class="" data-position="bottom" ><i class="material-icons prefix">developer_mode</i></a></li>
                                <li class="tab-new col s3 " data-position="bottom" data-delay="5" ><a href="logout.php"><i class="material-icons prefix">exit_to_app</i></a></li>
                            </ul>
                        </div>
                        
                    </div>                   
                    
                </nav>
                
            </div>
            
            <div class="content">                
                <div class="row">
                    <div class="col m8 s12 offset-m2">                       
                        <ul class="collapsible" data-collapsible="accordion">
                            
                            <?php
                                $u_id = $user_details['u_id'];

                                $sql = "select * from notice where u_id='$u_id' order by n_id desc";
                                $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

                                $ctr = 0;
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    $d_id = $row['d_id'];
                                    $n_id = $row['n_id'];
                                    $ctr++;
                                    $sql = "select d_name from department where d_id='$d_id'";
                                    $dept_res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                    $dept_details = mysqli_fetch_assoc($dept_res);
                                    $dept = $dept_details['d_name'];
                                    $dept = strtolower($dept);
                                    //$exp = $row['exp'];
                                    $upDate = $row['uploadDate'];
                                    $title = $row['title'];
                                    $name = $row['name'];
                                    $classes = " ";
                                    $classes = printDepts($n_id);
                                    
                                    
                                                                        
                                    $upDate = alphaDate($upDate);
                                    //$exp = alphaDate($exp);                                    
                                                                     
                                    
                                    if($name[0] != '#')
                                    {
                                        echo "<li>
                                                <div class='collapsible-header'>
                                                    <div class='row no-margin title-header'>
                                                        <div class='col s10 m11 no-padding' >
                                                            <i class='material-icons'>insert_drive_file</i>
                                                            <p class='notice-title truncate'>
                                                                $title
                                                            </p>
                                                        </div>
                                                        <div class='col no-padding s2 m1' >
                                                                                                                    
                                                            <a class='right modal-trigger' href='#message$ctr'>
                                                                <i class='material-icons no-margin'>description</i>
                                                            </a>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div id='message$ctr' class='modal modal-fixed-footer'>

                                                    <div class='modal-content'>
                                                    
                                                        <embed width='100%' height='100%' src='notices/$dept/$name.pdf'>
                                                    </div>

                                                    <div class='modal-footer'>
                                                        <a class='modal-action modal-close waves-effect waves-blue btn-flat '>close</a>
                                                    </div>
                                                </div>
                                                

                                                <div class='collapsible-body'>
                                                    <p class=''>Uploaded on $upDate</p>
                                                    
                                                    <ul class='class-list no-padding-top'>
                                                        $classes                                                
                                                    </ul>
                                                    
                                                    
                                                </div>
                                            </li>";                                        
                                    }
                                    
                                    else
                                    {
                                        $name = substr($name, 1);   
                                        echo "<li>
                                                <div class='collapsible-header'>
                                                    <div class='row no-margin title-header'>
                                                        <div class='col s10 m11 no-padding' >
                                                            <i class='material-icons'>chat_bubble</i>
                                                            <p class='notice-title truncate'>
                                                                $title
                                                            </p>
                                                        </div>
                                                        <div class='col no-padding s2 m1' >
                                                            <a class='right modal-trigger' href='#message$ctr'>
                                                                <i class='material-icons no-margin'>chat</i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id='message$ctr' class='modal modal-fixed-footer'>

                                                    <div class='modal-content'>
                                                    
                                                        <h5 class='center-align truncate'>
                                                            $title
                                                        </h5> 
                                                        
                                                        <div class='container'>
                                                            <div class='divider'></div>
                                                            <p class='justify'>
                                                                $name
                                                            </p> 
                                                        </div>
                                                    </div>

                                                    <div class='modal-footer'>
                                                        <a class='modal-action modal-close waves-effect waves-blue btn-flat '>close</a>
                                                    </div>
                                                </div>                                

                                                <div class='collapsible-body'>
                                                    <p>Uploaded on $upDate</p>
                                                    
                                                    <ul class='class-list no-padding-top'>
                                                        $classes                                                
                                                    </ul>
                                                    
                                                    
                                                </div>
                                            </li>";                                        
                                    }
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
                        </ul>                    
                    </div>
                </div>
            </div>
        </main>        
        
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src=" js/materialize.min.js"></script>
        <script>
            $(document).ready(function() {
            
            $('.tooltipped').tooltip({delay: 50});
            $('.modal-trigger').leanModal();
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

          }); 
        })(jQuery);
        
        </script>
        
        <script>
            $(window).bind('scroll', function() 
            {
                if ($(window).scrollTop() > 100)
                {
                    $('#myDivId').hide();
                }
                else 
                {
                    $('#myDivId').show();
                }
            });
        </script>
    </body>
</html>
