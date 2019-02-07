<?php
    $page = 'index';
    require_once('inc/config.php');
    $user_id = $_SESSION['activity']['id'];
    require_once('inc/functions.php');
    $message='';

    if( isset($_POST['update']) ){
        $profile_surname = $_POST['profile_surname'];
        $profile_username = $_POST['profile_username'];
        $profile_name = $_POST['profile_name'];
        $profile_cp = $_POST['profile_cp'];
        $profile_adress = $_POST['profile_adress'];
        $profile_aboutme = addslashes($_POST['profile_about']);
        $profile_email = $_POST['profile_email'];
        $profile_city = $_POST['profile_city'];

        $update_request = "UPDATE users
        SET users_surname = '".$profile_surname."',
            users_name = '".$profile_name."',
            users_adress = '".$profile_adress."',
            users_username = '".$profile_username."',
            users_email = '".$profile_email."',
            users_aboutme = '".$profile_aboutme."',
            users_cp = '".$profile_cp."',
            users_city = '".$profile_city."'
        WHERE id = '".$user_id."'";
        if( $mysqli->query($update_request) === TRUE){
            $message = "Mise à jour effectuée.";
        }
        
    }
    // Récup données
    $profile_request = "SELECT * FROM users WHERE id = '".$user_id."' LIMIT 1";
    if($profile_details = $mysqli->query($profile_request) ){
        while( $res = $profile_details->fetch_object()){
            $username = $res->users_username;
            $name = $res->users_name;
            $surname = $res->users_surname;
            $adress = $res->users_adress;
            $cp = $res->users_cp;
            $city = $res->users_city;
            $email = $res->users_email;
            $type = $res->users_type;
            $username = $res->users_username;
            $aboutme = $res->users_aboutme;
        }
    }
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
                    include('inc/profile-details.php');
                ?>
            </div>
        </div>
        <?php include('inc/footer.php'); ?>
    </div>
</div>
<?php include('inc/scripts.php'); ?>
</body>
</html>