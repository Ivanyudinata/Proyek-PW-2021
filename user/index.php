<?php 
include 'header.php';
if(isset($_COOKIE['now'])){
    $now = $_COOKIE["now"];
    if($now == "admin"){
        header("Location:../admin/index.php");
    }else{

    }
}else{
    header("Location:../index.php");
}
?>

<div class="container-fluid m-0 p-0">

    <?php include 'navbar.php' ?>

    <div class="w-100 bg-dark pb-4">
        <div class="row container mx-auto p-3 row-cols-5 w-100">
            <div class="w-100 my-3 text-center">
                <h5 class="fw-lighter color-gold" style="letter-spacing: 2px;">RANDOM PRODUCTS</h5>
            </div>

            <div class="col">
            <a href="product.php">

                <div class="col card w-100 p-3">
                    <img src="assets/img/ball.jpg" alt="" class="card-img-top">
                    <h5 class="card-title mt-2 fw-normal mb-1" style="letter-spacing: 2px; font-size: 18px;">BURNING BALL</h5>
                    <small class="lh-sm fw-light mb-2" style="letter-spacing: 0 !important;">Lorem ipsum dolor sit amet consectetur, adipisicing elit...</small>
                    <b class="d-inline-block text-end">Rp. 50.000</b>

                </div>
                </a>
            </div>

            <div class="col">
            <a href="product.php">

                <div class="col card w-100 p-3">
                    <img src="assets/img/ball.jpg" alt="" class="card-img-top">
                    <h5 class="card-title mt-2 fw-normal mb-1" style="letter-spacing: 2px; font-size: 18px;">BURNING BALL</h5>
                    <small class="lh-sm fw-light mb-2" style="letter-spacing: 0 !important;">Lorem ipsum dolor sit amet consectetur, adipisicing elit...</small>
                    <b class="d-inline-block text-end">Rp. 50.000</b>

                </div>
            </a>
            </div>
            
            <div class="col">
                <a href="product.php">

                    <div class="col card w-100 p-3">
                        <img src="assets/img/ball.jpg" alt="" class="card-img-top">
                        <h5 class="card-title mt-2 fw-normal mb-1" style="letter-spacing: 2px; font-size: 18px;">BURNING BALL</h5>
                        <small class="lh-sm fw-light mb-2" style="letter-spacing: 0 !important;">Lorem ipsum dolor sit amet consectetur, adipisicing elit...</small>
                        <b class="d-inline-block text-end">Rp. 50.000</b>

                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="listProduk" class="row container mx-auto p-3 row-cols-5 w-100">
            
            
        </div>
    </div>
<script>
    
    function load(){
        
        $('#listProduk').load("../controllers/loadUserProduct.php", function (response, status, request) {

            }    
        );
    }
    load();
    
</script>
</div>
