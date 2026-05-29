<!-- CONTENT HEADER -->
<div class="content-header">
    <div class="container-fluid">
        <!-- <div class="row mb-2">

            <div class="col-sm-6">
                <h1 class="m-0">
                    Transaksi Barang Keluar
                </h1>
            </div>

        </div> -->
    </div>
</div>
<!-- CONTENT -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">
                    Form Barang Keluar
                </h3>
            </div>
            <form action="add/proses_barang_keluar.php" method="POST">
                <div class="card-body">
                    <!-- ROW 1 -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <select name="id_barang"
                                    id="id_barang"
                                    class="form-control select2"
                                    required>
                                    <option value="">
                                        -- Pilih Barang --
                                    </option>
                                    <?php
                                    include "sambungkan.php";
                                    $barang = mysqli_query($conn, "
                                        SELECT * FROM barang
                                        WHERE status='aktif'
                                        ORDER BY nama_barang ASC
                                    ");
                                    while ($b = mysqli_fetch_array($barang)) {
                                    ?>
                                        <option value="<?= $b['id_barang']; ?>">
                                            -<?=$b['kode_barang'];  ?>-<?= $b['nama_barang']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Stok Saat Ini</label>
                                <input type="number" id="stok_lama" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Isi Pack</label>
                                <input type="number" id="isi_pack" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Qty Keluar<span class="text-red">*</span></label>
                                <input type="number" name="qty" class="form-control" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Estimasi Stok</label>
                                <input type="number" name="updstok" id="stok_baru" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- ROW 2 -->
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Tipe Jual</label>
                                <select name="tipe_jual"
                                    id="tipe_jual"
                                    class="form-control">
                                    <option value="pcs">
                                        PCS
                                    </option>
                                    <option value="pack">
                                        PACK
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Harga PCS</label>
                                <input type="number" id="harga_pcs" name="harga_pcs" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Harga PACK</label>
                                <input type="number" id="harga_pack" name="harga_pack" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Subtotal</label>
                                <input type="text" id="subtotal" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <select name="keterangan"
                                    class="form-control">
                                    <option value="Penjualan">
                                        Penjualan
                                    </option>
                                    <option value="Penyesuaian">
                                        Penyesuaian
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- <hr>
                    <h5>FOR YOUR INFORMASI :</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Modal PCS</label>
                                <input type="text"id="modal_pcs"class="form-control"readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Profit PCS</label>
                                <input type="text" id="profit_pcs" class="form-control"readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Modal PACK</label>
                                <input type="text"id="modal_pack"class="form-control"readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Profit PACK</label>
                                <input type="text" id="profit_pack" class="form-control"readonly>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="card-footer text-right">
                    <button type="submit"
                        class="btn btn-danger">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- <script>
    $(document).ready(function() {
        // FORMAT RUPIAH
        function rupiah(angka) {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        }
        // AMBIL DATA BARANG
        $('#id_barang').change(function() {
            var id_barang = $(this).val();
            $.ajax({
                url: 'ajax/get_barang.php',
                method: 'POST',
                data: {
                    id_barang: id_barang
                },
                dataType: 'json',
                success: function(data) {
                    // STOK
                    $('#stok_lama').val(data.stok);
                    // ISI PACK
                    $('#isi_pack').val(data.isi_perpack);
                    // HARGA
                    $('#harga_pcs').val(data.harga_pcs);
                    $('#harga_pack').val(data.harga_pack);
                    // MODAL
                    let modal_pcs = parseInt(data.modal) || 0;
                    let isi_pack = parseInt(data.isi_perpack) || 0;
                    let modal_pack = modal_pcs * isi_pack;
                    $('#modal_pcs').val(rupiah(modal_pcs));
                    $('#modal_pack').val(rupiah(modal_pack));
                    // PROFIT
                    let profit_pcs = data.harga_pcs - modal_pcs;
                    let profit_pack = data.harga_pack - modal_pack;
                    $('#profit_pcs').val(rupiah(profit_pcs));
                    $('#profit_pack').val(rupiah(profit_pack));
                    // HITUNG
                    hitungSemua();
                }
            });
        });
        // EVENT PERUBAHAN
        $('input[name="qty"], #harga_pcs, #harga_pack, #tipe_jual')
            .on('keyup change', function() {
                hitungSemua();
            });
        // FUNCTION HITUNG
        function hitungSemua() {
            let stok_lama = parseInt($('#stok_lama').val()) || 0;
            let qty = parseInt($('input[name="qty"]').val()) || 0;
            let isi_pack = parseInt($('#isi_pack').val()) || 0;
            let harga_pcs = parseInt($('#harga_pcs').val()) || 0;
            let harga_pack = parseInt($('#harga_pack').val()) || 0;
            let tipe_jual = $('#tipe_jual').val();
            // ========================
            // VALIDASI STOK
            // =========================
            if (qty > stok_lama) {
                alert('Qty melebihi stok tersedia!');
                $('input[name="qty"]').val('');
                qty = 0;
            }
            // =========================
            // HITUNG STOK BARU
            // =========================
            
            let stok_baru = stok_lama - qty;
            $('#stok_baru').val(stok_baru);
            // =========================
            // HITUNG SUBTOTAL
            // =========================
            let subtotal = 0;
            subtotal = qty * harga;
            if (tipe_jual == 'pcs') {
                subtotal = qty * harga_pcs;
            } else {
                subtotal = qty * harga_pack;
            }
            $('#subtotal').val(rupiah(subtotal));
        }
    });
</script> -->

<script>
    $(document).ready(function() {

        // FORMAT RUPIAH
        function rupiah(angka) {

            return 'Rp ' + Number(angka).toLocaleString('id-ID');

        }

        // AMBIL DATA BARANG
        $('#id_barang').change(function() {

            var id_barang = $(this).val();

            $.ajax({
                url: 'ajax/get_barang.php',
                method: 'POST',
                data: {
                    id_barang: id_barang
                },
                dataType: 'json',

                success: function(data) {

                    // STOK
                    $('#stok_lama').val(data.stok);

                    // ISI PACK
                    $('#isi_pack').val(data.isi_perpack);

                    // HARGA
                    $('#harga_pcs').val(data.harga_pcs);
                    $('#harga_pack').val(data.harga_pack);

                    // MODAL
                    let modal_pcs = parseInt(data.modal) || 0;
                    let isi_pack = parseInt(data.isi_perpack) || 0;

                    let modal_pack = modal_pcs * isi_pack;

                    $('#modal_pcs').val(rupiah(modal_pcs));
                    $('#modal_pack').val(rupiah(modal_pack));

                    // PROFIT
                    let profit_pcs = data.harga_pcs - modal_pcs;
                    let profit_pack = data.harga_pack - modal_pack;

                    $('#profit_pcs').val(rupiah(profit_pcs));
                    $('#profit_pack').val(rupiah(profit_pack));

                    // HITUNG
                    hitungSemua();

                }
            });

        });

        // EVENT INPUT
        $('input[name="qty"], #harga_pcs, #harga_pack, #tipe_jual')
            .on('keyup change', function() {

                hitungSemua();

            });

        // FUNCTION HITUNG
        function hitungSemua() {

            let stok_lama = parseInt($('#stok_lama').val()) || 0;

            let qty = parseInt($('input[name="qty"]').val()) || 0;

            let isi_pack = parseInt($('#isi_pack').val()) || 0;

            let harga_pcs = parseInt($('#harga_pcs').val()) || 0;

            let harga_pack = parseInt($('#harga_pack').val()) || 0;

            let tipe_jual = $('#tipe_jual').val();

            // =========================
            // QTY REAL
            // =========================

            let qty_real = 0;

            if (tipe_jual == 'pcs') {

                qty_real = qty;

            } else {

                qty_real = qty * isi_pack;

            }

            // =========================
            // VALIDASI STOK
            // =========================

            if (qty_real > stok_lama) {

                alert('Qty melebihi stok tersedia!');

                $('input[name="qty"]').val('');

                qty = 0;
                qty_real = 0;

            }

            // =========================
            // HITUNG STOK BARU
            // =========================

            let stok_baru = stok_lama - qty_real;

            $('#stok_baru').val(stok_baru);

            // =========================
            // HITUNG SUBTOTAL
            // =========================

            let subtotal = 0;

            if (tipe_jual == 'pcs') {

                subtotal = qty * harga_pcs;

            } else {

                subtotal = qty * harga_pack;

            }

            $('#subtotal').val(rupiah(subtotal));

        }

    });
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: '--Pilih Barang--',
            allowClear: true
        });

    });
</script>