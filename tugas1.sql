-- 1.1 Total buku seluruhnya
SELECT COUNT(*) AS total_buku
FROM buku;

-- 1.2 Total nilai inventaris (harga × stok)
SELECT SUM(harga * stok) AS total_nilai_inventaris
FROM buku;

-- 1.3 Rata-rata harga buku
SELECT AVG(harga) AS rata_rata_harga
FROM buku;

-- 1.4 Buku termahal (judul dan harga)
SELECT judul, harga
FROM buku
ORDER BY harga DESC
LIMIT 1;

-- 1.5 Buku dengan stok terbanyak
SELECT judul, stok
FROM buku
ORDER BY stok DESC
LIMIT 1;
   

-- ==============================
-- 2. FILTER DAN PENCARIAN (5 QUERY)
-- ==============================

-- 2.1 Buku kategori Programming dengan harga < 100000
SELECT *
FROM buku
WHERE kategori = 'Programming' AND harga < 100000;

-- 2.2 Buku dengan judul mengandung "PHP" atau "MySQL"
SELECT *
FROM buku
WHERE judul LIKE '%PHP%' OR judul LIKE '%MySQL%';

-- 2.3 Buku yang terbit tahun 2024
SELECT *
FROM buku
WHERE tahun_terbit = 2024;

-- 2.4 Buku dengan stok antara 5 sampai 10
SELECT *
FROM buku
WHERE stok BETWEEN 5 AND 10;

-- 2.5 Buku dengan m pengarang "Budi Raharjo"
SELECT *
FROM buku
WHERE pengarang = 'Budi Raharjo';


-- ==============================
-- 3. GROUPING & AGREGASI (3 QUERY)
-- ==============================

-- 3.1 Jumlah buku dan total stok per kategori
SELECT kategori,
       COUNT(*) AS jumlah_buku,
       SUM(stok) AS total_stok
FROM buku
GROUP BY kategori;

-- 3.2 Rata-rata harga per kategori
SELECT kategori,
       AVG(harga) AS rata_rata_harga
FROM buku
GROUP BY kategori;

-- 3.3 Kategori dengan total nilai inventaris terbesar
SELECT kategori,
       SUM(harga * stok) AS total_nilai
FROM buku
GROUP BY kategori
ORDER BY total_nilai DESC
LIMIT 1;


-- ==============================
-- 4. UPDATE DATA (2 QUERY)
-- ==============================

-- 4.1 Naikkan harga buku kategori Programming sebesar 5%
UPDATE buku
SET harga = harga * 1.05
WHERE kategori = 'Programming';

-- 4.2 Tambah stok 10 untuk buku dengan stok < 5
UPDATE buku
SET stok = stok + 10
WHERE stok < 5;


-- ==============================
-- 5. LAPORAN KHUSUS (2 QUERY)
-- ==============================

-- 5.1 Daftar buku yang perlu restocking (stok < 5)
SELECT *
FROM buku
WHERE stok < 5;

-- 5.2 Top 5 buku termahal
SELECT judul, harga
FROM buku
ORDER BY harga DESC
LIMIT 5;