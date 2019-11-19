<?php
//insert.php  

include('db.php');

if(!empty($_POST))
{
 $output1 = '';
    $customer_id= mysqli_real_escape_string($con, $_POST["customer_id1"]);
    $type1 = mysqli_real_escape_string($con, $_POST["type1"]);      
    $source1 = mysqli_real_escape_string($con, $_POST["source1"]);  
    $monthly_emi1 = mysqli_real_escape_string($con, $_POST["monthly_emi1"]);  
    

    $query = "INSERT INTO income(`customer_id`,`type`, `source`, `monthly_emi`, `created_date`)  
     VALUES('$customer_id','$type1', '$source1', '$monthly_emi1', now())";

    $res = $con->query($query);
    
    $msg = base64_encode("Data Inserted.");
    }
	$referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
	$referer1 = substr($referer, 0, strpos($referer, "&"));
    if(!$referer1=='') 
	{
	 echo "<script>location.href='".$referer1. "&insert=".$msg."'</script>";
	} else {
	echo "<script>location.href='".$referer. "&insert=".$msg."'</script>";
    }
?>