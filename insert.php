<?php
//insert.php  

include('db.php');

if(!empty($_POST))
{
 $output = '';
    $customer_id= mysqli_real_escape_string($con, $_POST["customer_id"]);
    $type = mysqli_real_escape_string($con, $_POST["type"]);      
    $source = mysqli_real_escape_string($con, $_POST["source"]);  
    $monthly_emi = mysqli_real_escape_string($con, $_POST["monthly_emi"]);  
    

    $query = "INSERT INTO obligation(`customer_id`,`type`, `source`, `monthly_emi`, `created_date`)  
     VALUES('$customer_id','$type', '$source', '$monthly_emi', now())";

    $res = $con->query($query);
    
    $msg = base64_encode("Data Inserted.");
    }
	$referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
	$referer1 = substr($referer, 0, strpos($referer, "&")); 
    if(!$referer1=='') 
	{
	 echo "<script>location.href='".$referer1. "&add=".$msg."'</script>";
	} else {
	echo "<script>location.href='".$referer. "&add=".$msg."'</script>";
    }
?>