<?php
class Connection{
    public function connection(){
        $conn_string = "host=ec2-107-20-185-16.compute-1.amazonaws.com port=5432 dbname=dc7uon8427ri8b user=nkbzmkzdmejfpa password=1d13fb44c3d78e0ff43df24f7cb9527e96f0be1f1a41273d11bd41eeefe7f401";
        $connection = pg_connect($conn_string)  or die('connection failed');
        return $connection;
    }
}