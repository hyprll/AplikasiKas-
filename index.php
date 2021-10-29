<?PHP error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); ?>
<?php
require 'koneksi/koneksi.php';
require 'page/auth/middleware.php';
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UP-RPL - Kas App</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"> -->
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <link rel="icon" href="assets/img/logo.png">
</head>

<body>
    <div id="wrapper" style="background: #FFD700;">
        <nav class="no-print navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0; background: #22106e;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" style="background: #22106e; color: #FFD700;">RPL Kas</a>
            </div>
            <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;" class="logout">
                <a href="logout.php" class="btn btn-danger square-btn-adjust" style="background: #FFD700; color: #696969;">Logout</a>
            </div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="no-print navbar-default navbar-side" role="navigation" style="background: #FFD700; ">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="text-center">
                        <img src="assets/img/logo.png" class="user-image img-responsive" />
                    </li>


                    <li>
                        <a href="http://localhost/aplikasi_kas/" style="background: #FFD700; color: #696969"><i class="glyphicon glyphicon-home"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="?page=masuk" style="background: #FFD700; color: #696969"><i class="glyphicon glyphicon-floppy-save"></i> Kas Masuk</a>
                    </li>
                    <li>
                        <a href="?page=keluar" style="background: #FFD700; color: #696969"><i class="glyphicon glyphicon-floppy-open"></i> Kas Keluar</a>
                    </li>
                    <li>
                        <a href="?page=rekap" style="background: #FFD700; color: #696969"><i class="glyphicon glyphicon-th-list"></i> Rekap Kas</a>
                    </li>
                    <li>
                        <a href="?page=barang" style="background: #FFD700; color: #696969"><i class="glyphicon glyphicon-inbox"></i> Data Barang</a>
                    </li>
                    <li class="logoutadmin">
                    <a href="logout.php" style="background: #FFD700; color: #696969"><i class="glyphicon glyphicon-circle-arrow-right"></i> Logout</a>
                    </li>

                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <?php

                        $page = $_GET['page'];
                        $aksi = $_GET['aksi'];

                        if ($page == "masuk") {
                            if ($aksi == "") {
                                include "page/kas_masuk/masuk.php";
                            }

                            if ($aksi == "hapus") {
                                include "page/kas_masuk/hapus.php";
                            }
                        } else if ($page == "keluar") {
                            if ($aksi == "") {
                                include "page/kas_keluar/keluar.php";
                            }

                            if ($aksi == "hapus") {
                                include "page/kas_keluar/hapus.php";
                            }
                        } else if ($page == "rekap") {
                            if ($aksi == "") {
                                include "page/rekap/rekap.php";
                            }
                        } else if ($page == "user") {
                            if ($aksi == "") {
                                include "page/user/user.php";
                            }
                        } else if ($page == "") {
                            include "home.php";
                        } else if ($page == "barang") {
                            if ($aksi == "") {
                                include "page/user/barang.php";
                            }

                            if ($aksi == "hapus") {
                                include "page/user/hapus.php";
                            }
                        } else if ($aksi == "hapus") {
                            $id = $_GET['id'];

                            $sql = $connect->query("delete from barang where id_barang = $id");

                            if ($sql) {
                        ?>
                                <script type="text/javascript">
                                    alert("Hapus Barang Berhasil");
                                    window.location.href = "?page=barang";
                                </script>
                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />

            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script> -->
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <!-- <script src="assets/js/custom.js"></script> -->
    <!-- Barcode js -->
    <script src="assets/js/JsBarcode.all.min.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/app.js"></script>


</body>

</html>