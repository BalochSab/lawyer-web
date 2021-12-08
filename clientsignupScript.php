<?php
include("connection.php");
$err = array('username' => '', 'email' => '', 'pass' => '', 'mbl' => '', 'wrong' => '');
$email = $pass = $username = $mbl = '';
if (isset($_POST['signup'])) {
    if (empty($_POST["username"])) {
        $err['username'] = "User Name is required!";
    } else {

        if (!preg_match("/^[0-9a-zA-Z-_']*$/", $_POST["username"])) {
            $err['username'] = "Only letters and '_' allowed";
        } else {
            $username = htmlspecialchars($_POST["username"]);
        }
    }
    if (empty($_POST["email"])) {
        $err['email'] = "Email is required!";
    } else {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $err['email'] = "Invalid email format";
        } else {
            $email = htmlspecialchars($_POST["email"]);
        }
    }
    if (empty($_POST["pass"])) {
        $err["pass"] = "Password is required!";
    } else {
        $pass = htmlspecialchars($_POST["pass"]);
    }
    if (empty($_POST["mbl"])) {
        $err['mbl'] = "Moble Number is required!";
    } else {
        if (!preg_match("/^[0-9]{11}$/", $_POST["mbl"])) {
            $err['mbl'] = "Only letters and 11 numbers allowed";
        } else {
            $mbl = htmlspecialchars($_POST["mbl"]);
        }
    }
    
    $email_check_query = mysqli_query($con, "SELECT * FROM user WHERE user_name = '{$username}'; ");
    $UserNamerowCount = mysqli_num_rows($email_check_query);
    $email_check_query = mysqli_query($con, "SELECT * FROM user WHERE email = '{$email}'; ");
    $EmailrowCount = mysqli_num_rows($email_check_query);

    if (!array_filter($err)) {
        if ($EmailrowCount > 0) {
            $err['email'] = 'User with email already exist!';
        } else if ($UserNamerowCount > 0) {
            $err['username'] = 'User Name already exist!';
        } else {
            $sql_check = "INSERT INTO user(user_name,email,password,mobile,userType,datetime) VALUES ('{$username}', '{$email}',  '{$pass}', 
                '{$mbl}','client', now())";
            $result = mysqli_query($con, $sql_check) or die(mysqli_error($con));
            // $ch = mysqli_num_rows($result) or die("num row error: ".mysqli_error($con));
            if ($result) {
                header("Location:success.php");
            } else {
                $pass = '';
                $err["wrong"] = "<div class='alert alert-danger'><i class='fas fa-exclamation-circle'></i>Username or Password is incorrect!</div>";
            }
        }
    }
}

?>
