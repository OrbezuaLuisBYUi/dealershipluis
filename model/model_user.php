<?php
/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 04/02/2020
 * Time: 09:56 PM
 */
class model_user{
    private $db;

    public function __construct(){
        $connection = new Connection();
        $conn = $connection->connection();

        $this->db=$conn;
    }

    public function login($user,$password)
    {
        $connection = new Connection();
        $conn = $connection->connection();

        $resultlogin = pg_query($conn,"select use_name,use_lastname,use_username,use_password,use_profile from users where UPPER(use_username) = UPPER('".$user."') and UPPER(use_password) = UPPER('".$password."')");
        $data = pg_fetch_array($resultlogin);
        $name = $data['use_name'];
        $lastname = $data['use_lastname'];
        $username = $data['use_username'];
        $password = $data['use_password'];
        $profile = $data['use_profile'];

        session_start();
        $_SESSION['user'] = $username;
        $_SESSION['password']= $password;
        $_SESSION['profile']= $profile;

        return $name." ".$lastname;
    }

    public function signup()
    {
        $connection = new Connection();
        $conn = $connection->connection();

        $user = "";
        $password = "";
        $name = "";
        $lastname = "";
        $email = "";
        $phone = "";
        $address = "";
        if(isset($_POST['user'])){ $user = $_POST['user']; }
        if(isset($_POST['password'])){ $password = $_POST['password']; }
        if(isset($_POST['name'])){ $name = $_POST['name']; }
        if(isset($_POST['lastname'])){ $lastname = $_POST['lastname']; }
        if(isset($_POST['email'])){ $email = $_POST['email']; }
        if(isset($_POST['phone'])){ $phone = $_POST['phone']; }
        if(isset($_POST['address'])){ $address = $_POST['address']; }

        $resultsignup = pg_query($conn,"insert into users(use_username,use_password,use_name,use_lastname,use_phone,use_email,use_address,use_profile) values('".$user."','".$password."','".$name."','".$lastname."','".$phone."','".$email."','".$address."',2)");

        return $resultsignup;
    }
}