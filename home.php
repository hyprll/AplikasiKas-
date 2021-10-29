<?php 

  $sql = $connect->query("select * from kas");
  while ($data=$sql->fetch_assoc()) {
    
    $jml = $data['jumlah'];
    $total_masuk = $total_masuk+$jml;

    $jml_keluar = $data['keluar'];
    $total_keluar = $total_keluar+$jml_keluar;

    $total = $total_masuk-$total_keluar;

  }

 ?>


  <div id="page-inner">
    <div class="row">
      <div class="col-md-12">
        <h2 style="color: #696969; font-weight: bold;">Halaman Utama</h2>   
          <h5>Pengelolaan Kas Rekayasa Perangkat Lunak.</h5>
      </div>
    </div>              
<!-- /. ROW  -->
      <hr />
    <div class="row">
      <div class="col-md-4 col-sm-6 col-xs-6">           
          <div class="panel panel-back noti-box">
            <span class="icon-box bg-color-green set-icon">
              <i class="glyphicon glyphicon-floppy-save"></i>
            </span>
            <div class="text-box" >
              <p class="main-text"><?php echo "Rp." .number_format($total_masuk); "$total_masuk"; ?>,-</p>
              <p class="text-muted">Total Kas Masuk</p>
            </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-red set-icon">
          <i class="glyphicon glyphicon-floppy-open"></i>
        </span>
        <div class="text-box" >
          <p class="main-text"><?php echo "Rp." .number_format($total_keluar); "$total_keluar"; ?>,-</p>
          <p class="text-muted">Total Kas Keluar</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-6">           
      <div class="panel panel-back noti-box">
        <span class="icon-box bg-color-blue set-icon">
          <i class="glyphicon glyphicon-floppy-disk"></i>
        </span>
        <div class="text-box" >
          <p class="main-text"><?php echo "Rp." .number_format($total); "$total_keluar"; ?>,-</p>
          <p class="text-muted">Saldo Akhir</p>
        </div>
      </div>
    </div>