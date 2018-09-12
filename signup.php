<?php
require_once('config.php');
?>
<?php if (!isset($_POST['register'])){ $_POST['fname']= NULL; $_POST['fathername']= NULL; $_POST['boed']=NULL; $_POST['occupation']= NULL; $_POST['email']=NULL;$_POST['gender']=NULL; $_POST['password']=NULL;} ?>
<?php
	if (isset($_POST['register'])){
	$firstname=mysql_real_escape_string($_POST['fname']);
	$fathername=mysql_real_escape_string($_POST['fathername']);
	$email=mysql_real_escape_string($_POST['email']);
	$gender=mysql_real_escape_string($_POST['gender']);
	$boed=mysql_real_escape_string($_POST['boed']);
	$occupation=mysql_real_escape_string($_POST['occupation']);
	$password = md5(mysql_real_escape_string($_POST['password']));
	
	$f = mysqli_query($con,"SELECT student_email_id,teacher_email_id from student,teacher where student_email_id='$email' or teacher_email_id='$email' ")or die(mysqli_error($con));
													$count = mysqli_num_rows($f);
													if($count <= 0)
													{
													if($firstname=="" || $fathername=="" || $email=="" || $gender=="" || $boed=="" || $password=="" || $occupation == "") 
													{?><script>
alert('Some Error Occured While Signing UP!');
window.location = "signup.php";
</script> <?php exit(); }
													else {
														if($occupation == "Student") {
	$checking=mysqli_query($con,"INSERT INTO `candidate` (`Ref_id`, `cand_id`, `cand_password`, `cand_full_name`, `cand_father_name`, `cand_nic`, `cand_dob`, `cand_gender`, `cand_contactno`, `cand_email`, `cand_permenant_address`, `cand_current_address`, `cand_nic_attachment`, `cand_profile_pic`,`cand_pob`,`cand_organization`,`isactive`) VALUES ('0', '', '$password', '$firstname', '$fathername', '$NIC', '$bdate', '$gender', '$contact', '$email', '$paddress', '$caddress','$nicimg','$image','$pob','$organization','0')")or die(mysqli_error($con));
	if($checking)
	{
 if($organization=="Pakistan International Airlines") {$org="PIA"; } else {$org="PVT"; }
 if($_POST['refid']=='')
{
$select = "SELECT max(cand_id) as cand_id FROM candidate";
$qry=mysqli_query($con,$select);
		while($rec = mysqli_fetch_array($qry)) {
		$cand_id = "$rec[cand_id]";}
		$cand_idd = "000" .$cand_id;
		$cand_idd = substr($cand_idd, -4);
		$year = date("Y");
		$ref_id= $year. $org. $cand_idd;
		mysqli_query($con,"UPDATE `candidate` SET `Ref_id` = '$ref_id',isapprove=0 WHERE `candidate`.`cand_id` = '$cand_id' ")or die(mysqli_error($con));
	    mysqli_commit($con);
		 mysqli_close($con);
		?>
<script>
alert('Your Account will be activated after admin approval.You will get confirmation email soon');
window.location = "index.php";
</script>
<?php }
else  {$qry=mysqli_query($con,"UPDATE `candidate` SET `Ref_id` = '$refid',isapprove=0 WHERE `candidate`.`cand_id` = '$cand_id' ")or die(mysqli_error($con));
mysqli_commit($con);
 mysqli_close($con);
		?>
<script>
alert('Your Account will be activated after admin approval.You will get confirmation email soon');
window.location = "index.php";
</script>
<?php
   }}
   else {
   mysqli_rollback($con);
   mysqli_close($con);
   ?>
<script>
alert('Your Account will be activated after admin approval.You will get confirmation email soon');
window.location = "index.php";
</script>
<?php }}}
else {
   $f = mysqli_query($con,"SELECT cand_id from candidate where  cand_nic='$NIC'  ")or die(mysqli_error($con));
													$count = mysqli_num_rows($f);
													$f = mysqli_query($con,"SELECT cand_email from candidate where  cand_email='$email'  ")or die(mysqli_error($con));
													$count1 = mysqli_num_rows($f);
													$f = mysqli_query($con,"SELECT cand_contactno from candidate where  cand_contactno='$contact'  ")or die(mysqli_error($con));
													$count2 = mysqli_num_rows($f);
													$f = mysqli_query($con,"SELECT cand_contactno from candidate where Ref_id='$refid'")or die(mysqli_error($con));
													$count3 = mysqli_num_rows($f);
 if( $count>0 AND $count1<=0 AND $count2<=0 and $count3<=0) {
 ?> <script> alert('NIC already exist!'); </script> <?php $_POST['nic']=NULL;
  echo '<div class="errormsgbox">NIC already exist!</div>';}
 else if($count<=0 AND $count1>0 AND $count2<=0 and $count3<=0) {
 ?> <script> alert('email already exist!'); </script> <?php  $_POST['email']=NULL;
  echo '<div class="errormsgbox">Email already exist!</div>';}
 else if ($count<=0 AND $count1<=0 AND $count2>0 and $count3<=0)
 {?> <script> alert('contact no already exist!'); </script> <?php $_POST['contact']=NULL;
 echo '<div class="errormsgbox">Contact no already exist!</div>';
 }
  else if ($count<=0 AND $count1<=0 AND $count2<=0 and $count3>0)
 {?> <script> alert('Refrence id already exist!'); </script> <?php  $_POST['refid']=NULL;
echo '<div class="errormsgbox">Refrence id already exist!</div>';
 }
 else if( $count>0 AND $count1>0 AND $count2<=0 and $count3<=0) {
 ?> <script> alert('NIC and email already exist!'); </script> <?php  $_POST['email']=NULL; $_POST['nic']=NULL;
 echo '<div class="errormsgbox"NIC and email already exist!</div>';}
 else if( $count>0 AND $count1<=0 AND $count2>0 and $count3<=0) {
 ?> <script> alert('NIC and contact number already exist!'); </script> <?php  $_POST['contact']=NULL; $_POST['nic']=NULL;
 echo '<div class="errormsgbox">NIC and contact number already exist!</div>';}
 else if( $count<=0 AND $count1>0 AND $count2>0 and $count3<=0) {
 ?> <script> alert('Email and contact number already exist!'); </script> <?php  $_POST['email']=NULL; $_POST['contact']=NULL;
 echo '<div class="errormsgbox">Email and contact number already exist!</div>';}
 else if( $count<=0 AND $count1<=0 AND $count2>0 and $count3>0) {
 ?> <script> alert('Refrence_id and contact number already exist!'); </script> <?php  $_POST['refid']=NULL; $_POST['contact']=NULL;
 echo '<div class="errormsgbox">Refrence_id and contact number already exist!</div>';}
 else if( $count<=0 AND $count1>0 AND $count2<=0 and $count3>0) {
 ?> <script> alert('Refrence_id and Email already exist!'); </script> <?php  $_POST['email']=NULL; $_POST['refid']=NULL;
 echo '<div class="errormsgbox">Refrence_id and Email already exist!</div>';}
 else if( $count>0 AND $count1<=0 AND $count2<=0 and $count3>0) {
 ?> <script> alert('Refrence_id and NIC already exist!'); </script> <?php $_POST['refid']=NULL; $_POST['nic']=NULL;
 echo '<div class="errormsgbox">Refrence_id and NIC already exist!</div>'; }
 else if( $count>0 AND $count1>0 AND $count2>0 and $count3<=0) {
 ?> <script> alert('NIC,Email and Contact already exist!'); </script> <?php  $_POST['contact']=NULL; $_POST['email']=NULL; $_POST['nic']=NULL;
 echo '<div class="errormsgbox">NIC,Email and Contact already exist!</div>';}
 else if( $count>0 AND $count1>0 AND $count2<=0 and $count3>0) {
 ?> <script> alert('NIC,Email and Refrence_id already exist!'); </script> <?php  $_POST['refid']=NULL; $_POST['email']=NULL; $_POST['nic']=NULL; 
 echo '<div class="errormsgbox">NIC,Email and Refrence_id already exist!</div>';
 }
  else if( $count>0 AND $count1<=0 AND $count2>0 and $count3>0) {
 ?> <script> alert('NIC,contactno and Refrence_id already exist!'); </script> <?php  $_POST['contact']=NULL; $_POST['nic']=NULL; $_POST['refid']=NULL;
 echo '<div class="errormsgbox">NIC,contactno and Refrence_id already exist!</div>';}
  else if( $count<=0 AND $count1>0 AND $count2>0 and $count3>0) {
 ?> <script> alert('Email,contact number and Refrence_id already exist!'); </script> <?php  $_POST['refid']=NULL; $_POST['contact']=NULL; $_POST['email']=NULL; 
 echo '<div class="errormsgbox">Email,contact number and Refrence_id already exist!</div>';}
 else {
 ?> <script> alert('NIC, Email , contact numberand reference id already exist!'); </script> <?php  $_POST['contact']=NULL; $_POST['email']=NULL; $_POST['refid']=NULL; $_POST['nic']=NULL;
 echo '<div class="errormsgbox">NIC, Email , contact numberand reference id already exist!<br>You may go to <a href="needhelp.php">Send ActivationLink again</a></div>';
 }
}
}

		?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="description" content="" />
<meta name="author" content="" />
<!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
<title>Tutor Matter | Sign Up</title>
<link rel="shortcut icon" href="images/Logo/TMLogo.png">
<!--  Bootstrap Style -->
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<!--  Font-Awesome Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet" />
<!--  Animation Style -->
<link href="assets/css/animate.css" rel="stylesheet" />
<!--  Pretty Photo Style -->
<link href="assets/css/prettyPhoto.css" rel="stylesheet" />
<!--  Google Font Style -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<!--  Custom Style -->
<link href="assets/css/style.css" rel="stylesheet" />
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body style="background:url(images/backgroundimg/hd.jpg) no-repeat center center fixed;
		-webkit-background-size: cover !important;
		-moz-background-size: cover !important;
		-o-background-size: cover !important;
		background-size: cover !important;
	">
<!--/. PRELOADER END -->
<!--./ NAV BAR END -->
<div id="home" >
<div class="overlay">
<div class="container">
<div class="span3">
<div class="title_index">
  <div class="row-fluid"> </div>
</div>
<div class="col-lg-5 col-md-5">
<div class="div-trans text-center">
<h3>Register Here</h3>
<br>
<br>
<div class="col-lg-16 col-md-16 col-sm-16" />
<form action="signup.php" class="form-signin" method="post" role="form">
           
<div>	
	   <div class="form-group">
              <label class="col-md-6 control-label">Name:</label>
              <div class="col-md-6">
                <input type="text" name="fname" id = "fname" class="form-control input-md" pattern="[A-Za-z. ]{3,30}" <?php
if ( $_POST['fname'] ) {
print ' value="' . $_POST['fname'] . '"';
} ?> required/>
              </div>
            </div>		

			<br>
			<br>
			<br>
			
		
            <div class="form-group">
              <label class="col-md-6 control-label">Father Name:</label>
              <div class="col-md-6">
                <input type="text" name="fathername" id = "fathername" class="form-control input-md" pattern="[A-Za-z. ]{3,30}" <?php
if ( $_POST['fathername'] ) {
print ' value="' . $_POST['fathername'] . '"';
} ?> required/>
              </div>
            </div>
			
			
			<br>
			<br>
			
            <div class="form-group">
              <label class="col-md-6 control-label">Board of Education:</label>
              <div class="col-md-6">
                <select id="dept_id" name="boed" class="form-control" required <?php
if ( $_POST['boed_name'] ) {
print ' value="' . $_POST['boed_name'] . '"';
} ?>/>
                
                
                <?php 
						$query=mysqli_query($con,"SELECT * FROM `BOED` ORDER by boed_name");
						while($row=mysqli_fetch_array($query))
						 { 
						 $sel= "selected";
						 	?>
                <option value="<?php echo $row['boed_name'];?>" <?=$sel?> > <?php echo $row['boed_name'];?> </option>
                <?php 
						} ?>
                      
                </select>
              </div>
            </div>
			
			
			<br>
			<br>
			
			
            <div class="form-group">
              <label class="col-md-6 control-label">Gender:</label>
              <div class="col-md-6">
                 <div class="input-group">
                 <input type="radio" id="radio1" name="gender" value="Male" 
				  <?php if(isset($_POST['gender']) == 'Male')  echo ' checked="checked"';?>  checked />
<label for="radio1">Male</label>
    <input type="radio" id="radio2" name="gender"value="Female" <?php if(isset($_POST['gender']) == 'Female')  echo ' checked="checked"';?> />
      <label for="radio2">Female</label>
	  </div>
              </div>
            </div>
			
			
			<br>
			<br>
			
            <div class="form-group">
              <label class="col-md-6 control-label">Email:</label>
              <div class="col-md-6">
                <input type="text" name="email" id = "email" class="form-control input-md" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" title="Incorrect Email"  <?php
if ( $_POST['email'] ) {
print ' value="' . $_POST['email'] . '"';
} ?>required/>
              </div>
            </div>
           
           
			<br>
			<br>
         
            <div class="form-group">
              <label class="col-md-6 control-label">Occupation:</label>
              <div class="col-md-6">
                 <div class="input-group">
                 <input type="radio" id="radio3" name="occupation" value="Student" 
				  <?php if(isset($_POST['occupation']) == 'Student')  echo ' checked="checked"';?>  checked />
<label for="radio3">Student</label>
    <input type="radio" id="radio4" name="occupation"value="Teacher" <?php if(isset($_POST['occupation']) == 'Teacher')  echo ' checked="checked"';?> />
      <label for="radio4">Teacher</label>
	  </div>
              </div>
            </div>
			
			
			<br>
			<br>
			
			
            <div class="form-group">
              <label class="col-md-6 control-label" for="rental">Password:</label>
              <div class="col-md-6">
                <input type="password" placeholder="Password" id="password" class="form-control input-md" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" name="password" 
                title="Password should contain an upper case letter, a lower case letter, a number and a special character. Length should be atleast 8 characters" name="password" 
required>
              </div>
            </div>
			
			
			<br>
			<br>
			
			
            <div class="form-group">
              <label class="col-md-6 control-label" for="rental">Confirm Password:</label>
              <div class="col-md-6">
                <input type="password" placeholder="Confirm Password" id="confirm_password" class="form-control input-md" required>
              </div>
            </div>
			
			<br>
			<br>
			
			
			</div>
			</div>
			
<a href="needhelp.php">Need Help?</a> <br>
<div class="form-group">
 <button type="submit" id="submit" name="register" class="btn btn-primary btn-block">Signup</button>
  <a button id="login" name="login" class="btn btn-primary btn-block" href="login.php" >Login
  </button>
  </a>
  </p>
</div>
</div>


<!-- Date Time -->
<div class="row-fluid">
  <div class="col-md-5 col-md-offset-1">
    <h4>
    <span id=tick2> </span>&nbsp;|
    <script>
				function show2(){
				if (!document.all&&!document.getElementById)
				return
				thelement=document.getElementById? document.getElementById("tick2"): document.all.tick2
				var Digital=new Date()
				var hours=Digital.getHours()
				var minutes=Digital.getMinutes()
				var seconds=Digital.getSeconds()
				var dn="PM"
				if (hours<12)
				dn="AM"
				if (hours>12)
				hours=hours-12
				if (hours==0)
				hours=12
				if (minutes<=9)
				minutes="0"+minutes
				if (seconds<=9)
				seconds="0"+seconds
				var ctime=hours+":"+minutes+":"+seconds+" "+dn
				thelement.innerHTML=ctime
				setTimeout("show2()",1000)
				}
				window.onload=show2
				//-->
</script>
    <?php
            $date = new DateTime();
            echo $date->format('l, F jS, Y');

          ?>
    <h4>
  </div>

<!--./ Date Time END -->

<!-- /#wrapper -->
<!-- jQuery Version 1.11.0 -->
<script>
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");
   
function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Password Doesn't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
<script src="js/jquery-1.11.0.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>
</body>

<head>
<title>jQuery Date Entry</title>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.plugin.js"></script>
<script type="text/javascript" src="js/jquery.dateentry.js"></script>
<script type="text/javascript">
$(function () {
	$('#defaultEntry').dateEntry();
});
</script>
</head>
</html>