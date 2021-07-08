<?php

include('config.php');

$login_button= '';

if(isset($_GET["code"])){
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    if(!isset($token['error'])){
        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token']=$token['access_token'];
        $google_service=new Google_Service_Oauth2($google_client);
        $data=$google_service->userinfo->get();
        //print_($data);
        if(!empty($data['name'])){
            $_SESSION['name']=$data['name'];
        }
        if(!empty($data['family_name'])){
            $_SESSION['user_last_name']=$data['family_name'];
        }
        if(!empty($data['email'])){
            $_SESSION['user_email_address']=$data['email'];
        }
        if(!empty($data['picture'])){
            $_SESSION['user_image']=$data['picture'];
        }
    }
}
if(!isset($_SESSION['access_token'])){
    $login_button='<a href="'.$google_client->createAuthUrl().'">
    <img src="button.png"/></a>';
}
?>
<html>
    <head>
        <meta http-equive="Content-Type" content="text/html; charsetutf-8"/>
        <title>PHP Login using Google Account</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.js" rel="stylesheet"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" 
        integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
        <br/>
             <h2 align="center">LOGIN TO APOTEK</h2>
            <br/>
            <div class="panel panel-default">
            <?php
            if($login_button=='')    
            {
                echo '<h2><div class="panel-heading">Welcome '.$_SESSION['name'].'</div><div class="panel-body"></h2>';
                echo '<img style="width: 30%;"src="'.$_SESSION["user_image"].'" 
                class="img-responsive img-circle img-thumbnail" />';
                echo '<h4><b>Nama : </b>'.$_SESSION['name'].'</h4>';
                echo '<h4><b>Email : </b>'.$_SESSION['user_email_address'].'</h4>';
                echo '<h3 class="btn btn-warning btn-lg"><a href = "../view/nocobot/index.html#" >HOME</h3></div>';
                echo '<h3 class="btn btn-warning btn-lg"><a href="logout.php">LOGOUT</h3></div>';
            }
            else
            {
                echo '<div align="center">'.$login_button.'</div>';
            }
            ?>
        </div>
        </div>
        
    </body>
</html>
