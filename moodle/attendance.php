<?php
     {
        include("connect.php");
         
        function getCourseCode($name)
        {
            $coursecode = "";
            $ctr = 0;
            $new = "";
            
            if(!($name[0] >= '0' && $name[0] <= '9'))
            {
                return '#';
            }
            
            for($i = 0; $i<strlen($name); $i++)
            {
                if($name[$i] != ' ')
                {
                    $coursecode = $coursecode . $name[$i];
                    $ctr++;
                }
                
                if($ctr == 6)
                {
                    break;
                }
            }
            
            return $coursecode;
        }
         
        function getCourseName($name)
        {
            $ctr=0;
            for($i=0; $i<strlen($name); $i++)
            {
                if($name[$i] != ' ')
                {
                    $ctr++;
                }
                
                if($ctr == 6)
                {
                    break;
                }
            }
            
            if(!($name[0] >= '0' && $name[0] <= '9'))
            {
                $i = 0;
            }
            else
            {
                $i += 2;
            }
            
            $newname = '';
            $ctr = 0;
            
            for($j = $i; $j< strlen($name); $j++)
            {
                //$newname = $newname.$name[$j];
                
                if($name[$j] == '-' || $name[$j] == '/')
                {
                    $ctr = $j;
                }
            }
            
            if($ctr == 0)
            {
                $ctr = strlen($name);
            }
            
            for($j = $i; $j< $ctr; $j++)
            {
                $newname = $newname.$name[$j];
            }
            
            return $newname;
        }
         
        

        $prn = $_GET['prn'];         
        $userid = -1;
        //$prn= '2013BIT063';
         
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
                        /* GET THE COURSENAME OF COURSE FROM COURSSEID */
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
                            
                            if($percent != 0)
                            {
                                $coursecode = getCourseCode($name);
                                $coursename = getCourseName($name);

                                $row['coursecode'] = $coursecode;
                                $row['coursetitle'] = $coursename;
                                $row['percentage'] = $percent."";
                                $rows['result'][] = $row;
                            }
                            //echo "<br> $coursecode _____ $coursename _____ $name _______ $achieved/$total _________  $percent<br>";
                        }
                    }
                }
            }
        }
        echo json_encode($rows); 
    }
?>