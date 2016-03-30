<!DOCTYPE html>
<html>
    <head>
        <!--Import Font awesome Icon Font-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href=" css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/try.css" />
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400' rel='stylesheet' type='text/css'>
        <link rel="icon" type="image/png" href="myIcon.png">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <title>
            
            Manish Nikam
        </title>
        
    </head>
    <body>    
        
        <script>
            
        </script>      
        
        <main>            
            <div class="navbar-fixed">
                <nav class="nav-bar-info z-depth-half teal darken-3">
                    <div class="info">
                        <div class="title">
                            <label class="nav-title">Notapp - Upload</label>
                        </div>        
                        
                        <div class="dp">
                            <img height="40px" class="" src="graphics/dp.jpg">
                        </div>
                        
                        <div class="text-info">
                            <p class="email">nikamanish007@gmail.com</p>
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
                                <li class="tab-new col s3"><a  href="" target="_blank" class=" tooltipped" data-position="bottom" data-delay="5" data-tooltip="View uploaded notices">View</a></li>
                                <li class="tab-new col s3"><a href="" class="tooltipped" data-position="bottom" data-delay="5" data-tooltip="Need help?">Help</a></li>
                                <li class="tab-new col s3"><a href="aboutus.php" class="tooltipped" data-position="bottom" data-delay="5" data-tooltip="About the Developers">About</a></li>
                                <li class="tab-new invisible col s3 tooltipped" data-position="bottom" data-delay="5" data-tooltip="Sign out"><a href="">Exit</a></li>
                            </ul>
                        </div>
                    </div>                   
                    
                </nav>
            </div>
            
            <div class="content">
                
            </div>
            
           
        </main>
        
        
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src=" js/materialize.min.js"></script>
        <script>
            $(document).ready(function() {
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