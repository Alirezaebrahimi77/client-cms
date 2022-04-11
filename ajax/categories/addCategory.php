<?php
include_once "../../config/database/connect.php";

$category = $_POST['category'];

try{

    $sql = $conn->prepare("INSERT INTO categories(category_name) VALUE(:category_name)");
    $sql->execute(array(
        ':category_name' => $category
    ));


    echo $status = "success";

}catch(Exception $e){
    echo $status = "fail";
}









?>