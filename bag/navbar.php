<?php
include('sambungkan.php');
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM keranjang");
$data = mysqli_fetch_assoc($result);
$keranjang = $data['total'];
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link"  href="index.php?page=keranjang">
        <i class="fas fa-shopping-cart"></i>
        <span class="badge badge-danger navbar-badge"><?= $keranjang ?></span>
      </a>
    </li>
  </ul>
</nav>

<!-- <div class="modal fade" id="modalKeranjang">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Keranjang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Nama Barang</th>
              <th>jumlah</th>
              <th>total Harga</th>
              <th>Tanggal</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            include "sambungkan.php";
            $sqlproduct = "SELECT * FROM barang ORDER BY created_at ASC";

            $result = mysqli_query($conn, $sqlproduct);
            while ($product = mysqli_fetch_array($result)) {
            ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $product["kode_barang"] ?></td>
                <td><?php echo $product["nama_barang"] ?></td>
                <td><?php echo $product["stok_pcs"] ?></td>
                <td>Rp <?php echo number_format($product["harga_pcs"], 0, ',', '.'); ?></td>
                <td>Rp <?php echo number_format($product["harga_pack"], 0, ',', '.'); ?></td>
                <td><a href="" class="btn btn-success">Action</a></td>
                <td>
                  <a href="index.php?page=details&id=<?php echo $product["id_barang"] ?>" class="btn btn-secondary">Details</a>
                </td>
              </tr>
            <?php $no++;
            } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div> -->