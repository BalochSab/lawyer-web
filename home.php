<?php 
    // include("connect.php");
    $sql = "SELECT user_id, user_name,img,service_name,country_name,city_name,userType FROM user 
    LEFT JOIN user_details ON user.user_id = user_details.user_fk_id 
    LEFT JOIN servicelist ON user_details.service_id = servicelist.service_id
    LEFT JOIN country ON user_details.country_id = country.country_id
    LEFT JOIN city ON  user_details.city_id = city.city_id";

    $sql_date = mysqli_query($con,$sql) or die("query field".mysqli_error($con));
    $find = mysqli_num_rows($sql_date);
    if ($find>0) {
    
        echo '<div class="row doctor-grid">';
    
    while ($show = mysqli_fetch_assoc($sql_date)) {
        if ($show['userType'] == 'admin'  || $show['userType'] == 'client') {
            
            continue;
        }
        
?>
    
        <div class="col-md-4 col-sm-4  col-lg-3">
            <div class="profile-widget">
                <div class="doctor-img">
                    <a class="avatar" href="Profile.php?userId=<?php echo $show["user_id"]?>" ><img alt="" src="assets/img/upload/<?php echo $show["img"]?>"></a>
                </div>
                <h4 class="doctor-name text-ellipsis"><a href="Profile?userId=<?php echo $show["user_id"]?>"><?php echo $show["user_name"]?></a></h4>
                <div class="doc-prof"><?php echo $show["service_name"]?></div>
                <div class="user-country">
                    <i class="fa fa-map-marker"></i> <?php echo $show["country_name"]?>, <?php echo $show["city_name"]?>
                </div>
            </div>
        </div>
    
<?php } echo "</div>"; 
 }else {
            echo '<div class="card row no-gutters bg-light position-relative shadow p-1 mb-4 bg-white border-0">
                <div class="card-body ">
                    <p class="h3"> No Record Found<p>
                </div>
            </div>';
        }
         
         
         ?>


