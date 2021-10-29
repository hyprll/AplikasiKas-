<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-warning">
           	<div class="panel-heading">
                Data Barang
            </div>
         	<div class="panel-body">
                <div class="table-responsive">
                   	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Harga</th>
                                <th>Nama Barang</th>
                                <th>Barcode</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php 

                                $index = 1; 
			                    $no = 1;
                                
			                    $sql = $connect->query("select * from barang");
			                    while ($data=$sql->fetch_assoc()) {
			                                    		
			                     ?>

			                    <tr class="odd gradeX">
			                        <td><?php echo $no++; ?></td>
			                        <td><?php echo number_format($data['harga']) . ",-"; ?></td>
                                    <td><?php echo $data['nama_barang']; ?></td>
			                        <td class="id_barcode" > 
                                        <svg class="barcode" id="barcode-<?= $index ?>" data-id_barcode="<?php echo $data['barcode'] ?>"></svg>
                                        <?php $index++ ?>
                                    </td>

			                        <td>
			                           	<a id="edit_data" data-toggle="modal" data-target="#edit" data-id="<?php echo $data['id_barang'] ?>" data-harga="<?php echo $data['harga'] ?>" data-nama="<?php echo $data['nama_barang']; ?>" class="btn btn-info"><i class="fa fa-edit"></i>Edit</a>

			                           	<a onclick="return confirm('Yakin Akan Menghapus Data Ini ?')" href="?page=barang&aksi=hapus&id=<?php echo $data['id_barang']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i>Hapus</a>

			                           	
			                        </td>
			                    </tr>

			                    <?php
			                    $total=$total+$data['jumlah']; 

			                    	}
			                    ?>
		                    </tbody>
		                    
                    </table>
                </div>
            </div>

            	<!-- halaman tambah data -->

                <div class="panel-body">
                    <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal">
                        Tambah Barang
                    </button>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal yModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Form Tambah Barang</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" method="POST">

		                                <div class="form-group">
		                                    <label>Nama Barang</label>
		                                    <input class="form-control" name="NamaBarang" placeholder="Input Nama Barang" />
		                                </div>

                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input class="form-control" name="Harga" placeholder="Harga" />
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
                			
                			$NamaBarang = $_POST['NamaBarang'];
                			$Harga = $_POST['Harga'];

                			$sql = $connect->query("insert into barang (harga, nama_barang)values('$Harga', '$NamaBarang')");

                			if ($sql) {
                				?>
                					<script type="text/javascript">
                						alert("Tambah Barang Berhasil");
                						window.location.href="?page=barang";
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
                                        <h4 class="modal-title" id="myModalLabel">Form Ubah Data Barang</h4>
                                </div>
                                <div class="modal-body" id="modal_edit">
                                    <form role="form" method="POST">

                                            <div class="form-group d-none" style="display: none;">
                                            <label>id barang</label>
                                            <input class="form-control" name="id_barang" id="id_barang" placeholder="Input Nama Barang" />
                                        </div>

                                            <div class="form-group">
                                            <label>Nama Barang</label>
                                            <input class="form-control" name="NamaBarang" id="nama" placeholder="Input Nama Barang" />
                                        </div>

                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input class="form-control" name="Harga" id="harga" placeholder="Harga" />
                                        </div>
		                            
                               	</div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <input type="submit" name="ubah" value="Ubah" class="btn btn-primary">
                                </div>
                                	</form>

                                	<?php 

				                		if (isset($_POST['ubah'])) {

				            $NamaBarang = $_POST['NamaBarang'];
                            $Harga = $_POST['Harga'];
                            $id_barang = $_POST['id_barang'];

				                			$sql = $connect->query("update barang set harga ='$Harga',nama_barang = '$NamaBarang' where id_barang = '$id_barang' ");

				                			if ($sql) {
				                				?>
				                					<script type="text/javascript">
				                						alert("Ubah Data Barang Berhasil");
				                						window.location.href="?page=barang";
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
                	
                	$(document).on("click", "#edit_data", function(){

                		var kode = $(this).data('id');
                		var harga = $(this).data('harga');
                		var NamaBarang = $(this).data('nama');

                		$("#modal_edit #id_barang").val(kode);
                		$("#modal_edit #nama").val(NamaBarang);
                		$("#modal_edit #harga").val(harga);
                	})

                </script>

                	

               	<!-- akhir halaman ubah -->

	    </div>
	</div>
</div>

