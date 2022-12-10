<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}
include("config/db_config.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ManPower</title>

    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/feather.css">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body class="color-theme-blue mont-font">

<div class="preloader"></div>


<div class="main-wrapper">

    <!-- navigation top-->
    <?php include('include/navigation_top.php'); ?>
    <!-- navigation top -->

    <!-- navigation left -->
    <?php include('include/navigation_left.php'); ?>
    <!-- navigation left -->


    <!-- main content -->
    <div class="main-content right-chat-active">

        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left pe-0">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow-xss w-100 d-block d-flex border-0 p-4 mb-3">
                            <div class="card-body flex text-center p-0">
                                <h2 class="fw-700 mb-0 mt-0 font-md text-grey-900">New Jobs</h2>
                            </div>
                        </div>

                        <?php
                        $fetch_post = $con->query("select * from post where status = '1'");
                        if($fetch_post->num_rows > 0){
                            while($post = mysqli_fetch_assoc($fetch_post)){
                                ?>
                                <div class="row ps-2 pe-1">
                                    <div class="col-md-12 col-sm-12 pe-2 ps-2">
                                        <div class="card d-block border-0 shadow-xss rounded-3 overflow-hidden mb-3">
                                            <div class="card-body d-block w-100 pe-4 ps-4 pb-4 pt-0 text-left position-relative">
                                                <div class="clearfix">
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 text-center my-auto">
                                                        <div class="text-center">
                                                            <h2 class="fw-700 font-xsss mt-3 mb-1"
                                                                style="font-size: 30px !important;"><?php echo $post['company_name'];?></h2>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-center">
                                                            <h2 class="fw-700 font-xsss mt-3 mb-1"><?php echo $post['salary'];?></h2>
                                                        </div>
                                                        <div class="text-center">
                                                            <h2 class="fw-700 font-xsss mt-3 mb-1"><?php echo $post['location'];?></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3 text-center">
                                                    <?php
                                                    $post_id = $post['id'];
                                                    $user_id = $_SESSION['user'];
                                                    $check_saved_post = $con->query("select * from saved_post where post_id = '$post_id' and user_id = '$user_id'");
                                                    if ($check_saved_post->num_rows > 0){
                                                        $saved = 0;
                                                    }else{
                                                        $saved = 1;
                                                    }
                                                    ?>
                                                    <div class="col-12">
                                                        <button id="<?php echo $post['id'];?>" onclick="save_post(<?php echo $post['id']?>)"
                                                           class="text-center p-2 lh-24 w125 ms-1 ls-3 d-inline-block rounded-xl bg-current font-xsss fw-700 ls-lg text-white" <?php if($saved == 0) echo 'disabled';?>>
                                                            <?php
                                if($saved == 0) echo 'Post Saved'; else echo 'Save Post';
                                                            ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }else{
                            echo "nothing posted";
                        }
                        ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- main content -->


    <div class="app-footer border-0 shadow-lg bg-primary-gradiant">
        <a href="index.html" class="nav-content-bttn nav-center"><i class="feather-home"></i></a>
        <a href="saved_jobs.php" class="nav-content-bttn"><i class="feather-package"></i></a>
        <a href="#" class="nav-content-bttn"><img src="images/female-profile.png" alt="user"
                                                  class="w30 shadow-xss"></a>
    </div>

    <div class="app-header-search">
        <form class="search-form">
            <div class="form-group searchbox mb-0 border-0 p-1">
                <input type="text" class="form-control border-0" placeholder="Search...">
                <i class="input-icon">
                    <ion-icon name="search-outline" role="img" class="md hydrated"
                              aria-label="search outline"></ion-icon>
                </i>
                <a href="#" class="ms-1 mt-1 d-inline-block close searchbox-close">
                    <i class="ti-close font-xs"></i>
                </a>
            </div>
        </form>
    </div>

</div>
<script>
        function save_post(clicked)  {
            var post_id = clicked;
            $("#",post_id).attr("disabled", "disabled");
            var post_id = clicked;
                $.ajax({
                    url: "save_post.php",
                    type: "POST",
                    data: {
                        post_id: post_id
                    },
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            $('#',clicked).html('Post Saved!');
                            alert("Post Saved Successfully!");
                            console.log(post_id);
                        }
                        else if(dataResult.statusCode==201){
                            alert("Error occured !");
                        }

                    }
                });
        }
</script>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="js/plugin.js"></script>
<script src="js/scripts.js"></script>

</body>


</html>