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
        session_start();
        if(isset($_SESSION['user']) or ($_POST['user'] and $_POST['password']))
        {
            $username = "";
            $user = "";
            $password = "";
            if(isset($_POST['user'])){ $user = $_POST['user']; }
            if(isset($_POST['password'])){ $password = $_POST['password']; }
            $seeresult =$usermodel->login($user,$password);
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
            session_start();
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
        session_start();
        require_once("views/dealerview.phtml");
        if(isset($_SESSION['user']))
        {
            $username = $_SESSION['user'];
            echo "<script>$('#modalbuycar').modal('toggle');$('#modalbuycar').modal('show');</script>";
        }
        else
        {
            echo "<script>if(confirm('To buy you need to sign up')){ $('#modalsignup').modal('toggle');$('#modalsignup').modal('show'); }else{ $('#modallogin').modal('toggle');$('#modallogin').modal('show'); }</script>";
        }

        $car_id = $_GET['car_id'];
        $result = "";
    }
    else
    if($_GET['operation'] == "confirmbuy")
    {
        $method = $_POST['method'];
        $cash = $_POST['cash'];
        $loan = $_POST['loan'];
        $time = $_POST['time'];
        $car_id = $_GET['car_id'];
        $userid = $_GET['userid'];

        $carmodel->buycar($car_id,$userid,$method,$cash,$loan,$time);
        session_start();
        require_once("views/dealerview.phtml");
    }
    else
    if($_GET['operation'] == "gotocars")
    {
        session_start();
        require_once("views/cars.phtml");
    }
    else
    if($_GET['operation'] == "newcar")
    {
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $warranty = $_POST['warranty'];
        $price = $_POST['price'];
        $userid = $_GET['userid'];

        $result = $carmodel->newcar($brand,$model,$year,$warranty,$price,$userid);

        if($result > 0)
        {
            echo "<script>alert('Register successfull')</script>";
        }
        else
        {
            echo "<script>alert('Try again')</script>";
        }

        session_start();
        require_once("views/cars.phtml");
    }
}
else
{
    session_start();
    require_once("views/dealerview.phtml");
}