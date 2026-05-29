<?php

$nama_file = $_FILES['file_csv']['name'];

$tmp_file = $_FILES['file_csv']['tmp_name'];

$path = "temp/" . $nama_file;

move_uploaded_file($tmp_file, $path);

// $file = fopen($_FILES['file_csv']['tmp_name'], 'r');
$file = fopen($path, 'r');

?>
<!-- CONTENT HEADER -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Preview Import Barang</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="index.php?page=databrg" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- CONTENT -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">
                    Preview Data CSV
                </h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Supplier</th>
                            <th>Stok</th>
                            <th>Isi Pack</th>
                            <th>Harga PCS</th>
                            <th>Harga PACK</th>
                            <th>Modal Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $nomor = 1;
                        while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
                            if ($no < 2) {
                                $no++;
                                continue;
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?= $nomor; ?></td>
                                <td><?= $row[0]; ?></td>
                                <td><?= $row[1]; ?></td>
                                <td><?= $row[2]; ?></td>
                                <td><?= $row[3]; ?></td>
                                <td class="text-center"><?= $row[4]; ?></td>
                                <td class="text-center"><?= $row[5]; ?></td>
                                <td>Rp <?= number_format($row[6], 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($row[7], 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($row[8], 0, ',', '.'); ?></td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <form action="add/proses_import.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden"name="file" value="../temp/<?= $nama_file; ?>">
                    <!-- <input type="hidden" name="file_tmp" value="< $_FILES['file_csv']['tmp_name']; ?>"> -->
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-file-import mr-1"></i>
                        Import Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>