<?php

include_once __DIR__ . "/../sambungkan.php";

// ==============================
// VALIDASI KERANJANG
// ==============================

$cek = mysqli_query($conn, "SELECT * FROM keranjang");

if (mysqli_num_rows($cek) == 0) {

    echo "
        <script>
            alert('Keranjang kosong!');
            window.location='../index.php?page=keranjang';
        </script>
    ";

    exit;
}

// ==============================
// AMBIL TOTAL
// ==============================

$getTotal = mysqli_query($conn, "
    
    SELECT 
        SUM(subtotal) as total_harga,
        SUM(profit) as total_profit,
        SUM(qty) as total_qty
    FROM keranjang

");

$total = mysqli_fetch_assoc($getTotal);

$total_harga  = $total['total_harga'];
$total_profit = $total['total_profit'];
$total_qty = $total['total_qty'];

// ==============================
// SIMPAN TRANSAKSI
// ==============================

mysqli_query($conn, "

    INSERT INTO transaksi (
        total_qty,
        total_harga,
        total_profit,
        created_at
    )

    VALUES (
        '$total_qty',
        '$total_harga',
        '$total_profit',
        NOW()
    )

");

// ==============================
// AMBIL ID TRANSAKSI
// ==============================

$id_transaksi = mysqli_insert_id($conn);

// ==============================
// AMBIL DATA KERANJANG
// ==============================

$keranjang = mysqli_query($conn, "

    SELECT 
        k.*,
        b.nama_barang
    FROM keranjang k

    JOIN barang b
    ON k.id_barang = b.id_barang

");

// ==============================
// LOOP DATA KERANJANG
// ==============================

while ($data = mysqli_fetch_assoc($keranjang)) {

    $id_barang      = $data['id_barang'];
    $qty            = $data['qty'];
    $tipe_jual      = $data['tipe'];
    $harga_jual     = $data['harga'];
    $subtotal       = $data['subtotal'];
    $modal_total    = $data['modal'];
    $profit         = $data['profit'];
    $stok_sebelum   = $data['stok_sebelum'];
    $stok_sesudah   = $data['stok_sesudah'];
    $keterangan     = $data['keterangan'];

    // ==========================
    // DETAIL TRANSAKSI
    // ==========================

    mysqli_query($conn, "

        INSERT INTO detail_transaksi (

            id_transaksi,
            id_barang,
            qty,
            harga,
            subtotal,
            modal,
            profit

        )

        VALUES (

            '$id_transaksi',
            '$id_barang',
            '$qty',
            '$harga_jual',
            '$subtotal',
            '$modal_total',
            '$profit'

        )

    ");

    // ==========================
    // LOG BARANG KELUAR
    // ==========================

    mysqli_query($conn, "

        INSERT INTO barang_keluar (

            id_barang,
            qty,
            stok_sebelum,
            stok_sesudah,
            keterangan,
            tanggal

        )

        VALUES (

            '$id_barang',
            '$qty',
            '$stok_sebelum',
            '$stok_sesudah',
            '$keterangan',
            NOW()

        )

    ");

}

// ==============================
// HAPUS KERANJANG
// ==============================

mysqli_query($conn, "TRUNCATE TABLE keranjang");

// ==============================
// REDIRECT
// ==============================

echo "

    <script>

        alert('Checkout berhasil!');

        window.location='../index.php?page=transaksi';

    </script>

";

?>