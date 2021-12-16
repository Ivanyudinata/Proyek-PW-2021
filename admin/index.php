<?php
    require_once '../connection.php';
    
    if(isset($_COOKIE['now'])){
      $now = $_COOKIE["now"];
        if($now != "admin"){
          header("Location:../user/index.php");
        }
    }else{
      header("Location:../index.php");
    }

        
    $stmt = $conn->prepare("SELECT * FROM kategori");
    $stmt->execute();
    $kategori = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    require_once '../alert.html';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Barang | Skibble Store</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Fontawesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js" integrity="sha512-U0/lvRgEOjWpS5e0JqXK6psnAToLecl7pR+c7EEnndsVkWq3qGdqIGQGN2qxSjrRnCyBJhoaktKXTVceVG2fTw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400&family=Work+Sans:wght@300;400&display=swap" rel="stylesheet">

    <script src="../js/popper.min.js"></script>
    <script src="../js/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" >

    
    <script src="../js/script.js"></script>
    

    <script>
          function addcollapse(){
            var coll = document.getElementsByClassName("collapsible");
            var i;

            for (i = 0; i < coll.length; i++) {
              coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.maxHeight){
                  content.style.maxHeight = null;
                } else {
                  content.style.maxHeight = content.scrollHeight + "px";
                } 
              });
            }

          }
    </script>
      <script>
        var now = "SEMUA";

        function load(){
          var table = (now == "SEMUA" ? "tableSemuaProduk" : (now == "ACTIVE" ? "tableProdukAktif" : "tableProdukNonAktif") ); 
          $('#'+table).load("../controllers/loadProduct.php",{
            status: now
          }, function (response, status, request) {

            }    
          );
        }
        
        function onClickChxBox(e){
          var arr = e.id.split("-");
          if(arr[0] == "switchvar"){

            $.ajax({
                url: "../controllers/product.php",
                type: "POST",
                data: {
                  type: "SWITCHVAR",
                  idvarian: arr[1]
                },
                success: function(response){
                    var response = JSON.parse(response);
                    if(response.statusCode==200){
                        load();			
                    }else if(response.statusCode==209){
                        $('#error').html('Error status tidak bisa diubah!');
                        $('#header').html('Error');
                        $('#myModal').modal('show');						
                    }
                    
                }
              });
          }else{
            $.ajax({
                  url: "../controllers/product.php",
                  type: "POST",
                  data: {
                    type: "SWITCH",
                    idproduk: arr[1]
                  },
                  success: function(response){
                      var response = JSON.parse(response);
                      if(response.statusCode==200){
                          load();			
                      }else if(response.statusCode==209){
                          $('#error').html('Error status tidak bisa diubah!');
                          $('#header').html('Error');
                          $('#myModal').modal('show');						
                      }
                      
                  }
                });

          }
        }

        var lastColor = [];
        function callback(e, thisObj) {	
          var arr = e.currentTarget.id.split("-");
          if(arr[0] == "edit"){
            $('#exampleModalLabel').html('Edit Product');	
            $('#addKategori').html('Edit');	
            
            $.ajax({
              url: "../controllers/loadProductById.php",
              type: "POST",
              data: {
                id:arr[1]						
              },
              success: function(response){
                  console.log(response);
                  var response = JSON.parse(response);
                  if(response[1].length > 0){
                    
                    $('#product-name').val(response[0]["name"]);
                    $('#product-deskripsi').val(response[0]["description"]);
                    $('#product-min-order').val(response[0]["minimumorder"]);
                    $('#product-berat').val(response[0]["berat"]);
                    
                    $("#product-kategori option[value='"+response[0]["kategori"]+"']").attr('selected','selected').change();
                    
                    $('#product-kategori').val(response[0]["kategori"]).change();
                    
                    var text = $("#product-kategori option[value='"+response[0]["kategori"]+"']").text();
                    
                    var arrsd = [];
                    response[1].forEach(function(item) {
                      var stat = (item["status"] == 1) ? "checked" : "";
                      var newelem = elemukuranedit(item["warna"],item["harga"],item["stok"],stat);
                      $("#input-attr-warna").append(newelem);
                      var newitem = item["warna"].replace(/\s/g, '');
                      $("#variasi-warna option[value='"+newitem+"']").prop("selected", true);
                      arrsd.push(newitem);
                      lastColor.push(newitem);
                      res = "<div id='warna-"+newitem+"' class='card p-0 m-3 border-0' style='width: 6rem'>" +     
                                "<div class='w-100 d-flex justify-content align-items-center' style='height: 100px; border: 1px solid red; line-height: 30px;' >"+
                                  "<img id='warna-img-"+newitem+"' src='../Uploads/"+item["img_path"]+"' class='w-100 h-100'>"+
                                  "<input type='file' accept='image/*' src='../Uploads/"+item["img_path"]+"' name='Gambar[]' id='warna-input-"+newitem+"' style='opacity: 0.0; position: absolute; top: 0; left: 0; bottom: 0; right: 0; width: 100%; height:100%;' required/>"+
                                "</div>"+
                                "<div class='w-100 bg-danger text-white text-center' style='font-size: 14px;'>"+
                                  "<span>"+newitem+"</span>" + 
                                "</div>" + 
                            "</div>";
                      $("#input-variasi-warna").append(res);
                      $('#warna-input-'+newitem+'').change(function(evt) {
                        const[file] = $('#warna-input-'+newitem+'').prop('files');
                        if (file) {
                          $('#warna-img-'+newitem+'').attr("src",URL.createObjectURL(file));
                        }
                        
                      });

                      $("#input-harga").hide();
                    });
                    $("#variasi-warna").val(arrsd);
                  }else{

                    $('#product-name').val(response[0]["name"]);
                    $('#product-deskripsi').val(response[0]["description"]);
                    $('#product-min-order').val(response[0]["minimumorder"]);
                    $('#product-berat').val(response[0]["berat"]);
                    $('#product-harga').val(response[0]["harga"]);
                    $('#product-stok').val(response[0]["qty"]);
                    
                    
                    $("#warna-input-main").attr("src","../Uploads/"+response[0]["img_path"]);
                    $('#warna-img-main').attr("src","../Uploads/"+response[0]["img_path"]);
                    $("#product-kategori option[value='"+response[0]["kategori"]+"']").attr('selected','selected').change();
                    
                    $('#product-kategori').val(response[0]["kategori"]).change();
                    
                    var text = $("#product-kategori option[value='"+response[0]["kategori"]+"']").text();
                    
                  }
                  
                  $('#addTablesModal').modal('show');
                  $('#addBarang').attr('IDKategori', arr[1]);
                }
              });
          }else if(arr[0] == "delete"){
            $('#btn-Ok').attr('IDProduk', arr[1]);
            $('#ConfirmationModal').modal('show');	
          }else if(arr[0] == "deletevar"){
            $('#btn-Ok').attr('IDVariasi', arr[1]);
            $('#ConfirmationModal').modal('show');	

          }else if(arr[0] == "editvar"){
            
            $('#editTablesModal').modal('show');
          }
      
        }

        function elemukuranedit(id,harga,stok,status ){
          return "<tr id='tab-"+id+"'>"+
            "<th scope='row'>"+id+"</th>"+
            "<td>"+
            "<div class='input-group mb-3'>"+
                "<div class='input-group-prepend'>"+
                  "<span class='input-group-text'>Rp.</span>"+
                "</div>"+
              "<input type='text' value='"+harga+"' name='hargaVarian[]' class='form-control harga' placeholder='Harga' aria-label='Harga' required>"+
              "</div>"+
              "</td>"+
            "<td>"+
              "<input type='number' value='"+stok+"' name='stokVarian[]' class='form-control' placeholder='Stok' aria-label='Stok' required>"+
              "</td>"+
            "<td>"+
              "<div class='form-check form-switch'>"+
                "<input class='form-check-input' name='statusVarian[]' type='checkbox' role='switch' "+status+">"+
              "</div>"+
            "</td>"+
          "</tr>";
        }
        function elemukuran(nama,id ){
          return "<tr id='tab-"+id+"'>"+
            "<th scope='row'>"+nama+"</th>"+
            "<td>"+
            "<div class='input-group mb-3'>"+
                "<div class='input-group-prepend'>"+
                  "<span class='input-group-text'>Rp.</span>"+
                "</div>"+
              "<input type='text' name='hargaVarian[]' class='form-control harga' placeholder='Harga' aria-label='Harga' required>"+
              "</div>"+
              "</td>"+
            "<td>"+
              "<input type='number' name='stokVarian[]' class='form-control' placeholder='Stok' aria-label='Stok' required>"+
              "</td>"+
            "<td>"+
              "<div class='form-check form-switch'>"+
                "<input class='form-check-input' name='statusVarian[]' type='checkbox' role='switch' checked>"+
              "</div>"+
            "</td>"+
          "</tr>";
        }

        $(document).ready(function() {
          var warna = [];
          
          load();
          
          $('#allproduct-tab').on('click',function(e) {
            now = "SEMUA";
            load();
          });
          $('#aktifproduct-tab').on('click',function(e) {
            now = "ACTIVE";
            load();
          });
          $('#nonaktifproduct-tab').on('click',function(e) {
            now = "NONACTIVE";
            load();
          });

          $('#addBarang').submit(function(e) {
              e.preventDefault();
                
            if($('#addBarang').attr('IDKategori') != null){
              var id = $(this).attr('IDKategori');
              
              alert("TESTING");
            }else{
              $('#addTablesModal').modal('hide');	
              $('body').removeClass('modal-open');
              $('.modal-backdrop').remove();
              var kam = "";
              var form = $('form')[0]; 
              var formData = new FormData(form);
              
              formData.append('type', 'ADD');
              $.ajax({
                url: "../controllers/product.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response);
                    var response = JSON.parse(response);
                    if(response.statusCode==200){
                        $('#error').html('Berhasil Add!');
                        $('#header').html('Success');
                        $('#myModal').modal('show');	
                        load();			
                    }else if(response.statusCode==209){
                        $('#error').html('Nama sudah ada!');
                        $('#header').html('Error');
                        $('#myModal').modal('show');						
                    }
                    
                }
              });
              
            }
            
          });
  
          $('#btn-Ok').on('click', function(e) {
            $('#ConfirmationModal').hide();	
            var id = $(this).attr('IDProduk');
            if(id != null){
              $.ajax({
                  url: "../controllers/product.php",
                  type: "POST",
                  data: {
                      type:"DEL",
                      idproduk: id						
                  },
                  success: function(response){
                      console.log(response);
                      var response = JSON.parse(response);
                      if(response.statusCode==200){
                          $('.modal-backdrop').remove();
                          $('#error').html('Berhasil Dihapus!');
                          $('#header').html('Success');
                          $('#myModal').modal('show');	
                          load();			
                      }else if(response.statusCode==209){
                          $('#error').html('Gagal Dihapus!');
                          $('#header').html('Error');
                          $('#myModal').modal('show');		
                          $('.modal-backdrop').remove();				
                      }
                      
                  }
              });

            }else{
              var id = $(this).attr('IDVariasi');
              $.ajax({
                  url: "../controllers/product.php",
                  type: "POST",
                  data: {
                      type:"DELVARIASI",
                      idvariasi: id						
                  },
                  success: function(response){
                      console.log(response);
                      var response = JSON.parse(response);
                      if(response.statusCode==200){
                          $('#error').html('Berhasil Dihapus!');
                          $('#header').html('Success');
                          $('#myModal').modal('show');	
                          load();			
                      }else if(response.statusCode==209){
                          $('#error').html('Gagal Dihapus!');
                          $('#header').html('Error');
                          $('#myModal').modal('show');						
                      }
                      
                  }
              });

            }
          });

          $('#warna-input-main').change(function(evt) {
            const[file] = $('#warna-input-main').prop('files');
            if (file) {
              $('#warna-img-main').attr("src",URL.createObjectURL(file));
            }
          });
          $('#addTablesModal').on('hidden.bs.modal', function(e) {
            $(this).find('form')[0].reset();
            $('#variasi-warna').val('');
            $("#input-harga").show();
            $("#input-variasi-warna").html('');
            $("#input-attr-warna").html('');
            if($('#addBarang').attr('IDKategori') != null){
              $('#addBarang').removeAttr('IDKategori');
            }

            $("#product-kategori").val('default');
            $("#variasi-warna").val('default');
            $(".filter-option-inner-inner").html('');
            $("#product-harga").prop('disabled', false);
            lastColor = [];
            $("#product-stok").prop('disabled', false);
          });

          $('#addTablesModal').on('show.bs.modal', function(e) {
            $("#warna-input-main").prop('disabled', false);
            
          });
          var newnum;
          $('select').change(function(e) {
            var selected = $(e.target).val() + "";
            var check = selected.split(",");
            if(e.target.id == "variasi-warna"){
              var res = "";var war = "";
              warna = check;
              if(selected != ""){
                $("#input-harga").hide();
                $("#warna-input-main").val('');
                $('#warna-img-main').attr('src', '../assets/plus.svg');
                $("#warna-input-main").prop('disabled', true);
                $("#product-harga").prop('disabled', true);
                $("#product-stok").prop('disabled', true);

                if(lastColor != null){
                  console.log(lastColor + " Check: " + check);
                }
                if(lastColor.length > 0){
                  lastColor.forEach(function(item) {
                      if(check.indexOf(item) == -1){
                        if(check.length < lastColor.length ){
                          var newitem = item.replace(/\s/g, '');
                          $('#warna-'+newitem+'').remove();
                          $('#tab-'+newitem+'').remove();
                        }
                      }
                    
                    
                  });
                }
                check.forEach(function(item) {
                  var ada = false;
                  if(lastColor != null){
                    lastColor.forEach(function(itemColor) {
                      if(item == itemColor){
                        ada = true;
                      }
                    });
                  }
                  if(!ada){
                    var newitem = item.replace(/\s/g, '');
                    res = "<div id='warna-"+newitem+"' class='card p-0 m-3 border-0' style='width: 6rem'>" +     
                                  "<div class='w-100 d-flex justify-content align-items-center' style='height: 100px; border: 1px solid red; line-height: 30px;' >"+
                                    "<img id='warna-img-"+newitem+"' src='../assets/plus.svg' class='w-100 h-100'>"+
                                    "<input type='file' accept='image/*' name='Gambar[]' id='warna-input-"+newitem+"' style='opacity: 0.0; position: absolute; top: 0; left: 0; bottom: 0; right: 0; width: 100%; height:100%;' required/>"+
                                  "</div>"+
                                  "<div class='w-100 bg-danger text-white text-center' style='font-size: 14px;'>"+
                                    "<span>"+item+"</span>" + 
                                  "</div>" + 
                              "</div>";
                    $("#input-variasi-warna").append(res);
                    $('#warna-input-'+newitem+'').change(function(evt) {
                      const[file] = $('#warna-input-'+newitem+'').prop('files');
                      if (file) {
                        $('#warna-img-'+newitem+'').attr("src",URL.createObjectURL(file));
                      }
                    });
                    
                    $("#input-attr-warna").append(elemukuran(item,newitem));
                    
                  }
                });
                lastColor = check;
                if(check.length == 0){
                  $("#input-variasi-ukuran").hide();
                }
                }else{
                  $("#input-harga").show();
                  $("#warna-input-main").prop('disabled', false);
                  $("#product-harga").prop('disabled', false);
                  $("#product-stok").prop('disabled', false);
                
                }
              }
            }); 
        });

      </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <style>
      :root {
        --nav-width: 100px;
        --sidebar-width: 110px;
        --z-fixed: 100;
      }

        * {
            font-family: 'Work Sans', sans-serif;
        }

        body, html {
          height: 100%;
          position: relative;
        }
        tr.spacer>td {
          padding-bottom: 1em;
        }
    </style>
</head>
    <?php include 'sidebar.html'; ?>
<body id="body-pd">

  <div class="px-5 container" id="">
    <div class="row mt-3 pb-3">
      <div class="col-8">
        <h3 class="mb-3 text-primary">List Product</h3>
      </div>
      <div class="col-4 d-inline-block text-end">
        <button class="btn btn-primary" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#addTablesModal">Add Item</button>
      </div>
    </div>
    
    <ul class="nav nav-tabs" id="productTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="allproduct-tab" data-bs-toggle="tab" data-bs-target="#allproduct" type="button" role="tab" aria-controls="home" aria-selected="true">Semua Produk</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="aktifproduct-tab" data-bs-toggle="tab" data-bs-target="#aktifproduct" type="button" role="tab" aria-controls="profile" aria-selected="false">Aktif</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="nonaktifproduct-tab" data-bs-toggle="tab" data-bs-target="#nonaktifproduct" type="button" role="tab" aria-controls="contact" aria-selected="false">Nonaktif</button>
      </li>
    </ul>
    <div class="tab-content" id="productTabContent">
      <div class="tab-pane fade show active table-responsive-md" id="allproduct" role="tabpanel" aria-labelledby="allproduct-tab">
        <table class="table text-dark table-hover">
        <thead>
          <tr>
            <th scope="col">Info Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Stok</th>
            <th scope="col">Aktif</th>
            <th scope="col">Action</th>
          </tr>
        </thead>  
        <tbody id="tableSemuaProduk">

        </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="aktifproduct" role="tabpanel" aria-labelledby="aktifproduct-tab">
        <table class="table text-dark table-hover">
        <thead>
          <tr>
            <th scope="col">Info Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Stok</th>
            <th scope="col">Aktif</th>
            <th scope="col">Action</th>
          </tr>
        </thead>  
        <tbody id="tableProdukAktif">

        </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="nonaktifproduct" role="tabpanel" aria-labelledby="nonaktifproduct-tab">
        <table class="table text-dark table-hover">
        <thead>
          <tr>
            <th scope="col">Info Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Stok</th>
            <th scope="col">Aktif</th>
            <th scope="col">Action</th>
          </tr>
        </thead>  
        <tbody id="tableProdukNonAktif">

        </tbody>
        </table>
      </div>
    </div>

    
  </div>
  <!-- Modal Add Produk -->
  
  <div class="modal fade" id="addTablesModal"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
          <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" id="addBarang" enctype="multipart/form-data">
            <div class="form-group py-2">
              <label for="product-name" class="col-form-label">Nama : </label>
              <input type="text" class="form-control" id="product-name" name="product-name" required>
            </div>

            <div class="form-group row py-2">
              <div class="col">
                <label for="product-kategori" class="col-form-label">Kategori : </label>
                <select class="form-control selectpicker" id="product-kategori" name="product-kategori" data-live-search="true" required>
                <?php 
                foreach($kategori as $key => $value) {
                    ?> 
                    <option value='<?= $value["id"] ?>'> <?= $value["nama_kategori"] ?> </option> 
                    <?php
                  }
                    ?>
                  </select>
              </div>
            </div>

            <div class="form-group py-2">
              <label for="product-deskripsi" class="col-form-label">Deskripsi:</label>
              <textarea class="form-control" id="product-deskripsi" name="product-deskripsi"></textarea>
            </div>

            <div class="form-group py-2">
              <label for="product-min-order"> Minimum Pemesanan : </label>
              <div class="input-group mb-3">
                <input class="form-control validate" type="number" name="product-min-order" id="product-min-order" placeholder="Masukkan Minimum Pemesanan" required>
              </div>
            </div>

            
            <div class="d-flex py-2">
              <label for="variasi-warna"> Warna (Optional) </label>
              <select class="selectpicker" id="variasi-warna" name="product-variasi-warna[]" multiple data-live-search="true">
                <option value="red">red</option>
                <option value="yellow">yellow</option>
                <option value="blue">blue</option>
                <option value="brown">brown</option>
                <option value="orange">orange</option>
                <option value="green">green</option>
                <option value="violet">violet</option>
                <option value="black">black</option>
                <option value="white">white</option>
                <option value="dandelion">dandelion</option>
                <option value="cerulean">cerulean</option>
                <option value="apricot">apricot</option>
                <option value="scarlet">scarlet</option>
              </select>
            </div>
            <hr>
            

            <div id="input-variasi-warna" class="d-flex flex-wrap py-2"></div>

            <div class="form-group py-2" id="input-harga">
              <label for="product-harga"> Foto Produk </label>
              <div id='gambarmain' class='card p-0 m-3 border-0' style='width: 6rem'>
                <div class='w-100 d-flex justify-content align-items-center' style='height: 100px; border: 1px solid red; line-height: 30px;' >
                  <img id='warna-img-main' src='../assets/plus.svg' class='w-100 h-100'>
                  <input type='file' accept='image/*' name='Gambar[]' id='warna-input-main' style='opacity: 0.0; position: absolute; top: 0; left: 0; bottom: 0; right: 0; width: 100%; height:100%;' required/>
                </div>

                <div class='w-100 bg-danger text-white text-center' style='font-size: 14px;'>
                  <span>Main Picture</span>
                </div> 
              </div>
              <label for="product-harga"> Harga : </label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input class="form-control validate" type="number" name="product-harga" id="product-harga" placeholder="Masukkan Harga" required>
              </div>
              
              <label for="product-stok"> Stok : </label>
              <div class="input-group mb-3">
                <input class="form-control validate" type="number" name="product-stok" id="product-stok" placeholder="Masukkan Stok" required>
              </div>
            </div>
            
            
            <div id="input-variasi-ukuran">

              <table class='table caption-top'>
                <thead>
                  <tr>
                    <th scope='col'>Nama</th>
                    <th scope='col'>Harga</th>
                    <th scope='col'>Stok</th>
                    <th scope='col'>Status</th>
                  </tr>
                </thead>
                <tbody id="input-attr-warna">
                  
                </tbody>
              </table>
            </div>

            <div class="form-group py-2" id="input-berat">
              <label for="product-berat"> Berat : </label>
              <div class="input-group mb-3">
                <input class="currencyInput form-control validate" type="text" name="product-berat" id="product-berat" placeholder="Masukkan Berat" required>
                <div class="input-group-prepend">
                  <span class="input-group-text">Gram(g)</span>
                </div>
              </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="product-add">Add</button>
        </div>
        </form>

      </div>
    </div>
  </div>
            
</body>
</html>