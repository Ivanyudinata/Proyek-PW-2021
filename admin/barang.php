<?php 
     require_once '../connection.php';
     $query = "SELECT nama_kategori FROM kategori";
     $kategori = mysqli_query($conn,$query)->fetch_all(MYSQLI_ASSOC);
     if(isset($_REQUEST["btntambah"])){
         $namabarang = $_REQUEST["txtnamabarang"];
         $deskripsibarang = $_REQUEST["txtdeskripsi"];
         $hargabarang = $_REQUEST["txtharga"];
         $jumlahbarang = $_REQUEST["txtqty"];
         $warnabarang = $_REQUEST["txtwarna"];
         $kategori = $_REQUEST["cbkategori"];
         $size = $_REQUEST["txtsize"];
         $query2 = "INSERT INTO products VALUES('','$kategori','$namabarang','$deskripsibarang','$hargabarang','$jumlahbarang','$warnabarang','$size','','')";
         $tambahbarang = mysqli_query($conn,$query2);
     }
    //  $query1 = "SELECT p.*, k.nama_kategori FROM products p INNER JOIN kategori k ON p.kategori = k.id";
    //  $barang = mysqli_query($conn,$query1);
     $query1 = "SELECT * FROM products";
     $barang = mysqli_query($conn,$query1);
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
            <h3 class="mb-3 text-primary">Master Barang</h3>
          </div>
          <!-- <div class="col-4 d-inline-block text-end">    
            <button class="btn btn-primary" style="font-size: 12px; color: white;" data-bs-toggle="modal" data-bs-target="#addTablesModal"><a href="barang.php">Add Item</a></button>
          </div> -->
        </div>
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 gx-5 gy-3">
          <div class="col">
            <form action="#" method="get">
                Nama Barang : <input type="text" name="txtnamabarang" id=""><br>
                Deskripsi Barang : <input type="text" name="txtdeskripsi" id=""><br>
                Harga Barang : <input type="number" name="txtharga" id=""><br>
                Jumlah Barang : <input type="number" name="txtqty" id=""><br>
                Warna Barang : <input type="color" name="txtwarna" id=""><br>
                Kategori Barang : 
                <select name="cbkategori" id="">
                    <?php foreach($kategori as $kat) : ?>
                        <option value=""><?= $kat["nama_kategori"]; ?></option>
                    <?php endforeach; ?>
                </select><br>
                Size : <input type="number" name="txtsize" id=""><br>
                <button type="submit" name="btntambah">Tambah</button>
            </form>
             <table border="1" cellspacing="0" cellpadding="5">
                 <tr>
                     <th>ID</th>
                     <th>Nama Barang</th>
                     <th>Kategori Barang</th>
                     <th>Harga Barang</th>
                     <th>Jumlah Barang</th>
                     <th>Warna Barang</th>
                     <th>Ukuran Barang</th>
                     <th>Deskripsi</th>
                 </tr>
                 <?php foreach($barang as $tampil) : ?>
                    <tr>
                        <td><?= $tampil["id"];?></td>
                        <td><?= $tampil["name"];?></td>
                        <td><?= $tampil["kategori"];?></td>
                        <td><?= $tampil["harga"];?></td>
                        <td><?= $tampil["qty"];?></td>
                        <td><?= $tampil["warna"];?></td>
                        <td><?= $tampil["size"];?></td>
                        <td><?= $tampil["description"];?></td>
                    </tr>
                <?php endforeach; ?>
             </table>
          </div>
        </div>
    </div>
    

</body>
</html>