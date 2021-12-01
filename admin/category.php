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
    $query = "SELECT * FROM kategori";
    $kategori = mysqli_query($conn,$query)->fetch_all(MYSQLI_ASSOC);
    if(isset($_REQUEST["btnaddkategori"])){
        $namakategori = $_REQUEST["txtnamakategori"];
        $query1 = "INSERT INTO kategori VALUES('','$namakategori')";
        $tambahkategori = mysqli_query($conn,$query1);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | Retric Restaurant</title>

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

    <script src="../script.js"></script>

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
    
    <div class="px-5 py-4" style="margin-left: 70px;">
        <div class="row mt-3 pb-3">
          <div class="col-8">
            <h3 class="mb-3 text-primary">Tambah Kategori</h3>
          </div>
          <div class="col-4 d-inline-block text-end">    
            <button class="btn btn-primary" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#addTablesModal">Add Item</button>
          </div>
        </div>
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 gx-5 gy-3">
          <div class="col">
                <form action="#" method="get">
                    Nama Kategori : <input type="text" name="txtnamakategori" id=""><br>
                    <button type="submit" name="btnaddkategori">Add Kategori</button>
                </form>
                <table border="1" cellspacing="0" cellpadding="1">
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                    </tr>
                    <?php foreach($kategori as $kat) : ?>
                        <tr>
                            <td><?= $kat["id"]; ?></td>
                            <td><?= $kat["nama_kategori"]; ?></td>

                        </tr>
                    <?php endforeach; ?>
                </table>
          </div>
        </div>
    
    <!-- Modal Add Menu -->
    <div class="modal fade" id="addTablesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
          Text
        </div>
      </div>
    </div>

</body>
</html>