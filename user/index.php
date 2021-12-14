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