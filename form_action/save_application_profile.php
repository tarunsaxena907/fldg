<?php
session_start();
if (isset($_SESSION['user_id']) == false) {
 header('Location:../login.php');  
}

include('../db.php');

$act=$_GET['act'];

extract($_POST); 
switch ($act) {
	case 'status':
					$sql="UPDATE `customer` SET `status`='$status' where customer_id='$id'";
					if($query = $con->query($sql)){ 
						header("Location: ../application-profile.php?id=".$id);
					}
		break;

		case 'PI':
					$sql="UPDATE `customer` SET `name`='$name', `dob`='$dob', `mobile`='$mobile', `email`='$email', `residence_address`='$residence_address', `residence_city`='$residence_city', `residence_pincode`='$residence_pincode', `mother_name`='$mother_name', `marital_status`='$marital_status', `father_name`='$father_name' where customer_id='$id'"; 
					if($query = $con->query($sql)){ 
						header("Location: ../application-profile.php?id=".$id);
					}
		break;

	case 'EI':
					$sql="UPDATE `customer` SET `company_name`='$company_name', `company_email_id`='$company_email_id', `total_experience`='$total_experience', `designation`='$designation', `monthly_income`='$monthly_income', `office_address`='$office_address', `office_city`='$office_city', `office_pincode`='$office_pincode', `office_landline_no`='$office_landline_no' where customer_id='$id'"; 
					if($query = $con->query($sql)){ 
						header("Location: ../application-profile.php?id=".$id);
					}
		break;
	
	default:
		
		break;
}


?>