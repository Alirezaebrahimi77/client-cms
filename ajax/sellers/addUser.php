<?php
include_once "../../config/database/connect.php";

$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try{

    $sql = $conn->prepare("INSERT INTO users(user_email, user_password, user_role) VALUE(:email, :password, :role)");
    $sql->execute(array(
        ':email' => $email,
        ':password' => $hashedPassword,
        ':role'=> $role
    ));


    echo $status = "success";

}catch(Exception $e){
    echo $status = "fail";
}
