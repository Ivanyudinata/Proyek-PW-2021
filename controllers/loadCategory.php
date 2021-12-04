<?php
require_once("../connection.php");

$query = "SELECT * FROM kategori order by id asc";
$stmt = $conn->query($query);
$allprod = $stmt->fetch_all(MYSQLI_ASSOC);

if(count($allprod) > 0){ 
    
    foreach ($allprod as $key => $value) {
        ?>
      <tr>
        <td><?= $value["id"] ?></td>
        <td><?= $value["nama_kategori"] ?></td>
        <td>
            <button class="btn" onclick="callback(event,this)" data-tag='<?= $value["nama_kategori"] ?>' id='edit-<?= $value["id"] ?>'>
                <i class='fas fa-edit'></i> 
            </button>
            <button class="btn" onclick="callback(event,this)" id='delete-<?= $value["id"] ?>'>
                <i class='fas fa-trash-alt'></i> 
            </button>
        </td>
      </tr>
      <?php
    }

    echo $res;
}
    
?>