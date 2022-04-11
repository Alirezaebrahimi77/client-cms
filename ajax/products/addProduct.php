<?php

include_once "../../config/database/connect.php";

$productName = $_POST['productName'];
$productCategory = $_POST['productCategory'];
$productNumber = $_POST['productNumber'];
$productYear = $_POST['productYear'];

try{

    $sql = $conn->prepare("INSERT INTO products(product_name, product_number, product_category, product_year) VALUE(:product_name, :product_number, :product_category, :product_year)");
    $sql->execute(array(
        ':product_name' => $productName,
        ':product_number' => $productNumber,
        ':product_category'=> $productCategory,
        ':product_year'=> $productYear,
    ));

    echo $status = "success";

}catch(Exception $e){
    echo $status = "fail";
}


?>