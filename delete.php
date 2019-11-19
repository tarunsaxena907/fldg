<?php
//insert.php  

include('db.php');

if(!empty($_POST))
{
 $output = '';
    $obligation_id = $_POST['id'];
    $obl_id=$_POST['id'][0];
    $customer_query  = "SELECT customer_id FROM `obligation` where id='$obl_id'";
    $customer_result = $con->query($customer_query);
    $row = $customer_result->fetch_assoc();
    $customer_id = $row['customer_id'];
    for($i=0; $i<sizeof($obligation_id); $i++) {
        $query =  "DELETE FROM obligation WHERE id=$obligation_id[$i]";
    }
    $res = $con->query($query);
    $msg = base64_encode("Data Deleted.");
    }
    $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
    $referer1 = substr($referer, 0, strpos($referer, "&"));
    if(!$referer1=='') 
    {
    echo "<script>location.href='".$referer1. "&msg=".$msg."'</script>";
    } else {
    echo "<script>location.href='".$referer. "&msg=".$msg."'</script>";
    }
?>