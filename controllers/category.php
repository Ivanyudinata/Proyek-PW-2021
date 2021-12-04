<?php

require_once("../connection.php");
if($_POST["type"] == "ADD"){
    $nama = $_POST["nama"];
    
    $result =false;
    if(isset($nama) && $nama!=""){
      $stmt = $conn->prepare("INSERT INTO kategori(nama_kategori) VALUES(?)");
      $stmt->bind_param("s",$nama);
      $result =$stmt->execute();
    }
    
    if($result){
        echo json_encode(array("statusCode"=>200));
    }else{
        echo json_encode(array("statusCode"=>209));
    }
}else if($_POST["type"] == "EDIT"){
    
    $nama = $_POST["nama"];
    $category_id = $_POST["idkategori"];

    $result =false;
    if(isset($nama) && $nama!=""){
      $stmt = $conn->prepare("UPDATE KATEGORI SET nama_kategori=? WHERE id = ?");
      $stmt->bind_param("ss",$nama, $category_id);
      $result = $stmt->execute();
    }
    
    if($result){
        echo json_encode(array("statusCode"=>200));
    }else{
        echo json_encode(array("statusCode"=>209));
    }
    
}else if($_POST["type"] == "DEL"){
    $category_id = $_POST["idkategori"];
    $result = $conn->query("DELETE FROM KATEGORI WHERE id=$category_id");
    if($result){
        echo json_encode(array("statusCode"=>200));
    }else{
        echo json_encode(array("statusCode"=>209));
    }
}
?>