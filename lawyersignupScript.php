
<?php
include('navbar.php');
include("connection.php");
$err = array('username' => '', 'email' => '', 'pass' => '', 'mbl' => '', 'wrong' => '');
// user table
$email = $pass = $username = $mbl = '';


if (isset($_POST['next'])) {

    //for user Table in database
    if (empty($_POST["username"])) {
        $err['username'] = "<div class='text-danger'>User Name is required!</div>";
    } else {

        if (!preg_match("/^[a-zA-Z][a-zA-Z0-9-_.]{1,50}$/", $_POST["username"])) {
            $err['username'] = "<div class='text-danger'>Only letters , numbers and '_' '.' allowed</div>";
        } else {
            $username = htmlspecialchars($_POST["username"]);
        }
    }

    if (empty($_POST["email"])) {
        $err['email'] = "<div class='text-danger'>Email is required!</div>";
    } else {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $err['email'] = "<div class='text-danger'>Invalid email format</div>";
        } else {
            $email = htmlspecialchars($_POST["email"]);
        }
    }

    if (empty($_POST["pass"])) {
        $err["pass"] = "<div class='text-danger'>Password is required!</div>";
    } else {
        $pass = htmlspecialchars($_POST["pass"]);
    }

    if (empty($_POST["mbl"])) {
        $err['mbl'] = "<div class='text-danger'>Moble Number is required!</div>";
    } else {

        if (!preg_match("/^[0-9]{11}$/", $_POST["mbl"])) {
            $err['mbl'] = "<div class='text-danger'>Only letters and 11 numbers allowed</div>";
        } else {
            $mbl = htmlspecialchars($_POST["mbl"]);
        }
    }

    // check if UserName already exist
    $email_check_query = mysqli_query($con, "SELECT * FROM user WHERE user_name = '{$username}'; ");
    $UserNameExist = mysqli_num_rows($email_check_query);

    // check if email already exist
    $email_check_query = mysqli_query($con, "SELECT * FROM user WHERE email = '{$email}'; ");
    $Emailexist = mysqli_num_rows($email_check_query);


    if (!array_filter($err)) {

        if ($Emailexist > 0) {
            $err['email'] = 'User with email already exist!';
        } else if ($UserNameExist > 0) {
            $err['username'] = 'User Name already exist!';
        } else {
            $sql_user = "INSERT INTO user(user_name,email,password,mobile,userType,datetime) VALUES ('{$username}', '{$email}',  '{$pass}', 
                '{$mbl}','lawyer', now())";

            $result = mysqli_query($con, $sql_user) or die(mysqli_error($con));
            
            if ($result) {

                header("Location:lawyerSingupDetails.php?username={$username}&email={$email}");

            } else {
                $err["wrong"] = "<div class='alert alert-danger'><i class='fas fa-exclamation-circle'></i> Something went wront Sign Up failed try again!</div>";
            }
        }
    }
}
