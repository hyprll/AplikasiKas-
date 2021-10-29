<?php

$id = $_GET['id'];
$getKasKeluar = $connect->query("select * from kas_keluar where id_kas = $id");
$res = $getKasKeluar->fetch_assoc();
$id_kas_keluar = $res["id_kas_keluar"];


$sql = $connect->query("delete from kas where kode = $id");

$sql2 = $connect->query("delete from kas_keluar where id_kas_keluar = '$id_kas_keluar'");


if ($sql && $sql2) {
?>
	<script type="text/javascript">
		alert("Hapus Data Berhasil");
		window.location.href = "?page=keluar";
	</script>
<?php
}

?>