<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-md-8">
                <h1 class="m-0">
                    Data kategori
                </h1>
            </div>
            <div class="col-md-4">
                <form action="add/tambah_kategori.php" method="POST">
                    <div class="input-group">
                        <input type="text"
                            name="nama_kategori"
                            class="form-control"
                            placeholder="Masukkan nama kategori"
                            required>
                        <div class="input-group-append">
                            <button type="submit"
                                class="btn btn-primary"
                                title="Tambah kategori"
                                data-toggle="tooltip"
                                data-placement="bottom">
                                <i class="fas fa-plus mr-1"></i>
                                Tambah
                            </button>
                        </div>
                    </div>
                </form>
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
                        <th>kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    include "sambungkan.php";
                    $row = "SELECT * FROM kategori WHERE status='aktif'";
                    $result = mysqli_query($conn, $row);

                    $modal = '';

                    while ($rows = mysqli_fetch_array($result)) {
                    ?>

                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center">#00<?= $rows["id_kategori"]; ?></td>
                            <td class="text-center"><?= $rows["nama_kategori"]; ?></td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $rows['id_kategori']; ?>"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-danger btn-sm"
                                    data-toggle="modal"
                                    data-target="#hapus<?= $rows['id_kategori']; ?>"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php
                        $modal .= '
                            <!-- MODAL EDIT -->
                            <div class="modal fade" id="edit' . $rows['id_kategori'] . '">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h4 class="modal-title">Edit kategori</h4>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <form action="add/edit_kategori.php" method="POST">
                                            <input type="hidden" name="id_kategori" value="' . $rows['id_kategori'] . '">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>ID kategori</label>
                                                            <input type="text"
                                                                name="kode_kategori"
                                                                class="form-control"
                                                                value="' . $rows['id_kategori'] . '"
                                                                readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama kategori</label>
                                                            <input type="text"
                                                                name="nama_kategori"
                                                                class="form-control"
                                                                value="' . $rows['nama_kategori'] . '"
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
                            <div class="modal fade" id="hapus' . $rows['id_kategori'] . '">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h4 class="modal-title">Hapus kategori</h4>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <i class="fas fa-trash fa-4x text-danger mb-3"></i>
                                            <h5>
                                                Yakin hapus <br>
                                                <b>Data ' . $rows['nama_kategori'] . ' Dari Tabel?</b>
                                            </h5>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <a href="add/hapus_kategori.php?id=' . $rows['id_kategori'] . '"
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