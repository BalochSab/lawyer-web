<?php   
    include("navbar.php");
if (isset($_SESSION["userType"]) && $_SESSION["userType"]=="client") {
        include("connection.php");
        include("header.php");
        $search = '';
        
?>
<div class="container">
    <br><br><br><br>
    <!-- search form start   -->
    <div class="row filter-row">
        <div class="col-sm-6 col-md-4">
            <form action="" method="get">
                <div class="form-group form-focus select-focus focused">
                    <label class="focus-label">Specialist</label>
                    <select class="form-control select select2-hidden-accessible" name="service" tabindex="-1" aria-hidden="true">
                        <option value="" selected>Select Specialist</option>
                        <?php
                        $serviceSelect = "SELECT * FROM servicelist";
                        $serviceDb = mysqli_query($con, $serviceSelect) or die("Query Feil");
                        while ($srow = mysqli_fetch_assoc($serviceDb)) {
                        
                            echo "<option {$selected} value='{$srow["service_id"]}'>{$srow['service_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
        </div>
        
        <div class="col-sm-6 col-md-4">
            <div class="form-group form-focus select-focus focused">
                <label class="focus-label">City</label>
                <select class="form-control select select2-hidden-accessible" id="city" name="city" tabindex="-1" aria-hidden="true">
                    <option value="" selected>Select City</option>
                    <?PHP
                    $countrySelect = "SELECT * FROM city ;";
                    $countryDb = mysqli_query($con, $countrySelect) or die(mysqli_error($con)) ;
                    while($countrow = mysqli_fetch_assoc($countryDb) ){
                        
                        echo "<option {$selected} value='{$countrow["city_id"]}'>{$countrow['city_name']}</option>";
                    } 
                    ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <button type="submit"  class="btn btn-success btn-block"> Search </button>
        </div>
        </form>
    </div>

    <!-- search form end -->

    <?php
    if (isset($_GET["service"]) && isset($_GET["city"])) {
        
        include("search.php");
    }
    else if (isset($_GET["home"])) {
        include("home.php");
    } else {
        include("home.php");
    }

    ?>

</div>


<script>
    $(document).ready(function() {

        $("#country").change(function() {
            var countryID = $(this).val();

            if (countryID > 0) {

                $.post('citydata.php', {
                    'country_id': countryID
                }, function(data) {
                    $('#city').html('<option value="" selected>Select City</option>');
                    $('#city').html(data); // I change this part
                });

            } else {
                $("#city").html('<option value="" selected>Select City</option>');
            }
        });

        $("#signup").click(function(e) {
            e.defaultPrevented();
            var countryID = $("#country").val();
            var cityID = $("#city").val();
            if (countryID > 0) {

                $.post('citydata.php', {
                    'country_id': countryID,
                    'city_id': cityID
                }, function(data) {
                    $('#city').append(data); // I change this part
                    // alert(data);
                });

            } else {
                $("#city").append('<option value="" selected>Select City</option>');
            }
        });

    });

</script>

<?php include_once("footer.php");
}else{
    header("Location:login.php");
} ?>