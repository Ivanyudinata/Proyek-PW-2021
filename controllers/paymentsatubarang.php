<?php

    namespace Midtrans;

    require_once dirname(__DIR__,1) . '\midtrans\midtrans-php\Midtrans.php';
    require_once '../connection.php';

    Config::$serverKey = 'SB-Mid-server-9QZqJhyir6z2I_OHfHj3Z9M1';
    Config::$clientKey = 'SB-Mid-client-IZTGPkzRSyrlUwxH';

    Config::$isSanitized = true;
    Config::$is3ds = true;

    $harga = $_POST["harga"];
    $qty = $_POST["qty"];

    $transaction_details = array(
        'order_id' => rand(),
        'gross_amount' => $harga*$qty,
    );

    $arr = array();
    $prodid = $_POST["id"];
    $nama = $_POST["nama"];

    $arr[$ctr] = array (
        'id' => "$prodid",
        'price' => "$harga",
        'quantity' => "$qty",
        'name' => "$nama"
    );
    $item_details = $arr;
    $id_pelanggan = $_COOKIE["now"];
    
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