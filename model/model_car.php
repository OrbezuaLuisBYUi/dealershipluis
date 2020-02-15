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
    private $loans;
    private $pricecar;
    private $mywarranties;

    public function __construct(){
        $connection = new Connection();
        $conn = $connection->connection();

        $this->db=$conn;
        $this->cars = array();
        $this->loans = array();
        $this->pricecar = array();
        $this->mywarranties = array();
    }

    public function showcars($userid)
    {
        $result=pg_query($this->db,"select * from public.cars as c inner join warranties as w ON(w.war_key_inside = c.war_key_inside) where (c.use_key_inside = ".$userid." OR ".$userid." IS NULL OR ".$userid." = 0 )");

        while($rows=pg_fetch_assoc($result)){
            $this->cars[]=$rows;
        }
        return $this->cars;
    }

    public function showloans()
    {
        $result=pg_query($this->db,"select lon_key_inside,lon_months from public.loans");

        while($rows=pg_fetch_assoc($result)){
            $this->loans[]=$rows;
        }
        return $this->loans;
    }

    public function buycar($car_id,$userid,$method,$cash,$loan,$time)
    {
        if($time == "" or $time == 0){ $time = null; }
        if($cash == ""){ $cash = 0; }
        if($loan == ""){ $loan = 0; }
        $result = pg_query($this->db,"insert into public.users_cars(use_key_inside,car_key_inside,usc_sw_email,usc_payment_method,usc_loan,usc_cash,lon_key_inside) values(".$userid.",".$car_id.",0,'".$method."',".$loan.",".$cash.",".$time.")");


    }

    public function pricecar($car_id)
    {
        $result=pg_query($this->db,"select car_price,car_img from public.cars where car_key_inside = ".$car_id);
        $rows=pg_fetch_assoc($result);
        $this->pricecar[]=$rows;
        return $this->pricecar;
    }

    public function newcar($brand,$model,$year,$warranty,$price,$userid)
    {
        $result = pg_query($this->db,"insert into public.cars(car_brand,car_model,car_year,war_key_inside,car_price,car_zip_code,car_img,use_key_inside) values('".$brand."','".$model."',".$year.",'".$warranty."',".$price.",'','',".$userid.")");
        return $result;
    }

    public function showwarraty()
    {
        $result=pg_query($this->db,"select * from public.warranties order by war_months");

        while($rows=pg_fetch_assoc($result)){
            $this->mywarranties[]=$rows;
        }
        return $this->mywarranties;
    }
}