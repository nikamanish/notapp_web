<?php
     {
        include("connect.php");
                
        $prn = $_GET['prn'];         
        $userid = -1;
        $randomid=-1;
        $mode = -1;
        $flag=0;
        $mainflag = 0;
        
        if(isset($_GET['id']))
        {
            $randomid = $_GET['id'];
        }
         
        if(isset($_GET['mode']))
        {
            $mode = $_GET['mode'];
        }
         
         
        /* GET THE USERID OF STUDENT FROM PRN */        
        $stmt = mysqli_prepare($conn, "select id,username from mdl_user where lastname like ?");
        $prn = '%'.$prn.'%';
        mysqli_stmt_bind_param($stmt, "s", $prn);
        mysqli_stmt_execute($stmt); 
        $result = $stmt->get_result();
        
        while($x = mysqli_fetch_assoc($result))
        {
            $username = $x['username'];
            
            //if($username[0] > 'a' && $username[0] < 'z' && $username[2] !='@')
            {
                $userid = $x['id'];
                //echo "$userid   $username<br>";
                //break;
            }  
        }   
        
        if($userid != -1)
        {
            /* GET THE ENROLLMENT_ID OF STUDENT FROM HIS USERID/STUDENT_ID  */
            $sql = "select enrolid from mdl_user_enrolments where userid=$userid";
            $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

            while($x = mysqli_fetch_assoc($result))
            {
                $enrolid = $x['enrolid'];
                                
                /* GET THE COURSES REGISTERED BY STUDENT FROM HIS ENROLLMENT_ID  */
                $sql = "select courseid from mdl_enrol where id=$enrolid";
                $res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                
                while($y = mysqli_fetch_assoc($res))
                {
                    $courseid = $y['courseid'];
                    
                    if($courseid <= 2100)
                    {
                        /* GET THE COURSENAME OF COURSE FROM COURSEID */
                        $sql = "select fullname from mdl_course where id=$courseid";
                        $r1=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        
                        /* GET THE ATTENDANCE_ID OF COURSE FROM HIS COURSEID */
                        $sql = "select id from mdl_attendance where course=$courseid";
                        $r=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        
                        $t = mysqli_fetch_assoc($r1);                   
                        $z = mysqli_fetch_assoc($r);
                        
                        $attendanceid = $z['id'];
                        $name = $t['fullname'];
                        
                        $achieved = 0;
                        $total = 0;
                        
                        if($mode != -1)
                        {
                            if($courseid == $randomid)
                            {
                                //echo 'done<br>';
                                $b = $courseid == $randomid;
                                $flag = 1;
                                echo "$courseid ___ $randomid ______ $b <br>";
                                
                            }
                        }
                        
                        
                        if($attendanceid !=null)
                        {
                            
                            /* GET THE SESSIONS OF COURSE FROM ITS ATTENDANCE_ID */
                            $sql = "select id from mdl_attendance_sessions where attendanceid=$attendanceid";
                            $session=mysqli_query($conn,$sql) or die(mysqli_error($conn));

                            while($sess = mysqli_fetch_assoc($session))
                            {
                                $sessionid = $sess['id'];
                                
                                /* GET THE STATUSID OF SESSION FROM SESSION_ID AND USERID/STUDENTID */
                                $sql = "select statusid from mdl_attendance_log where sessionid=$sessionid and studentid=$userid";
                                $status=mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                $stat = mysqli_fetch_assoc($status);
                                
                                $statusid = $stat['statusid'];
                                
                                if($statusid != null)
                                {   
                                    /* GET THE GRADE VALUE OF SESSION FROM SESSIONS'S STATUSID */
                                    $sql = "select grade from mdl_attendance_statuses where id=$statusid";
                                    $grades=mysqli_query($conn,$sql) or die(mysqli_error($conn));

                                    $grade = mysqli_fetch_assoc($grades);
                                    
                                    $gradepoint = $grade['grade'];
                                    
                                    if($courseid == $randomid && $gradepoint == 0 && $mainflag == 0)
                                    {
                                        $sql = "select statusset from mdl_attendance_log where sessionid=$sessionid and studentid=$userid";
                                        $st = mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                        $se = mysqli_fetch_assoc($st);
                                        
                                        $set = $se['statusset'];
                                        
                                        $ss = explode(",",$set);
                                        $finid = '';
                                        
                                        foreach($ss as $a)
                                        {
                                            $sql = "select acronym from mdl_attendance_statuses where id=$a";
                                            $ar = mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                            $afa = mysqli_fetch_assoc($ar);
                                            $acr = $afa['acronym'];
                                            
                                            echo $acr.' ';
                                            
                                            if($acr == 'P')
                                            {
                                                //$finid = $a;
                                                $sql = "update mdl_attendance_log set statusid=$a where sessionid=$sessionid and studentid=$userid";
                                                $mainflag = 1;
                                                $flag = 0;
                                                $tt = mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                                
                                                echo $a.'<br><br>';
                                                break;
                                            }
                                        }
                                        
                                        
                                        //$rr = mysqli_fetch_assoc($tt);
                                        
                                        
                                            
                                    }

                                    
                                    
                                    
                                    /* CALCULATE GRADEPOINTS ACHIEVED BY ADDING GRADEPOINT OF EACH SESSION */
                                    $achieved += $gradepoint;
                                    
                                    /* TOTAL GRADEPOINTS FOR THE COURSE */
                                    $total += 2;    
                                    
                                    //echo "<br>  _____ $courseid _____ $name _______ $achieved/$total _________   _______ $gradepoint<br>";
                                    
                                }
                            }  
                            
                            if($total !=0)
                            {
                                $percent = $achieved/$total * 100;    
                            }
                            else
                            {
                                $percent = 0;    
                            } 
                            
                            $new = '';
                            $flag = 0;     
                            
                            for($i = 0; $i<strlen($name); $i++)
                            {
                                if($name[$i] != ' ')
                                {
                                    $flag = 1;
                                }
                                
                                if($flag == 1)
                                {
                                    $new = $new.$name[$i];
                                }
                            }
                            $name = $new;
                            
                            //$coursecode = getCourseCode($name);
                            //$coursename = getCourseName($name);
                                                        
                            //$row['coursecode'] = $coursecode;
                            //$row['coursetitle'] = $coursename;
                            $row['percentage'] = $percent."";
                            $rows['result'][] = $row;
                            
                            echo "<br>  _____ $courseid _____ $name _______ $achieved/$total _________  $percent<br>";
                        }
                    }
                }
            }
        }
        //echo json_encode($rows); 
    }
?>