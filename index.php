<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('bag/header.php'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <?php
    // include ('bag/preload.php'); 
    ?>
    <!-- Navbar -->
    <?php include('bag/navbar.php'); ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <?php include('bag/sidebar.php'); ?>
      <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- <div>MARI KITA MULAI ULANG </div> -->
      <?php
      if ($_GET['page'] == 'dashboard') {
        include('menu/dashboard.php');
      } else if ($_GET['page'] == 'databrg') {
        include('menu/data_brg.php');
      } else if ($_GET['page'] == 'formMasuk') {
        include('menu/form_masuk.php');
      } else if ($_GET['page'] == 'formKeluar') {
        include('menu/form_keluar.php');
      } else if ($_GET['page'] == 'brgMasuk') {
        include('menu/barang_masuk.php');
      } else if ($_GET['page'] == 'brgKeluar') {
        include('menu/barang_keluar.php');
      } else if ($_GET['page'] == 'transaksi') {
        include('menu/transaksi.php');
      } else if ($_GET['page'] == 'suplier') {
        include('menu/suplier.php');
      } else if ($_GET['page'] == 'kategori') {
        include('menu/kategori.php');
      } else if ($_GET['page'] == 'keranjang') {
        include('menu/keranjang.php');
      } else if ($_GET['page'] == 'import') {
        include('menu/import.php');
      } else if ($_GET['page'] == 'preview') {
        include('menu/preview_barang.php');
      } else {
        include('error.php');
      }
      ?>
    </div>
    <!-- /.content-wrapper -->
  </div>
  <!-- ./wrapper -->
  <!-- footer -->
  <?php include('bag/footer.php'); ?>
  <!-- footer -->
  <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <script>
    bsCustomFileInput.init();
  </script>
</body>

</html>