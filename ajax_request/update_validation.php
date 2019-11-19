<?php
include('../db.php');

$customer_id = $_POST['customer_id'];
$field_name = $_POST['field_name'];
$field_val = $_POST['field_val'];//Common...

$sql="UPDATE `customer_validation` SET $field_name='$field_val' where customer_id='$customer_id'";
$query = $con->query($sql);


?>