<?php
include_once "../../config/database/connect.php";

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email)) {
    echo $status = "emptyEmail";
    return;
}
if (empty($password)) {
    echo $status = "emptyPass";
    return;
}

// Check if user exists
$sql = $conn->prepare("SELECT * FROM users WHERE user_email = :user_email");
$sql->execute(array(
    ':user_email' => $email
));
$resultEmail = $sql->fetch(PDO::FETCH_OBJ);

if ($resultEmail) {

    if(password_verify($password, $resultEmail->user_password)){
        session_start();
        $_SESSION['user'] = $resultEmail->id;
        $_SESSION['user_role'] = $resultEmail->user_role;
        echo $status = "loggedIn";

    }else{
        echo $status = "wrongPass";
    }

    
} else {
    echo $status = "notFoundEmail";
    return;
}
