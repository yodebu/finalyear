<?php
include "h.conn.php";
session_start();
$submitted=2;
$q = "UPDATE user_other_details SET submitted='2' WHERE reg_id='".$_SESSION['reg_id']."' ";
$r = mysqli_query($conn, $q) or die(mysqli_error());
$reg_id = $_SESSION['reg_id'];
			include "phpmailer/class.phpmailer.php";
			include "phpmailer/class.smtp.php";
			$qq = "SELECT email,department,faculty_pos FROM user_info WHERE reg_id='".$reg_id."'";
			$rr = mysqli_query($conn, $qq) or die(mysqli_error());
			$dd = mysqli_fetch_array($rr);
			$email = $dd['email'];
			$department = $dd['department'];
			$faculty_pos = $dd['faculty_pos'];
			$nitd_rec1 = new phpmailer();

			$nitd_rec1->IsSMTP();
			$nitd_rec1->SMTPAuth = "true";
			$nitd_rec1->SMTPDebug = 2;
			$nitd_rec1->IsHTML(true);
			$nitd_rec1->SMTPAuth = true;

			$nitd_rec1->Username = "recruitment@nitdgp.ac.in"; //to change email id from sending
			$nitd_rec1->Password = "nit_rec@123"; //its password
			$nitd_rec1->SMTPSecure = 'tls';
			$nitd_rec1->From     = "recruitment@nitdgp.ac.in";
			$nitd_rec1->FromName = "NIT Durgapur";
			$nitd_rec1->Subject = "Form submitted successfully.";
			$nitd_rec1->Host     = "172.16.30.72"; // HOST SMTP OUT ADDRESS
			$nitd_rec1->Port = 587;
			$body = "<html><head><link href='http://www.nits.ac.in/css/style.css' rel='stylesheet' type='text/css'/><link href='css/recruitment_form.css' rel='stylesheet' type='text/css'/><link href='http://old.nits.ac.in/nits_rec/css/final_form.css' rel='stylesheet' type='text/css'/><link href='http://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'><link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'></head><body><div id='wrapper' style='width:600px;'><div id='top' ><div id='logo' ><h1><a href='http://recruitment.nits.ac.in/index.php'>National Institute of Technology, Durgapur</a></h1></div></div>";
			$body .= "THANK YOU for submitting your request for the faculty position : ". $faculty_pos . ", Department : ".$department. " at National Institute of Technology, DurgAPUR.<br /><br/><br/><b>Login & See your submitted form and print it out, <a href='http://recruitment.nits.ac.in/rlogin_a.php'>CLICK HERE</a></b></div></body>";
			$nitd_rec1->Mailer   = "smtp";
			$nitd_rec1->Priority = '1';
			$nitd_rec1->MsgHTML($body);
			$nitd_rec1->AltBody = "THANK YOU for submitting your request for the faculty position : ". $faculty_pos . ", Department : ".$department. " at National Institute of Technology, Durgapur.Login & See your submitted form and print it out, http://recruitment.nits.ac.in/rlogin_a.php";
			$nitd_rec1->AddAddress($email);
			$nitd_rec1->Encoding="base64";
			if(!$nits_rec1->Send())
			{
				echo "There has been a mail error sending to " . $email . "<br/>Error info : ". $nitd_rec->ErrorInfo;
			}
header("location:show_form.php");
?>
