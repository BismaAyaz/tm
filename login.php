<?php
//Configuring the Database File
require_once('config.php');
?>
<?php

//Setting the variables to find if teacher or student is active or not
$r =1; 
$s=1;

//Start session
session_start();

	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
		//Sanitize the POST values
    $email = clean($_POST['email']);
    $password = clean(md5($_POST['password']));
//Create query for Student
$qry="SELECT * from `student` WHERE (student_email_id = '$email') and student_password = '$password' and student_isactive =1";
	$result=mysqli_query($con,$qry);
//Create query for Teacher
	$qry1="SELECT * from `teacher` WHERE (teacher_email_id = '$email') and teacher_password = '$password' and teacher_isactive =1";
	$row=mysqli_query($con,$qry1);
//Checking if user is Student
if($result) { 
			if(mysqli_num_rows($result) > 0 ) {
			//Login Successful for Student
			session_regenerate_id();
			$member = mysqli_fetch_assoc($result);
			$_SESSION['student_id'] = $member['student_id'];
			$id = $member['student_id'];
			$_SESSION['student_name']=$member['student_name'];
			$_SESSION['student_email_id'] = $member['student_email_id'];
			$email_id= $member['student_email_id'];
			$_SESSION['student_father_name'] = $member['student_father_name'];
			$_SESSION['student_image'] = $member['student_image'];
			$select = "SELECT HOST FROM information_schema.processlist where id = connection_id()";
$qry=mysqli_query($con,$select);
		while($rec = mysqli_fetch_array($qry)){
		$host = "$rec[HOST]";}
			mysqli_query($con,"INSERT INTO `Login` (`login_id`,`login_email_id`, `login_time`, `logout_time`, `ip_address`) VALUES ('','$email_id', NOW(), '', '$host')")or die(mysqli_error($con));
		mysqli_commit($con);
		mysqli_close($con);
			session_write_close();
			header("location: student.php?");
			exit();
			}
			else {$r =0;}
		}
		
//checking if user is teacher		
		if($row)
			{ 
			if(mysqli_num_rows($row) > 0 ) {
			session_regenerate_id();
			$member = mysqli_fetch_assoc($row);
			$_SESSION['teacher_id'] = $member['teacher_id'];
			$id = $member['teacher_id'];
			$_SESSION['teacher_name']=$member['teacher_name'];
			$_SESSION['teacher_email_id'] = $member['teacher_email_id'];
			$email_id= $member['teacher_email_id'];
			$_SESSION['teacher_father_name'] = $member['teacher_father_name'];
			$_SESSION['teacher_image'] = $member['teacher_image'];
	$select = "SELECT HOST FROM information_schema.processlist where id = connection_id()";
$qry=mysqli_query($con,$select);
		while($rec = mysqli_fetch_array($qry)){
		$host = "$rec[HOST]";}
			mysqli_query($con,"INSERT INTO `Login` (`login_id`,`login_email_id`, `login_time`, `logout_time`, `ip_address`) VALUES ('','$email_id', NOW(), '', '$host')")or die(mysqli_error($con));
		mysqli_commit($con);
		mysqli_close($con);
			session_write_close();
			header("location: teacher.php?");
			exit();
			}
			else { $s=0;  }
			}
			
//If user is not active teacher or active student
		if($s==0 && $r==0) {
		$user_query_student = mysqli_query($con,"select student_isactive from student where (student_email_id = '$email')")or die(mysqli_error($con));
		$user_query_teacher = mysqli_query($con,"select teacher_isactive from teacher where (teacher_email_id = '$email')")or die(mysqli_error($con));
		
												while($row = mysqli_fetch_array($user_query_student)){
													$student_isactive = $row['student_isactive'];
													}
													while($rec = mysqli_fetch_array($user_query_teacher)){
													$teacher_isactive = $rec['teacher_isactive'];
													}
													
													if(mysqli_num_rows($user_query_student)>0){
											if($student_isactive == 0) {
											header("location: login_errors.php"); exit();
													}
													else if(mysqli_num_rows($user_query_teacher)>0){
											if($teacher_isactive == 0) {
											header("location: login_errors.php"); exit();
													}
													}
													else {header("location: login_error.php"); exit();}}
													header("location: login_error.php"); exit();
		}	
		
										
									
						
?>