<?php
require_once("../connection.php");

$status = $_POST["status"];
$quer = "where status=0";

if($status == "SEMUA"){
    $quer = "";
}else if($status == "ACTIVE"){
    $quer = "where status=1";
}


$query = "SELECT * FROM products ". $quer." order by id asc " ;
$stmt = $conn->query($query);
$allprod = $stmt->fetch_all(MYSQLI_ASSOC);
$res = "";
if(count($allprod) > 0){ 
    
    foreach ($allprod as $key => $value) {
        $idkategori = $value["kategori"];
        $idproduk = $value["id"];
        $stmt = $conn->query("SELECT * FROM kategori WHERE id='$idkategori'");
        $temp = $stmt->fetch_assoc();

                
        $query = "SELECT * FROM variasiwarna where product_id='$idproduk' order by id asc";
        $stmt = $conn->query($query);
        $allvariasi = $stmt->fetch_all(MYSQLI_ASSOC);
        $variasi = "";
        

        foreach ($allvariasi as $key => $values) {
            $isActive = ($values["status"] == 0) ? "" : "checked";
            $variasi .= '
                <tr style="background-color: rgb(243,244,245)">
                  <td>
                    <div class="d-flex">
                      <a class="d-inline-block position-relative" href="index.php" >
                        <img src="../Uploads/'.$values["img_path"].'" alt="'.$values["nama"].'" width="56" height="56" >
                      </a> 
                      <b class="d-inline-block align-items-start">'.$values["warna"].'</b>
                    </div>
                  </td>
                  <td>
                  '.$values["harga"].'
                  </td>
                  <td>
                  '.$values["stok"].'
                  </td>
                  <td>
                    <div class="form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" '.$isActive.'>
                    </div>
                  </td>
                  <td>
                    
                  </td>
                </tr>';
        }
        if(count($allvariasi) > 0){
            $variasi = "<tr>" . $variasi . "</tr>";
        }
        $isMainActive = ($value["status"] == 0) ? "" : "checked";
        $res .= '
        <tr class="spacer">
            <tr>
              <td style="padding-bottom: 1em;"> 
                <div class="d-flex">
                  <a class="d-inline-block position-relative" href="index.php" >
                    <img src="../Uploads/'. $value["img_path"].'" alt="'.$value["name"].'" width="56" height="56" >
                  </a> 
                  <a class="d-inline-block align-items-start" href="index.php">
                    <h5 class="d-block position-relative fw-bold">'.$value["name"].'</h5>
                  </a>
                </div>
              </td>
              <td>
                <div>
                  <h5>'. (isset($value["harga"]) ? $value["harga"] : 0) .'</h5>
                </div>
              </td>
              <td>
                <div>
                  <h5>'. $value["qty"].'</h5> 
                </div>
              </td>
              <td>
                <div class="form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="switch-'. $value["id"].'" onchange="onClickChxBox(this)" '.$isMainActive.'>
                </div>
              </td>
              <td>
                <button class="btn" onclick="callback(event,this)" data-tag="'. $value["id"].'" id="edit-'. $value["id"].'">
                    <i class="fas fa-edit"></i> 
                </button>
                <button class="btn" onclick="callback(event,this)" id="delete-'. $value["id"].'">
                    <i class="fas fa-trash-alt"></i> 
                </button>
              </td>
            </tr>
            ' . $variasi . '
          </tr>';
        
    }

    echo $res;
}
    
?>