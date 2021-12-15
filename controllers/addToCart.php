<?php

require_once("../connection.php");
$iduser = $_POST["iduser"];
$idproduk = $_POST["idproduk"];

$stmt = $conn->query("SELECT * FROM cart WHERE user_id='$iduser'");
$temp = $stmt->fetch_assoc();
if(count($temp) == 1){
    $idcart = $temp["id"];
    $stmt = $conn->query("SELECT * FROM cart_item WHERE product_id='$idproduk' and cart_id='$idcart'");
    $temp = $stmt->fetch_assoc();
    if(count($temp) > 0){
        $stmt = $conn->prepare("UPDATE cart_item SET qty=qty+1");
    }else{
        $stmt = $conn->prepare("INSERT INTO cart_item(product_id,cart_id,qty) VALUES(?,?,?)");
        $stmt->bind_param("sss",$idproduk,$idcart,1);    
    }
    $result =$stmt->execute();
    if($result){
        echo json_encode(array("statusCode"=>200));
    }else{
        echo json_encode(array("statusCode"=>209));
    }
}else if(count($temp) == 0){
    
    $stmt = $conn->prepare("INSERT INTO cart(user_id) VALUES(?)");
    $stmt->bind_param("s",$iduser);
    $result =$stmt->execute();

    $idcart = $stmt->insert_id;
    $stmt = $conn->prepare("INSERT INTO cart_item(product_id,cart_id,qty) VALUES(?,?,?)");
    $stmt->bind_param("sss",$idproduk,$idcart,1);
    
    $result =$stmt->execute();
    if($result){
        echo json_encode(array("statusCode"=>200));
    }else{
        echo json_encode(array("statusCode"=>209));
    }
}
?>