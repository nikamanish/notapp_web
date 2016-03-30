<!DOCTYPE html>
<html>
    <head>
        <!--Import Font awesome Icon Font-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/index.css" />
        
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
        
        
        
        <div class="parallax-container">
            <div class="parallax"><img src="graphics/mat4.jpg"></div>
        </div>
        <div class="section white">
            <div class="row container">
                <h3 class="header">Notapp</h3>
                <p class="grey-text  lighten-3">Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    >Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    >Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                                        
                                    
                </p>
            </div>
        </div>
        <div class="parallax-container">
            <div class="parallax"><img src="graphics/mat3.png"></div>
        </div>
        
        <div class="section white">
            <div class="row container">
                <h3 class="header">Xalpha Clan</h3>
                <p class="grey-text  lighten-3">Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    >Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    >Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                    Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.
                                        
                                    
                </p>
            </div>
        </div>
        <div class="parallax-container">
            <div class="parallax"><img src="graphics/mat6.jpg"></div>
        </div>
        
        <div class="fixed-action-btn click-to-toggle" style="bottom: 45px; right: 24px;">
            <a class="btn-floating btn-large light-blue">
                <i class="large material-icons">menu</i>
            </a>
            <ul>
                <li><a href="upload.php" class="btn-floating red"><i class="material-icons">file_upload</i></a></li>
                <li><a href="view.php" class="btn-floating green darken-1"><i class="material-icons">description</i></a></li>
                
            </ul>
        </div>
        
        
        
        
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
        
        <script>
            $(document).ready(function(){
              $('.parallax').parallax();
            });
        </script>
    </body>
</html>