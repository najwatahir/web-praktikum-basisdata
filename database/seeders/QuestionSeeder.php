<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [

            // ── SOAL 1: SELECT Dasar ──
            [
                'judul'           => 'Menampilkan Data Karyawan',
                'deskripsi'       => 'Tampilkan nama dan gaji semua karyawan yang bekerja di departemen IT, diurutkan dari gaji tertinggi.',
                'schema_sql'      => "
CREATE TABLE karyawan (
    id INT,
    nama VARCHAR(50),
    gaji INT,
    departemen VARCHAR(50)
);
INSERT INTO karyawan VALUES (1, 'Budi Santoso', 5000000, 'IT');
INSERT INTO karyawan VALUES (2, 'Ani Rahayu', 7000000, 'HR');
INSERT INTO karyawan VALUES (3, 'Cici Permata', 6000000, 'IT');
INSERT INTO karyawan VALUES (4, 'Dodi Pratama', 8000000, 'Finance');
INSERT INTO karyawan VALUES (5, 'Eka Wijaya', 4500000, 'IT');
                ",
                'expected_sql'    => "SELECT nama, gaji FROM karyawan WHERE departemen = 'IT' ORDER BY gaji DESC",
                'expected_output' => json_encode([
                    ['nama' => 'Cici Permata', 'gaji' => '6000000'],
                    ['nama' => 'Budi Santoso', 'gaji' => '5000000'],
                    ['nama' => 'Eka Wijaya',   'gaji' => '4500000'],
                ]),
                'poin'          => 100,
                'urutan'        => 1,
                'order_matters' => true,
                'aktif'         => true,
            ],

            // ── SOAL 2: SELECT dengan Filter ──
            [
                'judul'           => 'Filter Data Mahasiswa',
                'deskripsi'       => 'Tampilkan nim dan nama mahasiswa yang memiliki IPK lebih dari 3.5, diurutkan berdasarkan IPK tertinggi.',
                'schema_sql'      => "
CREATE TABLE mahasiswa (
    nim VARCHAR(10),
    nama VARCHAR(50),
    ipk DECIMAL(3,2),
    angkatan INT
);
INSERT INTO mahasiswa VALUES ('2101', 'Wayan Artha', 3.75, 2021);
INSERT INTO mahasiswa VALUES ('2102', 'Made Sari', 3.20, 2021);
INSERT INTO mahasiswa VALUES ('2103', 'Nyoman Bayu', 3.90, 2021);
INSERT INTO mahasiswa VALUES ('2104', 'Ketut Indra', 2.95, 2022);
INSERT INTO mahasiswa VALUES ('2105', 'Putu Lestari', 3.60, 2022);
                ",
                'expected_sql'    => "SELECT nim, nama FROM mahasiswa WHERE ipk > 3.5 ORDER BY ipk DESC",
                'expected_output' => json_encode([
                    ['nim' => '2103', 'nama' => 'Nyoman Bayu'],
                    ['nim' => '2105', 'nama' => 'Putu Lestari'],
                    ['nim' => '2101', 'nama' => 'Wayan Artha'],
                ]),
                'poin'          => 100,
                'urutan'        => 2,
                'order_matters' => true,
                'aktif'         => true,
            ],

            // ── SOAL 3: JOIN ──
            [
                'judul'           => 'Join Data Pesanan',
                'deskripsi'       => 'Tampilkan nama pelanggan beserta nama produk yang mereka pesan. Urutkan berdasarkan nama pelanggan.',
                'schema_sql'      => "
CREATE TABLE pelanggan (
    id INT,
    nama VARCHAR(50),
    kota VARCHAR(50)
);
CREATE TABLE produk (
    id INT,
    nama_produk VARCHAR(50),
    harga INT
);
CREATE TABLE pesanan (
    id INT,
    pelanggan_id INT,
    produk_id INT,
    jumlah INT
);
INSERT INTO pelanggan VALUES (1, 'Agus Setiawan', 'Denpasar');
INSERT INTO pelanggan VALUES (2, 'Bella Kusuma', 'Badung');
INSERT INTO pelanggan VALUES (3, 'Candra Putra', 'Gianyar');
INSERT INTO produk VALUES (1, 'Laptop', 8000000);
INSERT INTO produk VALUES (2, 'Mouse', 150000);
INSERT INTO produk VALUES (3, 'Keyboard', 300000);
INSERT INTO pesanan VALUES (1, 1, 1, 1);
INSERT INTO pesanan VALUES (2, 1, 2, 2);
INSERT INTO pesanan VALUES (3, 2, 3, 1);
INSERT INTO pesanan VALUES (4, 3, 1, 1);
                ",
                'expected_sql'    => "
SELECT pl.nama, pr.nama_produk
FROM pesanan ps
JOIN pelanggan pl ON ps.pelanggan_id = pl.id
JOIN produk pr ON ps.produk_id = pr.id
ORDER BY pl.nama
                ",
                'expected_output' => json_encode([
                    ['nama' => 'Agus Setiawan', 'nama_produk' => 'Laptop'],
                    ['nama' => 'Agus Setiawan', 'nama_produk' => 'Mouse'],
                    ['nama' => 'Bella Kusuma',  'nama_produk' => 'Keyboard'],
                    ['nama' => 'Candra Putra',  'nama_produk' => 'Laptop'],
                ]),
                'poin'          => 100,
                'urutan'        => 3,
                'order_matters' => true,
                'aktif'         => true,
            ],

            // ── SOAL 4: GROUP BY ──
            [
                'judul'           => 'Total Penjualan per Kategori',
                'deskripsi'       => 'Tampilkan nama kategori dan total harga penjualan per kategori. Urutkan dari total penjualan tertinggi.',
                'schema_sql'      => "
CREATE TABLE kategori (
    id INT,
    nama_kategori VARCHAR(50)
);
CREATE TABLE penjualan (
    id INT,
    kategori_id INT,
    nama_barang VARCHAR(50),
    harga INT,
    qty INT
);
INSERT INTO kategori VALUES (1, 'Elektronik');
INSERT INTO kategori VALUES (2, 'Pakaian');
INSERT INTO kategori VALUES (3, 'Makanan');
INSERT INTO penjualan VALUES (1, 1, 'Laptop', 8000000, 2);
INSERT INTO penjualan VALUES (2, 1, 'HP', 3000000, 5);
INSERT INTO penjualan VALUES (3, 2, 'Kaos', 100000, 10);
INSERT INTO penjualan VALUES (4, 2, 'Celana', 200000, 3);
INSERT INTO penjualan VALUES (5, 3, 'Nasi Kotak', 25000, 50);
INSERT INTO penjualan VALUES (6, 3, 'Minuman', 10000, 100);
                ",
                'expected_sql'    => "
SELECT k.nama_kategori, SUM(p.harga * p.qty) as total_penjualan
FROM penjualan p
JOIN kategori k ON p.kategori_id = k.id
GROUP BY k.nama_kategori
ORDER BY total_penjualan DESC
                ",
                'expected_output' => json_encode([
                    ['nama_kategori' => 'Elektronik', 'total_penjualan' => '31000000'],
                    ['nama_kategori' => 'Pakaian',    'total_penjualan' => '1600000'],
                    ['nama_kategori' => 'Makanan',    'total_penjualan' => '2250000'],
                ]),
                'poin'          => 100,
                'urutan'        => 4,
                'order_matters' => true,
                'aktif'         => true,
            ],

            // ── SOAL 5: GROUP BY + HAVING ──
            [
                'judul'           => 'Departemen dengan Rata-rata Gaji Tinggi',
                'deskripsi'       => 'Tampilkan nama departemen yang memiliki rata-rata gaji karyawan lebih dari 5.000.000. Tampilkan juga rata-rata gajinya, diurutkan dari rata-rata tertinggi.',
                'schema_sql'      => "
CREATE TABLE departemen (
    id INT,
    nama_departemen VARCHAR(50)
);
CREATE TABLE pegawai (
    id INT,
    nama VARCHAR(50),
    gaji INT,
    departemen_id INT
);
INSERT INTO departemen VALUES (1, 'IT');
INSERT INTO departemen VALUES (2, 'HR');
INSERT INTO departemen VALUES (3, 'Finance');
INSERT INTO departemen VALUES (4, 'Marketing');
INSERT INTO pegawai VALUES (1, 'Adi',   6000000, 1);
INSERT INTO pegawai VALUES (2, 'Bima',  7000000, 1);
INSERT INTO pegawai VALUES (3, 'Cika',  4000000, 2);
INSERT INTO pegawai VALUES (4, 'Dani',  4500000, 2);
INSERT INTO pegawai VALUES (5, 'Eka',   8000000, 3);
INSERT INTO pegawai VALUES (6, 'Fani',  9000000, 3);
INSERT INTO pegawai VALUES (7, 'Gita',  3000000, 4);
INSERT INTO pegawai VALUES (8, 'Hadi',  3500000, 4);
                ",
                'expected_sql'    => "
SELECT d.nama_departemen, AVG(p.gaji) as rata_gaji
FROM pegawai p
JOIN departemen d ON p.departemen_id = d.id
GROUP BY d.nama_departemen
HAVING AVG(p.gaji) > 5000000
ORDER BY rata_gaji DESC
                ",
                'expected_output' => json_encode([
                    ['nama_departemen' => 'Finance', 'rata_gaji' => '8500000.0000'],
                    ['nama_departemen' => 'IT',      'rata_gaji' => '6500000.0000'],
                ]),
                'poin'          => 100,
                'urutan'        => 5,
                'order_matters' => true,
                'aktif'         => true,
            ],

        ];

        foreach ($questions as $question) {
            DB::table('questions')->insert(array_merge($question, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}