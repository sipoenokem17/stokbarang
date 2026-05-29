<?php

include_once __DIR__ . "/../sambungkan.php";

// FILE CSV
// $file = fopen($_FILES['file_csv']['tmp_name'], 'r');
$file = fopen($_POST['file'], 'r');
$no = 0;

while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {

    // SKIP HEADER + CONTOH
    if ($no < 2) {
        $no++;
        continue;
    }

    $kode_barang  = mysqli_real_escape_string($conn, $row[0]);
    $nama_barang  = mysqli_real_escape_string($conn, $row[1]);
    $kategori     = mysqli_real_escape_string($conn, $row[2]);
    $supplier     = mysqli_real_escape_string($conn, $row[3]);

    $stok         = (int)$row[4];
    $isi_perpack  = (int)$row[5];

    $harga_pcs    = (int)$row[6];
    $harga_pack   = (int)$row[7];

    $modal_total  = (int)$row[8];

    // VALIDASI STOK
    if ($stok <= 0) {
        continue;
    }

    // HITUNG MODAL PCS
    $modal = $modal_total / $stok;

    /*
    =========================
    CEK / INSERT KATEGORI
    =========================
    */

    $cek_kategori = mysqli_query($conn, "

        SELECT *

        FROM kategori

        WHERE LOWER(nama_kategori)=LOWER('$kategori')

    ");

    if (mysqli_num_rows($cek_kategori) > 0) {

        $data_kategori = mysqli_fetch_assoc($cek_kategori);

        $id_kategori = $data_kategori['id_kategori'];

    } else {

        mysqli_query($conn, "

            INSERT INTO kategori(nama_kategori)

            VALUES('$kategori')

        ");

        $id_kategori = mysqli_insert_id($conn);

    }

    /*
    =========================
    CEK / INSERT SUPPLIER
    =========================
    */

    $cek_supplier = mysqli_query($conn, "

        SELECT *

        FROM supplier

        WHERE LOWER(nama_supplier)=LOWER('$supplier')

    ");

    if (mysqli_num_rows($cek_supplier) > 0) {

        $data_supplier = mysqli_fetch_assoc($cek_supplier);

        $id_supplier = $data_supplier['id_supplier'];

    } else {

        mysqli_query($conn, "

            INSERT INTO supplier(nama_supplier)

            VALUES('$supplier')

        ");

        $id_supplier = mysqli_insert_id($conn);

    }

    /*
    =========================
    CEK BARANG DUPLIKAT
    =========================
    */

    $cek_barang = mysqli_query($conn, "

        SELECT *

        FROM barang

        WHERE kode_barang='$kode_barang'

    ");

    if (mysqli_num_rows($cek_barang) > 0) {

        continue;

    }

    /*
    =========================
    INSERT BARANG
    =========================
    */

    mysqli_query($conn, "

        INSERT INTO barang(

            kode_barang,
            nama_barang,
            id_kategori,
            id_supplier,
            stok,
            isi_perpack,
            harga_pcs,
            harga_pack,
            modal,
            status,
            created_at

        ) VALUES (

            '$kode_barang',
            '$nama_barang',
            '$id_kategori',
            '$id_supplier',
            '$stok',
            '$isi_perpack',
            '$harga_pcs',
            '$harga_pack',
            '$modal',
            'aktif',
            NOW()

        )

    ");

    // AMBIL ID BARANG TERBARU
    $id_barang = mysqli_insert_id($conn);

    /*
    =========================
    INSERT LOG BARANG MASUK
    =========================
    */

    $tanggal = date('Y-m-d');

    mysqli_query($conn, "

        INSERT INTO barang_masuk (

            id_barang,
            qty,
            harga_beli,
            modal_perpcs,
            stok_sebelum,
            stok_sesudah,
            harga_pcs,
            harga_pack,
            isi_perpack,
            keterangan,
            tanggal

        ) VALUES (

            '$id_barang',
            '$stok',
            '$modal_total',
            '$modal',
            '0',
            '$stok',
            '$harga_pcs',
            '$harga_pack',
            '$isi_perpack',
            'Tambah Barang',
            '$tanggal'

        )

    ");

}

// fclose($file);
unlink($_POST['file']);
echo "

<script>

alert('Data berhasil di import');

window.location='../index.php?page=databrg';

</script>

";

?>