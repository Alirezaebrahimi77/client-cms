<?php

include_once "../../config/database/connect.php";
$id = $_POST['id'];
try{
    $sql = $conn->prepare("DELETE FROM clients WHERE client_id = :id");
    $sql->execute(array(
        ':id' => $id
    ));

    echo $status = "success";

}catch(Exeption $e){
    echo $e->getMessage();
}

?>