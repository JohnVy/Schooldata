<?php
    $page = 'login';
    require('inc/config.php');
    $message = '';
    if( isset($_POST['submit-signin'])){
        // Récup des valeurs des champs du formulaire
        $username = $_POST['signin-username'];
        $name = $_POST['signin-name'];
        $surname = $_POST['signin-surname'];
        $adress = $_POST['signin-adress'];
        $cp = $_POST['signin-cp'];
        $city = $_POST['signin-city'];
        $email = $_POST['signin-email'];
        $birth = $_POST['signin-birth'];
        $password = $_POST['signin-password'];
        $password2 = $_POST['signin-password2'];

        // vérification username non attribué
        $username_verify_request = "SELECT * FROM users WHERE users_username = '$username' LIMIT 1";
        if( $resultat = $mysqli->query($username_verify_request) ){
            $row_cnt = $resultat->num_rows;
            if($row_cnt !== 0){
                $message = "Votre pseudo est déjà utilisé.";
            }else{
                if( $password == $password2 ){
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $now = date('Y-m-d H:i:s');
                    $new_user_request = "INSERT INTO users (
                            users_username,
                            users_password,
                            users_active,   /* 0:inactif, 1:actif */
                            users_type,     /* 1:Etudiant, 2:Prof, 3:Admin */
                            users_name,
                            users_surname,
                            users_adress,
                            users_cp,
                            users_city,
                            users_add_date,
                            users_email,
                            users_avatar
                        ) VALUES (
                            '$username',
                            '$password',
                            0,
                            1,
                            '$name',
                            '$surname',
                            '$adress',
                            '$cp',
                            '$city',
                            '$now',
                            '$email',
                            'users/upload/profile.jpg'
                        )";
                    if($mysqli->query($new_user_request) === TRUE ){ 
                       $message = 'Recording ok'; 
                    }else{
                        echo $mysqli->error;
                    }
                }else{
                    $message = "Is not same";
                }
        // Enregistrement dans la bdd
            }
        }
    }else if( isset($_POST['submit-login']) ){
        // Récupérer les infos du formulaire dans des variables
        $username = $_POST['login-username'];
        $password = $_POST['login-password'];
        // Vérifier la concordance entre le formulaire et la BDD
        $login_request = "SELECT * FROM users WHERE users_username = '$username' LIMIT 1";
        // Vérification des résultats
        if( $resultat = $mysqli->query($login_request) ){       // Si il y a un username qui correspond entre le formulaire et la BDD
            while( $res = $resultat->fetch_object() ){
               $res_id = $res->id;
               $res_username = $res->users_username;
               $res_password = $res->users_password;
               $res_type = $res->users_type;
               if( password_verify($password, $res_password) === TRUE ){
                    $_SESSION['activity']['id'] = $res_id;
                    $_SESSION['activity']['username'] = $res_username;
                    $_SESSION['activity']['type'] = $res_type;
                    header('Location: index.php');
                    die();
               }else{
                    $message = 'Password Error';
               }
            }
        }
    }else{
        $message = "Welcom, log in";
        if(isset($_GET['logout'])){
            $_SESSION['activity'] = Array();
            session_destroy();
            $message = "You are connected";
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
    <div class="container">
      <div class="row">
          <div class="col-md-6">
              <h2>Login</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <input type="text" name="login-username" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" name="login-password" class="form-control" placeholder="Password">
                    </div>
                    <input type="submit" name="submit-login" value="To log in" class="btn btn-primary">
                </form>
                <p><?php if(isset($message)){ echo $message; } ?></p>
          </div>
          <div class="col-md-6">
                <h2>Sign In</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <input type="text" required name="signin-username" class="form-control" placeholder="Your Username">
                    </div>
                    <div class="form-group">
                        <input type="email" required name="signin-email" class="form-control" placeholder="Email address">
                    </div>
                    <div class="form-group">
                        <input type="password" required name="signin-password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="password" required name="signin-password2" class="form-control" placeholder="Password verification">
                    </div>
                    <div class="form-group">
                        <input type="text" name="signin-name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="signin-surname" class="form-control" placeholder="FirstName">
                    </div>
                    <div class="form-group">
                        <input type="text" name="signin-adress" class="form-control" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <input type="text" name="signin-cp" class="form-control" placeholder="Postal Code">
                    </div>
                    <div class="form-group">
                        <input type="text" name="signin-city" class="form-control" placeholder="City">
                    </div>

                    <div class="form-group">
                        <input type="date" name="signin-birth" class="form-control" placeholder="Date of Birth">
                    </div>
                    <div class="form-group">
                        <input type="file" name="signin-avatar" class="form-control">
                    </div>
                    <input type="submit" name="submit-signin" value="Submit" class="btn btn-primary">
                </form>
          </div>
      </div>
   </div>
    <?php
    include('inc/scripts.php'); 
    ?>
</body>
</html>