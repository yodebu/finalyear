<?php
@ob_start();
session_start();
include "h.conn.php";
?>
<?php

/** Validate captcha */
if (!empty($_REQUEST['captcha'])) {
    if(empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
        $_SESSION['s_email'] = $_POST['email'];
		$_SESSION['s_mobile'] = $_POST['mobile'];
		$_SESSION['captcha_check']="wrong";
		header("location:rlogin.php");
    }
	else //submit form from here
	{
		unset($_SESSION['captcha_check']);
		$email = addslashes($_POST['email']);
		$password = md5(SHA1($_POST['password']));
		$mobile = $_POST['mobile'];
		
		$qc = "SELECT reg_id FROM user_info WHERE email='".$email."' OR mobile='".$mobile."'";
		$rc = mysqli_query($conn, $qc) or die(mysqli_error($conn));
		if(mysql_num_rows($rc)==1)
		{
			header("location:rlogin.php?s");
		}
		else
		{
			$id=0;
			$q1 = "SELECT id FROM user_info";
			$r1 = mysqli_query($conn, $q1) or die(mysqli_error($conn));
			while($d1 = mysqli_fetch_array($r1))
			{
				$id = $d1['id'];
			}
			$id++;
			$reg_id = 14000 + $id;
			$q = "INSERT INTO user_info(id,reg_id,email,password,mobile) VALUES('".$id."','".$reg_id."','".$email."','".$password."','".$mobile."')";
			$r = mysqli_query($conn, $q) or die(mysql_error($conn));
			$q1 = "INSERT INTO user_exams(id,reg_id) VALUES('".$id."','".$reg_id."')";
			$r1 = mysqli_query($conn, $q1) or die(mysql_error($conn));
			$q2 = "INSERT INTO user_other_details(id,reg_id) VALUES('".$id."','".$reg_id."')";
			$r2 = mysqli_query($conn, $q2) or die(mysql_error($conn));
			$q3 = "INSERT INTO user_earlier_posts(id,reg_id) VALUES('".$id."','".$reg_id."')";
			$r3 = mysqli_query($conn, $q3) or die(mysql_error($conn));
			$q4 = "INSERT INTO user_phd_details(id,reg_id) VALUES('".$id."','".$reg_id."')";
			$r4 = mysqli_query($conn, $q4) or die(mysql_error($conn));
			$verify_id = md5($email);

			include "phpmailer/class.phpmailer.php";
			include "phpmailer/class.smtp.php";

			$nitd_rec = new phpmailer();

			$nitd_rec->IsSMTP();
			$nitd_rec->SMTPAuth = "true";
			$nitd_rec->SMTPDebug = 2;
			$nitd_rec->IsHTML(true);
			$nitd_rec->SMTPAuth = true;

			$nitd_rec->Username = "recruitment@nitdgp.ac.in"; //to change email id from sending
			$nitd_rec->Password = "nitd_rec@123"; //its password
			$nitd_rec->SMTPSecure = 'tls';
			$nitd_rec->From     = "recruitment@nitdgp.ac.in";
			$nitd_rec->FromName = "NIT Durgapur";
			$nitd_rec->Subject = "Verification for Recruitment of Faculty";
			$nitd_rec->Host     = "172.16.30.72"; // HOST SMTP OUT ADDRESS
			$nitd_rec->Port = 587;
			$body = "<html><head><link href='http://www.nits.ac.in/css/style.css' rel='stylesheet' type='text/css'/><link href='http://www.nits.ac.in/nits_rec/css/recruitment_form.css' rel='stylesheet' type='text/css'/><link href='http://old.nits.ac.in/nits_rec/css/final_form.css' rel='stylesheet' type='text/css'/><link href='http://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'><link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'></head><body><div id='wrapper' style='width:600px;'><div id='top' ><div id='logo' ><h1><a href='http://recruitment.nits.ac.in/index.php'>National Institute of Technology Silchar</a></h1></div></div>";
			$body .= "We have received your request for the faculty position at National Institute of Technology, Durgapur.<br /><br/><br/><b>To verify your account <a href='http://recruitment.nits.ac.in/verify.php?vid=".$verify_id."&rid=".$reg_id."'>CLICK HERE</a></b></div></body>";
			$nitd_rec->Mailer   = "smtp";
			$nitd_rec->Priority = '1';
			$nitd_rec->Body = $body;
			$nitd_rec->AltBody = "We have received your request for the non-faculty position at National Institute of Technology, Durgapur. To verify your account http://recruitment.nits.ac.in/verify.php?vid=".$verify_id."&rid=".$reg_id." Click on the link.";
			$nitd_rec->AddAddress($email);
	
			if(!$nitd_rec->Send())
			{
				echo "There has been a mail error sending to " . $_POST['email'] . "<br/>Error info : ". $nitd_rec->ErrorInfo;
			}
			header("location:index.php?f=s");
		}
	}
    $request_captcha = htmlspecialchars($_REQUEST['captcha']);
    unset($_SESSION['captcha']);
}
?>
