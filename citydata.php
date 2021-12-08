<?php

include("connection.php");

    $country_id = $_POST['country_id'];
    $city = $_POST['city_id'];



    $countrySelect = "SELECT * FROM city where coutry_fk_id = $country_id";
    $countryDb = mysqli_query($con, $countrySelect) or die("Query Feil") ;
    while($countrow = mysqli_fetch_assoc($countryDb) ){
        if ($countrow["city_id"]==$city) {
            $selected = "selected";
        }else{
            $selected = "";
        }
        echo "<option {$selected} value='{$countrow["city_id"]}'>{$countrow['city_name']}</option>";
    }

?>