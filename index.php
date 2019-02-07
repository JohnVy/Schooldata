<?php
    $page = 'index';
    require_once('inc/config.php');
    $user_id = $_SESSION['activity']['id'];
    require_once('inc/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('inc/head.php'); ?>
</head>
<body>
    <div class="wrapper">
    <?php include('inc/sidebar.php'); ?>
    <div class="main-panel">
    <?php include('inc/nav.php'); ?>
        <div class="content">
            <div class="container-fluid">
                <?php 
                    if( $_SESSION['activity']['type'] == 1 ){
                        include('inc/dashboard.php');
                    }else if( $_SESSION['activity']['type'] == 2 ){
                        include('inc/dashboard-plus.php');
                    }else if( $_SESSION['activity']['type'] == 3 ){
                        include('inc/dashboard-admin.php');
                    }
                ?>
              
            </div>
        </div>
        <?php include('inc/footer.php'); ?>
    </div>
</div>
<?php include('inc/scripts.php'); ?>
</body>
</html>