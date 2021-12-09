<?php
    require_once '../connection.php';
    
    require_once("../alert.html");
    if(isset($_COOKIE['now'])){
      $now = $_COOKIE["now"];
        if($now != "admin"){
          header("Location: ../user/index.php");
        }
    }else{
      header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Kategori | Skibble Store</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Fontawesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400&family=Work+Sans:wght@300;400&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
      $(document).ready(function() {
        
        $("#btn-close-sidebar").click(function(){
          $(".text-desc").toggle();
        });
      });
    </script>

    <style>
        * {
            font-family: 'Work Sans', sans-serif;
        }

        body, html {
          height: 100%;
        }
    </style>

</head>
<body>

    <?php include 'sidebar.html'; ?>
    
    <div class="px-5" >
        <div class="row mt-3 pb-3">
          <div class="col-8">
            <h3 class="mb-3 text-primary">Manage Category</h3>
          </div>
          <div class="col-4 d-inline-block text-end">    
            <button class="btn btn-primary" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#addTablesModal">Add Item</button>
          </div>
        </div>
        <table class="table text-dark table-hover">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Category Name</th>
            <th scope="col">Action</th>
          </tr>
        </thead>  
        <tbody id="tableCategory">

        </tbody>
        </table>
    </div>
    
    <!-- Modal Add Menu -->
    
  <div class="modal fade" id="addTablesModal"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-small modal-dialog-centered">
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
              <input type="text" class="form-control" id="category-name">
            </div>
          </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="addKategori" class="btn btn-primary">Add</button>
        </div>
      </div>
    </div>
  </div>
        
    
</body>
<script>
  function load(){
    $('#tableCategory').load("../controllers/loadCategory.php", 
        function (response, status, request) {
        }    
    );
  }
  
  function callback(e, thisObj) {	
    var arr = e.currentTarget.id.split("-");
    if(arr[0] == "edit"){
      $('#exampleModalLabel').html('Edit Product');	
      $('#addKategori').html('Edit');	
      $('#category-name').val(e.currentTarget.dataset.tag);	
      $('#addKategori').attr('IDKategori', arr[1]);
      $('#addTablesModal').modal('show');

    }else if(arr[0] == "delete"){
      $('#btn-Ok').attr('IDKategori', arr[1]);
      $('#ConfirmationModal').modal('show');	
    }
 
  }
  
  $(document).ready(function() {
      load();
    
      $('#addKategori').on('click', function() {
          $('#addTablesModal').modal('hide');	
          $('body').removeClass('modal-open');
          $('.modal-backdrop').remove();
          var nama = $('#category-name').val();
          if(nama != ""  ){
            if($('#addKategori').html() == "Edit"){
              var id = $('#addKategori').attr('IDKategori');
              $.ajax({
                  url: "../controllers/category.php",
                  type: "POST",
                  data: {
                      type:"EDIT",
                      nama: nama,
                      idkategori: id					
                  },
                  success: function(response){
                      console.log(response);
                      var response = JSON.parse(response);
                      if(response.statusCode==200){
                          $('#error').html('Berhasil diedit!');
                          $('#header').html('Success');
                          $('#myModal').modal('show');	
                          load();			
                      }else if(response.statusCode==209){
                          $('#error').html('Gagal diedit!');
                          $('#header').html('Error');
                          $('#myModal').modal('show');						
                      }
                      
                  }
              });
            }else{
              $.ajax({
                  url: "../controllers/category.php",
                  type: "POST",
                  data: {
                      type:"ADD",
                      nama: nama						
                  },
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
          }
          else{
              $('#error').html('Semua kolom harus diisi!');
              $('#header').html('Empty Field');
              $('#myModal').modal('show');
          }
      });

      $('#btn-Ok').on('click', function(e) {
        $('#ConfirmationModal').modal('hide');	
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        var id = $(this).attr('IDKategori');
        $.ajax({
            url: "../controllers/category.php",
            type: "POST",
            data: {
                type:"DEL",
                idkategori: id						
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
      });

  });

</script>
</html>