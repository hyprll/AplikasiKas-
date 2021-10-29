<?php $role = $_SESSION["role"]; ?>
<div class="row">
	<div class="col-md-12">
		<!-- Advanced Tables -->
		<div class="panel panel-warning">
			<div class="panel-heading">
				Data Kas Masuk
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Tgl</th>
								<th>Keterangan</th>
								<th>Jumlah</th>
								<th>Total Harga</th>
								<?php if ($role == "1") { ?>
									<th>Aksi</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>

							<?php

							$no = 1;


							$sql = $connect->query("select kas.*, kas_masuk.qty, kas_masuk.id_kas_masuk, kas_masuk.nama_pembeli from kas inner join kas_masuk on kas_masuk.id_kas = kas.kode where jenis = 'masuk' ");

							while ($data = $sql->fetch_assoc()) {

							?>
								<?php
								// check boolean just adjust or no
								$cek = intval($data['qty']) < 0;
								?>
								<tr class="odd gradeX <?= ($cek) ? "bg-warning adjust-kas" : "";  ?>">
									<td><?php echo $no++; ?></td>
									<td><?php echo $data['kode']; ?></td>
									<td><?php echo date('d F Y', strtotime($data['tgl'])); ?></td>
									<td><?php echo $data['keterangan']; ?></td>
									<td><?php echo $data['qty']; ?></td>
									<td align="right"><?php
														echo ($cek) ? number_format("-" . $data['keluar']) . ",-" : number_format($data['jumlah']) . ",-";
														?>
									</td>
									<?php if ($role == "1") { ?>
										<td>
											<a id="edit_data" data-hargabarang="<?= intval($data['jumlah']) / intval($data['qty']) ?>" data-idkasmasuk="<?= $data['id_kas_masuk']; ?>" data-toggle="modal" data-target="#edit" data-id="<?php echo $data['kode'] ?>" data-ket="<?php echo $data['keterangan'] ?>" data-tgl="<?php echo $data['tgl']; ?>" data-jml="<?php echo intval($data['qty']) ?>" data-namapembeli="<?= $data["nama_pembeli"] ?>" class="btn btn-info"><i class="fa fa-edit"></i>Edit</a>

											<a onclick="return confirm('Yakin Akan Menghapus Data Ini ?')" href="?page=masuk&aksi=hapus&id=<?php echo $data['kode']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</a>
										</td>
									<?php } ?>
								</tr>

							<?php
								$total = ($cek) ? $total - intval($data['keluar']) : $total + intval($data['jumlah']);
							}
							?>
						</tbody>
						<tr>
							<th colspan="4" style="text-align: center; font-size: 17px;">Total Kas Masuk</th>
							<th style="text-align: right; font-size: 20px;"><?php echo "Rp." . number_format($total) . ",-"; ?></th>
						</tr>
					</table>
				</div>
			</div>

			<!-- halaman tambah data -->

			<div class="panel-body">
				<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal">
					Tambah / Perbaiki Data
				</button>
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal yModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Form Tambah Data</h4>
							</div>
							<div class="modal-body">
								<form role="form" method="POST">

									<div class="form-group">
										<label>Nama Barang</label>
										<!-- <input class="form-control" name="kode" placeholder="Input Kode" /> -->
										<select name="barang" id="barang" class="form-control">
											<?php
											$sql1 = $connect->query("select barang.id_barang, barang.nama_barang from barang");
											foreach ($sql1 as $b) {
											?>
												<option value="<?= $b["id_barang"] ?>"><?= $b["nama_barang"] ?></option>
											<?php } ?>
										</select>
									</div>

									<div class="form-group">
										<label>Keterangan</label>
										<textarea class="form-control" rows="3" name="ket"></textarea>
									</div>

									<div class="form-group">
										<label>Tanggal</label>
										<input class="form-control" type="date" name="tgl" />
									</div>

									<div class="form-group">
										<label>Jumlah Beli</label>
										<input class="form-control" name="jml" type="number" />
									</div>

									<div class="form-group">
										<label>Nama Pembeli</label>
										<input class="form-control" name="nama_pembeli" type="text" />
									</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<input type="submit" name="simpan" value="simpan" class="btn btn-primary">
							</div>
							</form>

						</div>

					</div>
				</div>
			</div>


			<?php

			if (isset($_POST['simpan'])) {

				$barang = $_POST['barang'];
				$ket = $_POST['ket'];
				$tgl = $_POST['tgl'];
				$jml_beli = $_POST['jml'];
				$nama_pembeli = $_POST['nama_pembeli'];

				// get boolean for jml_beli
				$bl_jml_beli = $jml_beli < 0;

				if ($bl_jml_beli) {
					$getJml = explode("-", $jml_beli);
					$jml_beli = $getJml[1];
				}
				$getbarang = $connect->query("select barang.harga from barang where id_barang='$barang'");
				$result = $getbarang->fetch_assoc();

				$jml = intval($result["harga"]) * intval($jml_beli);
				$id_user = $_SESSION["id_user"];


				$query = "insert into kas (keterangan, tgl, jumlah, jenis, keluar)values( '$ket', '$tgl', '$jml', 'masuk', 0)";

				if ($bl_jml_beli) {
					$query = "insert into kas (keterangan, tgl, jumlah, jenis, keluar)values( '$ket', '$tgl', 0, 'masuk', '$jml')";
				}

				$sql = $connect->query($query);
				$id_kas = $connect->insert_id;

				$query2 = "insert into kas_masuk (id_user, id_barang, qty, nama_pembeli, id_kas)values('$id_user', '$barang', '$jml_beli', '$nama_pembeli', '$id_kas')";

				if ($bl_jml_beli) {
					$jml_beli = $_POST['jml'];
					$query2 = "insert into kas_masuk (id_user, id_barang, qty, nama_pembeli, id_kas)values('$id_user', '$barang', '$jml_beli', '$nama_pembeli', '$id_kas')";
				}

				$sql2 = $connect->query($query2);

				if ($sql && $sql2) {
			?>
					<script type="text/javascript">
						alert("Simpan Data Berhasil");
						window.location.href = "?page=masuk";
					</script>
			<?php
				}
			}

			?>

			<!-- akhir halaman tambah data -->


			<!-- halaman ubah -->
			<div class="panel-body">

				<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modal yModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Form Ubah Data</h4>
							</div>
							<div class="modal-body" id="modal_edit">
								<form role="form" method="POST">

									<div class="form-group">
										<label>Kode</label>
										<input class="form-control" name="kode" placeholder="Input Kode" id="kode" readonly />
										<input class="form-control" name="id_kas_masuk" placeholder="Input Kode" id="id_kas_masuk" type="hidden" />
										<input class="form-control" name="hargabarang" placeholder="Input Kode" id="hargabarang" type="hidden" />
									</div>

									<div class="form-group">
										<label>Keterangan</label>
										<textarea class="form-control" rows="3" name="ket" id="ket"></textarea>
									</div>

									<div class="form-group">
										<label>Tanggal</label>
										<input class="form-control" type="date" name="tgl" id="tgl" />
									</div>

									<div class="form-group">
										<label>Jumlah Beli</label>
										<input class="form-control" name="jml" type="number" id="jml" />
									</div>

									<div class="form-group">
										<label>Nama Pembeli</label>
										<input class="form-control" name="namapembeli" type="text" id="namapembeli" />
									</div>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<input type="submit" name="ubah" value="Ubah" class="btn btn-primary">
							</div>
							</form>

							<?php

							if (isset($_POST['ubah'])) {

								$kode = $_POST['kode'];
								$ket = $_POST['ket'];
								$tgl = $_POST['tgl'];
								$jml_beli = $_POST['jml'];
								$id_kas_masuk = $_POST["id_kas_masuk"];
								$namapembeli = $_POST["namapembeli"];
								$hargabarang = $_POST["hargabarang"];

								$jml = intval($jml_beli) * intval($hargabarang);

								$sql = $connect->query("update kas set keterangan ='$ket', tgl = '$tgl', jumlah = '$jml' where kode = '$kode' ");
								$sql2 = $connect->query("update kas_masuk set qty ='$jml_beli', nama_pembeli = '$namapembeli' where id_kas_masuk = '$id_kas_masuk' ");

								if ($sql && $sql2) {
							?>
									<script type="text/javascript">
										alert("Ubah Data Berhasil");
										window.location.href = "?page=masuk";
									</script>
							<?php
								}
							}

							?>

						</div>

					</div>
				</div>
			</div>
			<script src="assets/js/jquery-1.10.2.js"></script>

			<script type="text/javascript">
				$(document).on("click", "#edit_data", function() {

					var kode = $(this).data('id');
					var ket = $(this).data('ket');
					var tgl = $(this).data('tgl');
					var jml = $(this).data('jml');
					var idkasmasuk = $(this).data('idkasmasuk');
					var hargabarang = $(this).data('hargabarang');
					var namapembeli = $(this).data('namapembeli');

					$("#modal_edit #kode").val(kode);
					$("#modal_edit #ket").val(ket);
					$("#modal_edit #tgl").val(tgl);
					$("#modal_edit #jml").val(jml);
					$("#modal_edit #id_kas_masuk").val(idkasmasuk);
					$("#modal_edit #hargabarang").val(hargabarang);
					$("#modal_edit #namapembeli").val(namapembeli);
				})
			</script>



			<!-- akhir halaman ubah -->

		</div>
	</div>
</div>