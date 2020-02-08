<?php
/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 31/01/2020
 * Time: 10:34 PM
 */
require_once("db/db.php");
require_once("controllers/controller_user.php");
require_once("controllers/controller_car.php");

if(isset($_GET['operation']))
{
    if($_GET['operation'] == "login")
    {
        $username = "";
        if(!isset($_SESSION['user']))
        {
            $user = "";
            $password = "";
            if(isset($_POST['user'])){ $user = $_POST['user']; }
            if(isset($_POST['password'])){ $password = $_POST['password']; }
            $usermodel->login($user,$password);
            require_once("views/dealerview.phtml");
        }
        else
        {
            require_once("views/dealerview.phtml");
        }
    }
    else
    if($_GET['operation'] == "logout")
    {
        if(isset($_SESSION['user']))
        {
            session_destroy();
        }
        require_once("views/dealerview.phtml");
    }
    else
    if($_GET['operation'] == "signup")
    {
        $resultsignup = $usermodel->signup();
        if($resultsignup > 0)
        {
            $user = "";
            $password = "";

            if(isset($_POST['user'])){ $user = $_POST['user']; }
            if(isset($_POST['password'])){ $password = $_POST['password']; }
            $usermodel->login($user,$password);
        }
        else
        {
            echo "<script>alert('There was an error when you try the registration')</script>";
        }
        require_once("views/dealerview.phtml");
    }
    else
    if($_GET['operation'] == "buy")
    {
        require_once("views/dealerview.phtml");
        if(isset($_SESSION['user']))
        {
            $username = $_SESSION['user'];
            if($username == "")
            {
                echo "<script>if(confirm('To buy you need to sign up')){ $('#modalsignup').modal('toggle');$('#modalsignup').modal('show'); }else{ $('#modallogin').modal('toggle');$('#modallogin').modal('show'); }</script>";
            }
        }
        else
        {
            echo "<script>if(confirm('To buy you need to sign up')){ $('#modalsignup').modal('toggle');$('#modalsignup').modal('show'); }else{ $('#modallogin').modal('toggle');$('#modallogin').modal('show'); }</script>";
        }

        $car_id = $_GET['car_id'];
        $result = "";
    }
}
else
{
    require_once("views/dealerview.phtml");
}