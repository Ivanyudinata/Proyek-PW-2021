<?php

require_once("../connection.php");
if($_POST["type"] == "LOGIN"){
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    if($username == "admin" && $password == "admin"){
        setcookie("now", "admin", time() + 7200,'/');
        echo json_encode(array("statusCode"=>209));
    }else{

        $realpas = openssl_encrypt($password,"AES-128-ECB","RAHASIA");

        $stmt = $conn->prepare("SELECT id  FROM customers where (username=? or email=?) and password=?");
        $stmt->bind_param("sss",$username,$username,$realpas);
        $stmt->execute();
        $result = $stmt->get_result();
        $hass = $result->fetch_assoc();
    
        $count = count($hass);
    
        if($count == 1){
            setcookie("now", $hass['id']  , time() + 7200,'/');
            echo json_encode(array("statusCode"=>200));
        }else{
            echo json_encode(array("statusCode"=>404));
        }
    
    }

}
else if($_POST["type"] == "REGISTER"){
    $email = $_REQUEST["email"];
    $password = $_REQUEST["password"];
    $username = $_REQUEST["username"];
    $nama = $_REQUEST["nama"];


    $stmt = $conn->prepare("SELECT id  FROM customers where username=? or email=?");
    $stmt->bind_param("ss",$username,$email);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = count($result->fetch_all(MYSQLI_ASSOC));

    if($count == 1){
        echo json_encode(array("statusCode"=>403));
    }else{
        
        $password = openssl_encrypt($password,"AES-128-ECB","RAHASIA");

        $query = "INSERT INTO `customers`(`nama`, `username`, `password`, `email`, `alamat`, `kota`, `provinsi`, `kodepos`, `image_path`) VALUES('$nama','$username','$password','$email',NULL,NULL,NULL,NULL,NULL)";
        $result = mysqli_query($conn,$query);
        
    
        if($result){
            echo json_encode(array("statusCode"=>201));
        }else{
            echo json_encode(array("statusCode"=>400));
        }
    }


}

?>