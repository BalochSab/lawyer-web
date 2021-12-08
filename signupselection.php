
<?php
include("header.php");

include("connection.php");

$user_Id = $_GET['userId'];
// $user_Id = 29;
$sql = "SELECT user_id, user_name,userType,email,mobile,first_name,last_name,gender,dob,qualification,Biography,img,service_name,country_name,city_name FROM user 
	LEFT JOIN user_details ON user.user_id = user_details.user_fk_id 
	LEFT JOIN servicelist ON user_details.service_id = servicelist.service_id
	LEFT JOIN country ON user_details.country_id = country.country_id
	LEFT JOIN city ON  user_details.city_id = city.city_id WHERE user_id = $user_Id";

$sql_date = mysqli_query($con, $sql) or die("query field" . mysqli_error($con));
$find = mysqli_num_rows($sql_date);

$show = mysqli_fetch_assoc($sql_date) or die("Fatch :".mysqli_error($con));

if (mysqli_num_rows($sql_date) > 0) {
	echo $show['user_id']."<br>";
	echo $show['user_name']."<br>";
	echo $show['email']."<br>";
	echo $show['mobile']."<br>";
	echo $show['first_name']."<br>";
	echo $show['last_name']."<br>";
	echo $show['gender']."<br>";
	echo $show['dob']."<br>";
	echo $show['qualification']."<br>";
	echo $show['Biography']."<br>";
	echo $show['img']."<br>";
	echo $show['service_name']."<br>";
	echo $show['country_name']."<br>";
	echo $show['city_name']."<br>";
}

	?>