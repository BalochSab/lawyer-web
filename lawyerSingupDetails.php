<?php 
if (isset($_GET['username']) && !isset($_SESSION['userType'])) {
// include("lawyerSingupDetails.php");

include("connection.php");
$err = array('firstname' => '','lastname' => '',   'gender' => '',
            'dob' => '', 'country' => '',
            'city' => '','service' => '',
            'bio' => '','ext' => '',
            'qualification'=>'','wrong' => '');
    
// user detail table        $date = date('Y-m-d H:i:s');/
$username = $firstname = $lastname = $dob = $gender = $qualification = $country = $city = $service = $bio = $user_fk_id = '';
$username = $_GET['username'];
        $get_userId_query = mysqli_query($con, "SELECT user_id FROM user WHERE user_name = '{$username}';") or die(mysqli_error($con));
        if ($get_userId_query) {
            $_userId = mysqli_fetch_assoc($get_userId_query) or die(mysqli_error($con));
            $user_fk_id = $_userId["user_id"];
        }
        
if (isset($_POST['signup'])) {
        $username = $_GET['username'];
        //for use_detail Table in Database
        if (empty($_POST["firstname"])) {
            $err['firstname'] = "<div class='text-danger'>First Name is required!</div>";
        } else {

            if (!preg_match("/^[a-zA-Z- ']*$/", $_POST["firstname"])) {
                $err['firstname'] = "<div class='text-danger'>Only letters allowed</div>";
            } else {
                $firstname = htmlspecialchars($_POST["firstname"]);
            }
        }
        if (empty($_POST["lastname"])) {
            $err['lastname'] = "<div class='text-danger'>Last Name is required!</div>";
        } else {

            if (!preg_match("/^[0-9a-zA-Z- ']*$/", $_POST["lastname"])) {
                $err['lastname'] = "<div class='text-danger'>Only letters  allowed</div>";
            } else {
                $lastname = htmlspecialchars($_POST["lastname"]);
            }
        }
        if (empty($_POST["dob"])) {
            $err['dob'] = "<div class='text-danger'>Date Of Birth is required!</div>";
        } else {
            $datepiker = htmlspecialchars($_POST["dob"]);
            $dob  = date('Y-m-d',($datepiker));
                
        }
        if (empty($_POST["gender"])) {
            $err['gender'] = "<div class='text-danger'>Gender is not Selected!</div>";
        } else {
                $gender = $_POST["gender"];
        }
        if (empty($_POST["qualification"])) {
            $err['qualification'] = "<div class='text-danger'>Qualification is required!</div>";
        } else {

            if (!preg_match("/^[a-zA-Z][a-zA-Z0-9-_.]{1,50}$/", $_POST["qualification"])) {
                $err['qualification'] = "<div class='text-danger'>Only letters , numbers and '_' '.' allowed</div>";
            } else {
                $qualification = $_POST["qualification"];
            }
        }
        if (empty($_POST["country"])) {
            $err['country'] = "<div class='text-danger'>Country is not selected!</div>";
        } else {
                $country = $_POST["country"];
        }
        if (empty($_POST["city"])) {
            $err['city'] = "<div class='text-danger'>City is not selected!</div>";
        } else {
                $city = $_POST["city"];
        }
        if (empty($_POST["service"])) {
            $err['service'] = "<div class='text-danger'>Service is not selected!</div>";
        } else {
                $service = $_POST["service"];
        }

        if (empty($_POST["bio"])) {
            $err['bio'] = "<div class='text-danger'>Short Biography is required!</div>";
        } else { 
            // if (!preg_match("/^[a-zA-Z0-9- ]{10,500}$/", $_POST["bio"])) {
            //     $err['bio'] = "<div class='text-danger'>Only 50 to 500 letters , numbers and '_' , '.'  allowed</div>";
            // } else {
                // $bio = htmlspecialchars($_POST["bio"]);
                
            // }
                // $bio = $_POST["bio"];
        }
        
        
        $img = $_FILES["img"]["name"]; 
        $tmpname = $_FILES["img"]["tmp_name"]; 
        $img_name = '';

        if ($img == '') {
            $img_name = "defalt.png";
        }else {

            $dot = ".";
            $break = explode($dot,$img);
            $file_end_part = strtolower(end($break));		
            
            $exten = array("jpg","png","jpeg");
            
            if(in_array($file_end_part,$exten) == false)
            {
                $err['ext'] = "Please Select Picture Only Not Any Other File.....";
            }
            else
            {
                $img_name = rand().".".$file_end_part;
            }
        }

        // get user id from first lawyer sign up
        
        if (!array_filter($err)) {

            $sql_details = "INSERT INTO user_details(first_name,last_name,gender,dob,qualification,Biography,img,user_fk_id,country_id,city_id,service_id) ";
            $sql_details .= "VALUES ('$firstname','$lastname','$gender','$dob','$qualification','$bio','$img_name','$user_fk_id','$country','$city','$service');";
            
            $ins_det = mysqli_query($con, $sql_details) or die("last Error".mysqli_error($con));
            // $num = mysqli_num_rows($ins_detail) or die("last Num".mysqli_error($con));
            
            // if ($ins_det==true) {
                
                if ($img != "defalt.png") {

                move_uploaded_file($tmpname,"./assets/img/upload/".$img_name);//here we upload in folder
                header("Location:success.php");
                    
                }else{
                    $err["wrong"] = "image not uploaded";
                }
                
                
            // }else {
            //     $err["wrong"] = "<div class='alert alert-danger'><i class='fas fa-exclamation-circle'></i>Sing Up Fail! There is mistack with in textboxs!</div>";
            // }
                    
        }

    }
include_once("header.php");

 ?>
<br><br>
<div class="content container card ">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 card text-center bg-primary ">
            <br>
            <h4 class="page-title text-white">Lawyer Detail</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 offset-lg-2 ">
            <form method="post" enctype="multipart/form-data">

                <!-- img upload  -->
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="input-group col-md-4 text-center">
                        <div class="a">
                            <!-- <i class="fa fa-close close remove"></i> -->
                            <label class="imgdiv">
                                <img ID="impPrev" for="file" class="contactForm  rounded-circle  mx-auto d-block " src="assets/img/upload/defalt.png" />
                                <input type="file" name="img" id="file" class="inputfile text-center" onchange="ShowPreview(this);" />
                                <!-- <span class="fa fa-upload textdown" aria-hidden="true" id="textch">Upload Image</span> -->
                            </label>
                        </div>
                        <div class="text-danger"><?php echo $err['ext']; ?></div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row">
                <div class="col-ms-12 col-md-12">
                    <?php echo "<br>".$err['wrong']."<br>";  ?>
                </div>
                </div>
                <!-- ---------------------------------------- -->
                <div class="row">
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="firstname" value="<?php echo $firstname; ?>" type="text">
                            <?php echo $err['firstname']; ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input class="form-control" name="lastname" value="<?php echo $lastname; ?>" type="text">
                            <?php echo $err['lastname']  ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <div class="cal-icon">
                                <input type="date" name="dob" value="<?php echo $dob; ?>" class="form-control ">
                                <?php echo $err['dob']  ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group gender-select">
                            <label class="gen-label">Gender:</label>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" name="gender" class="form-check-input" <?=$gender=="male" ? "checked" : ""?>  value="male">Male
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                <input type="radio" name="gender" class="form-check-input" <?=$gender=="female" ? "checked" : ""?> value="female">Female
                                </label>
                            </div>
                        </div>
                        <? echo $err['gender']  ?>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Service</label>
                                    <select class="form-control select select2-hidden-accessible" name="service" tabindex="-1" aria-hidden="true">
                                    <option value="" selected>Select Service</option>
                                    <?php 
                                    
                                        $serviceSelect = "SELECT * FROM servicelist";
                                        $serviceDb = mysqli_query($con, $serviceSelect) or die("Query Feil ".mysqli_error($con));
                                        while($srow = mysqli_fetch_assoc($serviceDb) ){
                                            if ($srow["service_id"]==$service) {
                                                $selected = "Selected";
                                            }else{
                                                $selected = "";
                                            }
                                            
                                            echo "<option {$selected} value='{$srow["service_id"]}'>{$srow['service_name']}</option>";
                                            }
                                    ?>

                                    </select>
                                    <?php echo $err['service']  ?>
                                </div>

                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select id="country" class="form-control select select2-hidden-accessible" name="country" tabindex="-1" aria-hidden="true">
                                    <option value="" selected>Select Country</option>
                                    <?php 
                                        $countrySelect = "SELECT * FROM country";
                                        $countryDb = mysqli_query($con, $countrySelect) or die("Query Feil");
                                        while($countrow = mysqli_fetch_assoc($countryDb) ){
                                            if ($countrow["country_id"]==$country) {
                                                $selected = "Selected";
                                            }else{
                                                $selected = "";
                                            }
                                            echo "<option {$selected} value='{$countrow["country_id"]}'>{$countrow['country_name']}</option>";
                                            }
                                    ?> 
                                    </select>
                                    <?php echo $err['country']  ?>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>city</label>
                                    <select class="form-control select select2-hidden-accessible" id="city" name="city" tabindex="-1" aria-hidden="true">
                                        <option value="" selected >Select City</option>
                                        
                                    </select>
                                    <?php echo $err['city']  ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Qualification</label>
                            <input class="form-control" type="text" name="qualification" value="<?php echo $qualification; ?>">
                            <?php echo $err['qualification']  ?>
                        </div>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label>Short Biography</label>
                    <textarea class="form-control" rows="3" name="bio" cols="30"><?php echo $bio; ?></textarea>
                    <?php echo $err['bio']  ?>
                </div>
                <div class="m-t-20 text-center">
                    <button class="btn btn-primary submit-btn" id="signup" name="signup">Sign Up</button>
                </div>
                <br><br>
            </form>
        </div>
    </div>
</div>
<br><br>

<script>
    $(document).ready(function(){
        
        $( "#country").change(function () {
            var countryID = $(this).val();

            if(countryID > 0) {

                $.post('citydata.php', {'country_id': countryID }, function(data) {
                    $('#city').html('<option value="" selected>Select City</option>');
                    $('#city').html(data); // I change this part
                });

            }else{
                $("#city").html('<option value="" selected>Select City</option>');
            }
        });

        $("#signup").click(function (e) {
            e.defaultPrevented();
            var countryID = $("#country").val();
            var cityID = $("#city").val();
            if(countryID > 0) {

                $.post('citydata.php', {'country_id': countryID ,'city_id': cityID }, function(data) {
                    $('#city').append(data); // I change this part
                    // alert(data);
                });

            }else{
                $("#city").append('<option value="" selected>Select City</option>');
            }
        });

});
</script>
<?php include("footer.php");
}else{
    header("Location:error-404.php");
} ?>