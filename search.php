<?php 
    if (empty($_GET['service']) && empty($_GET['city'])) {
        echo '<div class="card row no-gutters bg-light position-relative shadow p-1 mb-4 bg-white border-0">
                <div class="card-body ">
                    <p class="h3">Please Select Dropdown No Record Found<p>
                </div>
            </div>';
    }else{


    $sql = "SELECT user_id, user_name,img,service_name,country_name,city_name,userType FROM user 
    INNER JOIN user_details ON user_details.user_fk_id = user.user_id
    INNER JOIN servicelist ON servicelist.service_id = user_details.service_id
    INNER JOIN country ON country.country_id = user_details.country_id
    INNER JOIN city ON city.city_id = user_details.city_id
    Where  user_details.service_id = {$_GET['service']} AND user_details.city_id LIKE '%".$_GET['city']."%'";
    $sql_date = mysqli_query($con,$sql) or die("query field".mysqli_error($con));
    $find = mysqli_num_rows($sql_date);
    if ($find>0) {
    
    echo '<div class="row doctor-grid">';
    while ($show = mysqli_fetch_assoc($sql_date)) {
        if ($show['userType'] == 'admin'  ||  $show['userType'] == 'client') {
            echo '<div class="card row no-gutters bg-light position-relative shadow p-1 mb-4 bg-white border-0">
                <div class="card-body ">
                    <p class="h3"> No Record Found<p>
                </div>
            </div>';
            continue;
        }
?>
    <!--  -->
        <div class="col-md-4 col-sm-4  col-lg-3">
            <div class="profile-widget">
                <div class="doctor-img">
                    <a class="avatar" href="Profile.php?userId=<?php echo $show["user_id"]?>" ><img alt="" src="assets/img/upload/<?php echo $show["img"]?>"></a>
                </div>
                <h4 class="doctor-name text-ellipsis"><a href="Profile.php?userId=<?php echo $show["user_id"]?>"><?php echo $show["user_name"]?></a></h4>
                <div class="doc-prof"><?php echo $show["service_name"]?></div>
                <div class="user-country">
                    <i class="fa fa-map-marker"></i> <?php echo $show["country_name"]?>, <?php echo $show["city_name"]?>
                </div>
            </div>
        </div>
    <!--  -->
<?php }
 }else {
            echo '<div class="card row no-gutters bg-light position-relative shadow p-1 mb-4 bg-white border-0">
                <div class="card-body ">
                    <p class="h3"> No Record Found<p>
                </div>
            </div>';
        }
    }
         
        echo '</div>';
         ?>


