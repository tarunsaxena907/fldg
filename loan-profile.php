<?php
  session_start();
  if (isset($_SESSION['user_id']) == false) {
   header('Location:login.php');  
  }
    include('db.php');
   $customer_id = $_GET['id'];


$query  = "select * from customer where customer_id=". $customer_id;
$result = $con->query($query);
$profile_data  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $profile_data[] = $row;  
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
            <a class="navbar-brand" href="/customer-dashboard">
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
                    <span>Customer ID : <?php echo  $profile_data[0]['customer_id']; ?></span>
                  </div>
                </div>
                <div class="col-md-5 d-flex align-items-center justify-content-end">
                  <div class="filter-box profile-filter-box">
                    <img src="images/bank_images/bank_logo.png" alt="fullerton"/>
                  </div>
                </div>
              </div>
              <div class="keyval-unit-box col-12">
                <div class="row">
                  <div class="col-md-4 col-lg-2 col-6">
                    <label>Loans</label>
                    <span>&#8377; <?php echo $profile_data[0]['loan_amount']; ?></span>
                  </div>
                  <div class="col-md-4 col-lg-2 col-6">
                    <label>Tenure</label>
                    <span class="ng-binding"><?php echo $profile_data[0]['tenure']; ?></span>
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
          <div class="row collapse show-content mt-5" id="show-content">
            <div class="col-12">
              <h3>PERSONAL INFORMATION</h3>
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
                          <span><?php echo $profile_data[0]['marital_status']; ?></span>
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
            </div>
          </div>
        </div>
        <div class="card-footer text-center py-4 bg-white">
          <span class="show-toggle text-secondary" data-toggle="collapse" data-target="#show-content">Show More</span>
        </div>
      </div>
      <div class="card mt-5">
        <?php
        $loan_amount = $profile_data[0]['loan_amount'];//principal amount
        $loan_roi = $profile_data[0]['roi'];//months
        $percentage_rate = 10;
        $interest =$percentage_rate/ 1200; //get percentage
        $loan_emi= round($loan_amount * $interest / (1 - (pow(1/(1 + $interest), $loan_roi)))); # This for total EMI
        $total_interest= ceil(($loan_amount * $interest / (1 - (pow(1/(1 + $interest), $loan_roi))))*$loan_roi) - $loan_amount; # This is for Total interest
        $total_payment =  $loan_amount + $total_interest;
        ?>
      <div class="card-body">
        <!-- Tab panes -->
        <div class="tab-content loan-breakup-content">
         <div class="tab-pane container active">
           <h2 class="text-center mb-5 font-weight-boldlight">Break up of Total amount</h2>
           <div class="row align-items-center my-5">
             <div class="col-lg-10 offset-lg-1">
               <div class="row">
                 <div class="col-lg-7">
                   <div id="loan-break-chart"></div>
                 </div>
                 <div class="col-lg-5">
                   <div class="emi-summary">
                     <div class="emi-summary-item emi-amount">
                       <h4><i class="fa fa-inr" aria-hidden="true"></i><?php echo $loan_emi;?></h4>
                       <p>Loan EMI</p>
                     </div>
                     <div class="emi-summary-item emi-totalinterest">
                       <h4><i class="fa fa-inr" aria-hidden="true"></i><?php echo $total_interest;?></h4>
                       <p>Total Interest Payable</p>
                     </div>
                     <div class="emi-summary-item emi-totalamount">
                       <h4><i class="fa fa-inr" aria-hidden="true"></i><?php echo $total_payment;?></h4>
                       <p>Total Payment (Principal + Interest)</p>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
            <div id="loan-details">
                    <?php
                        $balance = (float) $loan_amount;
                        $monthly_payment = (($percentage_rate /(100 * 12)) * $balance) / (1 - pow(1 + $percentage_rate / 1200,  (-$loan_roi)));
                    ?>
                    <div class="table-responsive">
                    <table class="table table-borderless emi-table">
                        <tbody>
                            <tr>
                                <th>EMI Number</th>
                                <th>Date</th>
                                <th>Principal (A)</th>
                                <th>Interest (B)</th>
                                <th>Total Payment (A +B)</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                            <?php
                            $date = '2019-11-18';
                            for($month = 0; $month < (int)$loan_roi; $month++) {
                                $interest = $balance * $percentage_rate / 1200;
                                $principal = $monthly_payment - $interest;
                            ?>
                            <tr>
                              <td>
                              <?php echo $month + 1 ?></td>
                              <td>
                              <?php 
                                echo $date = date ("Y-m-d", strtotime("1 month", strtotime($date)));
                              ?>
                              </td>
                                <td><i class="fa fa-inr" aria-hidden="true"></i><?php echo number_format($principal, 0) ?></td>
                                <td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo number_format($interest, 0) ?></td>
                                <td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo number_format($monthly_payment, 0) ?></td>
                                <td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo number_format($balance, 0) ?></td>
                                <td>Active</td>
                            </tr>
                            <?php
                                $balance -= $principal;
                            } 
                            ?>
                        </tbody>
                    </table>
                  </div>
                </div>
         </div><!--loan breakup-->
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
  <script src="js/highchart.js"></script>

  <script src="js/jquery.validate.js"></script>
  <script src="js/dashboard.js"></script>
</body>

</html>
