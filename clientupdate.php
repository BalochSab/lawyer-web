<?php
include("navbar.php");
if (!isset($_SESSION["userType"])) {
    header("Location:index.php");
}else
{
    include('header.php');
    include("connection.php");
    $err = array('username' => '', 'email' => '', 'pass' => '', 'mbl' => '', 'wrong' => '');
    $email = $pass = $username = $mbl = '';
    $user_id = $_SESSION["user_id"];

    $sql_update = "Select * FROM user WHERE user_id = {$user_id};";

    $get_date_update = mysqli_query($con,$sql_update) or die($con);

    $fatch_date = mysqli_fetch_assoc($get_date_update);

    $username = $fatch_date["user_name"];
    $email = $fatch_date["email"];
    $mbl = $fatch_date["mobile"];
    $pass = $fatch_date['password'];
    $valid = true;
    if (isset($_POST['update'])) {

        if (empty($_POST["pass"])) {
            $err["pass"] = "Password is required!";
            $valid= false;
        } else {
            $pass = htmlspecialchars($_POST["pass"]);
        }
        if (empty($_POST["mbl"])) {
            $err['mbl'] = "Moble Number is required!";
            $valid= false;
        } else {
            if (!preg_match("/^[0-9]{11}$/", $_POST["mbl"])) {
                $err['mbl'] = "Only letters and 11 numbers allowed";
                $valid= false;
            } else {
                $mbl = htmlspecialchars($_POST["mbl"]);
            }
        }
        

        if ($valid == true) {
            
             
            $sql_update = "UPDATE  user SET user_name = '$username' ,email = '$email',password=$pass,mobile=$mbl WHERE user_id = $user_id";
                $result = mysqli_query($con, $sql_update) or die(mysqli_error($con)) ;

                
                if ($result) {
                    header("Location:Profile.php");
                } else {
                    $err["wrong"] = "<div class='alert alert-danger'><i class='fas fa-exclamation-circle'></i>Username or Password is incorrect!</div>";
                }
            }
        }
    ?>

    <div class="main-wrapper  account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                <form action="" method="POST" class="form-signin">
                <div class="account-logo">
                    <<a href="index.php"><img src="assets/img/logo1.png" alt=""></a>
                    <h2>Lawyer Web</h2>
                </div>
                <?php echo $err['wrong']; ?>
                <div class="form-group">
                    <label>Username</label>
                    <div class="h4 text-center"><?php echo $username; ?></div>
                </div>
            

                <div class="form-group">
                    <label>Email Address</label>
                    <div class="h4 text-center"><?php echo $email; ?></div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="pass" value="<?php echo $pass;?>" class="form-control">
                    <div class="text-danger"><?php echo $err['pass']; ?></div>
                </div>
                
                <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="text" name="mbl"  value="<?php echo $mbl?>" class="form-control">
                    <div class="text-danger"><?php echo $err['mbl']; ?></div>
                </div>
                


                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" name="update" type="submit">Update</button>
                    <a class="btn btn-danger account-btn" href="Profile.php" >Cancile</a>
                </div>
                
            </form>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include_once("footer.php");

}?>