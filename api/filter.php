<?php

require '../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = mysqli_escape_string($connect,$_POST['data']);
    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d , H:i:s')
    if ($data == 'hari') {
        
    }else if($data == 'minggu'){
        
    }else if($data == 'bulan'){

    }else if($data == 'tahun'){

    }
}
