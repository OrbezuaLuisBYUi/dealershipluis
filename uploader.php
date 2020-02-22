<?php
error_reporting(0);
$carpeta = 'sources/tmp';
//CREACION DE CARPETA PARA LAS IMAGENES DE PRODUCTOS
$insimpro = 0;
if(!file_exists($carpeta)){
    if(mkdir($carpeta, 0777, true)){ $insimpro = 1; } else { $insimpro = 0; } }
else{ $insimpro = 1;}

$carpeta="sources/tmp/";
$ruta = $_GET['ruta'];
$input = $_GET['input'];
if($ruta=="rutarunt"){ $carpeta="sources/tmprunt/"; }
if($ruta=="rutasoat"){ $carpeta="sources/tmpsoat/"; }
if($ruta=="rutatecno"){ $carpeta="sources/tmptecno/"; }
if($ruta=="rutacedula"){ $carpeta="sources/tmpcedula/"; }
if($ruta=="rutapase"){ $carpeta="sources/tmppase/"; }

$name=$carpeta.basename($_FILES[$input]['name']);
move_uploaded_file($_FILES[$input]['tmp_name'], $name);
echo "NAME: ".$name;
if($ruta=="sources/tmp/" || $ruta=="sources/tmprunt/"  || $ruta=="sources/tmpsoat/" || $ruta=="sources/tmptecno/" || $ruta=="sources/tmpcedula/" || $ruta=="sources/tmppase/"){$ruta="";}
?>
<script type="text/javascript">
//parent.document.getElementById("picture").src ='<?php echo $name; ?>';

parent.document.getElementById('<?php echo $ruta;?>').innerHTML ='<?php echo $name; ?>';
</Script>
