<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
             <a class="close" data-dismiss="modal">×</a>
             <h3>Filter</h3>
         </div>
         <div class="modal-body">
			 <form action="#" onsubmit="FilterData(event)">
			 	<div class="input_group mb-2" style="display: flex; flex-direction: column;">
					<label for="tanggal">Tanggal</label>
				 	<select name="tanggal" id="tanggal" class="form-control tanggal">
						 <option value="hari">/Hari</option>
						 <option value="minggu">/Minggu</option>
						 <option value="bulan">/Bulan</option>
						 <option value="tahun">/Tahun</option>
					 </select>
				 </div>
				 <button type="submit" name="submit" class="btn btn-primary mt-2">Submit</button>
			 </form>
         </div>
         <div class="modal-footer">
             <a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
         </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<!-- Advanced Tables -->
		<div class="panel panel-warning">
			<div class="panel-heading no-print">
				<div class="content-print">
					Data Kas Masuk
					<div class="d-flex">
						<button class="btn btn-primary" onclick="window.print()">Print</button>
						<button class="btn btn-success" data-toggle="modal" data-target=".modal">Filter</button>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover table-rekap" id="dataTables-example">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Tanggal</th>
								<th>Keterangan</th>
								<th>Masuk</th>
								<th>Jenis</th>
								<th>Keluar</th>
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
								<tr class="odd gradeX <?= ($cek) ? "bg-light adjust-kas" : "";  ?>">
									<td><?php echo $no++; ?></td>
									<td><?php echo $data['kode']; ?></td>
									<td><?php echo date('d F Y', strtotime($data['tgl'])); ?></td>
									<td class="keterangan-column-rekap"><?php echo $data['keterangan']; ?></td>
									<td align="right"><?php echo number_format($data['jumlah']) . ",-"; ?></td>
									<td><?php echo $data['jenis']; ?></td>
									<td align="right"><?php echo number_format($data['keluar']) . ",-"; ?></td>

								</tr>

							<?php
								$total = $total + $data['jumlah'];
								$total_keluar = $total_keluar + $data['keluar'];

								$saldo_akhir = $total - $total_keluar;
							}
							?>
						</tbody>
						<tr>
							<th colspan="5" style="text-align: center; font-size: 17px;">Total Kas Masuk</th>
							<td style="text-align: right; font-size: 20px;"><?php echo number_format($total) . ",-"; ?></td>
						</tr>

						<tr>
							<th colspan="5" style="text-align: center; font-size: 17px;">Total Kas Keluar</th>
							<td style="text-align: right; font-size: 20px;"><?php echo number_format($total_keluar) . ",-"; ?></td>
						</tr>

						<tr>
							<th colspan="5" style="text-align: center; font-size: 17px;">Saldo Akhir</th>
							<th style="text-align: right; font-size: 20px;"><?php echo "Rp." . number_format($saldo_akhir) . ",-"; ?></th>
						</tr>

					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function FilterData(event) {
		event.preventDefault()
		const data = document.querySelector('.tanggal').value; 

		const dataTanggal = {
			'data' : data
		}

		$.ajax({
			url: "http://localhost/aplikasi_kas/api/filter.php",
			method: 'POST',
			dataType: 'JSON',
			body: dataTanggal,
			success: function(response){
				console.log(response)
			},
			error: function(error){
				console.log(error)
			}
		})
	}
</script>