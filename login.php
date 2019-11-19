<?php
 session_start();
 include('db.php');

$query  = "SELECT id,role_name FROM `user_role` WHERE status=1";
$result = $con->query($query);
$user_role  = array();
if($result->num_rows){
   while($row = $result->fetch_assoc()){
      $user_role[] = $row;
   }
}

// var_dump($user_role); die('-test');

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
  <link rel="stylesheet" href="css/login.css">
  <style>
    .loginid_error, .password_error {
        width: 100%;
        margin-top: .25rem;
        font-size: 80%;
        color: #dc3545;
      }
  </style>  
  <title>FLDG Login</title>
</head>

<body>
  <div class="container-fluid login-wrapper">
    <div class="login-wrapper-content">
      <div class="row login-wrapper-row">
        <div class="col-md-6 intro-col">
          <div class="site-logo">
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
          </div>

        </div>
        <div class="col-md-6 lead-col">
            <div class="login-container text-center">
                <h2>EMPLOYEE LOGIN</h2>
               <?php 
                if(isset($_SESSION['error']))
                 {
                  ?>
                     <div class="alert alert-danger" id="error_msg">
                       <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> <?php echo $_SESSION['error']; ?>
                    </div>
                  <?php
                  }
                  unset($_SESSION['error']);
                  ?>
                <p>Please login to your account.</p>
                <form id="login-form" action="form_action/login.php" method="post" onsubmit="return LoginValidation();">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                          <input type="email" class="form-control <?php echo ($err_email) ? 'is-invalid' : '' ?>"  name="loginID" id="loginID" placeholder="Login ID"/>
                          <div class="loginid_error"></div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                          <input type="password" class="form-control <?php echo ($err_password) ? 'is-invalid' : '' ?>" name="loginPassword" id="loginPassword" placeholder="Password"/>
                          <div class="password_error"></div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">                          
                          <select class="form-control" name="user_role_id" id="user_role_id" required>
                            <option value="">--Select Role--</option>
                            <?php
                              foreach ($user_role as $value) { 
                            ?>
                                <option value="<?php echo $value['id'];?>"> <?php echo $value['role_name']; ?></option>
                            <?php
                              }
                            ?>
                          </select>
                          <div class="user_role_error"></div>
                      </div>
                    </div>
                  </div>

                <p class="button-area">
                  <button class="btn btn-success" name="submit">Login</button>
                </p>
                </form>
            </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="js/jquery-3.2.1.js"></script>
  <script src="js/1.12.1-jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <script src="js/jquery.validate.js"></script>
 <!-- <script src="js/login.js"></script>-->
</body>

</html>
<script>

$(function(){
  $('#error_msg').delay(3000).fadeOut();
});

 // *********** Function if login id and password is blank ************ 
  
  function LoginValidation(){
      $('#loginID').removeClass('is-invalid');
      $('#loginPassword').removeClass('is-invalid');
      $('#user_role_id').removeClass('is-invalid');
      $('.loginid_error').text('');
      $('.password_error').text('');
      $('.user_role_error').text('');
      var email = $("#loginID").val();
      var password = $("#loginPassword").val();
      var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

      if(email ==''){
        $('#loginID').addClass('is-invalid');
        $('.loginid_error').text('Login id field not blank.');
        $('#loginID').focus();
        return false;
      }
      if(password ==''){
        $('#loginPassword').addClass('is-invalid');
        $('.password_error').text('Password field not blank.');
        $('#loginPassword').focus();
        return false;
      }
      if(user_role_id ==''){
        $('#user_role_id').addClass('is-invalid');
        $('.user_role_error').text('Please select role field.');
        $('#user_role_id').focus();
        return false;
      }

      if(!pattern.test(email)){
        $('#loginID').addClass('is-invalid');
        $('.loginid_error').text('Login id not valid.');
        $('#loginID').focus();
        return false; 
      }

  }
</script>

