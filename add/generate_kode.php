<?php

include_once __DIR__ . '/../sambungkan.php';

$id_supplier = $_POST['id_supplier'];

$supplier = mysqli_query($conn, "SELECT * FROM supplier 
                                WHERE id_supplier = '$id_supplier'");

$data_supplier = mysqli_fetch_array($supplier);

$kode_supplier = $data_supplier['kode_supplier'];

$query = mysqli_query($conn, "SELECT kode_barang 
                            FROM barang
                            WHERE kode_barang LIKE '$kode_supplier%'
                            ORDER BY id_barang DESC
                            LIMIT 1");

$data = mysqli_fetch_array($query);

$kode_terakhir = $data['kode_barang'];

$angka = (int) substr($kode_terakhir, strlen($kode_supplier));

$angka++;

$kode_baru = $kode_supplier . " " .str_pad($angka, 3, "0", STR_PAD_LEFT);

echo $kode_baru;
