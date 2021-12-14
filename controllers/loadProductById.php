<?php
require_once("../connection.php");


$id = $_POST["id"];

$stmt = $conn->query("SELECT p.id, p.kategori, p.name, p.description, p.harga, p.qty, p.berat, p.status, p.minimumorder, p.img_path FROM products p,kategori k WHERE p.kategori = k.id and p.id='$id'");
$temp = $stmt->fetch_assoc();
$arrBarang = $temp;


$query = "SELECT * FROM variasiwarna WHERE product_id='$id'";
$stmt = $conn->query($query);
$allvarian = $stmt->fetch_all(MYSQLI_ASSOC);

$arrret = array();
foreach($allvarian as $key => $value){
    array_push($arrret,$value);
}

echo json_encode(array($arrBarang,$arrret))
?>