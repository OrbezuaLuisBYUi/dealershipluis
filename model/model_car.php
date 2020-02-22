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
    private $infocar;

    public function __construct(){
        $connection = new Connection();
        $conn = $connection->connection();

        $this->db=$conn;
        $this->cars = array();
        $this->loans = array();
        $this->pricecar = array();
        $this->mywarranties = array();
        $this->infocar = array();
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
        $result_lastid = pg_fetch_row(pg_query($this->db,"SELECT setval('cars_car_key_inside_seq',nextval('cars_car_key_inside_seq')-1) as id;"));
        $lastid = $result_lastid[0];

        $carpeta="sources/images/";
        $name=$carpeta.basename($_FILES['imgcar']['name']);

        $ext = $this->extension_archive($name);
        if(move_uploaded_file($_FILES['imgcar']['tmp_name'], $carpeta.$lastid.".".$ext))
        {
            $result = pg_query($this->db,"update public.cars set car_img = '".$lastid.".".$ext."' where car_key_inside = ".$lastid);
        }

        return $result;
    }

    public function extension_archive($ruta)
    {
        $res = explode(".", $ruta);
        $extension = $res[count($res)-1];
        return $extension;
    }

    public function showwarraty()
    {
        $this->mywarranties = array();
        $result=pg_query($this->db,"select * from public.warranties order by war_months");

        while($rows=pg_fetch_assoc($result)){
            $this->mywarranties[]=$rows;
        }
        return $this->mywarranties;
    }

    public function giveinfocar($idcar)
    {
        $result=pg_query($this->db,"select * from public.cars where car_key_inside = ".$idcar);

        while($rows=pg_fetch_object($result))
        {
            $this->infocar[]=$rows;
        }
        return json_encode($this->infocar);
    }

    public function editcar($brand,$model,$year,$warranty,$price,$carid,$userid)
    {
        $result = pg_query($this->db,"update public.cars set car_brand = '".$brand."',car_model = '".$model."',car_year = ".$year.",war_key_inside = ".$warranty.",car_price = ".$price.",use_key_inside = ".$userid." where car_key_inside = ".$carid);

        $carpeta="sources/images/";
        $name=$carpeta.basename($_FILES['imgcaredit']['name']);

        $ext = $this->extension_archive($name);
        if(move_uploaded_file($_FILES['imgcaredit']['tmp_name'], $carpeta.$carid.".".$ext))
        {
            $result = pg_query($this->db,"update public.cars set car_img = '".$carid.".".$ext."' where car_key_inside = ".$carid);
        }

        return $result;
    }

    public function searchinfocar($search,$userid)
    {
        $this->infocar = array();
        $result=pg_query($this->db,"select * from public.cars c inner join public.warranties w ON(w.war_key_inside = c.war_key_inside)
          where ((UPPER(car_brand) LIKE REPLACE(UPPER('%".$search."%'),' ','%') OR '".$search."' IS NULL OR '".$search."' = '' )
          or (UPPER(car_model) LIKE REPLACE(UPPER('%".$search."%'),' ','%') OR '".$search."' IS NULL OR '".$search."' = '' ))
          and use_key_inside = ".$userid);

        while($rows=pg_fetch_object($result))
        {
            $this->infocar[]=$rows;
        }
        return json_encode($this->infocar);
    }

    public function deletecar($idcar)
    {
        $result = pg_query($this->db,"delete from public.cars where car_key_inside = ".$idcar);
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