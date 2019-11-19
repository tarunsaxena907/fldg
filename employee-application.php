<?php
session_start();
if (isset($_SESSION['user_id']) == false) {
 header('Location:login.php');  
}

include('db.php');

$page=10;
if(isset($_GET['p'])) {
  $p=$_GET['p'];
  $p_cond=$p;
}
else{
  $p=1;
  $p_cond='';
  unset($_SESSION['application']);
}


$cond='';


if(isset($_POST["status"]) && !empty($_POST["status"])){ 
    if($cond==''){
      $cond="Where";
    }
    else{
      $cond.=" && ";
    }
    if(!empty($_POST['status'])){
      $_SESSION['application']['post_status']=$_POST["status"];
    }
    
    $cond .= " status='".$_SESSION['application']['post_status']."'";
}
else if(!isset($p_cond)|| $p_cond==''){ 
  unset($_SESSION['application']['post_status']);
}


if(isset($_POST["customerID"]) && !empty($_POST["customerID"])){
    if($cond==''){
      $cond="Where";
    }
    else{
      $cond.=" && ";
    }
    if(!empty($_POST['customerID'])){
      $_SESSION['application']['post_customerID']=$_POST["customerID"];
    }
    
    $cond .= " c.customer_id='".$_SESSION['application']['post_customerID']."'";
    
}
else if(!isset($p_cond)|| $p_cond==''){
  unset($_SESSION['application']['post_customerID']);
}
  
if(isset($_POST["customerName"]) && !empty($_POST["customerName"])) {
  if($cond==''){
    $cond="Where";
  }
  else{
    $cond.=" && ";
  }
  if(!empty($_POST['customerName'])){
    $_SESSION['application']['post_customerName']=$_POST["customerName"];
  }
  
  $cond .= " c.name LIKE '%".$_SESSION['application']['post_customerName']."%'";
  
}
else if(!isset($p_cond)|| $p_cond==''){
  unset($_SESSION['application']['post_customerName']);
}

if(isset($_POST["mobile"]) && !empty($_POST["mobile"])){
  if($cond==''){
    $cond="Where";
  }
  else{
    $cond.=" && ";
  }
  if(!empty($_POST['mobile'])){
    $_SESSION['application']['post_mobile']=$_POST["mobile"];
  }
  
  $cond .= " c.mobile='".$_SESSION['application']['post_mobile']."'";
  
}
else if(!isset($p_cond)|| $p_cond==''){
  unset($_SESSION['application']['post_mobile']);
}

 if( (isset($_POST["dateFrom"]) && !empty($_POST["dateFrom"])) || (isset($_POST["dateTo"]) && !empty($_POST["dateTo"])) ) {
      if($cond==''){
        $cond="Where";
      }
      else{
        $cond.=" && ";
      }
      if(!empty($_POST['dateFrom'])){ 
        $_SESSION['application']['post_dateFrom']=$_POST["dateFrom"];
      }
      if(!empty($_POST['dateTo'])){ 
        $_SESSION['application']['post_dateTo']=$_POST["dateTo"];
      }

     $cond .= " ap.applied_date BETWEEN '".date("Y-m-d",strtotime($_POST["dateFrom"]))."' AND  '".date("Y-m-d",strtotime($_POST["dateTo"]))."'";
  }
  else if(!isset($p_cond)|| $p_cond==''){
    unset($_SESSION['application']['post_dateFrom']);
    unset($_SESSION['application']['post_dateTo']); 
  }



if((isset($_POST['status']) && !empty($_POST['status'])) || (isset($_POST['customerID']) && !empty($_POST['customerID'])) || (isset($_POST['customerName']) && !empty($_POST['customerName'])) || (isset($_POST['mobile']) && !empty($_POST['mobile'])) ){
    $_SESSION['application']['cond']=$cond; 
}
else{
 
    if(isset($p_cond) && !empty($p_cond)&& $p_cond>=1){
      $cond=$_SESSION['application']['cond'];   
    }
    else{
      unset($_SESSION['application']['cond']);
    }
    
}

  

//echo $_SESSION['application']['cond'].'<br/>'.$cond; exit;

//echo $post_customerName; exit;

$offset=($p-1)*$page;


// $query  = "select * from customer ".$cond." LIMIT ".$offset.", ".$page;
// $query  = "select * from customer c LEFT Join application ap on (c.customer_id=ap.customer_id) ".$cond." LIMIT ".$offset.", ".$page;
$query  = "select c.id, c.customer_id, c.name, c.mobile, c.email, c.pancard, c.dob, c.marital_status, c.education, c.total_experience, c.monthly_income, c.mother_name, c.father_name, c.residence_city, c.residence_pincode, c.residence_address, c.company_name, c.company_email_id, c.office_landline_no, c.designation, c.office_city, c.office_pincode, c.office_address, c.cibil_score, c.wishfin_score , c.image, ap.status, ap.sub_status, ap.loan_id, ap.role_id, ap.applied_date, ap.change_status_date  from customer c RIGHT Join application ap on (c.customer_id=ap.customer_id) ".$cond." ORDER BY c.customer_id LIMIT ".$offset.", ".$page;

$result = $con->query($query);
$employee_data  = array();
if($result->num_rows){
  while($row = $result->fetch_assoc()){
      $employee_data[] = $row;
  }
}

// var_dump($employee_data); die('-test');

//$query  = "select count(*) as size from customer ".$cond;
$query  = "select count(*) as size from customer as c right join application as ap on c.customer_id=ap.customer_id ".$cond;
$result = $con->query($query);
$employee_size = array();

if($result->num_rows){
  while($row = $result->fetch_assoc()){
      $employee_size = $row['size'];
  }
}


/*$query  = "SELECT id, status FROM `status`";
$result = $con->query($query);
$status  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $status[$row['id']] = $row['status'];
   }
}*/

// echo "<pre>";
// print_r($status); die;

$query  = "SELECT id, status FROM `main_lov`";
$result = $con->query($query);
$status  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $status[$row['id']] = $row['status'];
   }
}

 
$query  = "SELECT id,i_key,status FROM `main_lov`";
$result = $con->query($query);
$main_lov  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $main_lov[] = $row;
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
  <title>FLDG Employee Application</title>
   <style>
    .todate_error, .formdate_error {
        width: 100%;
        margin-top: .25rem;
        font-size: 80%;
        color: #dc3545;
      }
  </style>  
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
      <div class="row pd-t-32">
        <div class="col-12 pt-5 pb-4">
          <h2 class="dashboard-title">Application</h2>
          <?php
          if(isset($_SESSION['success']))
          {
          ?>
               <div class="alert alert-success" id="success_msg">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  <strong>Success!</strong> <?php echo $_SESSION['success']; ?>
              </div>
          <?php
           }
           unset($_SESSION['success']);
         ?>
        </div>
      </div>
      <div class="card">
        <!--<div class="card-header">
          <span class="card-title">Applications</span>
      </div>-->
        <div class="card-body">
          <div class="filter-box">
            <form id="filter-form-application" class="filter-form" action="employee-application.php" method="post">
              <div class="form-group select-field">
                  <select class="form-control" name="status">
                    <option value="" >Status</option>
                    <?php 
                              foreach ($main_lov as $value) { 
                            ?>
                    <option value="<?php echo $value['id'];?>" <?php if(isset($_SESSION['application']['post_status']) && $_SESSION['application']['post_status']=='1'){ echo " Selected"; } ?>><?php echo $value['status']; ?></option>
                    <?php
                              }
                    ?>
                    <!--<option value="2" <?php// if(isset($_SESSION['application']['post_status']) && $_SESSION['application']['post_status']=='2'){ echo " Selected"; } ?> >Pending</option>
                    <option value="3" <?php //if(isset($_SESSION['application']['post_status']) && $_SESSION['application']['post_status']=='3'){ echo " Selected"; } ?> >On Progress</option>-->
                  </select>
                  <span class="angledown"></span>
              </div>
              <div class="form-group input-group">
                  <input type="text" name="dateFrom" id="fromDate" class="form-control" placeholder="Date From" <?php if(isset($_SESSION['application']['post_dateFrom'])){ ?> value="<?php echo $_SESSION['application']['post_dateFrom']; ?>" <?php } ?> />
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                  </div>
                   <div class="formdate_error"></div>
              </div>
              <div class="form-group input-group">
                  <input type="text" name="dateTo"  id="toDate" class="form-control" placeholder="Date To" <?php if(isset($_SESSION['application']['post_dateTo'])){?> value="<?php echo $_SESSION['application']['post_dateTo']; ?>" <?php } ?> />
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                  </div>
                  <div class="todate_error"></div>
              </div>
              <div class="form-group">
                  <input type="tel" name="customerID" class="form-control" placeholder="Customer ID" <?php if(isset($_SESSION['application']['post_customerID'])){?> value="<?php echo $_SESSION['application']['post_customerID']; ?>" <?php } ?>/>
              </div>
              <div class="form-group">
                  <input type="tel" name="customerName" class="form-control" placeholder="Customer Name" <?php if(isset($_SESSION['application']['post_customerName'])){?> value="<?php echo $_SESSION['application']['post_customerName']; ?>" <?php } ?>/>
              </div>
              <div class="form-group">
                  <input type="tel" name="mobile" class="form-control" placeholder="Mobile" maxlength="10" <?php if(isset($_SESSION['application']['post_mobile'])){?> value="<?php echo $_SESSION['application']['post_mobile']; ?>" <?php } ?> />
              </div>
              <div class="form-group button-area">
                  <button type="submit" class="btn btn-success btn-raised" id='filter'>Filter</button>
              </div>
            </form>
          </div>
          <div class="filter-result">
            <div class="table-responsive">
                <table class="table table-borderless">
                  <thead>
                    <tr>
                      <th>Customer Name</th>
                      <th>Customer ID</th>
                      <th>PAN No.</th>
                      <th>Mobile No.</th>
                      <th>Applied Date</th>
                      <th>Status Change Date</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                   <?php foreach($employee_data as $employee_detail) { ?>
                    <tr>
                      <td><a href="application-profile.php?id=<?php echo $employee_detail['customer_id']; ?>"><?php echo $employee_detail['name']; ?></a></td>
                      <td><?php echo $employee_detail['customer_id']; ?></td>
                      <td><?php echo $employee_detail['pancard']; ?></td>
                      <td><?php echo $employee_detail['mobile']; ?></td>
                      <td>
                        <?php 
                          if(isset($employee_detail['applied_date'])){
                            echo $employee_detail['applied_date']; 
                          }else{
                            echo $employee_detail['applied_date'] = '';
                          }
                        ?>
                          
                      </td>
                      <td>
                        <?php 
                          if(isset($employee_detail['change_status_date'])){
                            echo $employee_detail['change_status_date']; 
                          }else{
                            echo $employee_detail['change_status_date'] = '';
                          }
                        ?>
                        
                      </td>
                      <td><?php echo $status[$employee_detail['status']]; ?></td>
                    </tr>

                    <?php } ?>
                  </tbody>
                </table>

              </div>
      <?php 
        $total_record  = $employee_size;
        if($total_record>$page){
      ?>

              <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                      <li class="page-item <?php if($p<=1){ echo 'disabled'; } ?> ">
                        <a class="page-link" href="?p=<?php echo $p-1;?>"  tabindex="-1">Previous</a>
                      </li>
                      <?php
                         $perpage_record  = $total_record/$page;
                         if($total_record%$page!=0){
                            $perpage_record++;
                         } 
                      
                         if($p+$page>$perpage_record){
                            $len=$perpage_record;
                         }
                         else{
                            $len=$p+$page;
                         }

                         if($len-$p<$page){ 
                            $start=1;
                         }
                         else{
                            $start=$p;
                         }

                        for($i=$start;$i<=$len;$i++)
                        {
                      ?>
                      <li class="page-item <?php if(isset($p) && $i==$p){echo "active"; } ?> "><a class="page-link" href="?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                       <?php
                         }
                       ?>
                      <li class="page-item <?php if($p>=$perpage_record-1){ echo 'disabled'; } ?>" >
                        <a class="page-link" href="?p=<?php echo $p+1;?>">Next</a>
                      </li>
                    </ul>
              </nav>

        <?php 
            }
        ?>
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
  <script src="js/dashboard.js"></script>
</body>

</html>

<script type="text/javascript">
  
  $(function(){
      $('#success_msg').delay(3000).fadeOut();
    });
  

   $(document).ready(function(){
        $('#filter').click(function(){
            var fromDate  = $('#fromDate').datepicker('getDate');
            var toDate  =   $('#toDate').datepicker('getDate');

            $('#fromDate').removeClass('is-invalid');
            $('#toDate').removeClass('is-invalid');
             
            $('.formdate_error').text('');
            $('.todate_error').text('');

            
            if(fromDate == null && toDate != null){
                //alert('Form Date is requird');
                $('.formdate_error').text('From Date fields requird');
                $('#fromDate').addClass('is-invalid');
                event.preventDefault();
            }
            if(toDate == null && fromDate != null){
                  //alert('To Date is requird');
                $('.todate_error').text('To Date fields requird');
                $('#toDate').addClass('is-invalid');
                event.preventDefault();
            }
             
              
        }); 

    });
</script>
