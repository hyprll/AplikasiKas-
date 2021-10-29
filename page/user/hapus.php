<?php

$id = $_GET['id'];

$sql = $connect->query("delete from barang where id_barang = '$id'");

if ($sql) {
?>
    <script type="text/javascript">
        alert("Hapus Data Berhasil");
        window.location.href = "?page=barang";
    </script>
<?php
}
 
?>
