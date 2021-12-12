<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <form method="POST" class="card">
        <div class="sign-in">SIGN IN</div>
        <i id="logo" class="fas fa-user-circle"></i>
        <!-- Username  -->
        <div class="login-form">
            <i class="fas fa-user" id="logo-input"></i>
            <input type="text" name="email" class="input" id="username">
            <span data-placeholder="Email"></span>
        </div>

        <!-- password  -->
        <div class="login-form">
            <i class="fas fa-lock" id="logo-input"></i>
            <input type="password" name="pword" class="input" id="password">
            <span data-placeholder="Password"></span>
        </div>
        <p>Don't have account? <a href="#">Sign up</a></p>
        <!-- <input type="submit" class="btn-submit" value="login"> -->
        <button class="btn-submit" type="submit">login</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".input").on("focus", function() {
                $(this).addClass("focus");
            });

            $(".input").on("blur", function() {
                if ($(this).val() == "")
                    $(this).removeClass("focus");

                if ($("#username").val() != "" && $("#password").val() != "") {
                    $("#logo").addClass("change-color")
                } else {
                    $("#logo").removeClass("change-color")
                }

            });
        });
    </script>
</body>

</html>
<?php
require("connection/connectdb.php");
session_start();
if (isset($_POST['email']) && isset($_POST['pword'])) {
    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($connectdb, $email);
    $password = stripslashes($_REQUEST['pword']);
    $password = mysqli_real_escape_string($connectdb, $password);

    // check email and password 
    if ($email != '' && $password != '') {
        $sql = "SELECT
            `login_email`,
            `login_password`,
            `login_name`,
            `login_status`
        FROM
            `login`
        WHERE
            `login_email` = '$email' AND `login_password` ='".md5($password)."'";
        $querydata = $connectdb->query($sql);
        $num = mysqli_num_rows($querydata);
        if ($num > 0) {
            $auth = $querydata->fetch_assoc();
            $_SESSION['login_email'] = $auth['login_email'];
            $_SESSION['login_name'] = $auth['login_name'];
            header("Location: index.php?pt=list_data");
        }else{
            echo "<script>Swal.fire({
                icon: 'error',
                title: 'ผิดพลาด',
                text: 'ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง'
            })</script>";
        }
    } 
}
?>