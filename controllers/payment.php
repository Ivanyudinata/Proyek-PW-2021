<?php

    namespace Midtrans;

    require_once dirname(__DIR__,1) . '\midtrans\midtrans-php\Midtrans.php';
    require_once '../connection.php';

    Config::$serverKey = 'SB-Mid-server-9QZqJhyir6z2I_OHfHj3Z9M1';
    Config::$clientKey = 'SB-Mid-client-IZTGPkzRSyrlUwxH';

    Config::$isSanitized = true;
    Config::$is3ds = true;

    $id_pelanggan = $_COOKIE['now'];

    $sql = mysqli_query($conn, "SELECT SUM(harga * cart_item.qty) as HargaMenu FROM cart_item LEFT JOIN cart ON cart.id=cart_item.cart_id  INNER JOIN products ON product_id=products.id WHERE cart.user_id='$id_pelanggan'");
    $amount = mysqli_fetch_array($sql);

    $transaction_details = array(
        'order_id' => rand(),
        'gross_amount' => $amount['HargaMenu'],
    );

    $arr = array();

    $ctr = 0;
    $query = "SELECT cart_item.* FROM cart_item LEFT JOIN cart ON cart.id=cart_item.cart_id  INNER JOIN products ON product_id=products.id WHERE cart.user_id='$id_pelanggan'" ;
    $stmt = $conn->query($query);
    $prod = $stmt->fetch_all(MYSQLI_ASSOC);
    $totharga = 0;
    foreach($prod as $key => $value){
        $prodid = $value["product_id"];
        if($value["isvarian"] == 1){
            $query = "SELECT * FROM variasiwarna where id='$prodid'" ;
            $stmt = $conn->query($query);
            $varwar = $stmt->fetch_assoc();
            $idr = $varwar["id"];
            $harga = $varwar["harga"];
            $query = "SELECT * FROM products where id='$idr'" ;
            $stmt = $conn->query($query);
            $proud = $stmt->fetch_assoc();
            $nama = $proud["name"];
        }else{
            $query = "SELECT * FROM products where id='$prodid'" ;
            $stmt = $conn->query($query);
            $kala = $stmt->fetch_assoc();
            $nama = $kala["name"];
            $harga = $kala["harga"];
        }
        $qty = $value["qty"];
        $totharga += ($harga * $qty);

        $arr[$ctr] = array (
            'id' => "$prodid",
            'price' => "$harga",
            'quantity' => "$qty",
            'name' => "$nama"
        );
        $ctr += 1;
    }

    $item_details = $arr;

    $sql = mysqli_query($conn, "SELECT * FROM customers WHERE id='$id_pelanggan'");
    $result = mysqli_fetch_assoc($sql);

    $nama = $result['nama'];
    $email = $result['email'];

    $customer_details = array(
        'first_name'  => "$nama",
        'email'       => "$email"
    );

    // Optional, remove this to display all available payment methods
    $enable_payments = array(
        "credit_card",
        "gopay",
        "shopeepay",
        "permata_va",
        "bca_va",
        "bni_va",
        "bri_va",
        "echannel",
        "other_va",
        "danamon_online",
        "mandiri_clickpay",
        "cimb_clicks",
        "bca_klikbca",
        "bca_klikpay",
        "bri_epay",
        "xl_tunai",
        "indosat_dompetku",
        "kioson",
        "Indomaret",
        "alfamart",
        "akulaku"
    );

    // Fill transaction details
    $transaction = array(
        'enabled_payments' => $enable_payments,
        'transaction_details' => $transaction_details,
        'customer_details' => $customer_details,
        'item_details' => $item_details
    );

    $snap_token = '';

    try {
        $snap_token = Snap::getSnapToken($transaction);
    }
    catch (\Exception $e) {
        echo $e->getMessage();
    }

    echo json_encode(array("SnapToken"=>$snap_token));
?>