<?php
/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 04/02/2020
 * Time: 09:56 PM
 */
class model_user{
    private $db;
    private $users;
    private $infouser;

    public function __construct(){
        $connection = new Connection();
        $conn = $connection->connection();

        $this->db=$conn;
        $this->users=array();
        $this->infouser=array();
    }

    public function login($user,$password)
    {
        $resultlogin = pg_query($this->db,"select use_name,use_lastname,use_username,use_password,use_profile,use_key_inside from public.users where UPPER(use_username) = UPPER('".$user."')");
        $data = pg_fetch_array($resultlogin);
        $name = $data['use_name'];
        $lastname = $data['use_lastname'];
        $username = $data['use_username'];
        $passwordHash = $data['use_password'];
        $profile = $data['use_profile'];
        $userid = $data['use_key_inside'];

        if (password_verify($password, $passwordHash))
        {
            session_destroy();
            session_start();

            $_SESSION['user'] = $username;
            $_SESSION['password']= $password;
            $_SESSION['profile']= $profile;
            $_SESSION['iduser'] = $userid;
            return 1;
        } else {
            session_destroy();
            session_start();
            $_SESSION['user'] = "";
            $_SESSION['password']= "";
            $_SESSION['profile']= "";
            $_SESSION['iduser'] = "";
            return 0;
        }
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
        $profile = 2;
        if(isset($_POST['user'])){ $user = $_POST['user']; }
        if(isset($_POST['password'])){ $password = $_POST['password']; }
        if(isset($_POST['name'])){ $name = $_POST['name']; }
        if(isset($_POST['lastname'])){ $lastname = $_POST['lastname']; }
        if(isset($_POST['email'])){ $email = $_POST['email']; }
        if(isset($_POST['phone'])){ $phone = $_POST['phone']; }
        if(isset($_POST['address'])){ $address = $_POST['address']; }
        if(isset($_POST['profile'])){ $profile = $_POST['profile']; }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $resultsignup = pg_query($this->db,"insert into public.users(use_username,use_password,use_name,use_lastname,use_phone,use_email,use_address,use_profile) values('".$user."','".$password."','".$name."','".$lastname."','".$phone."','".$email."','".$address."',".$profile.")");

        return $resultsignup;
    }

    public function showusers()
    {
        $result=pg_query($this->db,"select use_key_inside,use_username,use_password,use_name,use_lastname,use_phone,use_email,use_address,CASE use_profile WHEN 1 THEN 'Administrator' ELSE 'Client' END use_profile from public.users");

        while($rows=pg_fetch_assoc($result)){
            $this->users[]=$rows;
        }
        return $this->users;
    }

    //CRUD Administrator

    public function giveinfouser($iduser)
    {
        $result=pg_query($this->db,"select * from public.users where use_key_inside = ".$iduser);

        while($rows=pg_fetch_object($result))
        {
            $this->infouser[]=$rows;
        }
        return json_encode($this->infouser);
    }

    public function edituser()
    {
        $user = "";
        $oldpassword = "";
        $newpassword = "";
        $confirmpassword = "";
        $name = "";
        $lastname = "";
        $email = "";
        $phone = "";
        $address = "";
        $profile = 2;
        $iduser = "";
        if(isset($_POST['user'])){ $user = $_POST['user']; }
        if(isset($_POST['oldpassword'])){ $oldpassword = $_POST['oldpassword']; }
        if(isset($_POST['newpassword'])){ $newpassword = $_POST['newpassword']; }
        if(isset($_POST['confirmpassword'])){ $confirmpassword = $_POST['confirmpassword']; }
        if(isset($_POST['name'])){ $name = $_POST['name']; }
        if(isset($_POST['lastname'])){ $lastname = $_POST['lastname']; }
        if(isset($_POST['email'])){ $email = $_POST['email']; }
        if(isset($_POST['phone'])){ $phone = $_POST['phone']; }
        if(isset($_POST['address'])){ $address = $_POST['address']; }
        if(isset($_POST['profile'])){ $profile = $_POST['profile']; }
        if(isset($_POST['iduserhidden'])){ $iduser = $_POST['iduserhidden']; }
        $password = "";
        if($oldpassword != "")
        {
            $password = password_hash($newpassword, PASSWORD_DEFAULT);
            $result = pg_query($this->db,"update public.users set use_username = '".$user."',use_password = '".$password."',use_name = '".$name."',use_lastname = '".$lastname."',use_phone = '".$phone."',use_email = '".$email."',use_address = '".$address."',use_profile = ".$profile." where use_key_inside = ".$iduser);
        }
        else
        {
            $result = pg_query($this->db,"update public.users set use_username = '".$user."',use_name = '".$name."',use_lastname = '".$lastname."',use_phone = '".$phone."',use_email = '".$email."',use_address = '".$address."',use_profile = ".$profile." where use_key_inside = ".$iduser);
        }
        return $result;
    }

    public function validatepassword($oldpassword,$iduser)
    {
        $result = pg_query($this->db,"select use_password from public.users where use_key_inside = ".$iduser);
        $dataresult = pg_fetch_array($result);
        $passwordhash = $dataresult['use_password'];

        if (password_verify($oldpassword, $passwordhash))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function searchinfouser($search)
    {
        $this->infouser = array();
        $result=pg_query($this->db,"select * from public.users
          where (UPPER(use_username) LIKE REPLACE(UPPER('%".$search."%'),' ','%') OR '".$search."' IS NULL OR '".$search."' = '' )
          or (UPPER(use_name) LIKE REPLACE(UPPER('%".$search."%'),' ','%') OR '".$search."' IS NULL OR '".$search."' = '' )
          or (UPPER(use_lastname) LIKE REPLACE(UPPER('%".$search."%'),' ','%') OR '".$search."' IS NULL OR '".$search."' = '' )");

        while($rows=pg_fetch_object($result))
        {
            $this->infouser[]=$rows;
        }
        return json_encode($this->infouser);
    }

    public function deleteuser($iduser)
    {
        $result = pg_query($this->db,"select * from public.users_cars where use_key_inside = ".$iduser);
        $numbuys = pg_num_rows($result);

        if($numbuys > 0)
        {
            return -1;
        }
        else
        {
            $result = pg_query($this->db,"delete from public.cars where use_key_inside = ".$iduser);
            $result = pg_query($this->db,"delete from public.users where use_key_inside = ".$iduser);
            if($result)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
    }
}