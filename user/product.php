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
    if(isset($_GET["id"])){

        $id = $_GET["id"];

        $stmt = $conn->query("SELECT p.id, p.kategori, p.name, p.description, p.harga, p.qty, p.berat, p.status, p.minimumorder, p.img_path FROM products p,kategori k WHERE p.kategori = k.id and p.id='$id'");
        $temp = $stmt->fetch_assoc();
        $arrBarang = $temp;
        
        
        $query = "SELECT * FROM variasiwarna WHERE product_id='$id'";
        $stmt = $conn->query($query);
        $allvarian = $stmt->fetch_all(MYSQLI_ASSOC);
        
    }else{
        header("index.php");
    }

?>
<div class="container-fluid m-0 p-0">

    <?php include 'navbar.php' ?>

    <div class="container my-4 mx-auto">
        <div class="row row-cols-3">
            <div class="col-3">
                <?php
                    if(count($allvarian) == 0){       
                        ?>
                        <img id="main-photo-product" src='<?= "../Uploads/".$arrBarang["img_path"]  ?>' alt="" width="300" height="300" class="w-100">
                        
                <?php   
                    }else{
                ?>
                        <img id="main-photo-product" src='<?= "../Uploads/".$allvarian[0]["img_path"]  ?>' alt="" width="300" height="300" class="w-100">
                        
                <?php
                    }
                ?>
                <div class="row row-cols-3 py-2 g-2">
                    <?php
                        if(count($allvarian) == 0){       
                            ?>
                        <div class="col">
                            <div class="card p-1 w-100">
                                <img src='<?= "../Uploads/".$arrBarang["img_path"]  ?>' width="70" height="70" alt="">
                            </div>
                        </div>
                    <?php
                            
                        }else{
                            foreach($allvarian as $key => $value ){
                                ?>
                                <div class="col">
                                    <div class="card p-1 w-100">
                                        <img src='<?= "../Uploads/".$value["img_path"]  ?>' width="70" height="70" alt="">
                                    </div>
                                </div>
                            <?php
                            }
                        }
                    ?>
                    
                </div>
            </div>
            <div class="col-6">
                <?php
                    $idkat = $arrBarang["kategori"];
                    $stmt = $conn->query("SELECT * FROM kategori k WHERE k.id = '$idkat'");
                    $kat = $stmt->fetch_assoc();
                    
                    if(count($allvarian) == 0){  
                        $nama = $arrBarang["name"];
                        $harga = $arrBarang["harga"];
                        $berat = $arrBarang["berat"];
                        $description = $arrBarang["description"];
                        $kategori = $kat["nama_kategori"];

                    }else{
                        $nama = $arrBarang["name"];
                        $harga = $allvarian[0]["harga"];
                        $berat = $arrBarang["berat"];
                        $description = $arrBarang["description"];
                        $kategori = $kat["nama_kategori"];
                        
                    }

                ?>
                <h3 id="produk-nama"><?=$nama ?></h3>
                <h5 id="produk-harga">Rp <?= number_format($harga,2) ?></h5>
                <div class="my-3">
                    <small>Berat</small><p class="fw-light" id="produk-berat"><?= $berat ?> gram</p>
                    <small>Kategori</small><p class="fw-light" id="produk-kategori"><?= $kategori ?></p>
                </div>
                <p>
                    <?= $description ?>
                </p>
            </div>
            <div class="col-3">
            <?php
                    if(count($allvarian) == 0){       
                        ?>
                    
                        <button class="btn btn-dark w-100 mt-3">Beli Langsung</button>
                        <button id="addToCart" class="btn btn-outline-success mt-2 w-100">Masukkan Keranjang</button>
                <?php
                        
                    }else{
                        ?>

                <h5>Pilih Varian</h5>
                <select id="variasi-warna" class="form-select fw-light" aria-label="Default select example">
                        <?php
                        foreach($allvarian as $key => $value ){
                            ?>
                            <option value='<?= $value["id"] ?>'><?= $value["warna"] ?></option>
                        <?php
                        }
                        ?>
                                
                        </select>
                        <button class="btn btn-dark w-100 mt-3">Beli Langsung</button>
                        <button id="addToCart" class="btn btn-outline-success mt-2 w-100">Masukkan Keranjang</button>
                        <?php
                    }
                ?>


            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $("#addToCart").on('click', function() {
            var nows = $("#variasi-warna").val();
            if(nows == null){
                var idprod = <?php echo json_encode($id); ?>;
                var iduser = <?php echo json_encode($now); ?>;
                $.ajax({
                  url: "../controllers/addToCart.php",
                  type: "POST",
                  data: {
                    type: "PRODUK",
                    idproduk: idprod,
                    iduser: iduser
                  },
                  success: function(response){
                      var response = JSON.parse(response);
                      if(response.statusCode==200){
                          $('#error').html('item sukses ditambahkan!');
                          $('#header').html('Sukses');
                          $('#myModal').modal('show');	
                      }else if(response.statusCode==209){
                          $('#error').html('Error item tidak dapat ditambahkan!');
                          $('#header').html('Error');
                          $('#myModal').modal('show');						
                      }
                  }
                });
            }else{
                var idprod = nows;
                var iduser = <?php echo json_encode($now); ?>;
                $.ajax({
                  url: "../controllers/addToCart.php",
                  type: "POST",
                  data: {
                    type: "VARIAN",
                    idproduk: idprod,
                    iduser: iduser
                  },
                  success: function(response){
                      var response = JSON.parse(response);
                      if(response.statusCode==200){
                          $('#error').html('item sukses ditambahkan!');
                          $('#header').html('Sukses');
                          $('#myModal').modal('show');	
                      }else if(response.statusCode==209){
                          $('#error').html('Error item tidak dapat ditambahkan!');
                          $('#header').html('Error');
                          $('#myModal').modal('show');						
                      }
                  }
                });
            }
        });
        $('select').on('change', function() {
            var idkat = this.value;
            var varian = <?php echo json_encode($allvarian); ?>;

            var barang = <?php echo json_encode($arrBarang); ?>;
            varian.forEach(function(item) {
                console.log(item);
                if(item.id == idkat){
                    $("#main-photo-product").attr('src',"../Uploads/"+item.img_path);
                    $("#produk-harga").html("Rp " + Number(item["harga"]).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $("#produk-nama").html(barang["name"]);
                }
            });
        });
    });
    </script>
</div>