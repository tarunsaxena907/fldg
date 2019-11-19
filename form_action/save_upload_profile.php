<?php
session_start();
if (isset($_SESSION['user_id']) == false) {
 header('Location:../login.php');  
}

include('../db.php');

// $act=$_GET['act'];
extract($_POST); 
/**
*
*@Pancard Upload...
*/
$target_pan_dir = "../uploads/pancard_proof/";
// $filename = $_FILES["panCardFile"]["name"];
$filename = rand(1000,9999).'_'.date("Y-m-d H:i:s").'_'.$_FILES["panCardFile"]["name"];
$target_pan_file = $target_pan_dir . basename($filename);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_pan_file, PATHINFO_EXTENSION));
// echo $imageFileType; die('-test');

// Check if image file is a actual image or fake image
/*if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}*/
// Check if file already exists
/*if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}*/
// Check file size
/*if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}*/
// Allow certain file formats
/*if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}*/
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["panCardFile"]["tmp_name"], $target_pan_file)) {
        // echo "The file ". basename( $_FILES["panCardFile"]["name"]). " has been uploaded.";
        //Update table...
    	$sql = "UPDATE `kyc_details` SET `pancard_proof_path`='$target_pan_file' where customer_id='$id'";
    	$query = $con->query($sql);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


//////////////////////////////////////////////////////////............................
/**
*
*@Passport Upload...
*/
$target_passport_dir = "../uploads/passport_proof/";
// $filename = $_FILES["passPortFile"]["name"];
$filename = rand(1000,9999).'_'.date("Y-m-d H:i:s").'_'.$_FILES["passPortFile"]["name"];
$target_passport_file = $target_passport_dir . basename($filename);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_passport_file, PATHINFO_EXTENSION));


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["passPortFile"]["tmp_name"], $target_passport_file)) {
        // echo "The file ". basename( $_FILES["passPortFile"]["name"]). " has been uploaded.";
        //Update table...
    	$sql = "UPDATE `kyc_details` SET `passport_proof_path`='$target_passport_file' where customer_id='$id'";
    	$query = $con->query($sql);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
/////////////////////////////////////////..................................
/**
*
*@Salary Slip Upload...
*/
$target_salary_dir = "../uploads/salary_slip_proof/";
// $filename = $_FILES["salarySlipFile"]["name"];
$filename = rand(1000,9999).'_'.date("Y-m-d H:i:s").'_'.$_FILES["salarySlipFile"]["name"];
$target_salary_file = $target_salary_dir . basename($filename);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_salary_file, PATHINFO_EXTENSION));


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["salarySlipFile"]["tmp_name"], $target_salary_file)) {
        // echo "The file ". basename( $_FILES["salarySlipFile"]["name"]). " has been uploaded.";
        //Update table...
    	$sql = "UPDATE `kyc_details` SET `salary_slip_proof_path`='$target_salary_file' where customer_id='$id'";
    	$query = $con->query($sql);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
////////////////////////////////////////..............................
/**
*
*@Bank Statement Upload...
*/
$target_bank_dir = "../uploads/bank_statement_proof/";
// $filename = $_FILES["bankStatementFile"]["name"];
$filename = rand(1000,9999).'_'.date("Y-m-d H:i:s").'_'.$_FILES["bankStatementFile"]["name"];
$target_bank_file = $target_bank_dir . basename($filename);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_bank_file, PATHINFO_EXTENSION));


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["bankStatementFile"]["tmp_name"], $target_bank_file)) {
        // echo "The file ". basename( $_FILES["bankStatementFile"]["name"]). " has been uploaded.";
        //Update table...
    	$sql = "UPDATE `kyc_details` SET `income_proof_path`='$target_bank_file' where customer_id='$id'";
    	$query = $con->query($sql);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
/////////////////////////////............................................
/**
*
*@Address Proof Upload...
*/
$target_address_dir = "../uploads/address_proof/";
// $filename = $_FILES["addressProofFile"]["name"];
$filename = rand(1000,9999).'_'.date("Y-m-d H:i:s").'_'.$_FILES["addressProofFile"]["name"];
$target_address_file = $target_address_dir . basename($filename);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_address_file, PATHINFO_EXTENSION));


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["addressProofFile"]["tmp_name"], $target_address_file)) {
        // echo "The file ". basename( $_FILES["addressProofFile"]["name"]). " has been uploaded.";
        //Update table...
    	$sql = "UPDATE `kyc_details` SET `address_proof_path`='$target_address_file' where customer_id='$id'";
    	$query = $con->query($sql);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

//Redirect to previous page...
header("Location: ../application-profile.php?id=".$id);

/*switch ($act) {
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
}*/


?>