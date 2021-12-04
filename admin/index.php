<?php
    require_once '../connection.php';
    
    if(isset($_COOKIE['now'])){
      $now = $_COOKIE["now"];
        if($now != "admin"){
          header("Location: ../user/index.php");
        }
    }else{
      header("Location: ../index.php");
    }

        
    $stmt = $conn->prepare("SELECT * FROM kategori");
    $stmt->execute();
    $kategori = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400&family=Work+Sans:wght@300;400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css"/>
    <script src="../js/popper.min.js"></script>
    <script src="../js/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" >

    
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
              
      .collapsible  {
          background-color: #777;
          color: white;
          cursor: pointer;
          padding: 18px;
          width: 100%;
          border: none;
          text-align: left;
          outline: none;
          font-size: 15px;
        } 
        
        .active, .collapsible:hover {
          background-color: #555;
        }
        
        .collapsible:after {
          content: '\002B';
          color: white;
          font-weight: bold;
          float: right;
          margin-left: 5px;
        }
        
        .active:after {
          content: "\2212";
        }
        
        .content {
          padding: 0 18px;
          max-height: 0;
          overflow: hidden;
          transition: max-height 0.2s ease-out;
          background-color: #f1f1f1;
        }

    </style>
    <script src="../js/script.js"></script>
</head>
    <?php include 'sidebar.html'; ?>
<body id="body-pd">

  <div class="px-5" id="">
    <div class="row mt-3 pb-3">
      <div class="col-8">
        <h3 class="mb-3 text-primary">Manage Product</h3>
      </div>
      <div class="col-4 d-inline-block text-end">
        <button class="btn btn-primary" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#addTablesModal">Add Item</button>
      </div>
    </div>
    <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 gx-5 gy-3">
      <div class="col">
        <div class="card p-3 text-center">
          <div class="d-flex justify-content-end">
            <button class="btn border-0 p-0 d-inline-block text-end" style="width: auto;">
              <i class="fas fa-print"></i>
            </button>
          </div> <?php
              
              $string = "http://localhost/Retric-Restaurant/?meja=1";

              $google_chart_api_url = "https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/893b61c5-772c-4f83-828f-cea1e9cd46a1/nikecourt-dri-fit-adv-rafa-18cm-tennis-shorts-MkhwzR.png";

              echo "
					<img src='".$google_chart_api_url."' alt='".$string."'>";
            ?> <h5>
            <b> NikeCourt Dri-FIT ADV Rafa </b>
          </h5>
          <h6>Men's 18cm (approx.) Tennis Shorts</h6>
          <small>Rp 789,000</small>
        </div>
      </div>
    </div>

    
  </div>
  <!-- Modal Add Menu -->
  
  <div class="modal fade" id="addTablesModal"  aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
            <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="product-name" class="col-form-label">Nama : </label>
                <input type="text" class="form-control" id="product-name">
              </div>
              <div class="form-group row">
                <div class="col">
                  <label for="product-kategori" class="col-form-label">Kategori : </label>
                  <input class="form-control" list="product-kategori-list" id="product-kategori" placeholder="Type to search...">
                  <datalist id="product-kategori-list"> <?php 
                      foreach($kategori as $key => $value) {
                      ?> <option value='<?= $value["nama_kategori"] ?>'> <?= $value["nama_kategori"] ?> </option> <?php
                      }
                    ?> </datalist>
                </div>
              </div>
              <div class="form-group">
                <label for="product-deskripsi" class="col-form-label">Deskripsi:</label>
                <textarea class="form-control" id="product-deskripsi"></textarea>
              </div>
              <div class="form-group">
                <label for="product-harga"> Harga : </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Rp.</span>
                  </div>
                  <input class="currencyInput form-control validate" type="text" name="hargastandard" id="product-harga" placeholder="Masukkan Harga">
                </div>
              </div>
              <div class="form-group">
                <label for="product-harga"> Minimum Pemesanan : </label>
                <div class="input-group mb-3">
                  <input class="form-control validate" type="number" name="hargastandard" id="product-min-order" placeholder="Masukkan Minimum Pemesanan" require>
                </div>
              </div>
              <hr>
              <label for="variasi-warna"> Warna (Optional) </label>
              <div class="d-flex">
                <select class="selectpicker" id="variasi-warna" multiple data-live-search="true">
                  <option> red </option>
                  <option> yellow</option>
                  <option> blue</option>
                  <option> brown</option>
                  <option> orange</option>
                  <option> green</option>
                  <option> violet</option>
                  <option> black</option>
                  <option> carnation pink</option>
                  <option> yellow orange</option>
                  <option> blue green</option>
                  <option> red violet</option>
                  <option> red orange</option>
                  <option> yellow green</option>
                  <option> blue violet</option>
                  <option> white</option>
                  <option> violet red</option>
                  <option> dandelion</option>
                  <option> cerulean</option>
                  <option> apricot</option>
                  <option> scarlet</option>
                  <option> green yellow</option>
                  <option> indigo and gray</option>
                </select>
              </div>
              <div id="input-variasi-warna" class="d-flex flex-wrap"></div>
              <hr>
              
              <hr>
              <div id="input-variasi-ukuran"></div>
          </div>
          </form>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Add</button>
          </div>
        </div>
      </div>
    </div>
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
          function elemukuran(nama,id ){
            return "<tr>"+
              "<th scope='row'>"+nama+"</th>"+
              "<td>"+
              "<div class='input-group mb-3'>"+
                  "<div class='input-group-prepend'>"+
                    "<span class='input-group-text'>Rp.</span>"+
                  "</div>"+
                "<input type='text' name='ukuran["+id+"]' class='form-control harga' placeholder='Harga' aria-label='Harga'>"+
                "</div>"+
                "</td>"+
              "<td>"+
              
                "<input type='text' name='ukuran["+id+"]' class='form-control' placeholder='Stok' aria-label='Stok'>"+
              

                "</td>"+
              "<td>"+
                "<div class='form-check form-switch'>"+
                  "<input class='form-check-input' name='ukuran["+id+"]' type='checkbox' role='switch' id='flexSwitchCheckDefault' checked>"+
                "</div>"+
              "</td>"+
            "</tr>";
          }
          $(document).ready(function() {
            var warna = [];
              $('select').change(function(e) {
                  var selected = $(e.target).val() + "";
                  var check = selected.split(",");
                  if(e.target.id == "variasi-warna"){
                    var res = "";var war = "";
                    $("#input-variasi-warna").html("");
                    $("#input-variasi-ukuran").html("");
                    warna = check;
                    if(selected != ""){
                      check.forEach(function(item) {
                        var newitem = item.replace(/\s/g, '');
                        res = "<div id='warna-"+newitem+"' class='card p-0 m-3 border-0' style='width: 6rem'>" +     
                                      "<div class='w-100 d-flex justify-content align-items-center' style='height: 100px; border: 1px solid red; line-height: 30px;' >"+
                                        "<img id='warna-img-"+newitem+"' src='../assets/plus.svg' class='w-100 h-100'>"+
                                        "<input type='file' accept='image/*' id='warna-input-"+newitem+"' style='opacity: 0.0; position: absolute; top: 0; left: 0; bottom: 0; right: 0; width: 100%; height:100%;' />"+
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
                        war += elemukuran(item,newitem);
                      });
                      res = "<table class='table caption-top'>"+
                                    "<thead>"+
                                      "<tr>"+
                                        "<th scope='col'>Nama</th>"+
                                        "<th scope='col'>Harga</th>"+
                                        "<th scope='col'>Stok</th>"+
                                        "<th scope='col'>Status</th>"+
                                      "</tr>"+
                                    "</thead>"+
                                    "<tbody>"+
                                      war + 
                                    "</tbody>"+
                                  "</table>";
                                  
                        $("#input-variasi-ukuran").append(res);
                        var newnum = new AutoNumeric.multiple('.harga', AutoNumeric.getPredefinedOptions().numericPos.dotDecimalCharCommaSeparator);
                      }
                    }
                  }); 
              var autoNumericInstance = new AutoNumeric('#product-harga', AutoNumeric.getPredefinedOptions().numericPos.dotDecimalCharCommaSeparator);
              
          });

        </script>
            
</body>
</html>