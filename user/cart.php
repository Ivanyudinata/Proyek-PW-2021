<?php 

    include 'header.php';
    require_once '../connection.php';  
    require_once '../alert.html'; 

    if(isset($_COOKIE['now'])){
        $now = $_COOKIE["now"];
        if($now == "admin"){
            header("Location:../admin/index.php");
        }else{
    
        }
    }else{
        header("Location:../index.php");
    }
    $query = "SELECT * FROM cart where user_id= ". $now."" ;
    $stmt = $conn->query($query);
    $cart = $stmt->fetch_assoc();
    $idcart = $cart["id"];

    $query = "SELECT * FROM cart_item where cart_id=". $idcart."" ;
    $stmt = $conn->query($query);
    $allitem = $stmt->fetch_all(MYSQLI_ASSOC);
    $totharga = 0;
?>

<div class="container-fluid m-0 p-0">

    <?php include 'navbar.php' ?>

    <div class="container my-3 mx-5">
        <div class="row row-cols-2">
            <div class="col-9 d-flex flex-column">
                <div class="row row-cols-2">
                    <?php
                        foreach($allitem as $key => $value){
                            $prodid = $value["product_id"];
                            if($value["isvarian"] == 1){
                                $query = "SELECT * FROM variasiwarna where id= ". $prodid."" ;
                                $stmt = $conn->query($query);
                                $prod = $stmt->fetch_assoc();

                                $proudid = $prod["product_id"];
                                $query = "SELECT * FROM products where id= ". $proudid."" ;
                                $stmt = $conn->query($query);
                                $proud = $stmt->fetch_assoc();
                                $nama = $proud["name"];
                            }else{
                                $query = "SELECT * FROM products where id= ". $prodid."" ;
                                $stmt = $conn->query($query);
                                $prod = $stmt->fetch_assoc();
                                $nama = $prod["name"];
                            }
                            $imgpath = $prod["img_path"];
                            $harga = $prod["harga"];
                            $qty = $value["qty"];
                            $totharga += ($harga * $qty);
                    ?>
                            <div class="col">
                                <div class="card p-3 w-100">
                                    <div class="row">
                                        <div class="col-3">
                                            <img src='<?= "../Uploads/".$imgpath?>' alt="" class="w-100" srcset="">
                                        </div>
                                        <div class="col-6 d-flex flex-column align-items-start justify-content-center">
                                            <h5 class="mb-0"><?= $nama ?></h5>
                                            <small class="fw-light">Rp. <?= number_format($harga,2) ?></small>
                                        </div>
                                        <div class="col-3 d-flex align-items-center">
                                            <input type="text" name="" id="" value='<?= $qty ?>' class="form-control" placeholder="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="col-3">
                <h5 class="mt-3">Ringkasan Harga</h5>
                <hr>
                <div class="d-flex justify-content-between">
                    <p>Total Harga</p>
                    <small>Rp. <?= number_format($totharga,2) ?></small>
                </div>
                <input type="text" name="" id="" class="form-control fw-light" placeholder="Kode Promo">
                <button class="btn w-100 btn-dark mt-3">Bayar Sekarang</button>
            </div>
        </div>
    </div>
    

</div>