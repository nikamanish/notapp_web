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
                include_once("connect.php");
                $cookie_name = "notapp_username";
                if(!isset($_COOKIE[$cookie_name]))
                {
                    header( "Location:index.php"); 
                    exit();
                }            
                $username = $_COOKIE[$cookie_name];
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
                            <label class="nav-title">Notapp - Upload</label>
                        </div>        
                        
                        <div class="dp">
                            <img src=' graphics/placeholder.png' alt='' height='40px'>
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
                                            <input type="checkbox" value="on" onchange="toggleFile(this);" class="filled-in" checked id="notice-type" name="notice-type" />
                                            <span class="lever"></span>
                                            Short Message
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                                
                                <script type="text/javascript">
                                    
                                    
                                    function toggleFile(cb)
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
                                                //echo $file_err;
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
                                    
                                    <div class="input-field col s12">
                                        <div class="switch">
                                            <label>
                                                Specific
                                                <input type="checkbox" value="on" onchange="toggle(this);" class="filled-in" checked id="notice-type" name="notice-type" />
                                                <span class="lever"></span>
                                                Classes
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <br>    
                                    
                                    <div style="width:60px; margin:auto; margin-top: 100px;">
                                        <a class="btn-floating center btn-large blue modal-trigger waves-effect waves-light" href="#recipientModal"><i class="material-icons">add</i></a>   
                                    </div>
                                    
                                    <div id="recipientModal" class="modal modal-fixed-footer">
                                        
                                        <div class="modal-content">
                                            
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
                                                        //echo $branch_err;
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
                                        
                                        <div class="modal-footer">
                                            <a href="#!" class="modal-action modal-close waves-effect waves-blue btn-flat ">dONE</a>
                                        </div>
                                        
                                        

                                    </div>
                                    
                                  
                                </div>
                            </div>
                        </div>
                        
                        <div class="card white">
                            <div class="card-content grey-text text-darken-1">
                                
                                <div class="input-field">
                                    <div class="error">
                                        <?php
                                            //echo $dept_err;
                                        ?>
                                    </div>                                   
                                </div>
                                
                                <span class="card-title">Select Notice Section</span>
                                
                                
                                <div class="row">
                                    <div class="input-field col s12 m8 offset-m2 sel-input">
                                        <select class="icons" name="dept" id="dept">
                                            <option value="" disabled selected>Choose your option</option>
                                            <optgroup label="Departments">
                                                
                                                <option value="it" data-icon="graphics/icons/it.png" class="circle left">Information Technology</option>
                                                <option value="cse" data-icon="graphics/icons/cse.png" class="circle left">Computer Science</option>
                                                <option value="eln" data-icon="graphics/icons/eln.png" class="circle left">Electronics</option>
                                                <option value="ele" data-icon="graphics/icons/ele.png" class="circle left">Electrical</option>
                                                <option value="mech" data-icon="graphics/icons/mech.png" class="circle left">Mechanical</option>
                                                <option value="civ" data-icon="graphics/icons/civ.png" class="circle left">Civil</option>
                                            </optgroup>
                                            
                                            <optgroup label="Sciences">
                                                
                                                <option value="phy" data-icon="graphics/icons/phy.png" class="circle left">Physics</option>
                                                <option value="chem" data-icon="graphics/icons/chem.png" class="circle left">Chemistry</option>
                                                <option value="math" data-icon="graphics/icons/math.png" class="circle left">Mathematics</option>
                                                <option value="bio" data-icon="graphics/icons/bio.png" class="circle left">Biology</option>
                                                
                                            </optgroup>
                                            
                                            <optgroup label="Administration">
                                                
                                                <option value="admin" data-icon="graphics/icons/admin.png" class="circle left">Admin / Office</option>
                                                <option value="tpo" data-icon="graphics/icons/tpo.png" class="circle left">Training & Placement</option>
                                                <option value="exam" data-icon="graphics/icons/exam.png" class="circle left">Exam Cell</option>
                                                
                                            </optgroup>
                                            
                                            <optgroup label="Miscellaneous">
                                                
                                                <option value="rector" data-icon="graphics/icons/rector.png" class="circle left">Rector</option>
                                                <option value="sports" data-icon="graphics/icons/sports.png" class="circle left">Sports & Gym</option>
                                                <option value="scholarship" data-icon="graphics/icons/scholarship.png" class="circle left">Scholarship</option>
                                                <option value="library" data-icon="graphics/icons/library.png" class="circle left">Library</option>
                                                <option value="lostfound" data-icon="graphics/icons/lostfound.png" class="circle left">Lost & Found</option>
                                                
                                            </optgroup>
                                        </select>
                                        
                                        
                                        
                                        
                                        <label>Notice Board</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card white">
                            <div class="card-content grey-text text-darken-1">
                                <span class="card-title">Select Expiration Date (optional)</span>                       
                                <div class="row date">
                                     <div class="input-field col s12 m10 offset-m1" style="padding-bottom: 40px;">
                                 
                                        <i class="material-icons prefix">date_range</i>
                                        <input id="expiration" type="date" name="expiration"  class="datepicker">
                                        <label class="active" for="expiration">Expiration Date</label>
                                    </div>
                                </div>
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
                $('.modal-trigger').leanModal();
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