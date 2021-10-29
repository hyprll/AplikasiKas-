<?php

$id = $_GET['id'];

$getKasMasuk = $connect->query("select * from kas_masuk where id_kas = $id");
$res = $getKasMasuk->fetch_assoc();
$id_kas_masuk = $res["id_kas_masuk"];

$sql = $connect->query("delete from kas where kode = '$id'");
$sql2 = $connect->query("delete from kas_masuk where id_kas_masuk = '$id_kas_masuk'");

if ($sql && $sql2) {
?>
    <script type="text/javascript">
        alert("Hapus Data Berhasil");
        window.location.href = "?page=masuk";
    </script>
<?php
}
 
?>
