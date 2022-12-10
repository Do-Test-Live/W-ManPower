<?php
session_start();
if(isset($_SESSION['user'])) {
    header("Location: index.php");
}
include ('config/db_config.php');
$result = 0;
if (isset($_POST['add_user'])){
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $number = mysqli_real_escape_string($con, $_POST['number']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $key = 'ManPower';
    $Pwd_peppered = Hash_hmac("Sha256", $password, $key);
    $Pwd_hashed = Password_hash($Pwd_peppered, PASSWORD_ARGON2ID);

    $check_user = $con->query("select * from user where contact_number = '$number'");

    if($check_user -> num_rows < 1){
        $add_user =$con->query("INSERT INTO `user`( `user_name`, `contact_number`, `password`) VALUES ('$user_name','$number','$Pwd_hashed')");
        if($add_user){
            $fetch_id = $con->query("select * from user where contact_number = '$number'");
            if($fetch_id){
                while($user = mysqli_fetch_assoc($fetch_id)){
                    $id = $user['user_id'];
                }
            }
            session_start();
            $_SESSION['user'] = $id;
            header("Location: index.php");

        }else{
            $result = 2;
        }
    }else{
        $result = 1;
    }


}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GogoJob</title>

    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/feather.css">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">


</head>

<body class="color-theme-blue">

<div class="preloader"></div>

<div class="main-wrap">

    <div class="nav-header bg-transparent shadow-none border-0">
        <div class="nav-top w-100">
            <a href="index.html"><i class="feather-zap text-success display1-size me-2 ms-0"></i><span
                        class="d-inline-block fredoka-font ls-3 fw-600 text-current font-xxl logo-text mb-0">GogoJob. </span>
            </a>

            <a href="login.php"
               class="header-btn d-none d-lg-block bg-dark fw-500 text-white font-xsss p-3 ms-auto w100 text-center lh-20 rounded-xl">Login</a>
            <a href="register.php"
               class="header-btn d-none d-lg-block bg-current fw-500 text-white font-xsss p-3 ms-2 w100 text-center lh-20 rounded-xl">Register</a>

        </div>


    </div>

    <div class="row">
        <div class="col-xl-12 vh-100 align-items-center d-flex bg-white rounded-3 overflow-hidden">
            <div class="card shadow-none border-0 ms-auto me-auto login-card">
                <div class="card-body rounded-0 text-left">

                    <?php
                    if($result == 1){
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Sorry!</strong> This contact number is already registered.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php
                    }elseif($result == 2){
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Sorry!</strong> Something went wrong.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php
                    }
                    ?>


                    <h2 class="fw-700 display1-size display2-md-size mb-4">Create <br>your account</h2>
                    <form action="" method="post">

                        <div class="form-group icon-input mb-3">
                            <i class="font-sm ti-user text-grey-500 pe-0"></i>
                            <input type="text" name="user_name" autocomplete="off"
                                   class="style2-input ps-5 form-control text-grey-900 font-xsss fw-600"
                                   placeholder="Your Name">
                        </div>
                        <div class="form-group icon-input mb-3">
                            <input type="text" class="style2-input ps-5 form-control text-grey-900 font-xss ls-3"
                                   placeholder="Contact Number with Country Code" name="number" id="number">
                            <i class="font-sm ti-microphone text-grey-500 pe-0"></i>
                        </div>
                        <div class="form-group icon-input mb-1">
                            <input type="Password" name="password" class="style2-input ps-5 form-control text-grey-900 font-xss ls-3"
                                   placeholder="Password" autocomplete="off">
                            <i class="font-sm ti-lock text-grey-500 pe-0"></i>
                        </div>
                        <div class="form-group icon-input mb-1">
                            <div id="recaptcha-container"></div>
                        </div>
                        <div class="col-sm-12 p-0 text-left">
                            <div class="form-group mb-1">
                                <button type="submit" name="add_user"
                                        class="form-control text-center style2-input text-white fw-600 bg-dark border-0 p-0"
                                        onclick="phoneAuth();">Register
                                </button>
                            </div>
                            <h6 class="text-grey-500 font-xsss fw-500 mt-0 mb-0 lh-32">Already have account <a
                                        href="login.php" class="fw-700 ms-1">Login</a></h6>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase.js"></script>
<script>
    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyAE5tnqPkbZAMVNJx6KJZm_c0up8au3jpM",
        authDomain: "manpower-a2e73.firebaseapp.com",
        projectId: "manpower-a2e73",
        storageBucket: "manpower-a2e73.appspot.com",
        messagingSenderId: "741394482552",
        appId: "1:741394482552:web:3a2cfabfda4af5c1cf348d",
        measurementId: "G-DTGNPGHSDD"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
</script>

<script src="js/firebase.js"></script>
<script src="js/plugin.js"></script>
<script src="js/scripts.js"></script>


</body>

</html>