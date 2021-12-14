<?php
require_once("../connection.php");

$query = "SELECT * FROM products where status=1 order by id asc" ;
$stmt = $conn->query($query);
$allprod = $stmt->fetch_all(MYSQLI_ASSOC);
$res = "";
if(count($allprod) > 0){ 
    
    foreach ($allprod as $key => $value) {
        $res .= '
        <div class="col">
            <a href="product.php">
                <div class="col card w-100 p-3">
                    <img src="../Uploads/'.$value["img_path"].'" alt="" class="card-img-top"  width="188" height="188">
                    <h5 class="card-title mt-2 fw-normal mb-1" style="letter-spacing: 2px; font-size: 18px;">'.$value["name"].'</h5>
                    <small class="lh-sm fw-light mb-2" style="letter-spacing: 0 !important;">'.$value["description"].'</small>
                    <b class="d-inline-block text-end">Rp. '.$value["harga"].'</b>
                </div>
            </a>
        </div>';
        
    }

    echo $res;
}
    
?>