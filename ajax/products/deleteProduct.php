<?php

include_once "../../config/database/connect.php";

$id = $_POST['id'];

try{

    $sql = $conn->prepare("DELETE FROM products WHERE product_id = :id");
    $sql->execute(array(
        ':id' => $id
    ));

    echo $status = "success";

}catch(Exception $e){
    echo $status = "fail";
}

?>