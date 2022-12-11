<?php
session_start();
if(isset($_SESSION['user'])) {
    header("Location: index.php");
}
include ('config/db_config.php');
$result = 0;

if(isset($_POST['login'])){
    $number = mysqli_real_escape_string($con, $_POST['number']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $key = 'GogoJob';
    $Pwd_peppered = Hash_hmac("Sha256", $password, $key);

    $query = $con->query("select * from user where `contact_number` = '$number'");
    if($query -> num_rows == 1){
        while($row = mysqli_fetch_assoc($query)){
            $pass = $row["password"];
            if(Password_verify($Pwd_peppered, $pass) && $row['status'] == 1){
                session_start();
                $_SESSION["user"] = $row['user_id'];
                header("Location: index.php");
            }else{
                $result = 2;
            }
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


</head>

<body class="color-theme-blue">

<div class="preloader"></div>

<div class="main-wrap">

    <div class="nav-header bg-transparent shadow-none border-0">
        <div class="nav-top w-100">
            <a href="#"><i class="feather-zap text-success display1-size me-2 ms-0"></i><span
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
                    if($result == 2){
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Sorry!</strong> Password has not matched.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php
                    }elseif($result == 1){
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Sorry!</strong> Something went wrong.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php
                    }
                    ?>
                    <h2 class="fw-700 display1-size display2-md-size mb-3">Login into <br>your account</h2>
                    <form action="" method="post">

                        <div class="form-group icon-input mb-3">
                            <i class="font-sm ti-email text-grey-500 pe-0"></i>
                            <input type="text" class="style2-input ps-5 form-control text-grey-900 font-xsss fw-600" name="number"
                                   placeholder="Your Mobile Number">
                        </div>
                        <div class="form-group icon-input mb-1">
                            <input type="Password" class="style2-input ps-5 form-control text-grey-900 font-xss ls-3"
                                   placeholder="Password" name="password">
                            <i class="font-sm ti-lock text-grey-500 pe-0"></i>
                        </div>
                        <div class="form-check text-left mb-3">
                            <a href="forgot.php" class="fw-600 font-xsss text-grey-700 mt-1 float-right">Forgot your
                                Password?</a>
                        </div>
                        <div class="col-sm-12 p-0 text-left">
                            <div class="form-group mb-1"><button type="submit" name="login" class="form-control text-center style2-input text-white fw-600 bg-dark border-0 p-0 ">Login</button>
                            </div>
                            <h6 class="text-grey-500 font-xsss fw-500 mt-0 mb-0 lh-32">Dont have account <a
                                    href="register.php" class="fw-700 ms-1">Register</a></h6>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--whatsapp button-->
    <?php include ('include/whatsapp.php');?>
</div>



<script src="js/plugin.js"></script>
<script src="js/scripts.js"></script>

</body>


</html>