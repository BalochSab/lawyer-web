<?php 
if (isset($_SESSION["userType"])) {

    if ($_SESSION['userType']=='lawyer') {
        header("location:lawyerpanel.php");
    }else if($_SESSION['userType']=='client'){
        header("location:index.php");
    }else if($_SESSION['userType']=='admin'){
        header("location:index.php");
    }
    
}else{

include("lawyersignupScript.php");
include_once("header.php"); ?>
<br><br>
<div class="main-wrapper  account-wrapper">
    <div class="account-page">
        <div class="account-center">
            <div class="account-box">
            <form action="" method="POST" class="form-signin">
            <div class="account-logo">
                <a href="index.php"><img src="assets/img/logo1.png" alt=""></a>
                <h2>Lawyer Web</h2>
            </div>
            <?php echo $err['wrong']; ?>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username ;?>" class="form-control">
                <div class="text-danger"> <?php echo $err['username']; ?></div>
            </div>
           

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="<?php echo $email; ?>" class="form-control">
                <div class="text-danger"><?php echo $err['email']; ?></div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="pass" class="form-control">
                <div class="text-danger"><?php echo $err['pass']; ?></div>
            </div>
            
            <div class="form-group">
                <label>Mobile Number</label>
                <input type="text" name="mbl"  value="<?php echo $mbl?>" class="form-control">
                <div class="text-danger"><?php echo $err['mbl']; ?></div>
            </div>
            


            <div class="form-group text-center">
                <button class="btn btn-primary account-btn" name="next" type="submit">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
            <div class="text-center login-link">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </form>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php");
} ?>