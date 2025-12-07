<?php
$file = "data/transaksi.json";
$data = json_decode(file_get_contents($file), true);
$id = $_GET["id"];

foreach($data as &$trx){
    if($trx["id"] == $id){
        $trx["status"] = "Verified";
    }
}

file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

header("Location: admin.php");
?>
