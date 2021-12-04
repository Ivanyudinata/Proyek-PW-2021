<?php
require_once("../connection.php");

$query = "SELECT * FROM products order by id desc";
$stmt = $conn->query($query);
$allprod = $stmt->fetch_all(MYSQLI_ASSOC);

$string = "Not Found";

$google_chart_api_url = "https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/893b61c5-772c-4f83-828f-cea1e9cd46a1/nikecourt-dri-fit-adv-rafa-18cm-tennis-shorts-MkhwzR.png";

if(count($allprod) > 0){ 
    
    foreach ($allprod as $key => $value) {
        $id = $value["kategori"];
        $stmt = $conn->query("SELECT * FROM kategori WHERE id='$id'");
        $temp = $stmt->fetch_assoc();
        
        $res .= '
        <div class="card p-3 text-center">
            <img src='.$google_chart_api_url.' alt='.$string.'>
            <h5><b> ' . $value["name"] . ' </b></h5>
            <h6> ' . $temp["nama_kategori"] .'</h6>
            <small>Rp ' . number_format($value["harga"],2,',','.') . '</small>
        </div>';
        
    }

    echo $res;
}
    
?>