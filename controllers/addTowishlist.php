<?php

require_once("../connection.php");
$iduser = $_POST["iduser"];
$idproduk = $_POST["idproduk"];
$isvarian = 1;

$iduser = $_COOKIE["now"];
$idproduk = $_POST["idproduk"];
if($_POST["type"] == "PRODUK"){
    $isvarian = 0;
}

$stmt = $conn->prepare("INSERT INTO cart(user_id) VALUES(?)");
$stmt->bind_param("s",$iduser);
$result =$stmt->execute();

$idcart = $stmt->insert_id;
$stmt = $conn->prepare("INSERT INTO cart_item(product_id,isvarian,cart_id,qty) VALUES(?,?,?,?)");
$stmt->bind_param("sssi",$idproduk,$isvarian,$idcart,$jumlah);

$result =$stmt->execute();
if($result){
    echo json_encode(array("statusCode"=>200));
}else{
    echo json_encode(array("statusCode"=>209));
}

?>