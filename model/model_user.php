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
        $resultlogin = pg_query($this->db,"select use_name,use_lastname,use_username,use_password,use_profile,use_key_inside from public.users where UPPER(use_username) = UPPER('".$user."')");
        $data = pg_fetch_array($resultlogin);
        $name = $data['use_name'];
        $lastname = $data['use_lastname'];
        $username = $data['use_username'];
        $passwordVerify = $data['use_password'];
        $profile = $data['use_profile'];
        $userid = $data['use_key_inside'];

        if ($passwordVerify==$password) {
            session_destroy();
            session_start();

            $_SESSION['user'] = $username;
            $_SESSION['password']= $password;
            $_SESSION['profile']= $profile;
            $_SESSION['iduser'] = $userid;
        } else {
            session_destroy();
        }

        return $name." ".$lastname;
    }

    public function signup()
    {
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



        $resultsignup = pg_query($this->db,"insert into public.users(use_username,use_password,use_name,use_lastname,use_phone,use_email,use_address,use_profile) values('".$user."','".$password."','".$name."','".$lastname."','".$phone."','".$email."','".$address."',2)");

        return $resultsignup;
    }
}