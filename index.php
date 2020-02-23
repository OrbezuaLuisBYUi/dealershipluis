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

if(isset($_REQUEST['operation']))
{
    if(isset($_GET['operation']))
    {
        if($_GET['operation'] == "login")
        {
            session_start();
            if(isset($_SESSION['user']) or (isset($_POST['user']) and isset($_POST['password'])))
            {
                $username = "";
                $user = "";
                $password = "";
                if(isset($_POST['user'])){ $user = $_POST['user']; }
                if(isset($_POST['password'])){ $password = $_POST['password']; }
                $result = $usermodel->login($user,$password);

                if($result == 0)
                {
                    echo "<script>alert('Your login is incorrect')</script>";
                }
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
                $_SESSION['user'] = "";
                $_SESSION['password']= "";
                $_SESSION['profile']= "";
                $_SESSION['iduser'] = "";
                session_destroy();
            }
            require_once("views/dealerview.phtml");
        }
        else
        if($_GET['operation'] == "signup")
        {
            if(isset($_POST['user']))
            {
                $user = $_POST['user'];
                $password = $_POST['password'];
                $name = $_POST['name'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $profile = $_POST['profile'];

                if($user=="")
                {
                    echo "<script>alert('Enter you user name')</script>";
                }
                else
                if($password=="")
                {
                    echo "<script>alert('Enter you password')</script>";
                }
                else
                if($name=="")
                {
                    echo "<script>alert('Enter you name')</script>";
                }
                else
                if($email=="")
                {
                    echo "<script>alert('Enter you email')</script>";
                }
                else
                if($phone=="")
                {
                    echo "<script>alert('Enter you phone')</script>";
                }
                else
                if($profile=="")
                {
                    echo "<script>alert('Select profile')</script>";
                }
                else
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
                }
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
                echo "<script>if(confirm('To buy, you need to sign up')){ $('#modalsignup').modal('toggle');$('#modalsignup').modal('show'); }else{ $('#modallogin').modal('toggle');$('#modallogin').modal('show'); }</script>";
            }

            $car_id = $_GET['car_id'];
            $result = "";
        }
        else
        if($_GET['operation'] == "confirmbuy")
        {
            if(isset($_POST['method']))
            {
                $method = $_POST['method'];
                $cash = $_POST['cash'];
                $loan = $_POST['loan'];
                $time = $_POST['time'];
                $car_id = $_GET['car_id'];
                $userid = $_GET['userid'];

                if($method=="")
                {
                    echo "<script>alert('Enter the method of payment')</script>";
                }
                else
                {
                    $carmodel->buycar($car_id,$userid,$method,$cash,$loan,$time);
                }
            }

            session_start();
            require_once("views/dealerview.phtml");
        }
        else
        if($_GET['operation'] == "gotodealership")
        {
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
        if($_GET['operation'] == "gotousers")
        {
            session_start();
            require_once("views/users.phtml");
        }
        else
        if($_GET['operation'] == "newcar")
        {
            if(isset($_POST['brand']))
            {
                $brand = $_POST['brand'];
                $model = $_POST['model'];
                $year = $_POST['year'];
                $warranty = $_POST['warranty'];
                $price = $_POST['price'];
                $userid = $_GET['userid'];

                if($brand=="")
                {
                    echo "<script>alert('Enter the brand')</script>";
                }
                else
                if($model=="")
                {
                    echo "<script>alert('Enter the model')</script>";
                }
                else
                if($year=="")
                {
                    echo "<script>alert('Enter the year')</script>";
                }
                else
                if($warranty=="")
                {
                    echo "<script>alert('Enter the warranty')</script>";
                }
                else
                if($price=="")
                {
                    echo "<script>alert('Enter the price')</script>";
                }
                else
                {
                    $result = $carmodel->newcar($brand,$model,$year,$warranty,$price,$userid);

                    if($result > 0)
                    {
                        echo "<script>alert('Register successfull')</script>";
                    }
                    else
                    {
                        echo "<script>alert('Try again')</script>";
                    }
                }
            }
            session_start();
            require_once("views/cars.phtml");
        }
        else
        if($_GET['operation'] == "editcar")
        {
            if(isset($_POST['brand']))
            {
                $brand = $_POST['brand'];
                $model = $_POST['model'];
                $year = $_POST['year'];
                $warranty = $_POST['warranty'];
                $price = $_POST['price'];
                $carid = $_POST['idcarhidden'];
                $userid = $_GET['userid'];

                if($brand=="")
                {
                    echo "<script>alert('Enter the brand')</script>";
                }
                else
                if($model=="")
                {
                    echo "<script>alert('Enter the model')</script>";
                }
                else
                if($year=="")
                {
                    echo "<script>alert('Enter the year')</script>";
                }
                else
                if($warranty=="")
                {
                    echo "<script>alert('Enter the warranty')</script>";
                }
                else
                if($price=="")
                {
                    echo "<script>alert('Enter the price')</script>";
                }
                else
                {
                    $result = $carmodel->editcar($brand,$model,$year,$warranty,$price,$carid,$userid);

                    if($result > 0)
                    {
                        echo "<script>alert('Register updated')</script>";
                    }
                    else
                    {
                        echo "<script>alert('Try again')</script>";
                    }
                }

                session_start();
                require_once("views/cars.phtml");
            }
        }
        else
        if($_GET['operation'] == "newuser")
        {
            if(isset($_POST['user']))
            {
                $user = $_POST['user'];
                $password = $_POST['password'];
                $name = $_POST['name'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $profile = $_POST['profile'];

                if($user=="")
                {
                    echo "<script>alert('Enter you user name')</script>";
                }
                else
                if($password=="")
                {
                    echo "<script>alert('Enter you password')</script>";
                }
                else
                if($name=="")
                {
                    echo "<script>alert('Enter you name')</script>";
                }
                else
                if($email=="")
                {
                    echo "<script>alert('Enter you email')</script>";
                }
                else
                if($phone=="")
                {
                    echo "<script>alert('Enter you phone')</script>";
                }
                else
                if($profile=="")
                {
                    echo "<script>alert('Select profile')</script>";
                }
                else
                {
                    $result = $usermodel->signup();

                    if($result > 0)
                    {
                        echo "<script>alert('Register successfull')</script>";
                    }
                    else
                    {
                        echo "<script>alert('Try again')</script>";
                    }
                }
            }

            session_start();
            require_once("views/users.phtml");
        }
        else
        if($_GET['operation'] == "edituser")
        {
            if(isset($_POST['user']))
            {
                $user = $_POST['user'];
                $oldpassword = $_POST['oldpassword'];
                $newpassword = $_POST['newpassword'];
                $confirmpassword = $_POST['confirmpassword'];
                $name = $_POST['name'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $profile = $_POST['profile'];
                $iduser = $_POST['iduserhidden'];

                if($oldpassword != "")
                {
                    $resultpassword = $usermodel->validatepassword($oldpassword,$iduser);
                }

                if($user=="")
                {
                    echo "<script>alert('Enter you user name')</script>";
                }
                else
                if($oldpassword != "" and $resultpassword == 0)
                {
                    echo "<script>alert('The old password is not correct')</script>";
                }
                else
                if($oldpassword != "" and ($newpassword == "" or $confirmpassword == ""))
                {
                    echo "<script>alert('Enter your new password')</script>";
                }
                else
                if($oldpassword != "" and ($newpassword != $confirmpassword))
                {
                    echo "<script>alert('Passwords no matth')</script>";
                }
                else
                if($name=="")
                {
                    echo "<script>alert('Enter you name')</script>";
                }
                else
                if($email=="")
                {
                    echo "<script>alert('Enter you email')</script>";
                }
                else
                if($phone=="")
                {
                    echo "<script>alert('Enter you phone')</script>";
                }
                else
                if($profile=="")
                {
                    echo "<script>alert('Select profile')</script>";
                }
                else
                {
                    $result = $usermodel->edituser();

                    if($result > 0)
                    {
                        echo "<script>alert('Register updated')</script>";
                    }
                    else
                    {
                        echo "<script>alert('Try again')</script>";
                    }
                }
            }

            session_start();
            require_once("views/users.phtml");
        }
    }
    else
    if(isset($_POST['operation']))
    {
        if($_POST['operation'] == "giveinfocar")
        {
            $idcar = $_POST['idcar'];
            $result = $carmodel->giveinfocar($idcar);
            echo $result;
        }
        else
        if($_POST['operation'] == "searchinfocar")
        {
            $search = $_POST['search'];
            $userid = $_POST['userid'];
            $result = $carmodel->searchinfocar($search,$userid);
            echo $result;
        }
        else
        if($_POST['operation'] == "deletecar")
        {
            $idcar = $_POST['idcar'];
            $result = $carmodel->deletecar($idcar);
            echo $result;
        }
        else
        if($_POST['operation'] == "giveinfouser")
        {
            $iduser = $_POST['iduser'];
            $result = $usermodel->giveinfouser($iduser);
            echo $result;
        }
        else
        if($_POST['operation'] == "deleteuser")
        {
            $iduser = $_POST['iduser'];
            $result = $usermodel->deleteuser($iduser);
            echo $result;
        }
        else
        if($_POST['operation'] == "searchinfouser")
        {
            $search = $_POST['search'];
            $result = $usermodel->searchinfouser($search);
            echo $result;
        }
    }
}
else
{
    session_start();
    $_SESSION['user'] = "";
    $_SESSION['password']= "";
    $_SESSION['profile']= "";
    $_SESSION['iduser'] = "";
    require_once("views/dealerview.phtml");
}