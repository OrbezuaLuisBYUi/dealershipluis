<?php
/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 04/02/2020
 * Time: 09:56 PM
 */
class model_car{
    private $db;
    private $cars;

    public function __construct(){
        $connection = new Connection();
        $conn = $connection->connection();

        $this->db=$conn;
        $this->cars = array();
    }

    public function showcars()
    {
        $result=pg_query($this->db,"select * from public.cars as c inner join warranty as w ON(w.war_key_inside = c.war_key_inside)");

        while($rows=pg_fetch_assoc($result)){
            $this->cars[]=$rows;
        }
        return $this->cars;
    }

    public function buycar($car_id)
    {
        $connection = new Connection();
        $conn = $connection->connection();


    }
}