<?php  
session_start();
if (isset($_SESSION['user_id']) == false) {
 header('Location:login.php');  
}

include('db.php');
// $page=2;

/*if(isset($_GET['p'])) {
  $p=$_GET['p'];
  $p_cond=$p;
}
else{
  $p=1;
  $p_cond='';
  unset($_SESSION['application']);
}*/


// $cond='';
$customer_id = $_GET['id'];

/*if(isset($customer_id)){ 
    if($cond==''){
      $cond="Where";
    }
    else{
      $cond.=" && ";
    }
    if(!empty($customer_id)){
      $_SESSION['application']['customer_id']=$customer_id;
    }
    
    $cond .= " customer_id='".$_SESSION['application']['customer_id']."'";
}
else if(!isset($p_cond)|| $p_cond==''){ 
  unset($_SESSION['application']['post_status']);
}*/

// $query  = "select * from customer as c left join customer_loan as cl on c.id=cl.customer_id where c.id=$customer_id";
//11-11-2019//comment by amir...
/*$query  = "select * from customer as c 
left join customer_loan as cl on c.customer_id=cl.customer_id 
left join kyc_details as kd on c.customer_id=kd.customer_id 
where c.customer_id=$customer_id";*/
/*$query  = "select * from customer as c 
left join kyc_details as kd on c.customer_id=kd.customer_id 
where c.customer_id=$customer_id";*/
$query  = "select * from customer as c 
right join application as ap on (c.customer_id=ap.customer_id)
where c.customer_id=$customer_id";
$result = $con->query($query);
$profile_data  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $profile_data[] = $row;
   }
}

/**
* Kyc Detail...
*/
$query  = "select pancard_proof_path, address_proof_path, income_proof_path from kyc_details as kd where kd.customer_id=$customer_id";
$result = $con->query($query);
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $kyc_data = $row;
   }
}

/**
* Loan Detail...
**/
$query  = "select loan_id, role_id, status from application as ap where ap.customer_id=$customer_id";
$result = $con->query($query);
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $app_data = $row;
   }
}
// var_dump($app_data); die('-test');
//$loan_id = $app_data['loan_id'];
//$query  = "select loan_amount, tenure from customer_loan as cl where cl.id=$loan_id";
//$query  = "select count(*) as size from customer as c left join customer_loan as cl on c.customer_id=cl.customer_id ".$cond;
$query  = "select ap.loan_amount,ap.tenure from customer as c left join application as ap on c.customer_id=ap.customer_id where c.customer_id=$customer_id";

$result = $con->query($query);
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $loan_data = $row;
   }
}
//For Test...
// echo $query  = "SELECT * FROM bankstatement where customer_id= $customer_id order by id DESC"; die('-test');
// $offset=($p-1)*$page;
// $query  = "SELECT * FROM bankstatement ".$cond." LIMIT ".$offset.", ".$page;
$query  = "SELECT * FROM bank_statement where customer_id= $customer_id order by id DESC";
$result = $con->query($query);
$bank_details  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $bank_details[] = $row;
   }
}

// echo "<pre>";
// print_r($bank_details); die('-test');

/*$query  = "select count(*) as size from bankstatement ".$cond;
$result = $con->query($query);
$employee_size = array();
if($result->num_rows){
  while($row = $result->fetch_assoc()){
      $employee_size = $row['size'];
  }
}*/

// echo "<pre>";
// print_r($bank_details); die;

$query  = "SELECT id, status FROM `status` where flag='loan'";
$result = $con->query($query);
$status  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $status[] = $row;
   }
}

$query  = "SELECT id, status FROM `marital_status`";
$result = $con->query($query);
$marital_status  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $marital_status[$row['id']] = $row['status'];
   }
}

$query  = "SELECT value, status FROM `status` where flag='validations'";
$result = $con->query($query);
$validation_status  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $validation_status[] = $row;
   }
}

$query  = "SELECT id, i_key, status FROM main_lov Where lov_status=1 AND role_id='".$app_data['role_id']."'";
$result = $con->query($query);
$main_lov  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $main_lov[] = $row;
   }
}
// var_dump($main_lov); die('-test');

$query = "SELECT * FROM obligation where customer_id=$customer_id ORDER BY id DESC";
$result = $con->query($query);

$lists  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $lists[] = $row;
   }
}
$query = "SELECT * FROM income where customer_id=$customer_id ORDER BY id DESC";
$result = $con->query($query);

$lists1  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $lists1[] = $row;
   }
}
// var_dump($validation_status); die('-test');

$query  = "SELECT * FROM `customer_validation` where customer_id=$customer_id";
$result = $con->query($query);
$validations_data  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $validations_data[] = $row;
   }

   if (isset($validations_data)) {
     
     foreach ($validations_data as $value) {
      
      $result = $value;

     }   
     


   }
}


?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Jquery UI CSS -->
  <link rel="stylesheet" href="css/jquery-ui.css">

  <!-- Site CSS -->
  <link rel="stylesheet" href="css/fonts.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/dashboard.css">
  <title>FLDG Employee Profile</title>
</head>

<body>
  <div class="container-fluid loggedin-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white fldg-navbar">
      <div class="container">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">
              <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1020.7 426.8" style="enable-background:new 0 0 1020.7 426.8;" class="wishfinlogo" xml:space="preserve">
                <g>
                  <path class="st0" d="M806.7,0H214C95.8,0,0,95.2,0,213.4s95.8,213.4,214,213.4h592.7c118.2,0,214-95.2,214-213.4S924.9,0,806.7,0z"
                    />
                  <ellipse class="st1" cx="800.8" cy="213.4" rx="187.9" ry="182.3"/>
                  <g>
                    <path class="st2" d="M801.3,145.3h-25c-1.5,0-2.4,1-2.4,2.6v128.5c0,1.6,0.9,2.6,2.4,2.6h25c1.5,0,2.4-1,2.4-2.6V148
                      C803.7,146.3,802.8,145.3,801.3,145.3z"/>
                    <path class="st2" d="M865.2,147.4c-0.6-1.4-1.3-2-2.8-2h-0.1h-32.7h-0.1c-1.5,0-2.4,1-2.4,2.6v128.4c0,1.6,0.9,2.6,2.4,2.6h0.1
                      h24.8h0.1c1.5,0,2.4-1,2.4-2.6v-51.8c0-4.3,0-8.1-0.1-11.7v-27.1l0.7,1L872,219l0,0v-0.3l10,21.3c2.9,6.7,9.7,22.5,17.9,37
                      c0.8,1.3,1.3,2,2.8,2h32.7c1.5,0,2.4-1,2.4-2.6V148c0-1.6-0.9-2.6-2.4-2.6h-24.8c-1.5,0-2.4,1-2.4,2.6v12.5l0,0v78.1l-0.7-1
                      L893,205.4l0,0"/>
                    <path class="st2" d="M757,145.3h-88.5c-1.5,0-2.4,1-2.4,2.6v128.5c0,1.6,0.9,2.6,2.4,2.6h25c1.5,0,2.4-1,2.4-2.6v-40.2h46.9
                      c1.5,0,2.4-1,2.4-2.6v-24.5c0-1.6-0.9-2.7-2.4-2.7l-46.9,0.1v-32.2l54.6,0.2c1.3,0,2.2-1.2,2.6-2.6l5.9-23.5
                      C759.4,146.5,758.7,145.3,757,145.3z"/>
                  </g>
                  <g>
                    <path class="st1" d="M315.6,276.9c0,1.6-0.9,2.6-2.4,2.6h-25c-1.5,0-2.4-1-2.4-2.6V147.6c0-1.6,0.9-2.6,2.4-2.6h25
                      c1.5,0,2.4,1,2.4,2.6V276.9z"/>
                    <path class="st1" d="M371.3,222.2c-25.2-10.3-34.4-20.4-34.4-42.5c0-26.5,18.2-36.6,47.3-36.6c10.7,0,20.6,2,29.4,5.3l12.1,4.5
                      c1.7,0.6,2,1.6,1.7,3.2l-7.5,17.8c-0.6,1.6-1.5,2.2-2.9,1.6l-10.9-3.6c-7.4-2.4-14.3-4.3-21.9-4.3c-10.3,0-17.3,4.9-17.3,12.1
                      c0,7.1,5.7,10.3,16.2,14.6l15.5,6.3c25.6,10.5,34.8,21,34.8,43.1c0,27.7-17.1,40-48.4,40c-11,0-21-1.2-36.2-6.7l-12.1-4.2
                      c-1.7-0.6-2-1.6-1.7-3.2l7.4-20c0.6-1.6,1.5-2.2,2.9-1.6l12.9,4.2c10.9,3.6,18.9,4.9,26.9,4.9c9.9,0,18.4-2.6,18.4-13.4
                      c0-6.1-6.4-10.7-16.6-15L371.3,222.2z"/>
                    <path class="st1" d="M559.6,276.4c0,1.6-0.9,2.6-2.4,2.6h-24.8c-1.5,0-2.4-1-2.4-2.6v-52h-47.8v52c0,1.6-0.9,2.6-2.4,2.6h-25
                      c-1.5,0-2.4-1-2.4-2.6V148c0-1.6,0.9-2.6,2.4-2.6h25c1.5,0,2.4,1,2.4,2.6v47.9H530V148c0-1.6,0.9-2.6,2.4-2.6h24.8
                      c1.5,0,2.4,1,2.4,2.6V276.4z"/>
                    <path class="st1" d="M266.1,145.4h-25.4c-1.5,0-2.4,0.8-2.8,2.2l-12.3,49.8c-1,4.3-1.9,8.9-2.8,13.6l-6.1,28.1l-6.2-26.6
                      c-1-5.3-2.2-10.4-3.3-15.1l-3.4-14c-3.2-13.7-6-22-8.3-35.6c-0.2-1.6-1.1-2.4-2.6-2.4h-0.8h-32.8h-0.9c-1.5,0-2.4,0.8-2.6,2.4
                      c-2.4,13.6-5.1,21.8-8.3,35.6l-3.4,14c-1.2,4.7-2.3,9.9-3.3,15.1l-6.2,26.6l-6.1-28.1c-0.9-4.7-1.8-9.4-2.8-13.6l-12.3-49.8
                      c-0.4-1.4-1.3-2.2-2.8-2.2H85.2c-1.7,0-2.6,1.2-2,2.8l22.6,92.2c3.3,14,6.1,22.4,8.5,36.2c0.2,1.6,1.1,2.4,2.6,2.4h33.7l0,0h1.6
                      c1.5,0,2.4-0.8,2.8-2.2l12.3-49.8c1-4.3,1.9-8.9,2.8-13.6l5.7-26.1l5.7,26.1c0.9,4.7,1.8,9.4,2.8,13.6l12.1,49.8
                      c0.4,1.4,1.3,2.2,2.8,2.2h1.6l0,0h33.7c1.5,0,2.4-0.8,2.6-2.4c2.4-13.8,5.2-22.2,8.5-36.2l22.6-92.2
                      C268.7,146.6,267.8,145.4,266.1,145.4z"/>
                  </g>
                </g>
                </svg>
            </a>

            <div class="collapse navbar-collapse justify-content-end" id="navbarToggler">
              <ul class="navbar-nav mt-2 mt-lg-0 justify-content-end">
                <li class="nav-item active">
                  <a class="nav-link" href="employee-application.php"><i class="fa fa-list" aria-hidden="true"></i> Applications <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="employee-loans.php"><i class="fa fa-money" aria-hidden="true"></i> Loans</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link notify-link" href="#">
                    <span class="notify-icon">
                      <span class="green-notify"></span><i class="fa fa-bell" aria-hidden="true"></i>
                    </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="my-account" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Saurabh Singh <img src="images/Avatar.png" alt=""/>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="my-account">
                    <a class="dropdown-item" href="logout.php">Logout</a>
                  </div>
                </li>
              </ul>
            </div>
      </div>
</nav><!--nav ends-->
  <div class="row dashboard">
    <div class="container">
      <div class="card mt-5">
        <div class="card-body">
          <div class="row">
            <div class="col-md-1">
              <div class="profile-image">
                <img src="images/<?php echo $profile_data[0]['name'].'_'.$customer_id;?>.png" alt=""/>
              </div>
            </div>
            <div class="col-md-11 pt-4">
              <div class="row mb-5">
                <div class="col-md-7 d-flex align-items-center">
                  <div class="profile-name pl-3">
                    <?php echo $profile_data[0]['name']; ?>
                  </div>
                  <div class="profile-id pl-5">
                    <span>Customer ID : <?php echo $customer_id; ?></span>
                  </div>
                </div>
                <div class="col-md-5 d-flex align-items-center justify-content-end">
                  <div class="filter-box profile-filter-box">
                    <!-- <form id="filter-form-profile" class="filter-form" action="form_action/save_application_profile.php?act=status" method="post">
                      <input type="hidden" name="id" value="<?php //echo $customer_id; ?>">
                      <div class="form-group select-field">
                          <select class="form-control" name="status" required>
                            <option value="">Status Action</option>
                            <?php 
                              //foreach ($status as $value) //{ 
                            ?>
                                <option value="<?php //echo $value['id']; ?>" <?php //if($profile_data[0]['status']==$value['id']){echo "Selected"; }?> > <?php //echo $value['status']; ?></option>
                            <?php
                              //}
                            ?>
                          </select>
                          <span class="angledown"></span>
                      </div>

                      <div class="form-group button-area">
                          <button type="submit" class="btn btn-success btn-raised">Approve</button>
                      </div>
                    </form> -->

                    <form id="filter-form-profile" class="filter-form" action="" method="post">
                      <input type="hidden" name="id" value="<?php echo $customer_id; ?>" id="customer_id">
                      <div class="form-group select-field" >
                          
                          <select class="form-control" name="first_status" id="first_status" required>
                            <option value="">Status Action</option>
                            <?php
                            if($app_data['role_id']==1) {
                              foreach ($main_lov as $value) { 
                            
                            ?>
                                <option value="<?php echo $value['id'];?>"  <?php if($value['id'] == $profile_data[0]['status']) echo "selected"; ?>> <?php echo $value['status']; ?></option>
                            <?php
                              }
                            }
                            ?>
                          </select>

                          <span class="angledown"></span>
                      </div>

                      <div class="form-group select-field" id="sub-status-group"  style="display:none">
                          <select class="form-control" name="sub_status" id="sub_status" required>
                             <option value=""> Select Sub Status Action</option>
                          </select>
                          <span class="angledown"></span>
                      </div>

                      <div class="form-group button-area">
                          <button type="submit" class="btn btn-success btn-raised" id="submit">Approve</button>
                      </div>
                    </form>

                  </div>
                </div>
              </div>
              <div class="keyval-unit-box col-12">
                <div class="row">
                  <div class="col-md-4 col-lg-2 col-6">
                    <label>Loans</label>
                    <span>&#8377; <?php 
                      if(isset($loan_data['loan_amount'])){
                        echo $loan_data['loan_amount']; 
                      }else{
                        $loan_data['loan_amount'] = '';
                      }
                    ?></span>
                  </div>
                  <div class="col-md-4 col-lg-2 col-6">
                    <label>Tenure</label>
                    <span class="ng-binding"><?php 
                    if(isset($loan_data['tenure'])){
                        echo $loan_data['tenure']; 
                      }else{
                        $loan_data['tenure'] = '';
                      }
                    ?></span>
                  </div>
                  <div class="col-md-4 col-lg-2 col-6">
                    <label>PAN</label>
                    <span><?php echo $profile_data[0]['pancard']; ?></span>
                  </div>
                  <div class="col-md-4 col-lg-2 col-6">
                    <label>Residence City</label>
                    <span><?php echo $profile_data[0]['residence_city']; ?></span>
                  </div>
                  <div class="col-md-4 col-lg-2 col-6">
                    <label>Wishfin Score</label>
                    <span><strong><?php echo $profile_data[0]['wishfin_score']; ?></strong></span>
                  </div>
                  <div class="col-md-4 col-lg-2 col-6">
                    <label>CIBIL Score</label>
                    <span><strong><?php echo $profile_data[0]['cibil_score']; ?></strong></span>
                  </div>
                </div>
              </div>
            </div>

          </div>



        </div>
      </div>
      <div class="card mt-5">
      <div class="card-header">
          <!-- Nav tabs -->
          <!-- <ul class="nav nav-tabs card-nav-tabs"> -->
          <ul class="nav nav-tabs card-nav-tabs" id="myTab">
           <li class="nav-item">
             <a class="nav-link active" data-toggle="tab" href="#profile1">Customer Profile</a>
           </li>
           <li class="nav-item">
             <a class="nav-link" data-toggle="tab" href="#profile2">Bank Statement</a>
           </li>
           <li class="nav-item">
             <a class="nav-link" data-toggle="tab" href="#profile3">Credit Notes</a>
           </li>
           <li class="nav-item">
             <a class="nav-link" data-toggle="tab" href="#profile4">Documents</a>
           </li>
           <li class="nav-item">
             <a class="nav-link" data-toggle="tab" href="#profile5">Validations</a>
           </li>
          </ul>
      </div>
      <div class="card-body">
        <!-- Tab panes -->
        <div class="tab-content">
         <div class="tab-pane active container" id="profile1">
           <div class="row info-card-heading">
             <div class="col-md-7">
               <h3>PERSONAL INFORMATION</h3>
             </div>
             <div class="col-md-5 text-right">
               <a href="javaScript:void(0)" data-toggle="modal" data-target="#personalInfoModal"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Personal Information</a>
             </div>
           </div>
            <div class="card info-card">
              <div class="card-body">
                <div class="row">
                  <div class="keyval-unit-box col-12">
                    <div class="row">
                      <div class="col-md-3 col-6">
                        <label>Mobile</label>
                        <span><?php echo $profile_data[0]['mobile']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>DOB</label>
                        <span><?php echo $profile_data[0]['dob']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Email</label>
                        <span><?php echo $profile_data[0]['email']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Marital Status</label>
                        <span><?php echo $marital_status[$profile_data[0]['marital_status']]; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Residence Address</label>
                        <span><?php echo $profile_data[0]['residence_address']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Pin Code</label>
                        <span><?php echo $profile_data[0]['residence_pincode']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Education</label>
                        <span><?php echo $profile_data[0]['education']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Mother's Name</label>
                        <span><?php echo $profile_data[0]['mother_name']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Father/Spouse's Name</label>
                        <span><?php echo $profile_data[0]['father_name']; ?></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div><!--card ends-->

            <div class="row info-card-heading">
              <div class="col-md-12">
                <h3>KYC Documents</h3>
              </div>
            </div>
            <div class="card info-card">
              <div class="card-body">
                <div class="row">
                  <div class="keyval-unit-box col-12">
                    <div class="row">
                      <div class="col-md-3 col-6">
                        <?php
                        $original_pancard = $kyc_data['pancard_proof_path'];
                        $original_addressproof = $kyc_data['address_proof_path'];
                        $original_income_proof = $kyc_data['income_proof_path'];
                        strpos($original_pancard,"../");
                        strpos($original_addressproof,"../");
                        strpos($original_income_proof,"../");
                        $pancard = substr($original_pancard, 3);
                        $address_proof = substr($original_addressproof, 3);
                        $income_proof  = substr($original_income_proof, 3); 
                       ?>
                        <label>PAN Image</label>
                        <span><i class="fa fa-file-pdf-o pr-2"></i>
                        <?php 
                          $exploded_pan_data = preg_split('#/#', $kyc_data['pancard_proof_path']);
                          echo $exploded_pan_data[3]; 
                        ?>
                        </span>
                        <a href="#pancard" data-toggle="modal" data-target="#pancard">Show pancard</a>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Address Proof Image</label>
                        <span><i class="fa fa-file-pdf-o pr-2"></i>
                          <?php 
                            $exploded_address_data = preg_split('#/#', $kyc_data['address_proof_path']);
                            echo $exploded_address_data[3]; 
                          ?>
                        </span>
                        <a href="#addressproof" data-toggle="modal" data-target="#addressproof">Show address proof</a>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Bank Statement</label>
                        <span><i class="fa fa-file-pdf-o pr-2"></i>
                          <?php 
                            $exploded_bank_data = preg_split('#/#', $kyc_data['income_proof_path']);
                            echo $exploded_bank_data[3]; 
                          ?>
                        </span>
                        <a href="#bankstatement" data-toggle="modal" data-target="#bankstatement">Show bank statement</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div><!--card ends-->
            <!-------------------bootstrap model pancard---------------------------------------->
  <div class="modal"  id="pancard" role="dialog">
    <div class="modal-dialog modal-large">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <iframe class="iframe" src="<?php echo $pancard;?>"  height="400" width="100%"> </iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
<!------------------- bootstrap model address_proof ---------------------------------------->
<div class="modal"  id="addressproof">
    <div class="modal-dialog modal-large">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
           <iframe src="<?php echo $address_proof;?>"  height="400" width="100%"> </iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
<!------------------- bootstrap model Bank Statement ---------------------------------------->
<div class="modal"  id="bankstatement">
    <div class="modal-dialog modal-large">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <iframe src="<?php echo @$income_proof;?>" height="400" width="100%"> </iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
<!------------------- bootstrap model -------------------------------------------------------->
            <div class="row info-card-heading">
              <div class="col-md-7">
                <h3>EMPLOYMENT DETAILS</h3>
              </div>
              <div class="col-md-5 text-right">
                <a href="javaScript:void(0)" data-toggle="modal" data-target="#employmentInfoModal"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Employment Information</a>
              </div>
            </div>
            <div class="card info-card">
              <div class="card-body">
                <div class="row">
                  <div class="keyval-unit-box col-12">
                    <div class="row">
                      <div class="col-md-3 col-6">
                        <label>Company Name</label>
                        <span><?php echo $profile_data[0]['company_name']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Company Email ID </label>
                        <span><?php echo $profile_data[0]['company_email_id']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Total Experience</label>
                        <span><?php echo $profile_data[0]['total_experience']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Designation</label>
                        <span><?php echo $profile_data[0]['designation']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Monthly Income (In hand)</label>
                        <span><?php echo $profile_data[0]['monthly_income']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Office  Address</label>
                        <span><?php echo $profile_data[0]['office_address']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>City</label>
                        <span><?php echo $profile_data[0]['office_city']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Pin code</label>
                        <span><?php echo $profile_data[0]['office_pincode']; ?></span>
                      </div>
                      <div class="col-md-3 col-6">
                        <label>Office Landline no.</label>
                        <span><?php echo $profile_data[0]['office_landline_no']; ?></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div><!--card ends-->

            <!-- Edit Personal Information Form Modal -->
                <div class="modal fade" id="personalInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h2 class="modal-title">Personal Information</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="personal-info-form" action="form_action/save_application_profile.php?act=PI" method="post">
                          <input type="hidden" name="id" value="<?php echo $customer_id; ?>">
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group bmd">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $profile_data[0]['name']; ?>" required/>
                                <span class="invalid-feedback">this field is required.</span>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group bmd">
                                <label>DOB</label>
                                <input type="text" class="form-control DOB" name="dob" value="<?php echo $profile_data[0]['dob']; ?>" required/>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group bmd">
                                <label>Mobile</label>
                                <input type="tel" class="form-control Numericonly" name="mobile" value="<?php echo $profile_data[0]['mobile']; ?>" maxlength="10"required/>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group bmd">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $profile_data[0]['email']; ?>" required/>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group bmd">
                                <label>Residence</label>
                                <input type="text" class="form-control" name="residence_address" <input type="email" class="form-control" value="<?php echo $profile_data[0]['residence_address']; ?>" required/>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group bmd">
                                <label>City</label>
                                <input type="text" class="form-control" name="residence_city"  value="<?php echo $profile_data[0]['residence_city']; ?>" required/>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group bmd">
                                <label>Pincode</label>
                                <input type="tel" class="form-control Numericonly" name="residence_pincode"  value="<?php echo $profile_data[0]['residence_pincode']; ?>" maxlength="6" required />
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group bmd">
                                <label>Mother name</label>
                                <input type="text" class="form-control" name="mother_name" value="<?php echo $profile_data[0]['mother_name']; ?>" required />
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group bmd">
                                <label>Marital Status</label>
                                <select class="form-control" name="marital_status" required>
                                  <option value="">Status Action</option>
                                  <?php 
                                    foreach ($marital_status as $id=>$status) { 
                                  ?>
                                      <option value="<?php echo $id; ?>" <?php if($profile_data[0]['marital_status']==$id){echo "Selected"; }?> > <?php echo $status; ?></option>
                                  <?php
                                    }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group bmd">
                                <label>Father/Spouse's Name</label>
                                <input type="text" class="form-control" name="father_name" value="<?php echo $profile_data[0]['father_name']; ?>" required/>
                              </div>
                            </div>
                          </div>
                          <p class="button-area text-center pt-5">
                              <button type="submit" class="btn btn-success">Update</button>
                          </p>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Edit Employment Information Form Modal -->
                    <div class="modal fade" id="employmentInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h2 class="modal-title">Employment Information</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="employment-info-form" action="form_action/save_application_profile.php?act=EI" method="post">
                              <input type="hidden" name="id" value="<?php echo $customer_id; ?>">
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group bmd">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" name="company_name" value="<?php echo $profile_data[0]['company_name']; ?>" required/>
                                    <span class="invalid-feedback">this field is required.</span>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group bmd">
                                    <label>Company Email ID </label>
                                    <input type="tel" class="form-control Numericonly" name="company_email_id" value="<?php echo $profile_data[0]['company_email_id']; ?>" required/>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group bmd">
                                    <label>Total Experience</label>
                                    <input type="tel" class="form-control Numericonly" name="total_experience" value="<?php echo $profile_data[0]['total_experience']; ?>" maxlength="3" required />
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group bmd">
                                    <label>Designation</label>
                                    <input type="text" class="form-control" name="designation" value="<?php echo $profile_data[0]['designation']; ?>" required />
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group bmd">
                                    <label>Monthly Income (In hand)</label>
                                    <input type="tel" class="form-control Numericonly inrFormat" name="monthly_income" maxlength="9" value="<?php echo $profile_data[0]['monthly_income']; ?>" required/>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group bmd">
                                    <label>Office Address</label>
                                    <input type="text" class="form-control" name="office_address" value="<?php echo $profile_data[0]['office_address']; ?>" required/>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group bmd">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="office_city" value="<?php echo $profile_data[0]['office_city']; ?>" required/>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group bmd">
                                    <label>Pincode</label>
                                    <input type="tel" class="form-control Numericonly" name="office_pincode" maxlength="6" value="<?php echo $profile_data[0]['office_pincode']; ?>" required/>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group bmd">
                                    <label>Office Landline no.</label>
                                    <input type="tel" class="form-control Numericonly" name="office_landline_no" maxlength="8" value="<?php echo $profile_data[0]['office_landline_no']; ?>"required/>
                                  </div>
                                </div>
                              </div>
                              <p class="button-area text-center pt-5">
                                  <button type="submit" class="btn btn-success">Update</button>
                              </p>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
         </div>
         <div class="tab-pane container" id="profile2">
           <div class="row">
             <div class="col-lg-6">
               <!-- <h4>Inflow Distribution</h4> -->
               <div id="inflow-chart"></div>
             </div>
             <div class="col-lg-6">
               <!-- <h4>Outflow Distribution</h4> -->
               <div id="outflow-chart"></div>
             </div>
           </div>
            <div class="table-responsive">
               <table class="table table-borderless">
                 <thead>
                   <tr>
                     <th>S.no.</th>
                     <th>Date</th>
                     <th>Narration</th>
                     <th>Amount</th>
                     <th>Balance</th>
                     <th>Category</th>
                     <th>DS Category</th>
                   </tr>
                 </thead>
                 <tbody>
                  <?php
                  $counter = 0;                  
                  foreach ($bank_details as $list) {  
                  ?>
                   <tr>
                     <td><?php echo ++$counter; ?></td>
                     <td><?php echo $list['date']; ?></td>
                     <td><?php echo ucwords($list['narration']); ?></td>
                     <td><?php echo $list['amount']; ?></td>
                     <td><?php echo $list['balance']; ?></td>
                     <td><?php echo ucwords($list['category']); ?></td>
                     <td><?php echo ucwords($list['ds_category']); ?></td>
                   </tr>
                 <?php } ?>
                 </tbody>
               </table>
             </div>

            <?php 
              // $total_record  = $employee_size;
              // if($total_record>$page){
            ?>

              

            <?php //} ?>
         </div>
         <!--profile2-->
         <div class="tab-pane container" id="profile3">
           <div class="card info-card">
             <div class="card-body">
               <div class="row">
                <?php
                  $obl_sum = 0;
                  foreach ($lists as $row) { 
                  $obl_sum +=$row["monthly_emi"];
                  }
                  $inc_sum = 0;
                  foreach ($lists1 as $row) { 
                  $inc_sum +=$row["monthly_emi"];
                  }
                ?>
                 <div class="col-12 text-right">
                   <p class="d-inline-block text-left btn-foir">
                     <span class="d-block">FOIR</span>
                     <span class="d-block h2">
                      <?php echo $foir=number_format(($obl_sum / $inc_sum)*100,2); ?>%
               </span>
                    </p>
                    <!-- <p class="d-inline-block text-left  btn-lti">
                      <span class="d-block">LTI</span>
                      <span class="d-block h2">12.23%</span>
                     </p> -->
                 </div>
               </div><!--row-->

               <div class="row">
                 <div class="col-lg-6">
                  <div style="top: 50px !important;margin-left: 356px;position: absolute;z-index: 1;">
                  <button type="button" name="age" id="age" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-success">Add</button>
                  <button type="button" name="btn_delete" id="btn_delete" class="btn btn-success">Delete</button>
                </div>
                <div id="employee_table">
                   <div class="card notes-card mt-5">
                     <div class="card-header">
                       <div class="row">
                         <div class="col-5">
                           <h4>Obligations</h4>
                         </div>
                       </div>
                     </div>
                     <div class="card-body">
                       <div class="table-responsive">
                        <label class="text-success"><?php if(!@$_GET['msg']=='') { echo base64_decode($_GET['msg']); } else { echo base64_decode(@$_GET['add']); } ?></label>
                         <table class="table table-borderless">
                          <thead>
                            <tr>
                              <th>&nbsp;</th>
                              <th>S.no.</th>
                              <th>Type</th>
                              <th>Source</th>
                              <th>Monthly EMI</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $obl_counter = 0;
                            $obl_sum = 0;
                            foreach ($lists as $row) { 
                            $obl_sum +=$row["monthly_emi"];
                              ?>
                              <?php 
                               ?>
                            <tr> 
                              <td><input type="checkbox" name="obligation[]" class="delete_obligation" value="<?php echo $row["id"]; ?>"></td>
                              <td><?php echo ++$obl_counter;?></td>
                              <td><?php echo $row["type"]; ?></td>
                              <td><?php echo $row["source"]; ?></td>
                              <td><?php echo $row["monthly_emi"]; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                       </div>
                     </div>
                   </div>
                   <p class="mt-3">Total Obligation for the user : <strong>₹ <?php echo $obl_sum; ?></strong></p>
                 </div>

                   <div id="add_data_Modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   
   </div>
   <div class="modal-body">
    <form method="post" id="insert_form">
     <label>Type</label>
     <input type="text" name="type" id="type" class="form-control" />
     <br />
     <label>Source</label>
     <textarea name="source" id="source" class="form-control"></textarea>
     <br /> 
     <label>Monthly EMI</label>
     <input type="text" name="monthly_emi" id="monthly_emi" class="form-control" />
     <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id; ?>" />
     <br />
     <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />

    </form>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>

<div id="dataModal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Employee Details</h4>
   </div>
   <div class="modal-body" id="employee_detail">
    
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>
                   <!-- <p class="mt-3">Total Obligation for the user : <strong>₹ <?php echo $obl_sum; ?></strong></p> -->
                 </div>

                 <div class="col-lg-6">
                  <div style="top: 50px !important;margin-left: 356px;position: absolute;z-index: 1;">
                  <button type="button" name="age1" id="age1" data-toggle="modal" data-target="#add_data_Modal_inc" class="btn btn-success">Add</button>
                  <button type="button" name="btn_delete_inc" id="btn_delete_inc" class="btn btn-success">Delete</button>
                </div>
                <div id="employee_table_inc">
                   <div class="card notes-card mt-5">
                     <div class="card-header">
                       <div class="row">
                         <div class="col-5">
                           <h4>Income</h4>
                         </div>
      
                       </div>
                     </div>
                     <div class="card-body">
                       <div class="table-responsive">
                        <label class="text-success"><?php if(!@$_GET['del']=='') { echo base64_decode($_GET['del']); } else { echo base64_decode(@$_GET['insert']); } ?></label>
                         <table class="table table-borderless">
                          <thead>
                            <tr>
                              <th>&nbsp;</th>
                              <th>S.no.</th>
                              <th>Type</th>
                              <th>Source</th>
                              <th>Monthly EMI</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $inc_counter = 0;
                            $inc_sum = 0;
                            foreach ($lists1 as $row) { 
                              $inc_sum +=$row["monthly_emi"];
                              ?>
                            <tr>
                              <td><input type="checkbox" name="obligation[]" class="delete_obligation_inc" value="<?php echo $row["id"]; ?>"></td>
                              <td><?php echo ++$inc_counter;?></td>
                              <td><?php echo $row["type"]; ?></td>
                              <td><?php echo $row["source"]; ?></td>
                              <td><?php echo $row["monthly_emi"]; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                       </div>
                     </div>
                   </div>
                   <p class="mt-3">Total Income for the user : <strong>₹ <?php echo $inc_sum; ?></strong></p>
                 </div>
                   <div id="add_data_Modal_inc" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   
   </div>
   <div class="modal-body">
    <form method="post" id="insert_form_inc">
     <label>Type</label>
     <input type="text" name="type1" id="type1" class="form-control" />
     <br />
     <label>Source</label>
     <textarea name="source1" id="source1" class="form-control"></textarea>
     <br /> 
     <label>Monthly EMI</label>
     <input type="text" name="monthly_emi1" id="monthly_emi1" class="form-control" />
     <input type="hidden" name="customer_id1" id="customer_id1" value="<?php echo $customer_id; ?>" />
     <br />
     <input type="submit" name="insert1" id="insert1" value="Insert" class="btn btn-success" />

    </form>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>

<div id="dataModal_inc" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Employee Details</h4>
   </div>
   <div class="modal-body" id="employee_detail_inc">
    
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>
                   <!-- <p class="mt-3">Total Income for the user : <strong>₹ <?php echo $inc_sum; ?></strong></p> -->
                 </div>

               </div>
             </div>
           </div><!--info-card ends-->

           <div class="card info-card">
             <div class="card-body">
               <h4 class="mb-4">LOAN Details<h4>
                 <form id="loan-detail-form" class="loan-detail-form" action="" method="post">
                   <div class="row">
                     <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                          <label>Loan Amount</label>
                          <input type="tel" class="form-control Numericonly inrFormat" name="loanAmount" value="2500000" />
                        </div>
                     </div>
                     <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                          <label>EMI</label>
                          <input type="tel" class="form-control Numericonly inrFormat" name="EMI" value="25000" />
                        </div>
                     </div>
                     <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                          <label>EMI</label>
                          <input type="tel" class="form-control Numericonly" name="tenure" value="24" maxlength="3" />
                        </div>
                     </div>
                     <div class="col-md-6 col-lg-3">
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>ROI</label>
                              <input type="tel" class="form-control" name="roi" value="10" maxlength="6" min="0" max="99.99" />
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <p class="button-area">
                                <button type="submit" class="btn btn-success w-100">Save</button>
                            </p>
                          </div>
                        </div>

                     </div>
                   </div><!--row ends-->
                 </form>

             </div>
           </div><!--info-card ends-->

         </div>
         
         <!--profile3-->


         <div class="tab-pane container" id="profile4">
           <form id="doc-upload-form" class="doc-upload-form" action="form_action/save_upload_profile.php" method="post"   enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $customer_id; ?>">
             <h3>IDENTITY PROOF</h3>
             <div class="row mb-5">
               <div class="col-md-4">
                 <div class="input-group form-group">
                   <input type="file" class="form-control form-control-file" name="panCardFile" required="required" />
                   <input type="text" class="form-control form-control-text" name="panCardFileName" placeholder="Pan Card" />
                   <div class="input-group-append">
                     <span class="input-group-text" id="basic-addon2"><i class="fa fa-paperclip" aria-hidden="true"></i></span>
                   </div>
                 </div>
               </div>
               <div class="col-md-4">
                 <div class="input-group form-group">
                   <input type="file" class="form-control form-control-file" name="passPortFile"/>
                   <input type="text" class="form-control form-control-text" name="passPortFileName" placeholder="Passport Pic" />
                   <div class="input-group-append">
                     <span class="input-group-text" id="basic-addon2"><i class="fa fa-paperclip" aria-hidden="true"></i></span>
                   </div>
                 </div>
               </div>
             </div>

             <h3>INCOME PROOF</h3>
             <div class="row mb-5">
               <div class="col-md-4">
                 <div class="input-group form-group">
                   <input type="file" class="form-control form-control-file" name="salarySlipFile"/>
                   <input type="text" class="form-control form-control-text" name="salarySlipFileName" placeholder="Salary Slip/ Letter from org" />
                   <div class="input-group-append">
                     <span class="input-group-text" id="basic-addon2"><i class="fa fa-paperclip" aria-hidden="true"></i></span>
                   </div>
                 </div>
               </div>
               <div class="col-md-4">
                 <div class="input-group form-group">
                   <input type="file" class="form-control form-control-file" name="bankStatementFile"/>
                   <input type="text" class="form-control form-control-text" name="bankStatementFileName" placeholder="3/6 Bank Statement" />
                   <div class="input-group-append">
                     <span class="input-group-text" id="basic-addon2"><i class="fa fa-paperclip" aria-hidden="true"></i></span>
                   </div>
                 </div>
               </div>
             </div>

             <h3>ADDRESS PROOF</h3>
             <div class="row mb-5">
               <div class="col-md-4">
                 <div class="input-group form-group">
                   <input type="file" class="form-control form-control-file" name="addressProofFile"/>
                   <input type="text" class="form-control form-control-text" name="addressProofFileName" placeholder="Aadhar / Bank passbook with latest address" />
                   <div class="input-group-append">
                     <span class="input-group-text" id="basic-addon2"><i class="fa fa-paperclip" aria-hidden="true"></i></span>
                   </div>
                 </div>
               </div>
             </div>

             <p class="button-area text-center">
                <button type="button" class="btn mx-2">Cancel</button>
                <button type="submit" class="btn btn-success mx-2">Submit</button>
             </p>

           </form>
         </div><!--profile4-->


         <div class="tab-pane container" id="profile5">

           <div class="table-responsive">
               <table class="table table-borderless table-check">
                 <thead>
                   <tr>
                     <th>Field</th>
                     <th>Value</th>
                     <th>PAN/NSDL</th>
                     <th>OTP</th>
                     <th>Address proof</th>
                     <th>Bank statement</th>
                     <th>Karza</th>
                     <th>Others</th>
                   </tr>
                 </thead>
                 <tbody>

                  <tr>
                     <td>Name</td>
                     <td><strong><?php echo $profile_data[0]['name']; ?></strong></td>
                     <td>
                      <?php 
                      // echo $result['name_pan_vld']; ?>
                      <div class="form-group select-field">
                        <select class="form-control ctmr-valid" name="name_pan_vld" id="name_pan_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['name_pan_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>

                                        
                     </td>
                     <td>
                      <?php 
                      // echo $result['name_otp_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="name_otp_vld" id="name_otp_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['name_otp_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>
                      </td>
                     <td>
                      <?php 
                      // echo $result['name_address_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="name_address_vld" id="name_address_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['name_address_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>
                      </td>
                     <td>
                      <?php 
                      // echo $result['name_income_vld']; 

                      ?>
                      <div class="form-group select-field">
                       <select class="form-control ctmr-valid" name="name_income_vld" id="name_income_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['name_income_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                         <span class="angledown"></span>
                      </div>
                      </td>
                     <td>
                      <?php 
                      // echo $result['name_karza_vld']; 

                      ?>
                      <div class="form-group select-field">
                        <select class="form-control ctmr-valid" name="name_karza_vld" id="name_karza_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['name_karza_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                          <span class="angledown"></span>
                      </div>
                      </td>
                     <td>
                      <?php 
                      // echo $result['name_other_vld']; 

                      ?>
                      <div class="form-group select-field">
                        <select class="form-control ctmr-valid" name="name_other_vld" id="name_other_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['name_other_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>
                      </td>
                  </tr>

                  <tr>
                     <td>Pan no.</td>
                     <td><strong><?php echo $profile_data[0]['pancard']; ?></strong></td>
                     <td>
                      <?php 
                      // echo $result['pan_pan_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="pan_pan_vld" id="pan_pan_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pan_pan_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>
                     </td>
                     <td>
                      <?php 
                      // echo $result['pan_otp_vld'];

                      ?>
                      <div class="form-group select-field">
                       <select class="form-control ctmr-valid" name="pan_otp_vld" id="pan_otp_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pan_otp_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>
                      </td>
                     <td>
                      <?php 
                      // echo $result['pan_address_vld']; 

                      ?>
                      <div class="form-group select-field">
                       <select class="form-control ctmr-valid" name="pan_address_vld" id="pan_address_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pan_address_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>
                      </td>
                     <td>
                      <?php 
                      // echo $result['pan_income_vld']; 

                      ?>
                      <div class="form-group select-field">
                       <select class="form-control ctmr-valid" name="pan_income_vld" id="pan_income_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pan_income_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>
                      </td>
                     <td>
                      <?php 
                      // echo $result['pan_karza_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="pan_karza_vld" id="pan_karza_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pan_karza_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>
                      </td>
                     <td>
                      <?php 
                      // echo $result['pan_other_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="pan_other_vld" id="pan_other_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pan_other_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>  
                      </td>
                  </tr>

                  <tr>
                     <td>Mobile</td>
                     <td><strong><?php echo $profile_data[0]['mobile']; ?></strong></td>
                     <td>
                      <?php 
                      // echo $result['mobile_pan_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="mobile_pan_vld" id="mobile_pan_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['mobile_pan_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select> 
                        <span class="angledown"></span>
                      </div>  
                      </td>
                     <td>
                      <?php 
                      // echo $result['mobile_otp_vld'];

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="mobile_otp_vld" id="mobile_otp_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['mobile_otp_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select> 
                        <span class="angledown"></span>
                      </div>  
                      </td>
                     <td>
                      <?php 
                      // echo $result['mobile_address_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="mobile_address_vld" id="mobile_address_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['mobile_address_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div> 
                     </td>
                     <td>
                      <?php 
                      // echo $result['mobile_income_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="mobile_income_vld" id="mobile_income_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['mobile_income_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select> 
                        <span class="angledown"></span>
                      </div> 
                      </td>
                     <td>
                      <?php 
                      // echo $result['mobile_karza_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="mobile_karza_vld" id="mobile_karza_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['mobile_karza_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>  
                        <span class="angledown"></span>
                      </div> 
                      </td>
                     <td>
                      <?php 
                      // echo $result['mobile_other_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="mobile_other_vld" id="mobile_other_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['mobile_other_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>   
                      </td>
                  </tr>

                  <tr>
                     <td>DOB</td>
                     <td><strong><?php echo $profile_data[0]['dob']; ?></strong></td>
                     <td>
                      <?php 
                      // echo $result['dob_pan_vld'];

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="dob_pan_vld" id="dob_pan_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['dob_pan_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div> 
                     </td>
                     <td>
                      <?php 
                      // echo $result['dob_otp_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="dob_otp_vld" id="dob_otp_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['dob_otp_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select> 
                        <span class="angledown"></span>
                      </div> 
                      </td>
                     <td>
                      <?php 
                      // echo $result['dob_address_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="dob_address_vld" id="dob_address_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['dob_address_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>  
                      </td>
                     <td>
                      <?php 
                      // echo $result['dob_income_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="dob_income_vld" id="dob_income_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['dob_income_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>  
                      </td>
                     <td>
                      <?php 
                      // echo $result['dob_karza_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="dob_karza_vld" id="dob_karza_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['dob_karza_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div> 
                      </td>
                     <td>
                      <?php 
                      // echo $result['dob_other_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="dob_other_vld" id="dob_other_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['dob_other_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>
                      </td>
                  </tr>

                  <tr>
                     <td>Residence</td>
                     <td><strong><?php echo $profile_data[0]['residence_address']; ?></strong></td>
                     <td>
                      <?php 
                      // echo $result['res_addr_pan_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="res_addr_pan_vld" id="res_addr_pan_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['res_addr_pan_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div> 
                      </td>
                     <td>
                      <?php 
                      // echo $result['res_addr_otp_vld'];

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="res_addr_otp_vld" id="res_addr_otp_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['res_addr_otp_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>  
                      </td>
                     <td>
                      <?php 
                      // echo $result['res_addr_address_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="res_addr_address_vld" id="res_addr_address_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['res_addr_address_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div> 
                     </td>
                     <td>
                      <?php 
                      // echo $result['res_addr_income_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="res_addr_income_vld" id="res_addr_income_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['res_addr_income_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div> 
                      </td>
                     <td>
                      <?php 
                      // echo $result['res_addr_karza_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="res_addr_karza_vld" id="res_addr_karza_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['res_addr_karza_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div> 
                     </td>
                     <td>
                      <?php 
                      // echo $result['res_addr_other_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="res_addr_other_vld" id="res_addr_other_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['res_addr_other_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>  
                      </td>
                  </tr>

                  <tr>
                     <td>Pincode</td>
                     <td><strong><?php echo $profile_data[0]['residence_pincode']; ?></strong></td>
                     <td>
                      <?php 
                      // echo $result['pincode_pan_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="pincode_pan_vld" id="pincode_pan_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pincode_pan_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>  
                      </td>
                     <td>
                      <?php 
                      // echo $result['pincode_otp_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="pincode_otp_vld" id="pincode_otp_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pincode_otp_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>  
                      </td>
                     <td>
                      <?php 
                      // echo $result['pincode_address_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="pincode_address_vld" id="pincode_address_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pincode_address_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div> 
                     </td>
                     <td>
                      <?php 
                      // echo $result['pincode_income_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="pincode_income_vld" id="pincode_income_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pincode_income_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div>  
                      </td>
                     <td>
                      <?php 
                      // echo $result['pincode_karza_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="pincode_karza_vld" id="pincode_karza_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pincode_karza_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select>
                        <span class="angledown"></span>
                      </div> 
                      </td>
                     <td>
                      <?php 
                      // echo $result['pincode_other_vld']; 

                      ?>
                      <div class="form-group select-field">
                      <select class="form-control ctmr-valid" name="pincode_other_vld" id="pincode_other_vld" required>
                              <option value="">Status</option>
                              <?php 
                                foreach ($validation_status as $value) { 
                              ?>
                                  <option value="<?php echo $value['value']; ?>" <?php if($result['pincode_other_vld']==$value['value']){echo "Selected"; }?> > 
                                    <?php echo $value['status']; ?>
                                      
                                  </option>
                              <?php } ?>
                        </select> 
                        <span class="angledown"></span>
                      </div> 
                      </td>
                  </tr>

                 </tbody>
               </table>
             </div>

         </div>
        </div>
        </div>
      </div>
    </div>
  </div><!--dasboard row-->

  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="js/jquery-3.2.1.js"></script>
  <script src="js/1.12.1-jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <script src="js/jquery.validate.js"></script>
  <script src="js/dashboard.js"></script>
</body>

</html>

<script type="text/javascript">
  $(document).ready(function(){

    $('.ctmr-valid').on('change', function() {
      
      var field_val = this.value;      
      var field_name = $(this).attr('name');
      var customer_id = "<?php echo $customer_id; ?>";      
      
        $.ajax({
            url: "ajax_request/update_validation.php",
            type: "post",
            dataType: "json",
            data: {field_val: field_val, field_name:field_name, customer_id:customer_id},
            success: function (response) {

               // You will get response from your PHP page (what you echo or print)
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });

      });
  
    $('#first_status').on('change',function() {
       var id = $('#first_status').val();
       if(id =="2" || id =="3" || id =="7" || id =="8"|| id =="13"){
        $.ajax({
              type: "POST",
              url: "get_data.php",
              data:'m_id='+id,
              datatype: 'json',
              success: function(data){
              $('#sub_status').empty();
              var substatus = JSON.parse(data);
              $.each(substatus, function(key,value) {
                    $('#sub-status-group').show();
                    $('#sub_status').append('<option value="'+ value.id +'">'+ value.status +'</option>');
                });
              }
          });
       }
       else{
            $('#sub-status-group').hide();
       }
       
    });

    $('#submit').click(function () {
          var mainstatus = $('#first_status').val();
          var substatus  = $('#sub_status').val();
          var customer_id = $('#customer_id').val();
          if(mainstatus!==''){
          $.ajax({
            url: "get_data.php",
            type: "post",
            data: {customer_id: customer_id, mainstatus: mainstatus, substatus: substatus},
            success: function (data) {
              alert('Status Updated Succesfully!');
            }
          });
          }
          else{
            alert('please select the value');
          }
    }); 

  });
</script>

<script type="text/javascript">  
  $(document).ready(function() {

     $('#insert_form').on("submit", function(event) { 

      event.preventDefault();  

      if($('#type').val() == "")  
      {  
       alert("Type is required");  
      }  
      else if($('#source').val() == '')  
      {  
       alert("Source is required");  
      }  
      else if($('#monthly_emi').val() == '')
      {  
       alert("Monthly EMI is required");  
      }
       
      else  
      {  
         $.ajax({  
          url:"insert.php",  
          method:"POST",  
          data:$('#insert_form').serialize(),  
          beforeSend:function(){  
           $('#insert').val("Inserting");  
          },  
          success:function(data){  
           $('#insert_form')[0].reset();  
           $('#add_data_Modal').modal('hide');  
           $('#employee_table').html(data);  
          }  
         });  
      }  
     });     

     //Delete record...
     $('#btn_delete').click(function(){

        if (confirm("Are you sure you want to delete this?")) {
          var id = [];
          $(':checkbox:checked').each(function(i){

            id[i] = $(this).val();

          });
          if(id.length === 0){
            alert('Please select atleast one checkbox');
          }else{
              $.ajax({
                url:'delete.php',
                method:'POST',
                data:{id:id},
                success:function(data) {

                  // $('#insert_form')[0].reset();  
                  // $('#add_data_Modal').modal('hide');  
                  $('#employee_table').html(data);  

                }


              });
          }
        }else{
          return false;
        }

     });


  });  
 </script>

 <script type="text/javascript">  
  $(document).ready(function() {

     $('#insert_form_inc').on("submit", function(event) { 

      event.preventDefault();  

      if($('#type1').val() == "")  
      {  
       alert("Type is required");  
      }  
      else if($('#source1').val() == '')  
      {  
       alert("Source is required");  
      }  
      else if($('#monthly_emi1').val() == '')
      {  
       alert("Monthly EMI is required");  
      }
       
      else  
      {  
         $.ajax({  
          url:"insert-inc.php",  
          method:"POST",  
          data:$('#insert_form_inc').serialize(),  
          beforeSend:function(){  
           $('#insert').val("Inserting");  
          },  
          success:function(data){  
           $('#insert_form_inc')[0].reset();  
           $('#add_data_Modal_inc').modal('hide');  
           $('#employee_table_inc').html(data);  
          }  
         });  
      }  
     });     

     //Delete record...
     $('#btn_delete_inc').click(function(){

        if (confirm("Are you sure you want to delete this?")) {
          var id = [];
          $(':checkbox:checked').each(function(i){

            id[i] = $(this).val();

          });
          if(id.length === 0){
            alert('Please select atleast one checkbox');
          }else{
              $.ajax({
                url:'delete-inc.php',
                method:'POST',
                data:{id:id},
                success:function(data) {

                  // $('#insert_form')[0].reset();  
                  // $('#add_data_Modal').modal('hide');  
                  $('#employee_table_inc').html(data);  

                }


              });
          }
        }else{
          return false;
        }

     });


  });  
 </script>

<script type="text/javascript">

  $(document).ready(function(){
      $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
          localStorage.setItem('activeTab', $(e.target).attr('href'));
      });
      var activeTab = localStorage.getItem('activeTab');
      if(activeTab){
          $('#myTab a[href="' + activeTab + '"]').tab('show');
      }
  });

</script>