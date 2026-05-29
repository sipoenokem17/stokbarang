<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0  text-bold">Data Barang</h1>
            </div>
            <div class="col-sm-6 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#importBarang" title="Import File" data-placement="bottom">
                    <i class="fas fa-file-upload mr-1"></i> Import
                </button>
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
            <table id="custom" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Suplier</th>
                        <th>Stok</th>
                        <th>Harga Pcs</th>
                        <th>Harga Pack</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                    include "sambungkan.php";

                    $sqlproduct = "SELECT barang.*,kategori.nama_kategori,supplier.nama_supplier
                FROM barang 
                LEFT JOIN kategori 
                    ON barang.id_kategori = kategori.id_kategori
                LEFT JOIN supplier 
                    ON barang.id_supplier = supplier.id_supplier
                WHERE barang.status = 'aktif'
                ORDER BY barang.created_at ASC";

                    $result = mysqli_query($conn, $sqlproduct);

                    $modal = '';

                    while ($product = mysqli_fetch_array($result)) {

                        $list_kategori = '';

                        $qKategori = mysqli_query($conn, "
                                                            SELECT * FROM kategori
                                                            WHERE status='aktif'
                                                            ORDER BY nama_kategori ASC
                                                        ");

                        while ($k = mysqli_fetch_array($qKategori)) {

                            $selected = ($product['id_kategori'] == $k['id_kategori'])
                                ? 'selected'
                                : '';

                            $list_kategori .= '

                                            <option value="' . $k['id_kategori'] . '" ' . $selected . '>

                                                ' . $k['nama_kategori'] . '

                                            </option>

                                        ';
                        }

                        $list_supplier = '';

                        $qSupplier = mysqli_query($conn, "
                                                            SELECT * FROM supplier
                                                            WHERE status='aktif'
                                                            ORDER BY nama_supplier ASC
                                                        ");

                        while ($s = mysqli_fetch_array($qSupplier)) {

                            $selected = ($product['id_supplier'] == $s['id_supplier'])
                                ? 'selected'
                                : '';

                            $list_supplier .= '

                                                <option value="' . $s['id_supplier'] . '" ' . $selected . '>

                                                    ' . $s['nama_supplier'] . '

                                                </option>

                                            ';
                        }

                        $stok = $product['stok'];
                        $isi_perpack = $product['isi_perpack'];
                        $modals = $product['modal'];

                        $modalpack = $modals * $isi_perpack;

                        // KONVERSI STOK
                        if ($isi_perpack > 1) {

                            $pack = floor($stok / $isi_perpack);
                            $sisa = $stok % $isi_perpack;

                            if ($pack > 0 && $sisa > 0) {
                                $tampil = $pack . " Pack + " . $sisa . " Pcs";
                            } elseif ($pack > 0) {
                                $tampil = $pack . " Pack";
                            } else {
                                $tampil = $sisa . " Pcs";
                            }
                        } else {
                            $tampil = $stok . " Pcs";
                        }
                    ?>

                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center"><?= $product["kode_barang"]; ?></td>
                            <td><?= $product["nama_barang"]; ?></td>
                            <td class="text-center"><?= $product["nama_kategori"]; ?></td>
                            <td class="text-center"><?= $product["nama_supplier"]; ?></td>
                            <td class="text-center"><?= $tampil; ?></td>
                            <td>Rp <?= number_format($product["harga_pcs"], 0, ',', '.'); ?></td>
                            <td>Rp <?= number_format($product["harga_pack"], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <button class="btn btn-info btn-sm"
                                    data-toggle="modal"
                                    data-target="#detail<?= $product['id_barang']; ?>"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-warning btn-sm"
                                    data-toggle="modal"
                                    data-target="#edit<?= $product['id_barang']; ?>"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm"
                                    data-toggle="modal"
                                    data-target="#hapus<?= $product['id_barang']; ?>"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php
                        $modal .= '
                            <!-- MODAL DETAIL -->
                            <div class="modal fade" id="detail' . $product['id_barang'] . '">
                                <div class="modal-dialog  modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h4 class="modal-title">Detail Barang</h4>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered">
                                                <th class="bg-secondary">Kode</th>
                                                <th class="bg-secondary">Nama Barang</th>
                                                <th class="bg-secondary">Kategori</th>
                                                <th class="bg-secondary">Supplier</th>
                                            <tr>
                                                <td>' . $product['kode_barang'] . '</td>
                                                <td>' . $product['nama_barang'] . '</td>
                                                <td>' . $product['nama_kategori'] . '</td>
                                                <td>' . $product['nama_supplier'] . '</td>
                                                </tr>
                                            </table>
                                            <table class="table table-bordered">
                                                    <th class="bg-secondary">Stok</th>
                                                    <th class="bg-secondary">Total Stok</th>
                                                    <th class="bg-secondary">Isi perpack</th>
                                                    <th class="bg-secondary">Harga PCS</th>
                                                    <th class="bg-secondary">Modal</th>
                                                    <th class="bg-secondary">Harga Pack</th>
                                                    <th class="bg-secondary">Modal</th>
                                                <tr>
                                                    <td>' . $tampil . '</td>
                                                    <td>' . $product['stok'] . ' Pcs</td>
                                                    <td>' . $product['isi_perpack'] . '</td>
                                                    <td>Rp ' . number_format($product['harga_pcs'], 0, ",", ".") . '</td>
                                                    <td>Rp ' . number_format($product['modal'], 0, ",", ".") . '</td>
                                                    <td>Rp ' . number_format($product['harga_pack'], 0, ",", ".") . '</td>
                                                    <td>Rp ' . number_format($modalpack, 0, ",", ".") . '</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL EDIT -->
                            <div class="modal fade" id="edit' . $product['id_barang'] . '">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h4 class="modal-title">Edit Barang</h4>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <form action="add/edit_barang.php" method="POST">
                                            <input type="hidden" name="id_barang" value="' . $product['id_barang'] . '">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Kode Barang</label>
                                                            <input type="text"
                                                                name="kode_barang"
                                                                class="form-control"
                                                                value="' . $product['kode_barang'] . '"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Nama Barang</label>
                                                            <input type="text"
                                                                name="nama_barang"
                                                                class="form-control"
                                                                value="' . $product['nama_barang'] . '"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Kategori</label>
                                                                <select name="id_kategori"
                                                                    class="form-control"
                                                                    required>

                                                                    <option value="">
                                                                        -- Pilih Kategori --
                                                                    </option>

                                                                    ' . $list_kategori . '

                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Nama Supplier</label>
                                                            <select name="id_supplier"
                                                                class="form-control"
                                                                required>

                                                                <option value="">
                                                                    -- Pilih Supplier --
                                                                </option>

                                                                ' . $list_supplier . '

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Stok</label>
                                                            <input type="number"
                                                                name="stok"
                                                                class="form-control"
                                                                value="' . $product['stok'] . '"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>isi Perpack</label>
                                                            <input type="number"
                                                                name="isi_perpack"
                                                                class="form-control"
                                                                value="' . $product['isi_perpack'] . '" min=0
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Harga PCS</label>
                                                            <input type="number"
                                                                name="harga_pcs"
                                                                class="form-control"
                                                                value="' . $product['harga_pcs'] . '" min=0
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Harga Pack</label>
                                                            <input type="number"
                                                                name="harga_pack"
                                                                class="form-control"
                                                                value="' . $product['harga_pack'] . '" min=0
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Modal(pcs)</label>
                                                            <input type="number"
                                                                name="modal"
                                                                class="form-control"
                                                                value="' . $product['modal'] . '" min=0
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
                            <div class="modal fade" id="hapus' . $product['id_barang'] . '">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header bg-danger">

                                            <h4 class="modal-title">Hapus Barang</h4>

                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>

                                        </div>

                                        <div class="modal-body text-center">

                                            <i class="fas fa-trash fa-4x text-danger mb-3"></i>

                                            <h5>
                                                Yakin hapus <br>
                                                <b> Data ' . $product['nama_barang'] . ' dari tabel ?</b>
                                            </h5>

                                        </div>

                                        <div class="modal-footer justify-content-center">

                                            <a href="add/hapus_barang.php?id=' . $product['id_barang'] . '"
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

<!-- MODAL TAMBAH BARANG -->
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- HEADER -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">
                    <i class="fas fa-plus-circle mr-1"></i>
                    Tambah Barang
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <!-- FORM -->
            <form action="add/tambah_barang.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <!-- KODE -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Barang</label>
                                <input type="text" name="kode_barang" id="kode_barang" class="form-control" placeholder="Masukkan kode barang" required>
                            </div>
                        </div>
                        <!-- NAMA -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="text"
                                    name="nama_barang"
                                    class="form-control"
                                    placeholder="Masukkan nama barang"
                                    required>
                            </div>
                        </div>
                        <!-- KATEGORI -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="id_kategori"
                                    class="form-control"
                                    required>
                                    <option value="">
                                        -- Pilih Kategori --
                                    </option>
                                    <?php
                                    $kategori = mysqli_query($conn, "SELECT * FROM kategori WHERE status='aktif' ORDER BY nama_kategori ASC");
                                    while ($k = mysqli_fetch_array($kategori)) {
                                    ?>
                                        <option value="<?= $k['id_kategori']; ?>">
                                            <?= $k['nama_kategori']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- SUPPLIER -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Supplier</label>
                                <select name="id_supplier"
                                    class="form-control" id="supplier"
                                    required>
                                    <option value="">
                                        -- Pilih Supplier --
                                    </option>
                                    <?php
                                    $supplier = mysqli_query($conn, "SELECT * FROM supplier WHERE status='aktif' ORDER BY nama_supplier ASC");
                                    while ($s = mysqli_fetch_array($supplier)) {
                                    ?>
                                        <option value="<?= $s['id_supplier']; ?>">
                                            <?= $s['nama_supplier']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- STOK -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Stok (PCS)</label>
                                <input type="number" name="stok" class="form-control" min="0" placeholder="0" required>
                            </div>
                        </div>
                        <!-- ISI PACK -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Isi Per Pack</label>
                                <input type="number" min="0" name="isi_perpack" class="form-control"
                                    placeholder="1" required>
                            </div>
                        </div>
                        <!-- HARGA PCS -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Harga PCS</label>
                                <input type="number" min="0" name="harga_pcs" class="form-control" placeholder="0"
                                    required>
                            </div>
                        </div>
                        <!-- HARGA PACK -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Harga Pack</label>
                                <input type="number" min="0" name="harga_pack" class="form-control"
                                    placeholder="0" required>
                            </div>
                        </div>
                        <!-- MODAL -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Harga Beli</label>
                                <input type="number" min="0" name="modal" class="form-control" placeholder="0" required>
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
<!-- MODAL IMPORT DATA -->
<div class="modal fade" id="importBarang">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title">
                    Import Barang
                </h4>
            </div>
            <form action="index.php?page=preview"
                method="POST"
                enctype="multipart/form-data">
                <div class="modal-body">
                    <a href="/stokBrg/contoh.csv" class="btn btn-success btn-sm mb-3">
                        <i class="fas fa-download mr-1"></i>Download Template
                    </a>
                    <div class="form-group">
                        <label>File CSV</label>
                        <div class="custom-file">
                            <input type="file" name="file_csv" class="custom-file-input" accept=".csv" required>
                            <label class="custom-file-label">
                                Pilih file CSV
                            </label>
                        </div>
                        <small class="text-muted">
                            Format file harus .csv
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="btn btn-primary">
                        <i class="fas fa-search mr-1"></i>
                        Preview
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#supplier').change(function() {

        var id_supplier = $(this).val();

        $.ajax({
            url: 'add/generate_kode.php',
            type: 'POST',
            data: {
                id_supplier: id_supplier
            },
            success: function(data) {
                $('#kode_barang').val(data);
            }

        });

    });
</script>