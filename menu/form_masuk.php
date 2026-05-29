<?php
include 'sambungkan.php';
?>
<!-- CONTENT HEADER -->
<div class="content-header">
    <div class="container-fluid">
    </div>
</div>

<!-- CONTENT -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">
                    Form Barang Masuk
                </h3>
            </div>
            <form action="add/proses_barang_masuk.php" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <select name="id_barang" id="id_barang" class="form-control select2" required>
                                    <option value="">
                                        -- Pilih Barang --
                                    </option>
                                    <?php
                                    $barang = mysqli_query($conn, " SELECT * FROM barang WHERE status='aktif' ORDER BY nama_barang ASC");
                                    while ($b = mysqli_fetch_array($barang)) {
                                    ?>
                                        <option value="<?= $b['id_barang']; ?>">
                                            -<?=$b['kode_barang'];  ?>-<?= $b['nama_barang']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Stok</label>
                                <input type="number" id="stok_lama" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Qty (Pcs)<span class="text-red">*</span></label>
                                <input type="number" name="qty" class="form-control" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Estimasi Stok</label>
                                <input type="number" name="stok_baru" id="stok_baru" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Isi Pack</label>
                                <input type="number" id="isi_lama" name="isi_pack" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Harga Beli<span class="text-red">*</span></label>
                                <input type="number" name="modal_total" class="form-control" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Harga PCS</label>
                                <input type="number" name="harga_pcs" id="harga_pcs_lama" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Harga PACK</label>
                                <input type="number" name="harga_pack" id="harga_pack_lama" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Keterangan<span class="text-red">*</span></label>
                                <select name="keterangan" class="form-control">
                                    <option value="Restock">Restock</option>
                                    <option value="Penyesuaian">Penyesuaian</option>
                                </select>
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
                                <label>Modal Pcs</label>
                                <input type="text" id="modal_pcs_lama" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Modal Pack</label>
                                <input type="text" id="modal_pack_lama" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5>FOR YOUR INFORMASI :</h5>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Profit Pcs</label>
                                <input type="text" id="profit_pcs_lama" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Est Modal Pcs</label>
                                <input type="text" name="est_modal_pcs" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Est Profit Pcs</label>
                                <input type="text" name="est_profit_pcs" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Profit Pack</label>
                                <input type="text" id="profit_pack_lama" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Est Modal Pack</label>
                                <input type="text" name="est_modal_pack" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Est Profit Pack</label>
                                <input type="text" name="est_profit_pack" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit"
                            class="btn btn-success">
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
                    $('#stok_lama').val(data.stok);
                    $('#isi_lama').val(data.isi_perpack);
                    $('#harga_pcs_lama').val(data.harga_pcs);
                    $('#harga_pack_lama').val(data.harga_pack);
                    $('#modal_lama').val(data.modal);
                    hitungStok();
                }
            });
        });
        $('input[name="qty"]').keyup(function() {
            hitungStok();
        });

        function hitungStok() {
            var stok_lama = parseInt($('#stok_lama').val()) || 0;
            var qty = parseInt($('input[name="qty"]').val()) || 0;
            var hasil = stok_lama + qty;
            $('#stok_baru').val(hasil);
        }
    });
</script> -->
<script>
$(document).ready(function() {

    // FORMAT RUPIAH
    function rupiah(angka) {

        angka = parseInt(angka) || 0;

        return 'Rp ' + angka.toLocaleString('id-ID');

    }

    // HITUNG SEMUA
    function hitungSemua() {

        let stok_lama = parseInt($('#stok_lama').val()) || 0;

        let qty = parseInt($('input[name="qty"]').val()) || 0;

        let isi_pack = parseInt($('#isi_lama').val()) || 0;

        let modal_total = parseInt($('input[name="modal_total"]').val()) || 0;

        let harga_pcs = parseInt($('#harga_pcs_lama').val()) || 0;

        let harga_pack = parseInt($('#harga_pack_lama').val()) || 0;

        // ESTIMASI STOK
        let stok_baru = stok_lama + qty;

        $('#stok_baru').val(stok_baru);

        // ESTIMASI MODAL PCS
        let est_modal_pcs = 0;

        if (qty > 0) {

            est_modal_pcs = Math.round(modal_total / qty);

        }

        $('input[name="est_modal_pcs"]').val(rupiah(est_modal_pcs));

        // ESTIMASI MODAL PACK
        let est_modal_pack = est_modal_pcs * isi_pack;

        $('input[name="est_modal_pack"]').val(rupiah(est_modal_pack));

        // ESTIMASI PROFIT PCS
        let est_profit_pcs = harga_pcs - est_modal_pcs;

        $('input[name="est_profit_pcs"]').val(rupiah(est_profit_pcs));

        // ESTIMASI PROFIT PACK
        let est_profit_pack = harga_pack - est_modal_pack;

        $('input[name="est_profit_pack"]').val(rupiah(est_profit_pack));

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

                // DATA UTAMA
                $('#stok_lama').val(data.stok);

                $('#isi_lama').val(data.isi_perpack);

                // HARGA (tetap angka biar bisa dihitung)
                $('#harga_pcs_lama').val(data.harga_pcs);

                $('#harga_pack_lama').val(data.harga_pack);

                // MODAL
                let modal_pcs = parseInt(data.modal) || 0;

                let isi_pack = parseInt(data.isi_perpack) || 0;

                let modal_pack = modal_pcs * isi_pack;

                $('#modal_pcs_lama').val(rupiah(modal_pcs));

                $('#modal_pack_lama').val(rupiah(modal_pack));

                // PROFIT
                let profit_pcs = data.harga_pcs - modal_pcs;

                let profit_pack = data.harga_pack - modal_pack;

                $('#profit_pcs_lama').val(rupiah(profit_pcs));

                $('#profit_pack_lama').val(rupiah(profit_pack));

                // HITUNG ESTIMASI
                hitungSemua();

            }

        });

    });

    // EVENT INPUT
    $('input[name="qty"], input[name="modal_total"], #harga_pcs_lama, #harga_pack_lama')
    .on('keyup change', function() {

        hitungSemua();

    });

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