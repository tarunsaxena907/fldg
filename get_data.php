<?php
include('db.php');
if(isset($_REQUEST['m_id'])) {
    $mid = $_REQUEST['m_id'];
    $query = "select * from sub_lov where m_id=$mid";
    $result = $con->query($query);
	$data = array();
	if($result->num_rows) {
		while($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
    }
    echo json_encode($data);
}

if(isset($_REQUEST['customer_id'])){
    $customer_id = $_REQUEST['customer_id'];
    $mainstatus  = $_REQUEST['mainstatus'];
    $substatus   = $_REQUEST['substatus'];    

    if(isset($substatus)){
        $substatus   = $_REQUEST['substatus']; 
    }else{
        $substatus   = 0;
    }

    
    // $query = "update customer set status='$mainstatus',sub_status='$substatus' where customer_id='$customer_id'";
    $query = "update application set status=$mainstatus where customer_id=$customer_id"; 
    // $query = "update application set status=$mainstatus, sub_status=$substatus where customer_id=$customer_id"; 

    $result = $con->query($query);
    if($result){
        echo json_encode("Data Updated Successfully");
        }
    else {
        echo json_encode('Something Wrong');
    }
}
?>