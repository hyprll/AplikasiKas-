<div class="row">
	<div class="col-md-12">
		<!-- Advanced Tables -->
		<div class="panel panel-warning">
			<div class="panel-heading">
				Data Kas Keluar
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
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>

							<?php

							$no = 1;


							$sql = $connect->query("select * from kas where jenis = 'keluar' ");

							while ($data = $sql->fetch_assoc()) {

							?>

								<tr class="odd gradeX">
									<td><?php echo $no++; ?></td>
									<td><?php echo $data['kode']; ?></td>
									<td><?php echo date('d F Y', strtotime($data['tgl'])); ?></td>
									<td><?php echo $data['keterangan']; ?></td>
									<td align="right"><?php echo number_format($data['keluar']) . ",-"; ?></td>
									<td>
										<a id="edit_data" data-toggle="modal" data-target="#edit" data-id="<?php echo $data['kode'] ?>" data-ket="<?php echo $data['keterangan'] ?>" data-tgl="<?php echo $data['tgl']; ?>" data-jml="<?php echo $data['keluar'] ?>" class="btn btn-info"><i class="fa fa-edit"></i>Edit</a>

										<a onclick="return confirm('Yakin Akan Menghapus Data Ini ?')" href="?page=keluar&aksi=hapus&id=<?php echo $data['kode']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</a>
									</td>
								</tr>

							<?php
								$total = $total + $data['keluar'];
							}
							?>
						</tbody>
						<tr>
							<th colspan="4" style="text-align: center; font-size: 17px;">Total Kas Keluar</th>
							<th style="text-align: right; font-size: 20px;"><?php echo "Rp." . number_format($total) . ",-"; ?></th>
						</tr>
					</table>
				</div>
			</div>

			<!-- halaman tambah data -->

			<div class="panel-body">
				<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal">
					Tambah Data
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
										<label>Keterangan</label>
										<textarea class="form-control" rows="3" name="ket"></textarea>
									</div>

									<div class="form-group">
										<label>Tanggal</label>
										<input class="form-control" type="date" name="tgl" />
									</div>

									<div class="form-group">
										<label>Jumlah Keluar</label>
										<input class="form-control" name="jml" type="number" />
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
				$ket = $_POST['ket'];
				$tgl = $_POST['tgl'];
				$jml = $_POST['jml'];
				$id_user = $_SESSION["id_user"];

				$sql = $connect->query("insert into kas (keterangan, tgl, jumlah, jenis, keluar)values('$ket', '$tgl', 0, 'keluar', '$jml' )");
				$id_kas = $connect->insert_id;

				$sql2 = $connect->query("insert into kas_keluar (id_user, total_harga, keterangan, id_kas)values('$id_user', '$jml', '$ket', '$id_kas' )");

				if ($sql && $sql2) {
			?>
					<script type="text/javascript">
						alert("Simpan Data Berhasil");
						window.location.href = "?page=keluar";
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
										<label>Jumlah</label>
										<input class="form-control" name="jml" type="number" id="jml" />
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
								$jml = $_POST['jml'];

								$sql = $connect->query("update kas set keterangan ='$ket', tgl = '$tgl', jumlah =0, jenis = 'keluar', keluar = '$jml' where kode = '$kode' ");

								$sql2 = $connect->query("update kas_keluar set keterangan ='$ket', total_harga = '$jml' where id_kas = '$kode' ");

								if ($sql && $sql2) {
							?>
									<script type="text/javascript">
										alert("Ubah Data Berhasil");
										window.location.href = "?page=keluar";
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

					$("#modal_edit #kode").val(kode);
					$("#modal_edit #ket").val(ket);
					$("#modal_edit #tgl").val(tgl);
					$("#modal_edit #jml").val(jml);
				})
			</script>



			<!-- akhir halaman ubah -->

		</div>
	</div>
</div>