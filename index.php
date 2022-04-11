<?php
session_start();
if(isset($_SESSION['user'])){
    header("location: dashboard.php");
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="robots" content="noindex">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex">
    <title>Levikki</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <script src="https://kit.fontawesome.com/b6b1f69e20.js" crossorigin="anonymous"></script>
  </head>
  <body>


    <div class="loginContainer">
        <div class="login">
            <div class="loginHeader">
                <h1>Tervetuloa takaisin</h1>
                <!-- <p>Enter your credentials to enter your account</p> -->
            </div>
            <div class="loginMessage">
                <p id="loginMessage"></p>
            </div>
            <div class="loginContent">
                <form>
                    <div class="inputForm">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Sähköposti" id="email">
                    </div>
                    <div class="inputForm">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Salasana" id="password">
                    </div>

                    <button class="btn btn-login" id="login">Kirjaudu</button>
                </form>
            </div>

        </div>

    </div>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/login.js"></script>
  </body>
</html>
