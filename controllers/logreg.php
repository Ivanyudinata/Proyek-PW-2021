<?php

require_once("conn.php");
if($_POST["type"] == "LOGIN"){
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];


    $stmt = $conn->prepare("SELECT id  FROM user where username=:user and password=:pass");
    $stmt->bindParam(":user",$username);
    $stmt->bindParam(":pass",$password);

    $stmt->execute();
    
    $count = $stmt->rowCount();

    if($count == 1){
        $ada = true;
        $realpas = openssl_decrypt($value["password"],"AES-128-ECB","IV");
        if($realpas == $password || $value["password"] == $password){       
            setcookie("now", $value["id_user"]  , time() + 7200,'/');
            echo json_encode(array("statusCode"=>200, "nowCode" => $value["id_user"]));
        }else{
            echo json_encode(array("statusCode"=>401));
        }
    }

    if(!$ada){
        echo json_encode(array("statusCode"=>404));
    }

}
if($_POST["type"] == "REGISTER")){
    $email = $_REQUEST["email"];
    $password = $_REQUEST["password"];
    $username = $_REQUEST["username"];
    $nama = $_REQUEST["nama"];


    $stmt = $conn->prepare("SELECT id  FROM user where username=:user");
    $stmt->bindParam(":user",$username);
    $stmt->execute();
    
    $count = $stmt->rowCount();

    if($count == 1){
        echo json_encode(array("statusCode"=>403));
    }else{
        $password = openssl_encrypt($password,"AES-128-ECB","IV");
        $query = "INSERT INTO customers VALUES('$nama','$username','$password','$email')";
        $result = mysqli_query($conn,$query);
        
    
        if($result){
            echo json_encode(array("statusCode"=>201));
        }else{
            echo json_encode(array("statusCode"=>400));
        }
    }


}

?>