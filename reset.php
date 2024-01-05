<?php include "includes/header.php";
$error = '';
if (isset($_GET['token']) && isset($_GET['email'])) {
 $email = $_GET['email'];
 $token = $_GET['token'];
 $stmt = $connection->prepare("SELECT * FROM users WHERE user_email = ?");
 $stmt->bind_param("s", $email);
 $stmt->execute();
 $result = $stmt->get_result();
 $row = mysqli_fetch_assoc($result);
 $user_name = $row['user_name'];
 $user_token = $row['user_token'];
 $user_email = $row['user_email'];
 if ($user_name) {
  if ($user_token === $token && $user_email === $email) {
   if (request_method_exists('post') && isset($_POST['reset-password'])) {
    $confirmPassword = $_POST['confirmPassword'];
    $password = $_POST['password'];
    if (!$confirmPassword || !$password) {
     $error = 'Fields can not be empty!';
    } else {
     if ($confirmPassword !== $password) {
      $error = 'Fields are not the same.';
     } else {
      $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
      $stmt = $connection->prepare("UPDATE users SET user_password = ? , user_token='' WHERE user_email= ?");
      $stmt->bind_param('ss', $password, $email);
      $stmt->execute();
      if ($stmt->affected_rows > 0) {
       redirect('/portfolio/login');
      }
      $stmt->close();
      $connection->close();
     }
    }
   }
  } else {
   redirect('/portfolio');
  }
 } else {
  redirect('/portfolio');
 }
 $stmt->close();
 $connection->close();
} else {
 redirect('/portfolio');
}
?>
<!-- Page Content -->
<div class="container">

 <div class="form-gap"></div>
 <div class="container">
  <div class="row">
   <div class="col-md-4 col-md-offset-4">
    <div class="panel panel-default">
     <div class="panel-body">
      <div class="text-center">
       <h3><i class="fa fa-lock fa-4x"></i></h3>
       <h2 class="text-center">Reset Password</h2>
       <p>You can reset your password here.</p>
       <div class="panel-body">
        <form id="register-form" role="form" autocomplete="off" class="form" method="post">

         <div class="form-group">
          <div class="input-group">
           <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
           <input id="password" name="password" placeholder="Enter password" class="form-control" type="password">
          </div>
         </div>
         <div class="form-group">
          <div class="input-group">
           <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
           <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control" type="password">
          </div>
         </div>
         <div class="form-group">
          <input name="reset-password" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
         </div>
         <p class='text-danger text-left'><?php echo $error; ?></p>


         <input type="hidden" class="hide" name="token" id="token" value="">
        </form>

       </div><!-- Body-->

      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
 <hr>

 <?php include 'includes/footer.php'; ?>

</div> <!-- /.container -->