<?php
session_start();
require_once "db/connection.php";
if(isset($_GET['type']) && $_GET['type']=='department')
{
?>
<option value="">All Faculty Department</option>
<option value="1">Biotechnology
<option value="2">Chemical Engineering
<option value="3">Civil Engineering
<option value="4" >Computer Science Engineering
<option value="5" >Electrical Engineering
<option value="6">Electronics & Communication Engineering
<option value="7">Information Technology
<option value="8">Mechanical Engineering
<option value="9">Mining and Metallurgical Engineering
<option value="10">Mathematics
<option value="11">Physics
<option value="12">Chemistry
<option value="13">Humanities
<option value="14">Management Studies
<?php
}
elseif(isset($_GET['type']) && $_GET['type']=='0')
{
?>
<option value="">Department Not Applicable&nbsp;</option>
<?php
}
elseif(isset($_GET['type']) && $_GET['type']=='fposition')
{
?>
<option value="">All Faculty Positions</option>
<option value="1">Assistant Professor
<option value="2">Associate Professor
<option value="3">Professor
<?php
}
elseif(isset($_GET['type']) && $_GET['type']=='nfposition')
{
?>
<option value="">All Positions</option>
<option value="1">Deputy Registrar (Accounts)
<option value="2">Assistant Registrar
<option value="3">Students Activity & Sports (SAS) Office
<option value="4">Executive Engineer
<option value="5">Engineer
<option value="6">Medical Officer
<option value="7">Security Officer
<option value="8">Junior Assistant
<option value="9">Senior Secretary
<option value="10">Secretary
<?php
}
function getDepartmentName($data) {
	
	switch ($data) {
		case 1:
			return "Biotechnology";
			break;
		case 2:
			return "Chemical Engineering";
			break;
		case 3:
			return "Civil Engineering";
			break;
		case 4:
			return "Computer Science & Engineering";
			break;
		case 5:
			return "Electrical Engineering";
			break;
		case 6:
			return "Electronics & Communication Engineering";
			break;
		case 7:
			return "Information Technology";
			break;
		case 8:
			return "Mechanical Engineering";
			break;
		case 9:
			return "Mining and Metallurgical Engineering";
			break;
		case 10:
			return "Mathematics";
			break;
		case 11:
			return "Physics";
			break;
		case 12:
			return "Chemistry";
			break;
		case 13:
			return "Humanities";
			break;
		case 14:
			return "Management Studies";
			break;
			
		default:
			return "";
			break;
		
	}


}

function getFPositionName($data) {

	switch ($data) {
		case 1:
			return "Assistant Professor";
			break;
		case 2:
			return "Associate Professor";
			break;
		case 3:
			return "Professor";
			break;
		default:
			return "";
			break;
		
	}

}

function getNFPositionName($data) {

	switch ($data) {
		case 1:
			return "Deputy Registrar (Accounts) ";
			break;
		case 2:
			return "Assistant Registrar";
			break;
		case 3:
			return "Students Activity & Sports (SAS) Officer";
			break;
		case 4:
			return "Executive Engineer";
			break;
		case 5:
			return "Engineer";
			break;
		case 6:
			return "Medical Officer";
			break;
		case 7:
			return "Security Officer";
			break;
		case 8:
			return "Junior Assistant";
			break;
		case 9:
			return "Senior Secretary";
			break;
		case 10:
			return "Secretary";
			break;
		default:
			return "";
			break;
		
	}

}

function text($data) {
	$data = mysql_real_escape_string($data);
	return $data;
}

function queryFaculty($d,$p,$s) {

	$d = getDepartmentName($d);
	//$d = text($d);
	$p = getFPositionName($p);
	//$p = text($p);
	attempt_connection('nitd_recruitment');
	
	if($d=="" && $p==""){
		$query = "SELECT * FROM `user_info` JOIN user_other_details ON user_info.id=user_other_details.id WHERE user_other_details.submitted='".$s."'";
		$result = mysqli_query($conn4, $query) or die(mysql_error($conn4));
	}
	elseif($d=="" && $p!="") {
		$query = "SELECT * FROM `user_info` JOIN user_other_details ON user_info.id=user_other_details.id WHERE user_info.faculty_pos='".$p."' AND user_other_details.submitted='".$s."' ORDER BY user_info.id";
		$result = mysqli_query($conn4, $query) or die(mysql_error($conn4));
	}
	elseif($d!="" && $p=="") {
		$query = "SELECT * FROM `user_info` JOIN user_other_details ON user_info.id=user_other_details.id WHERE user_info.department='".$d."' AND user_other_details.submitted='".$s."' ORDER BY user_info.id";
		$result = mysqli_query($conn4, $query) or die(mysql_error($conn4));
		
	}
	elseif($d!="" && $p!="") {
		$query = "SELECT * FROM `user_info` JOIN user_other_details ON user_info.id=user_other_details.id WHERE user_info.department='".$d."' AND user_info.faculty_pos='".$p."' AND user_other_details.submitted='".$s."' ORDER BY user_info.id";
		$result = mysqli_query($conn4, $query) or die(mysql_error($conn4));	
	}
	
	?>
	<b>Total No. of Applications : <u><?php echo mysql_num_rows($result); ?></u></b><br/>
	<table border=1>
	<tr>
	<th>ID</th><th>Reg ID</th><th>Applicant Name</th><th>Department</th><th>Position</th><th>View Form</th><th>Certificates (Only Uploaded files)</th>
	</tr>
	<?php
	while($val = mysqli_fetch_array($result, )) {
			?>
			<tr>
			<td><?php echo $val['id']; ?></td><td><?php echo $val['reg_id']; ?></td><td><?php echo $val['name_applicant']; ?></td><td><?php echo $val['department']; ?></td><td><?php echo $val['faculty_pos']; ?></td><td><a href="view_faculty.php?id=<?php echo $val['id']; ?>">Click Here</a></td><td><a href="cert_faculty.php?rid=<?php echo $val['reg_id']; ?>">CLICK HERE</a></td>
			</tr>
			<?php
	}

}

function queryNFaculty($p,$s) {

	$p = getNFPositionName($p);
//	$p = text($p);
	attempt_connection('nitd_recruitment_nf');

	if($p=="") {
		$query = "SELECT * FROM `user_info` JOIN user_other_details ON user_info.id=user_other_details.id WHERE user_other_details.submitted='".$s."'";
		$result = mysqli_query($conn4, $query) or die(mysqli_error($conn4)); 
	}
	elseif($p!=""){
		$query = "SELECT * FROM `user_info` JOIN user_other_details ON user_info.id=user_other_details.id WHERE position='".$p."' AND user_other_details.submitted='".$s."'";
		$result = mysqli_query($conn4, $query) or die(mysql_error($conn4)); 
	}
	?>
	<b>Total No. of Applications : <u><?php echo mysqli_num_rows($result); ?></u></b><br/>
	<table border=1>
	<tr>
	<th>ID</th><th>Reg ID</th><th>Applicant Name</th><th>Position</th><th>View Form</th><th>Certificates (Only Uploaded files)</th>
	</tr>
	<?php
	while($val = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			?>
			<tr>
			<td><?php echo $val['id']; ?></td><td><?php echo $val['reg_id']; ?></td><td><?php echo $val['name_applicant']; ?></td><td><?php echo $val['position']; ?></td><td><a href="view_nonfaculty.php?id=<?php echo $val['id']; ?>">Click Here</a></td><td><a href="cert_nonfaculty.php?rid=<?php echo $val['reg_id']; ?>">CLICK HERE</a></td>
			</tr>
			<?php
	}
}






if(isset($_GET['type'])&&$_GET['type']=='faculty'){

	if($_GET['status']=='locked')
		$s = 2;
	elseif($_GET['status']=='unlocked')
		$s = 1; 
	elseif($_GET['status']=='')
		$s = 0; 
	queryFaculty($_GET['department'],$_GET['position'],$s);

}
elseif(isset($_GET['type'])&&$_GET['type']=='non-faculty') {
	
	if($_GET['status']=='locked')
		$s = 2;
	elseif($_GET['status']=='unlocked')
		$s = 1; 
	elseif($_GET['status']=='')
		$s = 0; 
	queryNFaculty($_GET['position'],$s);

}



?>
