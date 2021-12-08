<?php 

if (isset($_SESSION['userType']) && $_SESSION['userType']=='lawyer') {

    
    $err = array('firstname' => '','lastname' => '',
            'gender' => '', 'mbl'=>'',
            'dob' => '', 'country' => '',
            'city' => '','service' => '',
            'bio' => '','ext' => '',
            'qualification'=>'','wrong' => '');
    
// user detail table        $date = date('Y-m-d H:i:s');/
    $username = $firstname = $lastname = $dob = $gender = $qualification = $country = $city = $service = $bio = $user_fk_id = '';
    // user_id, user_name,userType,email,mobile,first_name,last_name,gender,dob,qualification,Biography,img,service_id,country_id,city_id
    $sql_get_lawyer = "SELECT * FROM user 
    INNER JOIN user_details ON user.user_id = user_details.user_fk_id 
    INNER JOIN servicelist ON user_details.service_id = servicelist.service_id
    INNER JOIN country ON user_details.country_id = country.country_id
    INNER JOIN city ON  user_details.city_id = city.city_id WHERE user_id = $user_Id";
    $run_get_lawyer = mysqli_query($con,$sql_get_lawyer);

    $FachLaw = mysqli_fetch_assoc($run_get_lawyer);
    // $username = $FachLaw['user_name'];
    $firstname =  $FachLaw['first_name'];
    $lastname = $FachLaw['last_name'];
    $dob = $FachLaw['dob'];
    $qualification = $FachLaw['qualification'];
    $gender = $FachLaw['gender'];
    $bio = $FachLaw['Biography'];
    $country = $FachLaw['country_id'];
    $city = $FachLaw['city_id'];
    $service = $FachLaw['service_id'];
    $imgOld = $FachLaw['img'];
    $mobile = $FachLaw['mobile'];
    $valid = true;

if (isset($_POST['save'])) {
        //for use_detail Table in Database
        if (empty($_POST["firstname"])) {
            $err['firstname'] = "<div class='text-danger'>First Name is required!</div>";
            $valid = false;
        } else {

            if (!preg_match("/^[a-zA-Z- ']*$/", $_POST["firstname"])) {
                $err['firstname'] = "<div class='text-danger'>Only letters allowed</div>";
                $valid = false;
            } else {
                $firstname = htmlspecialchars($_POST["firstname"]);
            }
        }
        if (empty($_POST["lastname"])) {
            $err['lastname'] = "<div class='text-danger'>Last Name is required!</div>";
            $valid = false;
        } else {

            if (!preg_match("/^[0-9a-zA-Z- ']*$/", $_POST["lastname"])) {
                $err['lastname'] = "<div class='text-danger'>Only letters  allowed</div>";
                $valid = false;
            } else {
                $lastname = htmlspecialchars($_POST["lastname"]);
            }
        }
        if (empty($_POST["dob"])) {
            $err['dob'] = "<div class='text-danger'>Date Of Birth is required!</div>";
            $valid = false;
        } else {
            // $datepiker = htmlspecialchars($_POST["dob"]);
            // $dob  = date('Y-m-d',($datepiker));
            $dob=$_POST['dob'];
                
        }
        if (empty($_POST["gender"])) {
            $err['gender'] = "<div class='text-danger'>Gender is not Selected!</div>";
            $valid = false;
        } else {
                $gender = $_POST["gender"];
        }
        if (empty($_POST["qualification"])) {
            $err['qualification'] = "<div class='text-danger'>Qualification is required!</div>";
            $valid = false;
        } else {

            if (!preg_match("/^[a-zA-Z][a-zA-Z0-9- ]{1,50}$/", $_POST["qualification"])) {
                $err['qualification'] = "<div class='text-danger'>Only letters , numbers and '_' '.' allowed</div>";
                $valid = false;
            } else {
                $qualification = $_POST["qualification"];
            }
        }
        if (empty($_POST["country"])) {
            $err['country'] = "<div class='text-danger'>Country is not selected!</div>";
            $valid = false;
        } else {
                $country = $_POST["country"];
        }
        if (empty($_POST["city"])) {
            $err['city'] = "<div class='text-danger'>City is not selected!</div>";
            $valid = false;
        } else {
                $city = $_POST["city"];
        }
        if (empty($_POST["service"])) {
            $err['service'] = "<div class='text-danger'>Service is not selected!</div>";
            $valid = false;
        } else {
                $service = $_POST["service"];
        }

        if (empty($_POST["bio"])) {
            $err['bio'] = "<div class='text-danger'>Short Biography is required!</div>";
            $valid = false;
        } else { 
            
                $bio = $_POST["bio"];
        }

        if (empty($_POST["mobile"])) {
            $err['mbl'] = "<div class='text-danger'>Mobile Number is required!</div>";
            $valid = false;
        } else {

            if (!preg_match("/^[0-9]{11}$/", $_POST["mobile"])) {
                $err['mbl'] = "<div class='text-danger'>Only 11 numbers allowed</div>";
                $valid = false;
            } else {
                $mobile = $_POST["mobile"];
            }
        }


        if ($valid==true) {
            $img_name = '';
            $img = $_FILES["img"]["name"]; 
            $tmpname = $_FILES["img"]["tmp_name"]; 
            // for image validation 
            if (!empty($img)) {
                
                // if ($img == "defalt.png") {
                //     $img_name = "defalt.png";
                // }else {

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
                // }

            }else {
                $img_name = $imgOld;
            }

            $sql_Update = "UPDATE user_details SET first_name = '{$firstname}',last_name='{$lastname}',
            gender='{$gender}',dob='{$dob}',
            qualification='{$qualification}',
            Biography='{$bio}',img='{$img_name}',service_id='{$service}',
            country_id='{$country}',city_id='{$city}' WHERE user_fk_id=$user_Id;";

            $sql_Update .= "UPDATE user SET mobile='{$mobile}' WHERE user_id=$user_Id;";

            $run_Update = mysqli_multi_query($con,$sql_Update)or die(mysqli_error($con));

            if ($run_Update) {
                if (!empty($img)) 
                {
                    //first remove old img
                    if ($imgOld!='defalt.png') {
                        unlink('./assets/img/upload/'.$imgOld);
                    }
                    // then upload new image
                    move_uploaded_file($tmpname,"./assets/img/upload/".$img_name);//here we upload in folder
                    header("Location:lawyerpanel.php");
                }else{
                    header("Location:lawyerpanel.php");
                }
                
            }
        }
}
?>

<br><br>
<div class="content">
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
                                <img ID="impPrev" for="file" class="contactForm  rounded-circle  mx-auto d-block " src="assets/img/upload/<?php echo $imgOld;?>" />
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
                            <div class="">
                                <input type="date" name="dob" value="<?php echo $dob; ?>" class="form-control ">
                                <small>example Date :m/d/y</small>
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
                                        <?php 
                                        $citySelect = "SELECT * FROM city where coutry_fk_id='{$country}'";
                                        $cityDb = mysqli_query($con, $citySelect) or die("Query Feil");
                                        while($cityrow = mysqli_fetch_assoc($cityDb) ){
                                            if ($cityrow["city_id"]==$city) {
                                                $selected = "Selected";
                                            }else{
                                                $selected = "";
                                            }
                                            echo "<option {$selected} value='{$cityrow["city_id"]}'>{$cityrow['city_name']}</option>";
                                            }
                                    ?> 
                                        
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
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Mobile No# </label>
                            <input class="form-control" type="text" name="mobile" value="<?php echo $mobile; ?>">
                            <?php echo $err['mbl']  ?>
                        </div>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label>Short Biography</label>
                    <textarea class="form-control" rows="3" name="bio" cols="30"><?php echo $bio; ?></textarea>
                    <?php echo $err['bio']  ?>
                </div>
                <div class="m-t-20 text-center">
                    <button class="btn btn-warning submit-btn" id="signup" name="save">Save</button>
                    <a href="lawyerpanel.php" class="btn btn-danger submit-btn" >Cancel</a>
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
            var cityID = <?php echo $city; ?>;
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

<?php 
}else{
    header("Location:error-404.php");
} ?>