<?php 
    require_once("../connection.php");
    if(isset($_REQUEST["btncari"])){
        $namaproduct = $_REQUEST["txtnamaproduct"];
        $query = "SELECT * FROM products WHERE name = '$namaproduct'";
        $cariproduct = mysqli_query($conn,$query);
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skibble</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@100;200;300;500;600&display=swap" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <style>
        body, html {
            width: 100%;
            height: 100%;
        }

        * {
            font-family: 'Montserrat Alternates', sans-serif;
        }
    </style>

</head>
<body class="bg-light">

    <div class="container-fluid m-0 p-0">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent text-dark w-100" style="z-index: 999">
                <div class="container-fluid w-100">
                    <div class="row w-100">
                        <div class="col-2 d-flex align-items-center text-dark">
                            <a class="navbar-brand" href="#" style="font-weight: 400 !important">Skibble</a>
                        </div>
                        <div class="col-8 d-flex align-items-end justify-content-center">
                            
                        </div>
                        <div class="col-2 fw-light">
                            <div class="flex flex-column w-100 justify-content-end">
                                <div class="w-100 text-end">
                                    
                                </div>
                                <div class="mt-2 d-flex justify-content-center">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="container-fluid bg-secondary w-100 mt-3" style="height: 400px;">

        </div>

        <div class="hstack gap-5 w-100 mx-auto justify-content-center my-4 py-2 px-5">
            <div class="p-3 border border-1 rounded row">
               
               
            </div>
            <div class="p-3 border border-1 rounded row">
               
            </div>
            <div class="p-3 border border-1 rounded row">
                
                
            </div>
        </div>

        <div class="container text-left mt-5">
            <form action="#" method="get">
                nama product = <input type="text" name="txtnamaproduct" id="">
                <button type="submit" name="btncari">Cari</button>
            </form>
            <table border="1" cellspacing="0" cellpadding="1">
                <tr>
                    <th>ID</th>
                    <th>Kategori</th>
                    <th>Nama Barang</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Berat</th>
                    <th>Status</th>
                    <th>Minimum Order</th>
                    <th>Gambar</th>
                </tr>
                <?php foreach($cariproduct as $cari) : ?>
                    <tr>
                        <td><?= $cari["id"]; ?></td>
                        <td><?= $cari["kategori"]; ?></td>
                        <td><?= $cari["name"]; ?></td>
                        <td><?= $cari["description"]; ?></td>
                        <td><?= $cari["harga"]; ?></td>
                        <td><?= $cari["qty"]; ?></td>
                        <td><?= $cari["berat"]; ?></td>
                        <td><?= $cari["status"]; ?></td>
                        <td><?= $cari["minimumorder"]; ?></td>
                        <td><?= $cari["img_path"]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <footer class="text-center py-3 mt-5">
            Skibble
        </footer>
    

</body>
</html>

<?php 

namespace Midtrans;
session_start();

require_once dirname(__FILE__) . '\vendor\midtrans\midtrans-php\Midtrans.php';
Config::$clientKey = 'SB-Mid-client-IZTGPkzRSyrlUwxH'; 

?>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey;?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php 


$_SESSION['meja'] = 4;
require_once 'db.php';

if(!isset($_SESSION['meja'])) {
    header('location:404.php');
}

if (isset($_POST['login']) && $_POST['username-login'] != "" && $_POST['password-login'] != "") {
    $username = $_POST['username-login'];
    $password = md5($_POST['password-login']);

    $sql = mysqli_query($conn, "SELECT id, nama, username, password FROM pelanggan WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($sql) > 0 ) {
        if ($row = mysqli_fetch_assoc($sql)) {
            setcookie("id_pel_restaurant", $row['id'], time() + (86400 * 30), "/");
        }
        header("location:index.php");
    };
}

if (isset($_POST['register']) && $_POST['username-register'] != "" && $_POST['password-register'] != "") {

    $nama = $_POST['nama-register'];
    $email = $_POST['email-register'];
    $username = $_POST['username-register'];
    $password = md5($_POST['password-register']);

    $sql = mysqli_query($conn, "SELECT email, username FROM pelanggan WHERE email='$email' AND username='$username'");

    if (mysqli_num_rows($sql) > 0 ) {
        
        ?>
        <script>
            $(document).ready(function(){
                $("#failedCreateAccountBtn").trigger("click");
            });
        </script>
        <?php

    } else {

        $sql   = mysqli_query($conn, "SELECT COUNT(*) FROM pelanggan");
        $count = mysqli_fetch_array($sql);
        $total = $count[0];
    
    
        $id = "P";
        if (strlen($total) < 4) {
            $id = "P";
            for ($i=0; $i < (4 - strlen($total)); $i++) { 
                $id .= "0";
            }
            $id .= $total;
        }

        mysqli_query($conn, "INSERT INTO pelanggan (id, nama, email, username, password) 
        VALUES ('$id', '$nama', '$email', '$username', '$password')");
        ?>
            <script>
                $(document).ready(function(){
                    $("#successCreateAccountBtn").trigger("click");
                });
            </script>
        <?php
    }
}

$status_code = 0;

if (isset($_GET['SnapToken'])) {
    $snap_token = $_GET['SnapToken'];
    ?>
    <script>
        snap.pay('<?php echo $snap_token?>', {
            onSuccess: function(result) {
                //document.getElementById('result-json').innerHTML = result["status_code"];
                window.location.href = "index.php?Status="+ result["status_code"] + "&OrderId=" + result["order_id"] + "&Payment=" + result["payment_type"] + "&Message=" + result["status_message"];
            },
            onPending: function(result) {
                //document.getElementById('result-json').innerHTML = result["status_code"];
                window.location.href = "index.php?Status="+ result["status_code"] + "&OrderId=" + result["order_id"] + "&Payment=" + result["payment_type"] + "&Message=" + result["status_message"];
            },
            onError: function(result) {
                //document.getElementById('result-json').innerHTML = result["status_code"];
                window.location.href = "index.php?Status="+ result["status_code"] + "&OrderId=" + result["order_id"] + "&Payment=" + result["payment_type"] + "&Message=" + result["status_message"];
            },
            onClose: function(result) {
                //document.getElementById('result-json').innerHTML = result["status_code"];
                window.location.href = "index.php?Status="+ result["status_code"] + "&OrderId=" + result["order_id"] + "&Payment=" + result["payment_type"] + "&Message=" + result["status_message"];
            }
        });
    </script>
    <?php
}

if (isset($_GET['Status'])) {
    if ($_GET['Status'] == 200) {
        echo "Status : " . $_GET['Status'] . "<br>";
        echo "Status : " . $_GET['OrderId'] . "<br>";
        echo "Status : " . $_GET['Payment'] . "<br>";
        echo "Status : " . $_GET['Message'] . "<br>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Fontawesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400&family=Work+Sans:wght@300;400&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Work Sans', sans-serif;
        }

        .btn-circle {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .pointer {
            cursor: pointer;
        }

        .fs-10 {
            font-size: 14px !important;
        }

        div.popover-body {
            padding-left: 0 !important;  
            padding-right: 0 !important;             
        }
    </style>

    <!--<script src="script.js"></script>   -->
    <script>
        $(document).ready(function(){

            window.onload = (event) => {
                <?php if (isset($_GET['Status']) && $_GET['Status'] == 200) { ?>
                    $toast = new bootstrap.Toast($("#successPaymentToast"));
                    $toast.show();
                <?php 
                    }
                ?>
            }

            $(".modal-register").hide();
            $('#btn-cart-popover').hide();
            $('#btn-notification-popover').hide();
            $(".sidebar-acc").hide();
            $(".modal-forgot-password").hide();

            $("#sidebar-accounts").click(function(){
                $(".sidebar-acc").show();
            });

            $(".close-sidebar-acc").click(function(){
                $(".sidebar-acc").hide();
            })

            $(".a-forgot-password").click(function(){
                $(".modal-register").hide();
                $(".modal-login").hide();
                $(".modal-forgot-password").show();
            });

            $(".register-back").click(function(){
                $(".modal-register").hide();
                $(".modal-login").show();
                $(".modal-forgot-password").hide();
            });

            $(".a-create-account").click(function(){
                $(".modal-register").show();
                $(".modal-login").hide();
                $(".modal-forgot-password").hide();
            });

            $('.btn-cart').popover({ 
                html : true,
                content: function() {
                    return $('#btn-cart-popover').html();
                }
            }).on('shown.bs.popover', function(e) {

                var current_popover = '#' + $(e.target).attr('aria-describedby');
                var $cur_pop = $(current_popover);
            
                $cur_pop.find('.proceed-payment').click(function(){
                    $("#btn-checkout").trigger("click");
                });

            });

            $('.btn-notification').popover({
                html : true,
                content: function() {
                    return $('#btn-notification-popover').html();
                }
            });

            $(".btn-notification").popover('hide');
            $('.btn-cart').popover('hide');

            $('.btn-cart').click(function(){
                $('#btn-cart-popover').popover('hide');
            });

            $('.btn-notification').click(function(){
                $('#btn-notification-popover').popover('hide');
            });

            $('.btn-user').click(function(){
                $('#btn-cart-popover').popover('hide');
                $('.btn-cart').popover('hide');

                $('#btn-notification-popover').popover('hide');
                $('.btn-notification').popover('hide');
            });
            
            $("#successCreateAccountBtn").click(function(){
                $toast = new bootstrap.Toast($("#successCreateAccountToast"));
                $toast.show();
            });

            $("#failedCreateAccountBtn").click(function(){
                $toast = new bootstrap.Toast($("#failedCreateAccountToast"));
                $toast.show();
            });
            <?php
            if (isset($_GET['SnapToken'])) {
                ?>
                    $("#payNow").click(function(){
                        snap.pay('<?php echo $snap_token?>');
                    });
                <?php
            }
            ?>

        });
    </script>
</head>

<body class="p-0 m-0">


    <!-- Navbar -->
    <?php include 'navbar.php' ?>

    <div id="result-json"></div>

    <button type="button" class="btn btn-primary" id="successCreateAccountBtn" hidden></button>
    <button type="button" class="btn btn-primary" id="failedCreateAccountBtn" hidden></button>

    <form action="payment.php">
        <button type="submit" class="btn btn-primary" id="btn-checkout" hidden>Check</button>
    </form>

    <button class="btn" id="payNow" hidden>Pay Now</button>

    <div class="position-fixed bottom-0 end-0 p-3 " style="z-index: 11">
    
        <div id="successPaymentToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <span class="me-auto">Notifikasi</span>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-success">
                <?php if (isset($_GET['Message'])) {
                    echo $_GET['Message'];
                } ?>
            </div>
        </div>

        <div id="successCreateAccountToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <span class="me-auto">Notifikasi</span>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-success">
                Akun telah berhasil dibuat!
            </div>
        </div>

        <div id="failedCreateAccountToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <span class="me-auto">Notifikasi</span>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-danger">
                Akun tidak berhasil dibuat, Username/email telah digunakan!
            </div>
        </div>
    </div>

    <main class="container mb-5">
        <div class="container p-0 my-3">
            <div class="d-flex justify-content-between mb-3">
                <h3 class="text-primary">
                    Recommended Menu
                </h3>
            </div>
            <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 gx-5 gy-3">
                <?php
                    $sql = mysqli_query($conn, "SELECT * FROM menu ORDER BY RAND() LIMIT 4");

                    while ($row = mysqli_fetch_assoc($sql)) {
                ?>
                <div class="col">
                    <div class="card">
                        <div style="width: 100%; height: 206px; background: url('admin/<?= $row['path'] ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                        <div class="card-body text-center">
                            <form action="add_item_cart.php" method="POST">
                                <input type="text" name="id-menu" value="<?= $row['id'] ?>" hidden>

                                <h5 class="card-title mb-2"><?= $row['nama'] ?></h5>
                                <small style="font-size: 12px;"><?= $row['deskripsi'] ?></small>
                                <h5 class="mt-2" style="font-size: 18px;"><b>Rp <?= $row['harga'] ?></b></h5>
                                <button type="submit" name="add-item-submit" class="btn btn-outline-primary w-100 mt-2" style="font-size: 12px;">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>

        <?php

            $sql_2 = mysqli_query($conn, "SELECT DISTINCT kategori.nama AS NamaKategori FROM kategori RIGHT JOIN menu ON kategori.nama=menu.kategori");

            while($row = mysqli_fetch_assoc($sql_2)){
                
                $NamaKategori = $row['NamaKategori'];
                
                $sql = mysqli_query($conn,
                "SELECT menu.id AS IdMenu, menu.kategori AS KategoriMenu, menu.nama AS NamaMenu, menu.deskripsi AS DeskripsiMenu, 
                menu.harga AS HargaMenu, menu.path as PathMenu
                FROM kategori INNER JOIN menu ON kategori.nama=menu.kategori AND menu.status='0' AND  menu.kategori='$NamaKategori'");
   
        ?>

        <div class="container p-0 my-3">
            <div class="d-flex justify-content-between mb-3">
                <h3 class="text-primary">
                    <?= $row['NamaKategori'] ?>
                </h3>
            </div>
        </div>
        
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 gx-5 gy-3">
            
            <?php
                while($rows = mysqli_fetch_assoc($sql)) {
                    
                    if ($rows['KategoriMenu'] == $NamaKategori) {
                    ?>
                        <div class="col">
                            <div class="card">
                                <div style="width: 100%; height: 206px; background: url('admin/<?= $rows['PathMenu'] ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                                <div class="card-body text-center">
                                    <form action="#" method="POST">
                                        <input type="text" name="id-menu" value="<?= $rows['IdMenu'] ?>" hidden>

                                        <h5 class="card-title mb-2"><?= $rows['NamaMenu'] ?></h5>
                                        <small style="font-size: 12px;"><?= $rows['DeskripsiMenu'] ?></small>
                                        <h5 class="mt-2" style="font-size: 18px;"><b>Rp <?= $rows['HargaMenu'] ?></b></h5>
                                        <button type="submit" class="btn btn-outline-primary w-100 mt-2" style="font-size: 12px;">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
        </div>
                <?php
            }        
        ?>

    </main>

    <footer class="w-100 mt-3 text-center text-primary py-3">
        Restaurant Management System
    </footer>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog p-4 modal-dialog-centered">
            <div class="modal-content p-3" style="border-radius: 7px;">
                <div class="modal-login">
                    <div class="modal-body text-dark p-4 pb-2">
                        <div class="container-fluid d-flex justify-content-between align-items-center">
                            <h5 class="modal-title text-dark" id="exampleModalLabel"><b>Log In</b></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 12px;"></button>
                        </div>
                        <div class="container-fluid my-4 pt-2">
                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                <div class="mb-3">
                                    <input type="text" name="username-login" class="form-control px-3 py-2 text-dark" style="border-radius: 7px;" id="input-email" placeholder="Username">
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password-login" class="form-control px-3 py-2 text-dark" style="border-radius: 7px;" id="input-password" placeholder="Password">
                                </div>
                                <div class="float-end mb-3">
                                    <a href="javacsript:void(0)" class="text-underline a-forgot-password" style="color: rgb(0, 52, 89) !important; font-size: 14px;">Forgot Password?</a>
                                </div>
                                <div class="">
                                    <button type="submit" name="login" class="btn w-100 text-white py-2 bg-primary">Log In</button>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between mt-3" style="font-size: 14px;">
                                <span>Don't have an account yet?</span>
                                <a href="javacsript:void(0)" class="a-create-account" style="color: rgb(0, 52, 89)">Create an Account</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-register">
                    <div class="modal-body text-dark p-4 pb-2">
                        <div class="container-fluid d-flex justify-content-between align-items-center">
                            <h5 class="modal-title text-dark" id="exampleModalLabel">
                                <i class="fas fa-angle-left register-back"></i>
                                <b class="ms-3">Daftar</b>
                            </h5>
                        </div>
                        <div class="container-fluid my-4 pt-2">
                            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="mb-3">
                                    <input type="text" name="nama-register" class="form-control px-3 py-2 text-dark" style="border-radius: 7px;" id="input-email" placeholder="Nama">
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email-register" class="form-control px-3 py-2 text-dark" style="border-radius: 7px;" id="input-email" placeholder="Email">
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="username-register" class="form-control px-3 py-2 text-dark" style="border-radius: 7px;" id="input-email" placeholder="Username">
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password-register" class="form-control px-3 py-2 text-dark" style="border-radius: 7px;" id="input-password" placeholder="Password">
                                </div>
                                <div class="pt-3">
                                    <button class="btn w-100 text-white py-2 bg-primary" type="submit" name="register">Daftar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-forgot-password">
                    <div class="modal-body text-dark p-4 pb-2">
                        <div class="container-fluid d-flex justify-content-between align-items-center">
                            <h5 class="modal-title text-dark" id="exampleModalLabel">
                                <i class="fas fa-angle-left register-back"></i>
                                <b class="ms-3">Lupa Kata Sandi</b>
                            </h5>
                        </div>
                        <div class="container-fluid my-4 pt-2">
                            <form action="">
                                <div class="mb-3">
                                    <input type="email" class="form-control px-3 py-2 text-dark" style="border-radius: 7px;" id="input-email" placeholder="Email">
                                    <div id="emailHelp" class="form-text">Masukkan email anda yang sudah terdaftar untuk dikirimkan email verifikasi.</div>
                                </div>
                                <div class="">
                                    <button class="btn w-100 text-white py-2" style="background-color: rgb(0, 52, 89);">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalQRCode" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <form action="?" method="get">
                    <input type="text" name="table">
                    <button type="submit" name="table">Text</button>
                </form>
            </div>
        </div>
    </div>


</body>
</html>