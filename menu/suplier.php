<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Supplier</h1>
            </div>
            <div class="col-sm-6 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah" title="Tambah Data" data-placement="bottom">
                    <i class="fas fa-plus mr-1"></i> Input
                </button>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="card">
        <div class="card-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Id</th>
                        <th>Kategori</th>
                        <th>Kode Supplier</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    include "sambungkan.php";
                    $row = "SELECT * FROM supplier WHERE status = 'aktif'";
                    $result = mysqli_query($conn, $row);
                    $modal = '';
                    while ($rows = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center">#00<?= $rows["id_supplier"]; ?></td>
                            <td class="text-center"><?= $rows["nama_supplier"]; ?></td>
                            <td class="text-center"><?= $rows["kode_supplier"]; ?></td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $rows['id_supplier']; ?>"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm"
                                    data-toggle="modal"
                                    data-target="#hapus<?= $rows['id_supplier']; ?>"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php
                        $modal .= '
                            <!-- MODAL EDIT -->
                            <div class="modal fade" id="edit' . $rows['id_supplier'] . '">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h4 class="modal-title">Edit supplier</h4>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <form action="add/edit_supplier.php" method="POST">
                                            <input type="hidden" name="id_supplier" value="' . $rows['id_supplier'] . '">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>ID Supplier</label>
                                                            <input type="text"
                                                                name="id_supplier"
                                                                class="form-control"
                                                                value="' . $rows['id_supplier'] . '"
                                                                readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama Supplier</label>
                                                            <input type="text"
                                                                name="nama_supplier"
                                                                class="form-control"
                                                                value="' . $rows['nama_supplier'] . '"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Kode Supplier</label>
                                                            <input type="text"
                                                                name="kode_supplier"
                                                                class="form-control"
                                                                value="' . $rows['kode_supplier'] . '"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-save mr-1"></i>
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL HAPUS -->
                            <div class="modal fade" id="hapus' . $rows['id_supplier'] . '">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h4 class="modal-title">Hapus Supplier</h4>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <i class="fas fa-trash fa-4x text-danger mb-3"></i>
                                            <h5>
                                                Yakin hapus <br>
                                                <b> Data ' . $rows['nama_supplier'] . ' Dari Tabel? </b>
                                            </h5>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <a href="add/hapus_supplier.php?id=' . $rows['id_supplier'] . '"
                                                class="btn btn-danger">
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                    }
                    ?>
                </tbody>
            </table>
            <?= $modal; ?>
        </div>
    </div>
</section>

<!-- MODAL TAMBAH supplier -->
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- HEADER -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">
                    <i class="fas fa-plus-circle mr-1"></i>
                    Tambah supplier
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <!-- FORM -->
            <form action="add/tambah_supplier.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <!-- KODE -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode supplier</label>
                                <input type="text" name="kode_supplier" class="form-control" placeholder="Masukkan kode supplier" required>
                            </div>
                        </div>
                        <!-- NAMA -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama supplier</label>
                                <input type="text"
                                    name="nama_supplier"
                                    class="form-control"
                                    placeholder="Masukkan nama supplier"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FOOTER -->
                <div class="modal-footer justify-content-between">
                    <button type="button"
                        class="btn btn-default"
                        data-dismiss="modal"> Tutup
                    </button>
                    <button type="submit"
                        class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>