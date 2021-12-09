<?php

require_once("../connection.php");

function uploadImage($fileGambar,$namafile,$idx) {
    
    if(isset($fileGambar)){
        $path = $fileGambar["name"][$idx];
        $file = $fileGambar;
        $nama = $file["name"][$idx];
        $asal = $file["tmp_name"][$idx];
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $target_dir = "../Uploads/";
        $target_file = $target_dir . $namafile . "." . $extension;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        $check = getimagesize($fileGambar["tmp_name"][$idx]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            return "";
        } else {
            if (move_uploaded_file($asal, $target_file)) {
                return $namafile . "." . $extension;
            } else {
                return "";
            }
        }
    }
}

if($_POST["type"] == "ADD"){    

    $nama = $_POST["product-name"];
    $kategori = $_POST["product-kategori"];
    $deskripsi = $_POST["product-deskripsi"];
    $minorder = $_POST["product-min-order"];
    $harga = (isset($_POST["product-harga"])) ? preg_replace('/[^0-9]/', '', $_POST["product-harga"])  : "";
    $berat = $_POST["product-berat"];
    $qty = (isset($_POST["product-stok"])) ? $_POST["product-stok"] : "";
    $arrwarna = isset($_POST["product-variasi-warna"]) ? $_POST["product-variasi-warna"] : "";
    
    $query = "SELECT * FROM products order by id asc";
    $stmt = $conn->query($query);
    $allprod = $stmt->fetch_all(MYSQLI_ASSOC);

    
    
    $idnow = count($allprod) + 1;
    $succes = true;
    
    if(count($_FILES["Gambar"]["name"]) == 1){
        $arrGambar = $_FILES["Gambar"];
        $namafile = uploadImage($arrGambar,$idnow,0);
        if($namafile != ""){

            $sql = "INSERT INTO `products`(`kategori`, `name`, `description`, `harga`, `qty`,`berat`,`status`,`minimumorder`, `img_path`) VALUES 
            ('$kategori','$nama','$deskripsi','$harga','$qty','$berat',1,'$minorder','$namafile')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(array("statusCode"=>200));
            }else{
                echo json_encode(array("statusCode"=>209));
            }
        }
    }else{
        $arrGambar = $_FILES["Gambar"];
        $arrStatus = $_POST["statusVarian"];
        $arrStok = $_POST["stokVarian"];
        $arrHarga = $_POST["hargaVarian"];
        
        $sql = "INSERT INTO `products`(`kategori`, `name`, `description`, `berat`, `minimumorder`) VALUES ('$kategori','$nama','$deskripsi','$berat','$minorder')";
        $sukses = true;

        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
                
            foreach($arrGambar as $key => $value){
                $new_str = str_replace(' ', '', $arrwarna[$key]);
                $namafile = uploadImage($value,$idnow."-".$new_str);
                if($namafile != ""){
                    $statnow = ($arrStatus[$key] == "on") ? 1 : 0;
                    $stoknow = $arrStok[$key];
                    $harganow = preg_replace('/[^0-9]/', '', $arrHarga[$key]);
                    $warnanow = $arrwarna[$key];
                    $query= "INSERT INTO `variasiwarna`(`product_id`, `warna`, `harga`, `stok`, `img_path`, `status`) VALUES ('$last_id','$warnanow','$harganow','$stoknow','$namafile','$statnow')";
                                
                    if ($conn->query($query) != TRUE) {
                        break;
                        $sukses = false;
                    }
                }
                
            }
            if($sukses){
                echo json_encode(array("statusCode"=>200));
            }else{
                echo json_encode(array("statusCode"=>209));
            }
        } else {
            echo json_encode(array("statusCode"=>209));
        }
        
    }
}else if($_POST["type"] == "EDIT"){

}else if($_POST["type"] == "DEL"){
    $product_id = $_POST["idproduk"];
    $result = $conn->query("DELETE FROM variasiwarna WHERE product_id=$product_id");
    $result = $conn->query("DELETE FROM products WHERE id=$product_id");

    if($result){
        echo json_encode(array("statusCode"=>200));
    }else{
        echo json_encode(array("statusCode"=>209));
    }

    
}else if($_POST["type"] == "SWITCH"){
    $product_id = $_POST["idproduk"];
    $result = $conn->query("UPDATE products SET status = IF(status=1, 0, 1)");

    if($result){
        echo json_encode(array("statusCode"=>200));
    }else{
        echo json_encode(array("statusCode"=>209));
    }
}
?>